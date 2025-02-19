<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\User;
use App\Models\UserDepartment;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
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

        return Inertia::render('Pages/Admin/UserList', [
            'user' => Auth::user(),
            'users' => $users,
            'roles' => $roles,
            'pageTitle' => 'User List',
            'messageSuccess' => session('success') ?? null,
            'departments' => $departments,
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

        $this->globalVariables();
        $roles = $this->roles;

         return Inertia::render('Pages/Admin/UserView', [
            'user' => Auth::user(),
            'personalDetails' => $personalDetails,
            'roles' => $roles,
            'pageTitle' => 'User Details',
        ]);

    }

    public function userEvaluation($id){
        $users = User::findOrFail($id);
        return Inertia::render('Pages/Forms/Evaluation/Evaluation',[
        'users' => $users,
        ]);
    }


    public function userAdd(Request $request){

        $user = User::create([
            'user' => $request->first_name[0] . $request->last_name,
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'email' => 'example@email.com',

        ]);

        $user->password = Hash::make('12345678');
        $user->save();


        foreach($request->departments as $dept){

            UserDepartment::create([
                'user_id' => $user->id,
                'department_id' => $dept,
            ]);
        }

        if($user){
            $user->assignRole('staff');

            return redirect()->back()->with('success', 'User added successfully!');

        }else{
            return redirect()->back()->with('error', 'Error adding user.');
        }
    }

}
