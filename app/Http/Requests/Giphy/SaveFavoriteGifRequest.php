<?php

namespace App\Http\Requests\Giphy;

use Illuminate\Foundation\Http\FormRequest;

class SaveFavoriteGifRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'gif_id' => 'required|string',
            'alias' => 'required|string|max:255'
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'gif_id.required' => 'The GIF ID is required',
            'gif_id.string' => 'The GIF ID must be a string',
            
            'alias.required' => 'The alias is required',
            'alias.string' => 'The alias must be a string',
            'alias.max' => 'The alias may not be greater than 255 characters'
        ];
    }
}
