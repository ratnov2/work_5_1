<?php

namespace App\Orchid\Screens\Player;

use App\Containers\Player\Models\Player;
use App\Containers\Player\Models\PlayerRole;
use App\Containers\RefSystem\Models\RefLevel;
use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class PlayerEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Редактирование';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(Player $player): array
    {
        $this->name .= ' ' . $player->name;
        return [
            'player' => $player
        ];
    }


    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Button::make('Обновить')
                ->icon('note')
                ->method('update')
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): array
    {
        return [
            Layout::rows([
                Relation::make('player.ref_level_id')
                    ->fromModel(RefLevel::class, 'id')
                    ->displayAppend('full')
                    ->title('Выберите реферальный уровень')
                    ->required(),

                Relation::make('player.roles.')
                    ->fromModel(PlayerRole::class, 'slug')
                    ->displayAppend('name')
                    ->multiple()
                    ->title('Роль'),

                Input::make('player.trade_link')
                    ->title('Trade-ссылка'),

                Input::make('player.balance')
                    ->type('number')
                    ->step(0.01)
                    ->title('Баланс (РУБ)'),

                Input::make('player.ref_balance')
                    ->type('number')
                    ->step(0.01)
                    ->title('Реф. баланс (РУБ)'),

                CheckBox::make('player.ban')
                    ->sendTrueOrFalse()
                    ->title('Забанен'),

                CheckBox::make('player.withdraw')
                    ->sendTrueOrFalse()
                    ->title('Выводы открыты'),
            ])
        ];
    }


    public function update(Player $player, Request $request)
{
        $params = $request->get('player');

        if(isset($params['roles'])) {
            $player->roles()->sync($params['roles']);
            unset($params['roles']);
        } else {
            $player->roles()->detach();
        }

        $player->fill($params);
        $player->save();

        Alert::info('Успешное обновление пользователя');

        return redirect()->route('platform.player.list');
    }
}
