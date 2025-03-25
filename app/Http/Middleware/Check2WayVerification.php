<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Check2WayVerification
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {


        $user = User::find(Auth::user()->id);

        $code = Session::get('code');


        if ($user->is_two_step_verification === 1 && !$code)
        {

            return redirect()->route('verification');

        } else
        {

            $user->update([
                'code' => null,
            ]);

            return $next($request);
        }


    }
}


