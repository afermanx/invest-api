<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Services\Auth\AuthService;
use App\Http\Controllers\Controller;
use App\Http\Resources\Auth\AuthResource;
use App\Http\Requests\Auth\LoginUserRequest;


class AuthController extends Controller
{

    public function __construct(public AuthService $service)
    {

    }
    public function login(LoginUserRequest $request): JsonResponse
    {
        $auth = $this->service->login($request->validated());

        return $this->ok(AuthResource::make($auth));
    }

    public function logout(Request $request): JsonResponse
    {
        $this->service->logout($request->user());

        return $this->noContent();
    }
}
