<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Active;
use App\Models\Transaction;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Criação de um usuário
        $user = User::factory()->create([
            'name' => 'Usuario Invest',
            'email' => 'user@invest.com',
            'password' => Hash::make('password'),
        ]);

        // Criação de 10 ativos e suas transações
        Active::factory()->count(10)->create(['user_id' => $user->id])->each(function ($active) use ($user) {
            Transaction::factory()->count(2)->create([
                'active_id' => $active->id,
                'user_id' => $user->id, // Use o mesmo usuário criado
            ]);
        });
    }
}
