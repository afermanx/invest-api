<?php

namespace App\Http\Requests\Active;

use Illuminate\Foundation\Http\FormRequest;

class GetActivePriceDailyRequest extends FormRequest
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
            'ticker' => ['bail', 'required', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'ticker.required' => 'O campo ticker é obrigatório.',
            'ticker.string' => 'O campo ticker deve ser uma string.',
            'ticker.max' => 'O campo ticker deve ter no maximo 255 caracteres.',
        ];
    }
}
