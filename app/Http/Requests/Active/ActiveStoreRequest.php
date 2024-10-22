<?php

namespace App\Http\Requests\Active;

use App\Enums\Active\TypesEnum;
use Illuminate\Foundation\Http\FormRequest;

class ActiveStoreRequest extends FormRequest
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
       $types = array_map(fn($type) => $type->value, TypesEnum::getTypes());
        return [
            'ticker' => ['bail', 'required', 'string', 'max:255', 'unique:actives'],
            'quantity' => ['bail', 'required', 'integer'],
            'price' => ['bail', 'required', 'numeric'],
            'type' => ['bail', 'required', 'string', 'in:' . implode(',', $types)],
        ];
    }

    public function messages(): array
    {
        return [
            'ticker.required' => 'O campo ticker é obrigatório.',
            'ticker.string' => 'O campo ticker deve ser uma string.',
            'ticker.max' => 'O campo ticker deve ter no maximo 255 caracteres.',
            'ticker.unique' => 'Um ativo com esse ticker ja foi cadastrado.',
            'quantity.required' => 'O campo quantidade é obrigatório.',
            'quantity.integer' => 'O campo quantidade deve ser um inteiro.',
            'price.required' => 'O campo preço é obrigatório.',
            'price.numeric' => 'O campo preço deve ser um valor numérico.',
            'type.required' => 'O campo tipo é obrigatório.',
            'type.string' => 'O campo tipo deve ser uma string.',
            'type.in' => 'O campo tipo deve ser um dos seguintes valores: ' . implode(',', array_map(fn($type) => $type->value, TypesEnum::getTypes())),
        ];
    }
}
