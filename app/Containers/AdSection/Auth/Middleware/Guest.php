<?php

namespace App\Containers\AdSection\Auth\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Closure;

class Guest
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
        if(Auth::guard('ad_users')->check()) {
            return redirect(route('ad.profile.index'));
        }

        return $next($request);
    }
}
