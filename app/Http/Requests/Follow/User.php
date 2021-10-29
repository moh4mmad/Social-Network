<?php

namespace App\Http\Requests\Follow;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\CheckValidUser;

class User extends FormRequest
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
            'personId' => [
                'required',
                'integer',
                'exists:users,id',
                new CheckValidUser()
            ]
        ];
    }

    public function messages()
    {
        return [
            'personId.exists' => 'User doesn\'t exists.',
        ];
    }


    public function all($keys = null)
    {
        $data = parent::all();
        $data['personId'] = $this->route('personId');

        return $data;
    }
}
