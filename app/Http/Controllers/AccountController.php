<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
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

    public function accountFeatureUpdate(Request $request)
    {
      
        $user = Auth::user();
    
        $user->update([
            'is_update_with_email' => $request->is_update_with_email == 'on' ?  1 : 0 ,
            'is_two_step_verification' => $request->is_two_step_verification == 'on' ? 1 : 0,
        ]);
       
        return redirect()->back()->with('success', 'Account settings updated successfully!');
    }
    
}
