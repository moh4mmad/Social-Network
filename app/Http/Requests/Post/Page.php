<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\CheckPageOwner;

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
            'post_content' => 'required|string',
            'pageId' => [
                'required',
                'integer',
                'exists:pages,id',
                new CheckPageOwner()
            ]
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
