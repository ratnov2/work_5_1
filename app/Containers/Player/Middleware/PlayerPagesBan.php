<?php

namespace App\Containers\Player\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class PlayerPagesBan
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
        $player = Auth::guard('players')->user();
        if($player && $player->ban) {
            return response()->json([
                'status' => 'success',
                'page' => View::make('pages::ban-page')->render()
            ]);
        }
        return $next($request);
    }
}
