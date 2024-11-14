<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cookie;

class RedirectIfUser
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
        if (!Cookie::has('api_token') && !Cookie::has('user_id') && Cookie::get('user_role') !== 'User') {
            return redirect()->route('login');
        }
        
        return $next($request);
    }
}
