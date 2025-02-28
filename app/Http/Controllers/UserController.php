<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\LeaveForm;
use App\Models\TravelForm;
use App\Models\User;
use App\Models\UserDepartment;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;
use Storage;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function updateProfilePicture(Request $request)
    {
        $validatedData = $request->validate([
            'image' => ['required', 'string'],
        ]);

        $imageData = $request->input('image');

        if (preg_match('/^data:image\/(\w+);base64,/', $imageData, $matches)) {
            $extension = $matches[1];
            $imageData = substr($imageData, strpos($imageData, ',') + 1);
            $imageData = base64_decode($imageData);

            if (!$imageData) {
                return redirect()->back()->with('error', 'Invalid image data.');
            }


            $path = 'public/users/images';

            if (!Storage::exists($path)) {
                Storage::makeDirectory($path, 0775, true);
            }


            $userId = (string)Auth::user()->id;


            $files = Storage::files($path);

            foreach ($files as $file) {

                $filePrefix = strtok(basename($file), '-');

                if ($filePrefix === $userId) {
                    Storage::delete($file);
                }
            }


            $dateTimeNow = Carbon::now()->format('Y-m-d-h-s');
            $fileName = Auth::user()->id . '-' . $dateTimeNow . '.' . $extension;

            $storedPath = Storage::put($path . '/' . $fileName, $imageData);

            User::find(Auth::user()->id)->update([
                'img' => $fileName,
            ]);

            if ($storedPath) {
                session()->flash('success', 'Image uploaded successfully!');
                return redirect()->route('account');
            } else {
                return redirect()->back()->with([
                    'error' => 'Error uploading the new image.',
                ]);
            }
        } else {
            return redirect()->back()->with('error', 'Invalid image format.');
        }
    }

    public function update(Request $request) {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::find(Auth::user()->id);


        $user->email = $request->email;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->back()->with('success', 'Account updated successfully!');
    }

    public function users(Request $request) {

        $users = User::orderBy('last_name')->get();

        $this->globalVariables();
        $roles = $this->roles;
        $departments = $this->departments;

        $roleList = Role::all();

        return Inertia::render('Pages/Admin/UserList', [
            'user' => Auth::user(),
            'users' => $users,
            'roles' => $roles,
            'pageTitle' => 'User List',
            'messageSuccess' => session('success') ?? null,
            'departments' => $departments,
            'roleList' =>  $roleList
        ]);
    }

    public function userView($id){
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



        ])->findOrFail($id);

        $userRoles = User::find($id)->getRoleNames();
        $userDepartments = User::where('id', $id)->with('departments:id,name,acronym')->first();

        $userDepartments =  $userDepartments->departments->pluck('name');

        $this->globalVariables();
        $roles = $this->roles;
        $departmentList = $this->parentDepartments;

        $roleList = Role::all();


            $leaveForms = LeaveForm::where('user_id', $id)
            ->where('status', 'approved')
            ->with([
                'substitutes.user',
                'user',
                'endorser',
                'userJobDetail',
                
            ])->orderBy('created_at', 'ASC')->get();


            $travelForms = TravelForm::where('user_id', $id)
            ->where('status', 'approved' )
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
            foreach ($forms as $formType => $formArray) {
                foreach ($formArray as $form) {
                    $form['form_type'] = $formType;
            
                    $form['endorser'] = $form['endorser'] ? $form['endorser']->toArray() : null;
                    $form['user_job_detail'] = $form['user_job_detail'] ? $form['user_job_detail']->toArray() : null;
                    
                    $flattenedForms[] = $form;
                }
            }
  
            usort($flattenedForms, function($a, $b) {
               return strtotime($b['created_at']) - strtotime($a['created_at']);
            });

         return Inertia::render('Pages/Admin/UserView', [
            'user' => Auth::user(),
            'personalDetails' => $personalDetails,
            'roles' => $roles,
            'userRoles' => $userRoles,
            'pageTitle' => 'User Details',
            'userDepartments' => $userDepartments,
            'roleList'=>  $roleList,
            'user_id' => $id,
            'messageSuccess' => session('success') ?? null,
            'departmentList' => $departmentList,
            'forms'=>  $flattenedForms
        ]);

    }

    public function userEvaluation($id){
        $user = User::findOrFail($id);
        return inertia('Pages/Forms/Evaluation/Evaluation',[
        'user' => $user,
        ]);
    }


    public function userAdd(Request $request){

        $username = $request->first_name[0] . $request->last_name;
        $originalUsername = $username;
        $counter = 1;

        while (User::where('user', $username)->exists()) {
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

        $roles = Role::whereIn('id', $request->roles)->get();

        foreach ($request->departments as $dept) {
            $department = Department::where('parent_id',$dept)->get();
        
            foreach($department as $subDept){
          
                UserDepartment::create([
                    'user_id' => $user->id,
                    'department_id' => $subDept->id,
                    'type' => $roles->contains(function ($role) {
                        return $role->name === 'dean';
                    }) ? 'head' : 'member',
                ]);
            }

            UserDepartment::create([
                'user_id' => $user->id,
                'department_id' => $dept,
                'type' => $roles->contains(function ($role) {
                    return $role->name === 'dean';
                }) ? 'head' : 'member',
            ]);
        }

        foreach ($request->roles as $role) {
            $user->assignRole($role);
        }

        if ($user) {
            return redirect()->back()->with('success', 'User added successfully!');
        } else {
            return redirect()->back()->with('error', 'Error adding user.');
        }
    }
    
    public function userUpdateRole($user_id, Request $request)
    {
        $user = User::find($user_id);
    
       
        $user->syncRoles([]);

        
        if ($request->roles && !empty($request->roles)) {
            $user->assignRole($request->roles);
        }
    
        return redirect()->back()->with('success', 'Roles updated successfully!');
    }
    

}
