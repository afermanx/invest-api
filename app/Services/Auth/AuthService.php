<?php

namespace App\Services\Auth;
use App\Models\User;
use App\Traits\ApiException;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    use ApiException;

    /**
     * User login
     *
     * @param  array  $data
     * @return User
     */
    public function login(array $data): User
    {
        if (!Auth::attempt($data)) {
            $this->badRequestException('Credenciais inválidas');
        }

        $token = Auth::user()->createToken('auth_token')->plainTextToken;

        return Auth::user();



    }

    public function register(string $email, string $password)
    {

    }

    /**
     * User logout
     *
     * @param  User  $user
     * @return void
     */
    public function logout(User $user): void
    {
        if(! $user){
            $this->notFoundRequestException('Usuário não encontrado');
        }

        $user->tokens()->delete();
    }
}
