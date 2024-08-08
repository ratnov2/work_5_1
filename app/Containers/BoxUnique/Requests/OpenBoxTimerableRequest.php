<?php

namespace App\Containers\BoxUnique\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OpenBoxTimerableRequest extends FormRequest
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
            'mode' => 'required'
        ];
    }
}
