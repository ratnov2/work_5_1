<?php

namespace App\Orchid\Screens\BoxPromocode;

use App\Containers\BoxUnique\Models\BoxPromocode;
use App\Orchid\Exceptions\BoxPromocode\BoxPromocodeException;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class PromocodeScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Создание\Редактирование';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(BoxPromocode $box_promocode): array
    {
        $this->exists = $box_promocode->exists;

        if($this->exists){
            $this->name = 'Редактирование';
        }

        return [
            'box_promocode' => $box_promocode
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
                Input::make('box_promocode.value')
                    ->required()
                    ->title('Промокод'),

                Input::make('box_promocode.limit')
                    ->type('number')
                    ->required()
                    ->title('Кол-во активаций')
                    ->help('Значение 0 - бесконечный'),
            ])
        ];
    }

    public function createOrUpdate(BoxPromocode $box_promocode, Request $request)
    {
        try {
            $params = $request->get('box_promocode');
            if($params['limit'] == 0) $params['limit'] = null;
            if( BoxPromocode::where([['value', $params['value']], ['id', '!=', $box_promocode->id]])->exists() ) throw new BoxPromocodeException('Такой промокод уже существует');

            $box_promocode->fill($params);
            $box_promocode->save();

            Alert::info('Промокод успешно обновлен');

            return redirect()->route('platform.box-promocode.promocodes');

        } catch (BoxPromocodeException $th) {
            Toast::error($th->getMessage());

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * @param Request $request
     */
    public function remove(BoxPromocode $box_promocode)
    {
        $box_promocode->delete();

        Alert::info('Промокод успешно удален');

        return redirect()->route('platform.box-promocode.promocodes');
    }
}
