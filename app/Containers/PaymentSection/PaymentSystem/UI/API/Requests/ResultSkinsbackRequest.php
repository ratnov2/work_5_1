<?php

namespace App\Containers\PaymentSection\PaymentSystem\UI\API\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResultSkinsbackRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'sign' => 'required',
            'status' => 'required',
            'steam_id' => 'required',
            'order_id' => 'required',
            'amount' => 'nullable',
            'amount_currency' => 'nullable',
            'amount_in_currencies' => 'nullable',
            'user_amount' => 'nullable',
            'user_amount_in_currencies' => 'nullable',
            'skins' => 'nullable'
        ];
    }
}
