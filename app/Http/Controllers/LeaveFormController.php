<?php

namespace App\Http\Controllers;

use App\Models\LeaveForm;
use App\Models\Substitute;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


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

    public function preview(Request $request)
    {
       
        $formData = $request->formData;

        $formData['user_id'] = Auth::user()->id;

        $leave_form = LeaveForm::create($formData);

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
    
        return redirect()->route('forms.tracking')->with('success', 'Leave request submitted successfully!.');
            
    }
    
}
