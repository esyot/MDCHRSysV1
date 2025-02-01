<?php

namespace App\Http\Controllers;

use App\Models\TravelForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FormsController extends Controller
{
    public function  index(){

        $this->globalVariables();

        $roles = $this->roles;
        $user = Auth::user();


        $travelForms = TravelForm::where('user_id', Auth::user()->id)->get();

        $forms = [];
        $forms['Travel Form'] = $travelForms;

        $flattenedForms = [];
            
        foreach ($forms as $formType => $formArray) {
            foreach ($formArray as $form) {
            
                $form['form_type'] = $formType;
                $flattenedForms[] = $form;
            }
        }


      
        return inertia('Pages/Forms/Tracking/Tracking',[
            'roles'=> $roles,
            'user'=>$user,
            'forms' => $flattenedForms
        ]);

        
    }
}
