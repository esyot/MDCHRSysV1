<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\LeaveForm;
use App\Models\Staff;
use App\Models\Teacher;
use App\Models\TravelForm;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;
use GuzzleHttp\Client;



class UserController extends Controller
{

    public function userUpdate(Request $request)
    {

        $user = User::find($request->userId);

        if (!$user)
        {
            return redirect()->back()->withErrors([
                'error' => "User not found!"
            ]);
        }

        try
        {
            $user->update([
                'user' => $request->formData['user'],
                'is_active' => $request->formData['is_active'] === true ? 1 : 0,
            ]);

        } catch (\Exception $e)
        {
            return redirect()->back()->withErrors([
                'error' => "Failed to update user details: " . $e->getMessage()
            ]);
        }


        if ($request->formData['password'])
        {
            try
            {
                $user->password = Hash::make($request->formData['password']);
                $user->is_default_pass = 1;
                $user->save();
            } catch (\Exception $e)
            {
                return redirect()->back()->withErrors([
                    'error' => "Failed to update password: " . $e->getMessage()
                ]);
            }
        }


        try
        {
            $user->syncRoles([]);
        } catch (\Exception $e)
        {
            return redirect()->back()->withErrors([
                'error' => "Failed to synchronize roles: " . $e->getMessage()
            ]);
        }


        if (!empty($request->formData['roles']))
        {
            try
            {
                $user->assignRole($request->formData['roles']);
            } catch (\Exception $e)
            {
                return redirect()->back()->withErrors([
                    'error' => "Failed to assign roles: " . $e->getMessage()
                ]);
            }
        }

        return redirect()->back()->with([
            'success' => "User details updated successfully!"
        ]);
    }


    public function staffUpdate(Request $request)
    {

        $staff = Staff::find($request->staff_id);

        if ($staff)
        {
            $formData = $request->formData;

            $staff->update([
                'position' => $formData['position'],
                'date_hired' => $formData['date_hired'],
            ]);

            if ($staff)
            {
                return redirect()->back()->with([
                    'success' => "Staff details has been updated successfully!"
                ]);

            } else
            {
                return back()->withErrors([
                    'error' => "Staff details update failed!"
                ]);
            }

        } else
        {

            return back()->withErrors([
                'error' => "Staff not found!"
            ]);
        }
    }
    public function teacherUpdate(Request $request)
    {

        if ($request)
        {
            $formData = $request->formData;
            $teacher = Teacher::find($request->teacher_id);

            $teacher->update([
                'specialization' => $formData['specialization'],
                'department_id' => $formData['department_id'],
                'date_hired' => $formData['date_hired'],
            ]);

            if ($teacher)
            {
                return redirect()->back()->with([
                    'success' => 'Teacher has been updated successfully!'
                ]);
            } else
            {
                return back()->withErrors([
                    'error' => "Teacher's update failed!"
                ]);
            }

        }

    }
    public function updateProfilePicture(Request $request)
    {
        $validatedData = $request->validate([
            'image' => ['required', 'string'],
        ]);

        $imageData = $request->input('image');

        if (preg_match('/^data:image\/(\w+);base64,/', $imageData, $matches))
        {
            $extension = $matches[1];
            $imageData = substr($imageData, strpos($imageData, ',') + 1);
            $imageData = base64_decode($imageData);

            if (!$imageData)
            {
                return redirect()->back()->with('error', 'Invalid image data.');
            }


            $path = 'public/users/images';

            if (!Storage::exists($path))
            {
                Storage::makeDirectory($path, 0775, true);
            }


            $userId = (string) Auth::user()->id;


            $files = Storage::files($path);

            foreach ($files as $file)
            {

                $filePrefix = strtok(basename($file), '-');

                if ($filePrefix === $userId)
                {
                    Storage::delete($file);
                }
            }


            $dateTimeNow = Carbon::now()->format('Y-m-d-h-s');
            $fileName = Auth::user()->id . '-' . $dateTimeNow . '.' . $extension;

            $storedPath = Storage::put($path . '/' . $fileName, $imageData);

            User::find(Auth::user()->id)->update([
                'img' => $fileName,
            ]);

            if ($storedPath)
            {
                session()->flash('success', 'Image uploaded successfully!');
                return redirect()->route('account');
            } else
            {
                return redirect()->back()->with([
                    'error' => 'Error uploading the new image.',
                ]);
            }
        } else
        {
            return redirect()->back()->with('error', 'Invalid image format.');
        }
    }

