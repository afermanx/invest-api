<?php

namespace App\Services;

use App\Enums\Active\TypesEnum;
use App\Models\Active;
use App\Traits\ApiException;
use Facades\App\Services\AlphaVantage;
use Illuminate\Pagination\LengthAwarePaginator;

class ActiveService
{
    use ApiException;

    /**
     * @param array $data
     * @return LengthAwarePaginator
     */
    /**
     * List all actives of the current user.
     * If the 'search' key is present in $data, it will filter the results by matching
     * the 'ticker' or 'type' fields with the given value.
     * The 'per_page' key can be used to set the number of records per page.
     * If not set, it will default to 5 records per page.
     */
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

    public function find(string $ticker): Active
    {
        if (!Active::activeWithUserAuth()->where('ticker', $ticker)->exists()) {
            $this->preConditionFailedException('Ativo não encontrado');
        }
        return Active::activeWithUserAuth()->where('ticker', $ticker)->firstOrFail();
    }

    public function update(Active $active, array $data): Active
    {
        $active->update($data);
        return $active;
    }

    public function delete(Active $active)
    {

        $active->activeWithUserAuth()->delete();
    }

    /**
     * Retrieve the list of active types.
     *
     * @return array An array of active types defined in the TypesEnum.
     */
    public function getActiveTypes(): array
    {
        return TypesEnum::getTypes();
    }

    /**
     * Busca o preco de fechamento do ativo com a chave $ticker no dia anterior
     * @param string $ticker Chave do ativo
     * @return array com a chave $ticker e o preco de fechamento do ativo
     * Exemplo de retorno:
     * [
     *     'PETR4.SA' => 25.99,
     * ]
     */
    public function getActivePriceDaily(string $ticker): array
    {
        $payload = [
            'function' => 'TIME_SERIES_DAILY',
            'symbol' => $ticker,
        ];
        $res = AlphaVantage::doGetRequest($payload);
        if(!isset($res['Time Series (Daily)'])) {
            return [
                "message" => "Nenhum dado encontrado"
            ];
        }
        $lastRefreshed = $res['Meta Data']['3. Last Refreshed'];

        return [
           $ticker =>  number_format($res["Time Series (Daily)"][$lastRefreshed]["4. close"], 2, ',', '.'),
        ];
    }

    public function getTotalActives(): array
    {
        return [
            'total_actives' => Active::activeWithUserAuth()->count(),
        ];
    }

    public function getActiveDistributionByType()
    {
        return Active::with('transactions')
        ->activeWithUserAuth()
        ->get()
        ->groupBy('type')
        ->map(function ($actives, $type) {
            $totalValue = $actives->reduce(function ($carry, $active) {
                $transactionTotal = $active->transactions->reduce(function ($sum, $transaction) {
                    return $sum + ($transaction->quantity * $transaction->price);
                }, 0);

                return $carry + $transactionTotal;
            }, 0);

            return [
                'type' => $type,
                'total' => number_format($totalValue, 2, ',', '.')
            ];
        })->values();
    }

    public function getTotalPriceActives(): array
    {
       $totalGross = Active::with('transactions')
        ->activeWithUserAuth()
        ->get()
        ->reduce(function ($carry, $active) {
            $transactionTotal = $active->transactions->reduce(function ($sum, $transaction) {
                return $sum + ($transaction->quantity * $transaction->price);
            }, 0);

            return $carry + $transactionTotal;
        }, 0);

        return [
            'total' => number_format($totalGross, 2, ',', '.')
        ];
    }

    /**
     * Sanitizes the given data before creating or updating an Active model.
     * If the 'name' key is not present, it will be set to the 'ticker' value.
     * The 'user_id' key will be set to the current authenticated user's id.
     * The 'purchase_date' key will be set to the current date and time.
     *
     * @param array $data
     * @return array
     */
    private function sanitizeData(array &$data): array
    {
        return [
            ...$data,
            'name'=> $data['name'] ?? $data['ticker'],
            'user_id' => auth()->user()->id,
            'purchase_date' => now(),
        ];
    }

}
