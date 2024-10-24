<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Facades\App\Services\ActiveService;
use Symfony\Component\HttpFoundation\JsonResponse;

class GetTotalActiveController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): JsonResponse
    {
        return $this->ok(ActiveService::getTotalActives());
    }
}
