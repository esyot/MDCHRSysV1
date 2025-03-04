<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (Auth::check()) {
            $user = Auth::user();

          
            if (!$user->hasAnyRole($roles)) {
                return redirect()->route('unauthorized')->with('error', 'You do not have permission to access this page.');
            }
        } else {
            return redirect()->route('guest')->with('error', 'You need to be logged in to access this page.');
        }

        return $next($request);
    }
}
