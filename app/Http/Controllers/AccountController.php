<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

class AccountController extends Controller
{
    public function index()
    {

        $this->globalVariables();
        $roles = $this->roles;

        $personalDetails = User::with([
            'personalDetails',
            'personalDetails.permanentAddress',
            'personalDetails.residentialAddress',
            'userJobDetails',
            'userFamilies',

        ])
            ->where('users.id', Auth::user()->id)
            ->first();

        $user = User::find(Auth::user()->id);

        $auth = Session::get('authenticate');

        if($auth == true){

            $auth = true;
            
        }else if($auth == null){

            $auth = false;
        }

        
        return Inertia::render('Pages/Account/Account', [
            'user' =>  $user,
            'roles' => $roles,
            'auth'=> $auth,
            'personalDetails' => $personalDetails,
            'messageSuccess' => session('success') ?? null,
            'authError' => session('error') ?? null,
        ]);
    }
}
