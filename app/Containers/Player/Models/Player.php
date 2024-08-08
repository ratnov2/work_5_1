<?php

namespace App\Containers\Player\Models;

use App\Containers\BoxUnique\Models\BoxPromocode;
use App\Containers\BoxLimit\Models\BoxLimit;
use App\Containers\Contest\Models\Contest;
use App\Containers\Jackpot\Models\JackpotBet;
use App\Containers\Mines\Models\MinesGame;
use App\Containers\PaymentSection\Payment\Models\Payment;
use App\Containers\Player\Data\Factories\PlayerFactory;
use App\Containers\RefSystem\Models\RefLevel;
use App\Containers\SiteQuest\Models\SiteQuest;
use App\Containers\Upgrade\Models\Upgrade;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;
use Jenssegers\Date\Date;

class Player extends Authenticatable
{
    use HasFactory, Notifiable, AsSource, Filterable, Authorizable;

    protected $fillable = [
        'ref_balance',
        'referrer_id',
        'ref_level_id',
        'name',
        'trade_link',
        'ref_code',
        'balance',
        'image',
        'steam_id',
        'ban',
        'withdraw',
    ];

    protected $allowedFilters = [
        'id',
        'steam_id',
        'name',
        'balance',
        'created_at',
    ];

    protected $allowedSorts = [
        'id',
        'steam_id',
        'name',
        'balance',
        'created_at',
    ];

    protected $with = [
        'roles'
    ];

    protected $casts = [
        'ban' => 'boolean',
        'withdraw' => 'boolean',
    ];

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return PlayerFactory::new();
    }

    public function scopeDefault($query)
    {
        return $query->whereDoesntHave('roles', function($query) {
            $query->whereIn('slug', ['admin', 'developer']);
        });
    }

    public function scopeEmployee($query)
    {
        return $query->whereHas('roles', function($query) {
            $query->where('slug', 'admin')->orWhere('slug', 'developer')->orWhere('slug', 'blogger');
        });
    }

    public function getHumanCreatedAtAttribute()
    {
        return Date::parse($this->created_at)->format('l j F Y H:i:s');
    }

    public function getHumanUpdatedAtAttribute()
    {
        return Date::parse($this->updated_at)->format('l j F Y H:i:s');
    }

    public function box_promocodes()
    {
        return $this->belongsToMany(BoxPromocode::class);
    }

    public function ref_level()
    {
        return $this->belongsTo(RefLevel::class);
    }

    public function next_ref_level()
    {
        $next_ref_level = RefLevel::where([['type', $this->ref_level->type], ['level', $this->ref_level->level + 1]])->first();
        return $next_ref_level ?? $this->ref_level;
    }

    public function vkAccount()
    {
        return $this->hasOne(PlayerVkAccount::class);
    }

    public function telegramAccount()
    {
        return $this->hasOne(PlayerTelegramAccount::class);
    }

    public function referrals() {
        return $this->hasMany(Player::class, 'referrer_id');
    }

    public function referrer() {
        return $this->belongsTo(Player::class, 'referrer_id');
    }

    public function jackpotBets()
    {
        return $this->hasMany(JackpotBet::class);
    }

    public function upgrades()
    {
        return $this->hasMany(Upgrade::class);
    }

    public function items()
    {
        return $this->hasMany(PlayerItem::class);
    }

    public function contests()
    {
        return $this->belongsToMany(Contest::class);
    }

    public function minesGames()
    {
        return $this->hasMany(MinesGame::class);
    }

    public function boxes_limit()
    {
        return $this->belongsToMany(BoxLimit::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function site_quests()
    {
        return $this->belongsToMany(SiteQuest::class)->withPivot([
            'id', 
            'wait_work_comment',
            'wait_done_comment',
            'wait_work_answer',
            'wait_done_answer',
            'status',
        ]);
    }

    public function roles()
    {
        return $this->belongsToMany(PlayerRole::class, 'player_role', 'player_id', 'role_id', 'id', 'id');
    }
}
