<?php

namespace App\Services;

use App\Models\Active;
use App\Traits\ApiException;
use Facades\App\Services\AlphaVantage;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;

class ActiveService
{
    use ApiException;

    public function list(array $data): LengthAwarePaginator
    {
        return Active::activeWithUserAuth()
            ->where(function ($query) use ($data) {
                if (isset($data['search'])) {
                    $query->where('ticker', 'like', '%' . $data['search'] . '%');
                    $query->orWhere('type', 'like', '%' . $data['search'] . '%');
                }
            })
            ->paginate($data['per_page'] ?? 5);
    }

    public function create(array $data): Active
    {
        return Active::create($this->sanitizeData($data));
    }

    public function update(Active $active, array $data): Active
    {
        $active->update($data);
        return $active;
    }

    public function delete(Active $active): void
    {
        $active->delete();
    }


    private function sanitizeData(array &$data): array
    {
        return [
            ...$data,
            'name'=> $data['name'] ?? $data['ticker'],
            'user_id' => auth()->user()->id,
            'purchase_date' => now(),
        ];
    }

    public function getActivePriceDaily(string $ticker): array
    {
        $payload = [
            'function' => 'TIME_SERIES_DAILY',
            'symbol' => $ticker,
        ];
        $res = AlphaVantage::doGetRequest($payload);
        $lastRefreshed = $res['Meta Data']['3. Last Refreshed'];
        return [
           $ticker => $res["Time Series (Daily)"][$lastRefreshed]["4. close"]
        ];
    }

}
