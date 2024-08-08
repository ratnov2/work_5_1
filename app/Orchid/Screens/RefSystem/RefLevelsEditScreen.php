<?php

namespace App\Orchid\Screens\RefSystem;

use App\Containers\RefSystem\Models\RefLevel;
use App\Orchid\Exceptions\RefSystem\RefSystemException;
use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Toast;

class RefLevelsEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Добавление уровня';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(RefLevel $ref_level): array
    {
        $this->exists = $ref_level->exists;

        if($this->exists){
            $this->name = 'Редактирование ' . $ref_level->full;
        } else {

        }

        return [
            'ref_level' => $ref_level
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
                ->method('createOrUpdate')
                ->canSee(!$this->exists),

            Button::make('Обновить')
                ->icon('note')
                ->method('createOrUpdate')
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
                Input::make('ref_level.sum_payments')
                    ->type('number')
                    ->title('Требуется депозитов')
                    ->required(),

                Input::make('ref_level.level')
                    ->type('number')
                    ->value(RefLevel::standart()->count() + 1)
                    ->canSee(!$this->exists)
                    ->title('LVL')
                    ->readonly()
                    ->required(),

                Input::make('ref_level.bonus_precent')
                    ->type('number')
                    ->step(0.01)
                    ->title('Бонус за каждого реферала (%)')
                    ->required(),

                Input::make('ref_level.ref_bonus_precent')
                    ->type('number')
                    ->step(0.01)
                    ->title('Реф. бонус (%)')
                    ->required(),
            ])
        ];
    }

    public function createOrUpdate(RefLevel $ref_level, Request $request)
    {
        try {
            $params = $request->get('ref_level');
            if(isset($params['level']) && RefLevel::where([['level', $params['level']], ['id', '!=', $ref_level->id]])->exists()) throw new RefSystemException('Такой level уже существует');
            $params['type'] = 'standart';
            $ref_level->fill($params);
            $ref_level->save();

            Alert::info('Успешное обновление реферальной системы');

            return redirect()->route('platform.ref-level.list');

        } catch (RefSystemException $th) {
            Toast::error($th->getMessage());

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function remove(RefLevel $ref_level)
    {
        try {
            $count = $ref_level->players->count();
            if(RefLevel::standart()->count() == 1) throw new RefSystemException('Ошибка удаления: Должен существовать хотя бы 1 уровень реферальной системы');
            if($count > 0) throw new RefSystemException('Ошибка удаления: К данному левелу привязано: ' .  $count . ' игроков');
            if(RefLevel::where('level', '>', $ref_level->level)->exists()) throw new RefSystemException('Ошибка удаления: удалить можно только уровень с самым большим LVL');
            $ref_level->delete();

            Alert::info('Реферальный уровень успешно удален');

            return redirect()->route('platform.ref-level.list');

        } catch (RefSystemException $th) {
            Toast::error($th->getMessage());

        } catch (\Throwable $th) {
            throw $th;

        }
    }
}
