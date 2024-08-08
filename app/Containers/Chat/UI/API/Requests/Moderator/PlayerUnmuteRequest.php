<?php

namespace App\Containers\Chat\UI\API\Requests\Moderator;

use Illuminate\Foundation\Http\FormRequest;

class PlayerUnmuteRequest extends FormRequest
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
            'player_id' => 'required',
        ];
    }
}
