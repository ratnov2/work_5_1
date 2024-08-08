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

class RefLevelsCustomEditScreen extends Screen
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
    public function query(RefLevel $ref_level): array
    {
        $this->exists = $ref_level->exists;

        if($this->exists){
            $this->name = 'Редактирование ' . $ref_level->full;
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

                Input::make('ref_level.name')
                    ->type('text')
                    ->title('Имя кастомного уровня')
                    ->required(),
            ])
        ];
    }

    public function createOrUpdate(RefLevel $ref_level, Request $request)
    {
        try {
            $params = $request->get('ref_level');
            if(RefLevel::where('name', $params['name'])->exists()) throw new RefSystemException('Уровень с таким именем уже существует');

            $params['type'] = 'custom';
            $params['level'] = null;
            $params['sum_payments'] = null;

            $ref_level->fill($params);
            $ref_level->save();

            Alert::info('Успешное создание реферального уровня');

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
            if($count > 0) throw new RefSystemException('Ошибка удаления: К данному левелу привязано: ' .  $count . ' игроков');
            $ref_level->delete();

            Alert::info('Кастомный реферальный уровень успешно удален');

            return redirect()->route('platform.ref-level.list');

        } catch (RefSystemException $th) {
            Toast::error($th->getMessage());

        } catch (\Throwable $th) {
            throw $th;

        }
    }
}
