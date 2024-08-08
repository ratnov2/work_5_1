<?php

namespace App\Containers\Auth\UI\Controllers;

use App\Http\Controllers\Controller;
use App\Containers\Player\Events\PlayerRegisteredEvent;
use App\Containers\Player\Models\Player;
use App\Containers\RefSystem\Tasks\GetStartRefLevelTask;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Invisnik\LaravelSteamAuth\SteamAuth;

class SteamAuthController extends Controller
{
    /**
     * The SteamAuth instance.
     *
     * @var SteamAuth
     */
    protected $steam;

    /**
     * The redirect URL.
     *
     * @var string
     */
    protected $redirectURL = '/';

    /**
     * AuthController constructor.
     *
     * @param SteamAuth $steam
     */
    public function __construct(SteamAuth $steam)
    {
        $this->steam = $steam;
    }

    /**
     * Redirect the player to the authentication page
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function redirectToSteam()
    {
        return $this->steam->redirect();
    }

    /**
     * Get player info and log in
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function handle()
    {
        try {
            if (!$this->steam->validate()) throw new \Exception('Steam is invalid');
            $info = $this->steam->getUserInfo();
            if (is_null($info)) throw new \Exception('Info is null');

            $player = $this->findOrNewPlayer($info);
            Auth::guard('players')->login($player, true);

            return redirect()->route('spa');

        } catch (\Throwable $th) {
            Log::error('['.$th->getCode().']' . ' ' . get_class($th) . ' "' . $th->getMessage().'" on line ' . $th->getTrace()[0]['line'] . ' of file ' . $th->getTrace()[0]['file']);

            return redirect()->route('spa')->with([
                'status' => 'error',
                'msg' => 'Ошибка регистрации пользователя. Попробуйте позже...'
            ]);
        }
    }

    /**
     * Getting player by info or created if not exists
     *
     * @param $info
     * @return Player
     */
    protected function findOrNewPlayer($info) {
        return DB::transaction(function() use($info) {
            $player = Player::where('steam_id', $info->steamID64)->lockForUpdate()->first();

            if ($player) {
                $player->fill([
                    'image' => $info->avatarfull,
                    'name' => htmlspecialchars($info->personaname),
                ])->save();

            } else {
                $player = Player::create([
                    'image' => $info->avatarfull,
                    'name' => htmlspecialchars($info->personaname),
                    'steam_id' => $info->steamID64,
                    'ref_code' => $info->steamID64,
                    'ref_level_id' => app(GetStartRefLevelTask::class)->run()->id,
                ]);
                
                event(new PlayerRegisteredEvent($player));
            }

            return $player;
        });
    }

    public function logout()
    {
        Auth::guard('players')->logout();
        return redirect('/');
    }
}
