<?php

namespace App\Containers\Withdraw\UI\API\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemWithdrawRequest extends FormRequest
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
            'uniqid' => 'required'
        ];
    }
}