    public function update(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::find(Auth::user()->id);


        $user->email = $request->email;
        if ($request->filled('password'))
        {
            $user->password = Hash::make($request->password);
            $user->is_default_pass = 0;
        }

        $user->save();

        return redirect()->back()->with('success', 'Account updated successfully!');
    }


    public function users(Request $request)
    {
        $this->globalVariables();
        $roles = $this->roles;
        $roleList = $this->roles;
        $departmentList = $this->departmentList;
        $positionList = config('variables.positionList');

        $orderBy = $request->orderBy ?? 'ASC';
        $type = $request->type ?? 'user';
        $department = $request->department ?? null;

        $search_value = $request->search_value;

        if ($type == 'user')
        {
            $users = User::
                when($search_value, function ($query, $search_value) {
                    $query->where('last_name', 'LIKE', '%' . $search_value . '%')
                        ->orWhere('first_name', 'LIKE', '%' . $search_value . '%');
                })
                ->orderBy('last_name', $orderBy)
                ->paginate(12);

        } else if ($type == 'teacher')
        {
            $users = User::
                whereHas('teacher', function ($query) {
                    $query->where('id', '!=', null);
                })
                ->when($department, function ($query) use ($department) {
                    $query->whereRelation('teacher', 'department_id', '=', $department);
                })
                ->when($search_value, function ($query) use ($search_value) {
                    $query->where('first_name', 'LIKE', '%' . $search_value . '%')
                        ->orWhere('last_name', 'LIKE', '%' . $search_value . '%');
                })
                ->with('teacher')
                ->paginate(12);


        } else if ($type == 'staff')
        {
            $users = User::
                whereHas('staff', function ($query) {
                    $query->where('id', '!=', null);
                })
                ->when($search_value, function ($query, $search_value) {
                    $query->where('last_name', 'LIKE', '%' . $search_value . '%')
                        ->orWhere('first_name', 'LIKE', '%' . $search_value . '%');
                })
                ->orderBy('last_name', $orderBy)
                ->with([
                    'staff'
                ])
                ->paginate(12);

        }


        return Inertia::render('Pages/Admin/UserList', [
            'type' => $type,
            'department' => $department ?? null,
            'user' => Auth::user(),
            'users' => $users,
            'roles' => $roles,
            'pageTitle' => 'Users',
            'departmentList' => $departmentList,
            'positionList' => $positionList,
            'roleList' => $roleList,
            'orderBy' => $orderBy,
            'search_value' => $search_value ?? null,
            'success' => session('success') ?? "",
        ]);
    }


