<?php

namespace App\Http\Middleware;


use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckIsDefaultPassword
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
        $user = Auth::user();


        if ($user->is_default_pass === 1)
        {
            return redirect()->route('account', [
                'tab' => "security",
                'is_default_pass' => true,
            ]);
        }

        return $next($request);
    }



}


