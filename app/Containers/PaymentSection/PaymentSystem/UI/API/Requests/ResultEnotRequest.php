<?php

namespace App\Containers\PaymentSection\PaymentSystem\UI\API\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResultEnotRequest extends FormRequest
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
            'merchant' => 'required',
            'merchant_id' => 'required',
            'amount' => 'required',
            'sign' => 'required',
            'sign_2' => 'required',
            'currency' => 'required',
        ];
    }
}
