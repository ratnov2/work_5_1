<?php

namespace App\Containers\Player\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlayerApiBan
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
        if(Auth::guard('players')->user()->ban) {
            return response()->json([
                'status' => 'error',
                'msg' => 'Вы были заблокированы'
            ]);
        }
        return $next($request);
    }
}
