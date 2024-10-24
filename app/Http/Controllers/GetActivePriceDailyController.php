<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Facades\App\Services\ActiveService;
use App\Http\Requests\Active\GetActivePriceDailyRequest;

class GetActivePriceDailyController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(GetActivePriceDailyRequest $request)
    {
        return ActiveService::getActivePriceDaily($request->ticker);
    }
}
