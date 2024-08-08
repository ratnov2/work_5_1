<?php

namespace App\Orchid\Screens\Player;

use App\Containers\Player\Models\Player;
use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Support\Facades\Toast;
use App\Orchid\Layouts\Player\PlayerListLayout;

class PlayerListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Игроки';

    /**
     * Display header description.
     *
     * @var string
     */
    public $description = 'Все Игроки';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'players' => Player::filters()->defaultSort('id')->paginate(10)
        ];
    }

    /**
     * Button commands.
     *
     * @return Link[]
     */
    public function commandBar(): array
    {
        return [

        ];
    }

    /**
     * Views.
     *
     * @return Layout[]
     */
    public function layout(): array
    {
        return [
            PlayerListLayout::class
        ];
    }


    /**
     * @param Request $request
     */
    public function ban(Request $request): void
    {
        Player::where('id', $request->get('id'))->update(['ban' => true]);

        $msg = 'Пользователь забанен';
        Toast::info($msg);
    }

    /**
     * @param Request $request
     */
    public function unban(Request $request): void
    {
        Player::where('id', $request->get('id'))->update(['ban' => false]);

        $msg = 'Пользователь разбанен';
        Toast::info($msg);
    }

    /**
     * @param Request $request
     */
    public function closeWithdraw(Request $request): void
    {
        Player::where('id', $request->get('id'))->update(['withdraw' => false]);

        $msg = 'Выводы успешно закрыты';
        Toast::info($msg);
    }

    /**
     * @param Request $request
     */
    public function openWithdraw(Request $request): void
    {
        Player::where('id', $request->get('id'))->update(['withdraw' => true]);

        $msg = 'Выводы успешно закрыты';
        Toast::info($msg);
    }
}
