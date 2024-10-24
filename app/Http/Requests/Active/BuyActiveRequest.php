<?php

namespace App\Http\Requests\Active;

use Illuminate\Foundation\Http\FormRequest;

class BuyActiveRequest extends FormRequest
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
           'active_id' => ['bail', 'required', 'integer', 'exists:actives,id'],
           'quantity' => ['bail', 'required', 'integer', 'min:1'],
           'price' => ['bail', 'required', 'numeric', 'min:1'],
           'date' => ['bail', 'nullable', 'date'],


        ];
    }

    public function messages(): array
    {
        return [
            'active_id.required' => 'O campo ativo é obrigatorio.',
            'active_id.integer' => 'O campo ativo deve ser um inteiro.',
            'active_id.exists' => 'O campo ativo é inválido.',
            'quantity.required' => 'O campo quantidade é obrigatorio.',
            'quantity.integer' => 'O campo quantidade deve ser um inteiro.',
            'quantity.min' => 'O campo quantidade deve ter no minimo 1.',
            'price.required' => 'O campo preciode é obrigatorio.',
            'price.numeric' => 'O campo preciode deve ser um valor numérico.',
            'price.min' => 'O campo preciode deve ter no minimo 1.',
            'date.date' => 'O campo data deve ser uma data.',
        ];
    }
}