    public function userView($id)
    {
        $personalDetails = User::with([
            'personalDetails',
            'personalDetails.permanentAddress',
            'personalDetails.residentialAddress',
            'userJobDetails',
            'userFamilies',
            'userEducationalBackgrounds',
            'userProfessionalExaminations',
            'userAwardReceives',
            'userAdminPosHelds',
            'userWorkExperiences',
            'userStudies',
            'userParticipations',
            'userSpecialTrainings',
            'userOtherInfos',
            'userSchoolCurriculars',
            'userOtherDetails',
            'userReferences',
            'userReferences.address',
            'userValidIds',
            'teacher',
            'teacher.department',
            'staff'

        ])->findOrFail($id);



        $userRoles = User::find($id)->getRoleNames();

        $teacher = null;
        if ($personalDetails->teacher)
        {
            $teacher = $personalDetails->teacher;
        }

        $staff = null;
        if ($personalDetails->staff)
        {
            $staff = $personalDetails->staff;
        }

        $this->globalVariables();
        $roles = $this->roles;

        $roleList = Role::all();
        $departmentList = Department::all();


        $leaveForms = LeaveForm::where('user_id', $id)
            ->where('status', 'approved')
            ->with([
                'substitutes.user',
                'user',
                'endorser',
                'userJobDetail',

            ])->orderBy('created_at', 'ASC')->get();


        $travelForms = TravelForm::where('user_id', $id)
            ->where('status', 'approved')
            ->orderBy('created_at', 'ASC')
            ->with([
                'substitutes.user',
                'user',
                'endorser',
                'userJobDetail',

            ])->orderBy('created_at', 'ASC')->get();



        $forms = [];
        $forms['Travel Form'] = $travelForms;
        $forms['Leave Form'] = $leaveForms;


        $flattenedForms = [];
        foreach ($forms as $formType => $formArray)
        {
            foreach ($formArray as $form)
            {
                $form['form_type'] = $formType;

                $form['endorser'] = $form['endorser'] ? $form['endorser']->toArray() : null;
                $form['user_job_detail'] = $form['user_job_detail'] ? $form['user_job_detail']->toArray() : null;

                $flattenedForms[] = $form;
            }
        }

        usort($flattenedForms, function ($a, $b) {
            return strtotime($b['created_at']) - strtotime($a['created_at']);
        });


        $pageTitle = $personalDetails->last_name . ', ' . $personalDetails->first_name;

        $positionList = config('variables.positionList');
        $specializationList = config('variables.specializationList');

        $illness = LeaveForm::
            where('leave_type', 'Sick')
            ->where('user_id', $personalDetails->id)
            ->where('status', 'approved')
            ->pluck('illness');

        return Inertia::render('Pages/Admin/UserView', [
            'user' => Auth::user(),
            'personalDetails' => $personalDetails,
            'roles' => $roles,
            'userRoles' => $userRoles,
            'pageTitle' => $pageTitle,
            'roleList' => $roleList,
            'userId' => $id,
            'success' => session('success') ?? "",
            'departmentList' => $departmentList,
            'forms' => $flattenedForms,
            'teacher' => $teacher,
            'staff' => $staff,
            'positionList' => $positionList,
            'specializationList' => $specializationList,
            'illness' => $illness


        ]);

    }

    public function userAdd($type, Request $request)
    {

        if ($type && $type === 'user')
        {

            $username = $request->first_name[0] . $request->last_name;
            $originalUsername = $username;
            $counter = 1;

            while (User::where('user', $username)->exists())
            {
                $username = $originalUsername . '_' . $counter;
                $counter++;
            }

            $user = User::create([
                'user' => $username,
                'first_name' => $request->first_name,
                'middle_name' => $request->middle_name,
                'last_name' => $request->last_name,
                'email' => 'example@email.com',
                'password' => Hash::make('12345678'),
            ]);


            foreach ($request->roles as $role)
            {
                $user->assignRole($role);
            }



            if ($user)
            {
                return redirect()->back()->with('success', 'User added successfully!');
            } else
            {
                return redirect()->back()->with('error', 'Error adding user.');
            }
        } elseif ($type && $type === 'teacher')
        {

            $formData = $request->formData;

            $teacher = Teacher::create([
                'user_id' => $request->selected_id,
                'specialization' => $formData['specialization'],
                'department_id' => $formData['department_id'],
            ]);

            if ($teacher)
            {
                return redirect()->back()->with('success', 'User added successfully!');
            } else
            {
                return redirect()->back()->with('error', 'Error adding user.');
            }


        } elseif ($type && $type === 'staff')
        {

            $formData = $request->formData;

            $fetchedUser = User::find($request->selected_id);

            $fetchedUser->assignRole('staff');

            $staff = Staff::create([
                'user_id' => $request->selected_id,
                'position' => $formData['position'],
                'date_hired' => $formData['date_hired'],
            ]);

            if ($staff)
            {
                return redirect()->back()->with('success', 'User added successfully!');
            } else
            {
                return redirect()->back()->with('error', 'Error adding user.');
            }
        }
    }



    public function updateUserDepartment(Request $request)
    {
        $user = User::find($request->user_id);

        if ($user->teacher)
        {
            $user->teacher->update([
                'department_id' => $request->department_id,
            ]);
        }

        return redirect()->back()->with('success', 'Department updated successfully!');
    }

