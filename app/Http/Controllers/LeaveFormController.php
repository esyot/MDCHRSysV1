<?php

namespace App\Http\Controllers;

use App\Events\NotificationCreate;
use App\Models\LeaveForm;
use App\Models\Substitute;
use App\Models\User;
use App\Models\UserDepartment;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class LeaveFormController extends Controller
{
    public function index()
    {

        $this->globalVariables();
        $roles = $this->roles;

        $personalDetails = User::with([
            'personalDetails',
            'personalDetails.permanentAddress',
            'personalDetails.residentialAddress',

        ])
            ->where('users.id', Auth::user()->id)
            ->first();

            $users = User::whereNot('id', Auth::user()->id)
            ->orderBy('last_name')
            ->get([
                'id','first_name', 'last_name'
            ]); 
            
        return inertia('Pages/Forms/LeaveForm/LeaveForm', [

            'user' => Auth::user(),
            'roles' => $roles,
            'personalDetails' => $personalDetails->toArray(),
            'pageTitle'=> 'Leave Form',
            'users'=> $users->toArray(),
        ]);
    }

    public function submit(Request $request)
    {        
        $formData = $request->toArray();

        unset($formData['medical_certificate']); 
        
        unset($formData['substitutes']);

        unset($formData['substitute']);
        
        $formData['user_id'] = Auth::user()->id;

        $leave_form = LeaveForm::create($formData);

        if ($request->hasFile('medical_certificate')) {
           
            $file = $request->file('medical_certificate');
            
           
            $path = 'public/users/medical_certificates';

            if (!Storage::exists($path)) {
                Storage::makeDirectory($path, 0775, true);
            }
            
            if (!$file->isValid()) {
                return redirect()->back()->with('error', 'Invalid file uploaded.');
            }
        
            $extension = $file->getClientOriginalExtension();
    
            $dateTimeNow = Carbon::now()->format('Y-m-d-H-i-s');
            $fileName = $leave_form->user_id . '-' . $dateTimeNow . '.' . $extension;
    
            Storage::putFileAs($path, $file, $fileName);
    
            $leave_form->update([
                'medical_certificate' => $fileName,
            ]);
        }

        if ($request['substitute'] !== 'true') {
            unset($request['substitutes']);
        }
    
        if ($request->substitutes) {
          
            $array = $request->substitutes;

            $substitutes = json_decode($array, true);
        
               foreach($substitutes as $sub){

                $sub['leave_form_id'] = $leave_form->id;
                
                unset($sub['days']);
                unset($sub['teacher']);
    
               
                $days = isset($sub['days']) && is_array($sub['days']) ? implode(', ', $sub['days']) : '';

                $sub['days'] = $days;
              
                Substitute::create($sub);

               }
              
            }

           
            $notificationController = new NotificationController();

            $notificationController->create(
                'Leave Form', 
                'A user submitted a leave form, check it now!',
                'checking',
                'dean',
                '/forms/checking'
        );
          

        
    
        return redirect()->route('forms.tracking')->with('success', 'Leave request submitted successfully!.');
            
    }
    
}
