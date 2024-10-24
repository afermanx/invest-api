<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Facades\App\Services\TransactionService;
use App\Http\Requests\Active\SellActiveRequest;
use App\Http\Resources\Transaction\TransactionResource;

class SellActiveController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(SellActiveRequest $request): JsonResponse
    {
        return $this->ok([
            'message' => 'Venda realizada com sucesso!',
            'data' => TransactionResource::make(TransactionService::sell($request->validated())),
        ]);
    }
}
