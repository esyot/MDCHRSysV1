<?php

namespace App\Http\Controllers;

use App\Models\User;
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

    public function preview(Request $request){



        dd($request->toArray());

        return view('forms.leaveForm');
    }
}
