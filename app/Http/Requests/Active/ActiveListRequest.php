<?php

namespace App\Http\Requests\Active;

use Illuminate\Foundation\Http\FormRequest;

class ActiveListRequest extends FormRequest
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
            'per_page' => ['bail','nullable', 'integer', 'min:5', 'max:100'],
            'search' => ['bail','nullable', 'string'],
        ];
    }
    public function messages(): array
    {
        return [
            'per_page.integer' => 'O campo per_page deve ser um inteiro.',
            'search.string' => 'O campo search deve ser uma string.',
        ];
    }
}
