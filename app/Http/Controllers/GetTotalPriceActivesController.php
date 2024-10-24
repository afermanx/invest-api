<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Facades\App\Services\ActiveService;

class GetTotalPriceActivesController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return $this->ok(ActiveService::getTotalPriceActives());
    }
}
