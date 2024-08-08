<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class GameModeSecret
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
        
        if(config('game_mode.secret') !== $secret) return response()->json([
            'status' => 'error',
            'msg' => 'Ошибка токена'
        ]);

        return $next($request);
    }
}
