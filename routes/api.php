<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    Auth\AuthController,
    ActiveController,
    GetActivePriceDailyController,
    GetActiveTypesController,
};

Route::prefix('v1')->group(function () {
    // Rota de boas-vindas
    Route::get('/', function () {
        return [
            'message' => 'Welcome!',
            'name' => config('app.name'),
            'version' => config('app.version'),
            'documentation' => config('app.documentation')
        ];
    });

    // Rotas de Autenticação
    Route::prefix('auth')->controller(AuthController::class)->group(function () {
        Route::post('/login', 'login');
    });

    // Rotas que exigem autenticação
    Route::middleware('auth:sanctum')->group(function () {

        // Rotas de Usuário Autenticado
        Route::prefix('users')->group(function () {
            Route::post('/logout', [AuthController::class, 'logout']);
            Route::get('/me', function (Request $request) {
                return $request->user();
            });
        });

        // Rotas de Active (CRUD)

       Route::prefix('actives')->group(function () {
        Route::post('/get-active-price-daily', GetActivePriceDailyController::class);
        Route::post('/types', GetActiveTypesController::class);
        Route::controller(ActiveController::class)->group(function () {
            Route::get('/', 'index');
            Route::post('/', 'store');
            Route::get('/{id}', 'show');
            Route::put('/{id}', 'update');
            Route::delete('/{id}', 'destroy');
        });
    });


    });
});
