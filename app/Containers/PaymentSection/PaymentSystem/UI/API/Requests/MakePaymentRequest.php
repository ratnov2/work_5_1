<?php

namespace App\Containers\PaymentSection\PaymentSystem\UI\API\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MakePaymentRequest extends FormRequest
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
            'payment_system_direction_id' => 'required',
            'promocode_value' => 'nullable',
            'sum' => 'nullable',
        ];
    }
}
