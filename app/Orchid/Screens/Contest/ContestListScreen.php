<?php

namespace App\Orchid\Screens\Contest;

use App\Containers\Contest\Models\Contest;
use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Support\Facades\Toast;
use App\Orchid\Layouts\Contest\ContestListLayout;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;

class ContestListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Конкурсы';

    /**
     * Display header description.
     *
     * @var string
     */
    public $description = 'Все конкурсы';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'contests' => Contest::filters()->defaultSort('position')->paginate(10)
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
            Link::make('Создать конкурс')
                ->icon('pencil')
                ->route('platform.contest.edit')
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
            ContestListLayout::class
        ];
    }

    /**
     * @param Request $request
     */
    public function remove(Request $request): void
    {
        Contest::findOrFail($request->get('id'))
            ->delete();

        Toast::info('Конкурс успешно удален');
    }
}
