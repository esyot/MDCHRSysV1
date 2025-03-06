<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function auth(Request $request)
    {
        $user = Auth::user();

        $isAuthenticated = Hash::check($request->password, $user->password);

        if ($isAuthenticated)
        {

            Session::put('authenticate', true);

            return redirect()->back()->with([
                'success' => 'Authenticated successfully!'
            ]);

        } else
        {

            return redirect()->back()->with([
                'authenticated' => false,
                'error' => 'Authentication failed!'
            ]);
        }
    }
}
