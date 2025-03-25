<?php

namespace App\Http\Controllers;

use App\Mail\VerificationEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class VerificationController extends Controller
{
    public function index()
    {

        $code = Str::random(6);


        $user = Auth::user();

        $user->update([
            'code' => $code
        ]);

        Mail::to(Auth::user()->email)->send(new VerificationEmail());

        $user->toArray();

        $user = collect($user)->only(['first_name', 'last_name', 'img']);


        if ($user)
        {

            return inertia('Pages/Login/Verification', [
                'user' => $user,
                'error' => session('error') ?? null,
            ]);

        }


    }

    public function verify(Request $request)
    {

        if (Auth::user()->code === $request->code)
        {
            Session::put('code', Auth::user()->code);
            return redirect()->route('dashboard');
        } else
        {
            return redirect()->back()->with('error', 'Verification code did not match, we sent you another code!');
        }

    }
}
