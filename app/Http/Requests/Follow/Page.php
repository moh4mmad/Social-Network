<?php

namespace App\Http\Requests\Follow;

use Illuminate\Foundation\Http\FormRequest;

class Page extends FormRequest
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
            'pageId' => 'required|integer|exists:pages,id'
        ];
    }

    public function messages()
    {
        return [
            'pageId.exists' => 'Page doesn\'t exists.',
        ];
    }


    public function all($keys = null)
    {
        $data = parent::all();
        $data['pageId'] = $this->route('pageId');

        return $data;
    }
}
