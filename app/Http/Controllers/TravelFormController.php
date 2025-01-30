<?php

namespace App\Http\Controllers;

use App\Models\TravelForm;
use App\Models\User;
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

    public function submit(Request $request){

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

        if($request){

            $request->merge([
                'user_id'=>Auth::user()->id
            ]);

            $travelForm = TravelForm::create($request->all());

            if($travelForm){
                return redirect()->back()->with('success', 'Travel request submitted successfully!.');
            }else{
                return redirect()->back()->with('error', 'Travel request submission failed!.');
            }
        }
        
    }
}
