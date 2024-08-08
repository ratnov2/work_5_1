<?php

namespace App\Containers\Jackpot\Middleware;

use Closure;
use Illuminate\Http\Request;

class JackpotSecret
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
        $secret = $request->header('Authorization');
        if(config('jackpot.secret') !== $secret) abort(403);
        return $next($request);
    }
}
