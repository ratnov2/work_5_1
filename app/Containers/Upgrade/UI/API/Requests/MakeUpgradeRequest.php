<?php

namespace App\Containers\Upgrade\UI\API\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MakeUpgradeRequest extends FormRequest
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
            'uniqid' => 'required',
            'sync_chance' => 'required',
            'wanted_market_hash_name' => 'required',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'sync_chance.required' => 'Ошибка параметров.',
            'uniqid.required' => 'Ошибка параметров.',
            'wanted_market_hash_name.required' => 'Ошибка параметров.',
        ];
    }
}
