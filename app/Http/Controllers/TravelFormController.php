<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Substitute;
use App\Models\TravelForm;
use App\Models\User;
use App\Models\UserDepartment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class TravelFormController extends Controller
{
    public function index(Request $request)
    {
   
        $this->globalVariables();
        $roles = $this->roles;

        $user = $this->user;

        $personalDetails = User::with([
            'personalDetails',
            'personalDetails.permanentAddress',
            'personalDetails.residentialAddress',

        ])
            ->where('users.id', Auth::user()->id)
            ->first();

            $users = User::whereNot('id', $user->id)->select([
                'id',
                'first_name',
                'middle_name',
                'last_name'
            ])->get();

           
        $budgetTypes = config('local_variables.budget_types');
        $budgetCharges = config('local_variables.budget_charges');

        return inertia('Pages/Forms/TravelForm/TravelForm', [
            'user' => $user,
            'users' => $users,
            'roles' => $roles,
            'personalDetails' => $personalDetails->toArray(),
            'budgetTypes' =>  $budgetTypes,
            'budgetCharges'=>  $budgetCharges,
            'messageSuccess' => session('success') ?? null,
            'formData' => $request ?? null,
            'pageTitle' => 'Travel Form'

        ]);
    }

      
    public function submit(Request $request){

        $formData = $request->formData;

        $formData['user_id'] = Auth::user()->id;

        $travelForm = TravelForm::create($formData);

      
        if ($request->substitutes) {
          
            $array = $request->substitutes;

           

            $substitutes = json_decode($array, true);
        
               foreach($substitutes as $sub){

                $sub['travel_form_id'] = $travelForm->id;
               

                unset($sub['days']);
                unset($sub['teacher']);
    
               
                $days = isset($sub['days']) && is_array($sub['days']) ? implode(', ', $sub['days']) : '';

                $sub['days'] = $days;
              
                Substitute::create($sub);
               }

        }
              
        if($travelForm){
            return redirect()->route('forms.tracking')->with('success', 'Travel request submitted successfully!.');
        }else{
            return redirect()->back()->with('error', 'Travel request submission failed!.');
        }
    }
           
}
