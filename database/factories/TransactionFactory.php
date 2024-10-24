<?php

namespace Database\Factories;

use App\Enums\Transaction\TypesEnum;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    protected $model = Transaction::class;

    public function definition()
    {
        return [
            'user_id' => 1, // ou use um usuário existente
            'active_id' => \App\Models\Active::factory(), // criando um Active se necessário
            'type' => $this->faker->randomElement(TypesEnum::getTypes()),
            'quantity' => $this->faker->numberBetween(1, 50),
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'total' => function (array $attributes) {
                return $attributes['price'] * $attributes['quantity'];
            },
            'date' => $this->faker->date(),
        ];
    }
}
