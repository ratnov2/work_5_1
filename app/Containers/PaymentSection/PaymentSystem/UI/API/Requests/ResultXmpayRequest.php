<?php

namespace App\Containers\PaymentSection\PaymentSystem\UI\API\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResultXmpayRequest extends FormRequest
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
            'id' => 'required',
            'label' => 'required',
            'amount' => 'required',
            'hash' => 'required',
            'method' => 'nullable',
            'shop_id' => 'required',
            'time' => 'nullable'
        ];
    }
}
