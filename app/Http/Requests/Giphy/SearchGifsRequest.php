<?php

namespace App\Http\Requests\Giphy;

use Illuminate\Foundation\Http\FormRequest;

class SearchGifsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'query' => 'required|string|max:255',
            'limit' => 'nullable|integer|min:1|max:50',
            'offset' => 'nullable|integer|min:0'
        ];
    }

    public function messages(): array
    {
        return [
            'query.required' => 'The search query is required',
            'query.string' => 'The search query must be a string',
            'query.max' => 'The search query may not be greater than 255 characters',
            
            'limit.integer' => 'The limit must be an integer',
            'limit.min' => 'The minimum limit is 1',
            'limit.max' => 'The maximum limit allowed by Giphy API is 50',
            
            'offset.integer' => 'The offset must be an integer',
            'offset.min' => 'The minimum offset is 0'
        ];
    }
}
