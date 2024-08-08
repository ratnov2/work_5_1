<?php

namespace App\Containers\Mines\UI\API\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TakeRequest extends FormRequest
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
   
        ];
    }
}
