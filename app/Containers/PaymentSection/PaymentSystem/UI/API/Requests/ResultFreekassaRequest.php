<?php

namespace App\Containers\PaymentSection\PaymentSystem\UI\API\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResultFreekassaRequest extends FormRequest
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
            'SIGN' => 'required',
            'MERCHANT_ID' => 'required',
            'MERCHANT_ORDER_ID' => 'required',
            'AMOUNT' => 'required',
        ];
    }
}
