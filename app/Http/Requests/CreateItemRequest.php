<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateItemRequest extends FormRequest
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
            'id' => [
                'nullable',
                'regex:/^([0-9]*)$/',
                'max:20'
            ],
            'item_type_id' => [
                'required',
                Rule::in(['1','2','3'])
            ],
            'name' => [
                'required',
                'string',
                'max:200'
            ],
            'description' => [
                'nullable',
                'string',
                'max:400'
            ],
            'images' => [
                'nullable',
                'image'
            ],
            'tag_id' => [
                'nullable',
                'string',
                'max:32'
            ]
        ];
    }

    public function messages()
    {
        return [
            'name' => 'Name is required',
            'item_type'  => 'Item type is required'
        ];
    }
}
