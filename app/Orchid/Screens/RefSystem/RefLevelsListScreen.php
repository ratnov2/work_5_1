<?php

namespace App\Orchid\Screens\RefSystem;

use App\Containers\RefSystem\Models\RefLevel;
use App\Orchid\Exceptions\RefSystem\RefSystemException;
use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Support\Facades\Toast;
use App\Orchid\Layouts\RefSystem\RefLevelsListLayout;
use App\Orchid\Layouts\RefSystem\RefCustomLevelsListLayout;

class RefLevelsListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Реферальные уровни';

    /**
     * Display header description.
     *
     * @var string
     */
    public $description = 'Реферальные уровни';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'ref_levels' => RefLevel::standart()->paginate(10),
            'ref_custom_levels' => RefLevel::custom()->paginate(10),
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
            Link::make('Добавить новый уровень')
                ->icon('pencil')
                ->route('platform.ref-level.edit'),

            Link::make('Создать кастомный уровень')
                ->icon('pencil')
                ->route('platform.ref-custom-level.edit')
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
            RefLevelsListLayout::class,
            RefCustomLevelsListLayout::class,
        ];
    }

    /**
     * @param Request $request
     */
    public function remove(Request $request): void
    {
        try {
            $ref_level = RefLevel::findOrFail($request->get('id'));
            $count = $ref_level->players->count();
            if(RefLevel::standart()->count() == 1) throw new RefSystemException('Ошибка удаления: Должен существовать хотя бы 1 уровень реферальной системы');
            if($count > 0) throw new RefSystemException('Ошибка удаления: К данному левелу привяно: ' .  $count . ' игроков');
            if(!is_null($ref_level->level)) {
                if(RefLevel::where('level', '>', $ref_level->level)->exists()) throw new RefSystemException('Ошибка удаления: удалить можно только уровень с самым большим LVL');
            }
            $ref_level->delete();

            Toast::info('Реферальный уровень был удален');

        } catch (RefSystemException $th) {
            Toast::error($th->getMessage());

        } catch (\Throwable $th) {
            throw $th;
        }
    }

}
