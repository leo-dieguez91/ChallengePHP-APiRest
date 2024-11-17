<?php

namespace App\Http\Requests\Giphy;

use Illuminate\Foundation\Http\FormRequest;

class ShowGifRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'required|string'
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'id.required' => 'The GIF ID is required',
            'id.string' => 'The GIF ID must be a string'
        ];
    }

    /**
     * Get data to be validated from the request.
     *
     * @return array
     */
    public function validationData()
    {
        return array_merge($this->all(), [
            'id' => $this->route('id')
        ]);
    }
}
