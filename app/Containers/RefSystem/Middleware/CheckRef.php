<?php

namespace App\Containers\RefSystem\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRef
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
        # Проверка реферальной системы
        if($request->has('ref')) {
            $request->session()->put('ref', $request->get('ref'));
        }
        return $next($request);
    }
}
