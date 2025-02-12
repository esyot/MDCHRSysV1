<?php

namespace App\Http\Controllers;

use App\Models\LeaveForm;
use App\Models\Substitute;
use App\Models\User;
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

        $formData['user_id'] = Auth::user()->id;

        $leave_form = LeaveForm::create($formData);

       

        if ($request->medical_certificate) {

            $file = $request->file('medical_certificate');

            $path = 'public/users/medical_certificates';

            $imageData = $request->input('medical_certificate');
             
            if (preg_match('/^data:image\/(\w+);base64,/', $imageData, $matches)) {
                $extension = $matches[1];
                $imageData = substr($imageData, strpos($imageData, ',') + 1);
                $imageData = base64_decode($imageData);
    
                if (!$imageData) {
                    return redirect()->back()->with('error', 'Invalid image data.');
                }
    
                $dateTimeNow = Carbon::now()->format('Y-m-d-H-i-s');
                $fileName = $leave_form->user_id . '-' . $dateTimeNow . '.' . $extension;
    
                Storage::put($path . '/' . $fileName, $imageData);
    
                $leave_form->update([
                    'medical_certificate' => $fileName, 
                ]);

            } else {
                
                $fileName = $file->getClientOriginalName();
                $file->storeAs($path, $fileName);
               
                $leave_form->update([
                    'medical_certificate' => $fileName,
                ]);
            }
        }

       
    
        if($request->substitutes){

        $substitutes = $request->input('substitutes');
        $groupedSubstitutes = [];
        $currentGroup = [];
    
        foreach ($substitutes as $item) {
            if (isset($item['subject'])) {
                
                if (!empty($currentGroup)) {
                    $groupedSubstitutes[] = $currentGroup;
                    $currentGroup = [];
                }
                $currentGroup['subject'] = $item['subject'];
            } elseif (isset($item['user_id'])) {
                $currentGroup['user_id'] = $item['user_id'];
            } elseif (isset($item['teacher'])) {
                $currentGroup['teacher'] = $item['teacher'];
            } elseif (isset($item['days'])) {
               
                if (!isset($currentGroup['days'])) {
                    $currentGroup['days'] = [];
                }
                $currentGroup['days'] = array_merge($currentGroup['days'], $item['days']);
            } elseif (isset($item['start_time'])) {
                $currentGroup['start_time'] = $item['start_time'];
            } elseif (isset($item['end_time'])) {
                $currentGroup['end_time'] = $item['end_time'];
            }

            if (isset($currentGroup['subject'], $currentGroup['user_id'], $currentGroup['teacher'], $currentGroup['days'], $currentGroup['start_time'], $currentGroup['end_time'])) {
                $groupedSubstitutes[] = $currentGroup;
                $currentGroup = []; 
            }
        }
    
       
        if (!empty($currentGroup)) {
            $groupedSubstitutes[] = $currentGroup;
        }

        
        foreach ($groupedSubstitutes as $substitute) {
            $sub = Arr::except($substitute, ['teacher']);
        
            if (is_array($sub['days'])) {
                $sub['days'] = implode(',', $sub['days']);
            }
            
            $sub['leave_form_id'] = $leave_form->id;
            
            Substitute::create($sub);
        }
    }
    
        return redirect()->route('forms.tracking')->with('success', 'Leave request submitted successfully!.');
            
    }
    
}
