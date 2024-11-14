<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cookie;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Cookie::has('api_token')) {
            $userRole = Cookie::get('user_role');
            if ($userRole === 'Admin') {
                return redirect()->route('dashboard');
            } elseif ($userRole === 'User') {
                return redirect()->route('landing-page');
            }
        }

        return $next($request);
    }
}
