<?php

namespace App\Orchid\Screens\Contest;

use App\Containers\Contest\Data\Types\Status;
use App\Containers\Contest\Models\Contest;
use App\Containers\Item\Models\Item;
use App\Orchid\Helpers\Condition\GetConditionParams;
use App\Orchid\Layouts\Conditions\ConditionsLayout;
use App\Orchid\Layouts\Contest\ContestItemsLayout;
use App\Orchid\Layouts\Contest\ContestEditLayout;
use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Alert;

class ContestEditScreen extends Screen
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
    public function query(Contest $contest, Request $request): array
    {
        $this->exists = $contest->exists;

        if($this->exists){
            $this->name = 'Редактирование';
        }

        return [
            'contest' => $contest,
            'conditionable' => $contest,
            'items' => Item::filters()->paginate(5),
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
                ->icon('check')
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
            ContestItemsLayout::class,
            ContestEditLayout::class,
            ConditionsLayout::class,
        ];
    }

    public function create(Request $request)
    {
        $contest_params = $request->get('contest');

        $now = \Carbon\Carbon::now();
        $reserved_at = \Carbon\Carbon::parse($contest_params['reserved_at'], 'Europe/Moscow')->setTimezone('UTC');
        $end_at = \Carbon\Carbon::parse($contest_params['end_at'], 'Europe/Moscow')->setTimezone('UTC');

        if($end_at < $now) throw new \Exception('Завершение розыгрыша не может быть раньше текущего времени');
        if($reserved_at >= $end_at) throw new \Exception('Старт розыгрыша не может быть позже его завершения');

        $contest_params['reserved_at'] = $reserved_at < $now ? $now : $reserved_at;
        $contest_params['end_at'] = $end_at;
        $contest_params['status'] = Status::Wait;


        $condition_params = $request->get('condition');
        $condition_params = app(GetConditionParams::class)->run($condition_params);

        DB::transaction(function() use($contest_params, $condition_params) {
            Contest::where('position', '>=', $contest_params['position'])->orderBy('position', 'desc')->increment('position');
            $contest = Contest::create($contest_params);
            $contest->condition()->create($condition_params ?? []);
        });

        Alert::info('Успешное создание конкурса');
        return redirect()->route('platform.contest.list');
    }

    public function update(Contest $contest, Request $request)
    {
        $contest_params = $request->get('contest');

        $condition_params = $request->get('condition');
        $condition_params = app(GetConditionParams::class)->run($condition_params);

        DB::transaction(function() use($contest, $contest_params, $condition_params) {
            $contest->position < $contest_params['position']
                ? Contest::where([['position', '<=', $contest_params['position']], ['position', '>', $contest->position]])->decrement('position')
                : Contest::where([['position', '>=', $contest_params['position']], ['position', '<', $contest->position]])->increment('position');

            $contest->fill($contest_params);
            $contest->save();
            
            $contest->condition
                ? $contest->condition()->update($condition_params ?? [])
                : $contest->condition()->create($condition_params ?? []);
        });

        Alert::info('Успешное обновление конкурса');
        return redirect()->route('platform.contest.list');
    }

    public function remove(Contest $contest)
    {
        $contest->delete();

        Alert::info('Конкурс успешно удален');
        return redirect()->route('platform.contest.list');
    }
}
