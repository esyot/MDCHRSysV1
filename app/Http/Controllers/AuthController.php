<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function auth(Request $request){

        
        $user = User::find(Auth::user()->id);

        if($user->password == Hash::make($request->password)){

            return redirect()->back()->with([
                'authChecked'=> true,
                'success' => 'Authenticated successfully!'
            ]
            );

        }else{
            return redirect()->back()->with([
                'authChecked'=> false,
                'error' => 'Authentication failed!'
             ]
            );

        }
    }
}
