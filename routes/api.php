<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Resources\UserResource;
use App\Http\Controllers\{
    Auth\AuthController,
    ActiveController,
    BuyActiveController,
    GetActivePriceDailyController,
    GetActiveTypesController,
    SellActiveController,
    GetTotalActiveController,
    GetMonthlyTransactionsController,
    GetActiveDistributionByTypeController,
    GetTotalPriceActivesController,
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
                return UserResource::make($request->user());
            });
        });

        // Rotas de Active (CRUD)

        Route::prefix('actives')->group(function () {
            Route::post('/get-active-price-daily', GetActivePriceDailyController::class);
            Route::post('/types', GetActiveTypesController::class);
            Route::post('/buy', BuyActiveController::class)->name('active.buy');
            Route::post('sell', SellActiveController::class)->name('active.sell');
            Route::controller(ActiveController::class)->group(function () {
                Route::get('/', 'index')->name('actives.index');
                Route::post('/', 'store')->name('actives.store');
                Route::get('/{active}', 'show')->name('actives.show');
                Route::patch('/{active}', 'update')->name('actives.update');
                Route::delete('/{active}', 'destroy')->name('actives.destroy');
            });
        });

        Route::prefix('dashboard')->group(function () {
            Route::get('/total-actives', GetTotalActiveController::class);
            Route::get('/monthly-transactions', GetMonthlyTransactionsController::class);
            Route::get('/active-distribution-by-type', GetActiveDistributionByTypeController::class);
            Route::get('/total-price-actives', GetTotalPriceActivesController::class);
        });


    });
});
