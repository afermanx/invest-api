<?php

namespace App\Services;

use App\Traits\ApiException;
use Illuminate\Support\Facades\Http;

class AlphaVantage
{
     use ApiException;
    private string $apiKey;
    private string $url;
    public function __construct()
    {
        $this->apiKey = config('alphavantage.key');
        $this->url = config('alphavantage.url');
    }

    public function doGetRequest(array $params): array
    {

        $res = Http::get($this->url, [
            'function' => $params['function'],
            'symbol' => $params['symbol'] ? $params['symbol'] : '',
            'apikey' => $this->apiKey
        ]);

        if($res->failed()) {
            $this->throwApiException($res->body());
        }

        return $res->json();
    }

}
