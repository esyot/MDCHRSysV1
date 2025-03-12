<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function index()
    {

        if (auth()->check())
        {
            return redirect()->route('dashboard');
        }

        $responseData = session('responseData');
        return inertia('Pages/Login/Login', [
            'responseData' => $responseData
        ]);
    }

    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'user' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where('user', $validatedData['user'])->first();

        $responseData = [
            'user' => [
                'value' => $validatedData['user'],
                'errorMessage' => '',
            ],
            'password' => [
                'value' => $validatedData['password'],
                'errorMessage' => '',
            ],
            'errorMessage' => '',
        ];

        if (!$user)
        {

            $responseData['user']['errorMessage'] = 'Username does not exist.';
        } elseif (!Hash::check($validatedData['password'], $user->password))
        {

            $responseData['password']['errorMessage'] = 'Invalid password.';
        } else
        {

            if ($user->is_two_step_verification == true)
            {

                Auth::login($user);
                return redirect()->route('verification');

            } else
            {

                Auth::login($user);
                return redirect()->route('dashboard');
            }
        }

        return redirect()->route('login')->with([
            'responseData' => $responseData,
        ]);
    }
}
