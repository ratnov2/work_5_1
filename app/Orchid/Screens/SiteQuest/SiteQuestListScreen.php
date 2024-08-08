<?php

namespace App\Orchid\Screens\SiteQuest;

use App\Containers\Site\Models\Site;
use App\Containers\SiteQuest\Models\SiteQuest;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Screen;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class SiteQuestListScreen extends Screen
{
    protected $site;
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Квесты';

    /**
     * Display header description.
     *
     * @var string
     */
    public $description = 'Все квесты';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(Site $site): array
    {
        $this->site = $site;

        return [
            'quests' => $site->quests()->orderBy('id', 'desc')->paginate(10)
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
            Link::make('Создать квест')
                ->icon('pencil')
                ->route('platform.site.quest.edit', $this->site->id)
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
            Layout::table('quests', [
                TD::make('id', 'ID'),
                TD::make('name', 'Название квеста'),
                TD::make('reward_price', 'Награда (монетки)'),
                TD::make('end_at', 'Завершится'),
                TD::make('is_active', 'Активен?')
                    ->render(function (SiteQuest $quest) {
                        return $quest->is_active ? 'Да' : 'Нет';
                    }),
                TD::make(__('Действия'))
                    ->align(TD::ALIGN_CENTER)
                    ->render(function ($site_quest) {
                        return DropDown::make()
                            ->icon('options-vertical')
                            ->list([
                                Link::make(__('Редактировать'))
                                    ->icon('pencil')
                                    ->route('platform.site.quest.edit', [$this->site->id, $site_quest->id]),

                                Button::make(__('Удалить'))
                                    ->icon('trash')
                                    ->method('remove', [
                                        'id' => $site_quest->id,
                                    ]),
                            ]);
                    }),
            ])
        ];
    }

    public function remove(SiteQuest $site_quest)
    {   
        $site_quest->delete();

        Toast::info('Сайт квест был удален');
    }
}
