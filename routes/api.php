<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    Auth\AuthController
};

Route::prefix('v1')->group(function () {
    Route::get('/', function () {
        return [
            'message' => 'Welcome!',
            'name' => config('app.name'),
            'version' => config('app.version'),
            "documentation" => config('app.documentation')

        ];
    });
    Route::controller(AuthController::class)->group(function () {
        Route::prefix('auth')->group(function () {
            Route::post('/login', [AuthController::class,'login']);
        });
    });

    //Authenticates Routes
    Route::middleware('auth:sanctum')->group(function () {
        Route::prefix('users')->group(function () {
            Route::post('/logout', [AuthController::class, 'logout']);

            Route::get('/me', function (Request $request) {
                return $request->user();
            });
        });
    });
});
