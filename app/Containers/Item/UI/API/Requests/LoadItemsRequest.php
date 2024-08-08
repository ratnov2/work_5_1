<?php

namespace App\Containers\Item\UI\API\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoadItemsRequest extends FormRequest
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
            'name' => 'nullable|string',
            'limit' => 'required|numeric',
            'offset' => 'required|numeric',
            'price' => 'nullable|numeric',
            'rarities' => 'nullable|array'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'limit.required' => 'Укажите лимит загружаемых предметов',
            'offset.required' => 'Укажите оффсет для загружаемых предметов',
        ];
    }
}
