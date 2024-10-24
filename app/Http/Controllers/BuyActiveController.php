<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Facades\App\Services\TransactionService;
use App\Http\Requests\Active\BuyActiveRequest;
use App\Http\Resources\Transaction\TransactionResource;

class BuyActiveController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(BuyActiveRequest $request): JsonResponse
    {
        return $this->ok([
            'message' => 'Compra realizada com sucesso!',
            'data' => TransactionResource::make(TransactionService::buy($request->validated())),
        ]);
    }
}
