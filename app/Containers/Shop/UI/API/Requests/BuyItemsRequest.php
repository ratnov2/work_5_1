<?php

namespace App\Containers\Shop\UI\API\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BuyItemsRequest extends FormRequest
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
            'extra_uniqids' => 'nullable',
            'market_hash_names_with_quantity' => 'required',
        ];
    }
}
