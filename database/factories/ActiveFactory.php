<?php

namespace Database\Factories;

use App\Enums\Active\TypesEnum;
use App\Models\Active;
use Illuminate\Database\Eloquent\Factories\Factory;

class ActiveFactory extends Factory
{
    protected $model = Active::class;

    // Lista de tickers brasileiros
    private $tickers = [
        'VALE3.SA', 'ITUB4.SA','BBAS3.SA',
        'MGLU3.SA', 'WEGE3.SA', 'LREN3.SA', 'USIM5.SA', 'CSNA3.SA',
        'GGBR4.SA', 'KROT3.SA', 'RADL3.SA','TRPL4.SA'
    ];

    public function definition()
    {
        return [
            'user_id' => 1,
            'name' => $this->faker->word,
            'ticker' => $this->faker->unique()->randomElement($this->tickers),
            'purchase_date' => $this->faker->date(),
            'quantity' => $this->faker->numberBetween(1, 100),
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'type' => $this->faker->randomElement(TypesEnum::getTypes()),
        ];
    }
}
