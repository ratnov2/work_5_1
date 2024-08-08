<?php

namespace App\Orchid\Screens\PaymentSystem;

use App\Containers\PaymentSection\Payment\Models\PaymentPromocode;
use App\Orchid\Exceptions\PaymentPromocode\PaymentPromocodeException;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class PaymentPromocodeEditScreen extends Screen
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
    public function query(PaymentPromocode $payment_promocode): array
    {
        $this->exists = $payment_promocode->exists;

        if($this->exists){
            $this->name = 'Редактирование';
        }

        return [
            'payment_promocode' => $payment_promocode
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
                Input::make('payment_promocode.value')
                    ->required()
                    ->title('Промокод'),

                Input::make('payment_promocode.precent')
                    ->type('number')
                    ->step('0.01')
                    ->required()
                    ->title('Процент к депозиту')
            ])
        ];
    }

    public function createOrUpdate(PaymentPromocode $payment_promocode, Request $request)
    {
        try {
            $params = $request->get('payment_promocode');
            if(PaymentPromocode::where([['value', $params['value']], ['id', '!=', $payment_promocode->id]])->exists()) throw new PaymentPromocodeException('Такой промокод уже существует');

            $payment_promocode->fill($params);
            $payment_promocode->save();

            Alert::info('Промокод для кейса успешно обновлен');

            return redirect()->route('platform.payment-promocode.list');

        } catch (PaymentPromocodeException $th) {
            Toast::error($th->getMessage());

        } catch (\Throwable $th) {
            throw $th;
        }
    }

     /**
     * @param Request $request
     */
    public function remove(PaymentPromocode $payment_promocode)
    {
        $payment_promocode->delete();

        Alert::info('Промокод успешно удален');

        return redirect()->route('platform.payment-promocode.list');
    }
}
