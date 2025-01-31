<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\TravelForm;
use App\Models\User;
use App\Models\UserDepartment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class TravelFormController extends Controller
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


        $budgetTypes = config('local_variables.budget_types');
        $budgetCharges = config('local_variables.budget_charges');

       
        return inertia('Pages/Forms/TravelForm/TravelForm', [

            'user' => Auth::user(),
            'roles' => $roles,
            'personalDetails' => $personalDetails->toArray(),
            'budgetTypes' =>  $budgetTypes,
            'budgetCharges'=>  $budgetCharges,
            'messageSuccess' => session('success') ?? null,
        ]);
    }

    public function preview(Request $request ){

        $request->validate([
            'date_start' => 'required|date',
            'date_end' => 'required|date|after_or_equal:date_start',
            'place' => 'required|string|max:255',
            'purpose' => 'required|string|max:255',
            'contact_person' => 'required|string|max:255',
            'contact_no' => 'nullable|string|max:255',
            'description' => 'required|string',
            'budget_type' => 'required|string|max:255',
            'budget_charged_to' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0', 
        ]);

        $user = Auth::user()->only(['id','first_name', 'last_name', 'middle_name']);

        $request->merge($user);
        $departments_ids = UserDepartment::where('user_id', Auth::user()->id)->pluck('id'); 

        $departments = Department::whereIn('id', $departments_ids)->get();
        
        $request->merge([
            'departments' => $departments->toArray()
        ]);
        
      
        return inertia('Pages/Forms/TravelForm/TravelFormPreview', [
            'formData' => $request,
        ]);
        
    }

   

    public function submit($travelFormData){

            $travelForm = TravelForm::create($travelFormData->all());

            if($travelForm){
                return redirect()->back()->with('success', 'Travel request submitted successfully!.');
            }else{
                return redirect()->back()->with('error', 'Travel request submission failed!.');
            }
        }
        
    
}
