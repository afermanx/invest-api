<?php

namespace App\Http\Requests\Active;

use App\Enums\Active\TypesEnum;
use Illuminate\Foundation\Http\FormRequest;

class ActiveUpdateRequest extends FormRequest
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
          'name' => ['bail', 'sometimes', 'string', 'max:255'],
          'quantity' => ['bail', 'sometimes', 'integer'],
          'price' => ['bail', 'sometimes', 'numeric'],
          'type' => ['bail', 'sometimes', 'string', 'in:' . implode(',', $types)],
        ];
    }

    public function messages(): array
    {
        return [
            'name.string' => 'O campo nome deve ser uma string.',
            'name.max' => 'O campo nome deve ter no maximo 255 caracteres.',
            'quantity.integer' => 'O campo quantidade deve ser um inteiro.',
            'price.numeric' => 'O campo precão deve ser um valor numérico.',
            'type.string' => 'O campo tipo deve ser uma string.',
            'type.in' => 'O campo tipo deve ser um dos seguintes valores: ' . implode(',', array_map(fn($type) => $type->value, TypesEnum::getTypes())),
        ];
    }
}
