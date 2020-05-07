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
            'item_id' => [
                'nullable',
                'regex:/^([0-9]*)$/',
                'max:20'
            ],
            'type_id' => [
                'required',
                Rule::in(['system','component','element'])
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
                'json',
                'max:400'
            ],
            'tag_id' => [
                'required',
                'string',
                'max:20'
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