    public function search($type, $value)
    {
        if ($type === 'user')
        {
            $searchTerms = explode(" ", $value);
            $users = User::where(function ($query) use ($searchTerms) {
                foreach ($searchTerms as $term)
                {

                    $query->orWhere(DB::raw('LOWER(first_name)'), 'LIKE', '%' . strtolower($term) . '%')
                        ->orWhere(DB::raw('LOWER(last_name)'), 'LIKE', '%' . strtolower($term) . '%')
                        ->orWhere(DB::raw('LOWER(middle_name)'), 'LIKE', '%' . strtolower($term) . '%');
                }
            })
                ->select(['id', 'first_name', 'last_name', 'middle_name'])
                ->take(10)
                ->get();

        } elseif ($type === 'teacher')
        {
            $searchTerms = explode(" ", $value);
            $users = User::whereDoesntHave('teacher')
                ->where(function ($query) use ($searchTerms) {
                    foreach ($searchTerms as $term)
                    {

                        $query->orWhere(DB::raw('LOWER(first_name)'), 'LIKE', '%' . strtolower($term) . '%')
                            ->orWhere(DB::raw('LOWER(last_name)'), 'LIKE', '%' . strtolower($term) . '%')
                            ->orWhere(DB::raw('LOWER(middle_name)'), 'LIKE', '%' . strtolower($term) . '%');
                    }
                })
                ->select(['id', 'first_name', 'last_name', 'middle_name'])
                ->take(10)
                ->get();

        } elseif ($type === 'staff')
        {
            $searchTerms = explode(" ", $value);

            $users = User::whereDoesntHave('staff')
                ->where(function ($query) use ($searchTerms) {
                    foreach ($searchTerms as $term)
                    {

                        $query->orWhere(DB::raw('LOWER(first_name)'), 'LIKE', '%' . strtolower($term) . '%')
                            ->orWhere(DB::raw('LOWER(last_name)'), 'LIKE', '%' . strtolower($term) . '%')
                            ->orWhere(DB::raw('LOWER(middle_name)'), 'LIKE', '%' . strtolower($term) . '%');
                    }
                })
                ->select(['id', 'first_name', 'last_name', 'middle_name'])
                ->take(10)
                ->get();

        }


        return response()->json($users ?? []);
    }

    public function syncUsers($type)
    {
        ini_set('max_execution_time', 300);

        if ($type === 'teacher')
        {

            $currentUsers = User::pluck('id')->toArray();

            $code = config('variables.api_key');

            $url = 'https://sis.materdeicollege.com/api/hr/users-teachers';

            $client = new Client();

            $response = $client->get($url, [
                'query' => [
                    'user_ids' => $currentUsers,
                    'code' => $code,
                ],
                'verify' => false,
            ]);

            $newUsers = json_decode($response->getBody(), true);

            foreach ($newUsers as $userData)
            {

                $user = User::create([
                    'id' => $userData['id'],
                    'user' => $userData['user'],
                    'first_name' => $userData['fname'],
                    'last_name' => $userData['lname'],
                    'email' => $userData['email'],

                ]);

                $user->assignRole('teacher');

                if (isset($userData['teacher_account']))
                {
                    Teacher::create([
                        'id' => $userData['teacher_account']['id'],
                        'user_id' => $userData['teacher_account']['user_id'],
                        'department_id' => $userData['teacher_account']['department_id'],
                        'specialization' => $userData['teacher_account']['specialization'],
                    ]);


                }
            }

            return redirect()->back()->with('success', 'Users synced successfully!');

        } else if ($type === 'staff')
        {
            $currentUsers = User::pluck('id')->toArray();

            $code = config('variables.api_key');

            $url = 'https://sis.materdeicollege.com/api/hr/non-teaching-users/';

            $client = new Client();

            $response = $client->get($url, [
                'query' => [
                    'code' => $code,
                ],
                'verify' => false,
            ]);

            $newUsers = json_decode($response->getBody(), true);

            $existingUserIds = User::all()->pluck('id')->toArray();

            $newUsers = array_filter($newUsers, function ($user) use ($existingUserIds) {
                return !in_array($user['id'], $existingUserIds);
            });


            $newUsers = array_values($newUsers);

            foreach ($newUsers as $userData)
            {
                $exist = User::find($userData['id']);

                if (!$exist)
                {

                    $user = User::create([
                        'id' => $userData['id'],
                        'user' => $userData['user'],
                        'first_name' => $userData['fname'],
                        'last_name' => $userData['lname'],
                        'email' => $userData['email'],
                        'password' => $userData['password'],
                    ]);


                    Staff::create([
                        'user_id' => $userData['id'],
                    ]);

                    $user->assignRole('staff');
                }


            }

            return redirect()->back()->with('success', 'Users synced successfully!');
        }

    }

}
