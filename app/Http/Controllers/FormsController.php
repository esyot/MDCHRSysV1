<?php

namespace App\Http\Controllers;

use App\Models\LeaveForm;
use App\Models\TravelForm;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FormsController extends Controller
{
    public function index()
    {
        $this->globalVariables();
    
        $roles = $this->roles;
        $user = Auth::user();
           
        $travelForms = TravelForm::where('user_id', $user->id)
        ->orderBy('created_at', 'ASC')
        ->get();
            
        $travelForms->transform(function ($form) use ($user) {
            $form->first_name = $user->first_name;
            $form->last_name = $user->last_name;
            $form->middle_name = $user->middle_name;
            return $form;
        });
            
        $leaveForms = LeaveForm::where('user_id', Auth::user()->id)
        ->with([
            'substitutes',
            'substitutes.user'
        ])->orderBy('created_at', 'ASC')->get();
       
        $forms = [];
        $forms['Travel Form'] = $travelForms;
        $forms['Leave Form'] = $leaveForms;
          
        $flattenedForms = [];
        foreach ($forms as $formType => $formArray) {
            foreach ($formArray as $form) {
                $form['form_type'] = $formType;
                $flattenedForms[] = $form;
            }
        }
        
        usort($flattenedForms, function($a, $b) {
           return strtotime($b['created_at']) - strtotime($a['created_at']);
        });
        
        return inertia('Pages/Forms/Tracking/Tracking', [
            'roles' => $roles,
            'user' => $user,
            'forms' => $flattenedForms,
            'messageSuccess' => session('success') ?? null,
            'pageTitle'=> 'Track Forms'
        ]);
            
    }

    public function checking($action=null){

        $this->globalVariables();
        $roles = $this->roles;
        $user = $this->user;

            $travelForms = TravelForm::orderBy('created_at', 'ASC')
            ->with('user')
            ->get();
            
            $travelForms->transform(function ($form) use ($user) {
                $form->first_name = $user->first_name;
                $form->last_name = $user->last_name;
                $form->middle_name = $user->middle_name;
                return $form;
            });
           
            $leaveForms = LeaveForm::with([
                'substitutes',
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
                    $flattenedForms[] = $form;
                }
            }
    
            
            usort($flattenedForms, function($a, $b) {
               return strtotime($b['created_at']) - strtotime($a['created_at']);
            });
              
            return inertia('Pages/Forms/Checking/Checking', [
                'user' => $user,
                'pageTitle' => 'Checking',
                'selected' => $action ?? 'all',
                'forms' => $flattenedForms, 
                'roles' => $roles
            ]);
        
    }

    public function forward(Request $request){


        dd($request->toArray());
        
       if($request->action == 'endorse'){

       if($request->form_type == 'Leave Form'){

        LeaveForm::find($request->id)
        ->update([
            'status' => 'endorsed',
            'endorsed_by' => Auth::user()->id,
        ]);
       }
       
       }

       if($request->action == 'recommend'){
        if($request->form_type == 'Leave Form'){

            LeaveForm::find($request->id)
            ->update([
                'status' => 'recommended',
                'recommended_by' => Auth::user()->id,
            ]);
           }
       }

    }
}
