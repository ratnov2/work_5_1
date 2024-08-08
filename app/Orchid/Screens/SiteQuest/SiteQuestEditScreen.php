<?php

namespace App\Orchid\Screens\SiteQuest;

use App\Containers\Site\Models\Site;
use App\Containers\SiteQuest\Models\SiteQuest;
use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Quill;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class SiteQuestEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Создание';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(Site $site, SiteQuest $quest): array
    {
        $this->exists = $quest->exists;

        if ($this->exists) $this->name = 'Редактирование';

        return [
            'quest' => $quest
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
            Button::make('Создать')
                ->icon('pencil')
                ->method('create')
                ->canSee(!$this->exists),

            Button::make('Обновить')
                ->icon('note')
                ->method('update')
                ->canSee($this->exists),

            Button::make('Удалить')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->exists),
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
                Input::make('quest.name')
                    ->type('text')
                    ->title('Название задания')
                    ->required(),

                Quill::make('quest.description')
                    ->title('Описание задания')
                    ->required(),

                Input::make('quest.reward_price')
                    ->type('number')
                    ->step('0.01')
                    ->title('Награда (монетки)')
                    ->required(),

                DateTimer::make('quest.end_at')
                    ->title('Дата завершения'),

                CheckBox::make('quest.is_wait_work_answer_required')
                    ->title('Требуется информация перед началом выполнения задания?')
                    ->value(true)
                    ->sendTrueOrFalse(),

                CheckBox::make('quest.is_wait_work_answer_required')
                    ->title('Требуется информация перед удтверждением задания?')
                    ->value(true)
                    ->sendTrueOrFalse(),

                CheckBox::make('quest.is_active')
                    ->title('Активный?')
                    ->value(true)
                    ->sendTrueOrFalse(),
            ])
        ];
    }

    public function create(Request $request, Site $site)
    {
        $params = $request->get('quest');
        $params['site_id'] = $site->id;

        if (!$this->validateParams($params)) return;

        SiteQuest::create($params);

        Alert::info('Успешно');

        return redirect()->route('platform.site.quest.list', $site->id);
    }

    public function update(Request $request, Site $site, SiteQuest $quest)
    {
        $params = $request->get('quest');
        $params['site_id'] = $site->id;

        if (!$this->validateParams($params)) return;

        $quest->fill($params);
        $quest->save();

        Alert::info('Успешно');

        return redirect()->route('platform.site.quest.list', $site->id);
    }

    private function validateParams($params)
    {
        if (!is_null($params['end_at'])) if ($params['end_at'] <= \Carbon\Carbon::now()) {
            Toast::info('Завершение задание должно быть в будущем...');
            return false;
        }

        return true;
    }

    public function remove(Site $site, SiteQuest $quest)
    {
        $quest->delete();

        Alert::info('Успешно удален');

        return redirect()->route('platform.site.quest.list', $site->id);
    }
}
