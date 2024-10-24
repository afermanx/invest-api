<?php

namespace App\Services;
use App\Models\{
    Transaction,
    Active,
};
use App\Traits\ApiException;
use Illuminate\Support\Facades\DB;
use App\Enums\Transaction\TypesEnum;

class TransactionService
{
    use ApiException;

    /**
     * Instantiate a new TransactionService.
     *
     * @return void
     */
    public function __construct()
    {
        $this->model = new Transaction();
    }

    /**
     * Register a buy transaction.
     *
     * @param array $data Must contain the following keys:
     *                    - active_id: The id of the active.
     *                    - quantity: The quantity of the transaction.
     *                    - price: The price of the transaction.
     *                    - date: The date of the transaction. If not set, it will default to the current date and time.
     *
     * @return Transaction The created transaction.
     */
    public function buy(array $data): Transaction
    {
        $transaction =  Transaction::create([
            'user_id' => auth()->user()->id,
            'active_id' => $data['active_id'],
            'type' => TypesEnum::BUY,
            'quantity' => $data['quantity'],
            'price' => $data['price'],
            'date' => $data['date'] ?? now(),
            'total' => $this->sumValueTotal($data['quantity'], $data['price']),
        ]);
        if($transaction->active->quantity === 0) {
            $this->preConditionFailedException('Ativo indisponível');
        }
        if($transaction->quantity > $transaction->active->quantity) {
            $this->preConditionFailedException('Quantidade indisponível');
        }
        return DB::transaction(function () use ($transaction): Transaction {
            $active = $transaction->active;
            $active->update([
                'quantity' => $active->quantity - $transaction->quantity,
            ]);
            return $transaction;
        });
    }

    /**
     * Register a sell transaction.
     *
     * @param array $data Must contain the following keys:
     *                    - active_id: The id of the active.
     *                    - quantity: The quantity of the transaction.
     *                    - price: The price of the transaction.
     *                    - date: The date of the transaction. If not set, it will default to the current date and time.
     *
     * @return Transaction The created transaction.
     */
    public function sell(array $data)
    {

        $active = Active::find($data['active_id'])->first();
        if($active->quantity === 0) {
            $this->preConditionFailedException('Ativo indisponível');
        }
        if($data['quantity'] > $active->quantity) {
            $this->preConditionFailedException('Quantidade indisponível');
        }
        $transaction =  $this->model->create([
            'user_id' => auth()->user()->id,
            'active_id' => $data['active_id'],
            'type' => TypesEnum::SELL,
            'quantity' => $data['quantity'],
            'price' => $active->price,
            'date' => $data['date'] ?? now(),
            'total' => $this->sumValueTotal($data['quantity'], $active->price),
        ]);

        return DB::transaction(function () use ($transaction, $active): Transaction {
            $active->update([
                'quantity' => $active->quantity + $transaction->quantity,
            ]);
            return $transaction;
        });
    }

    public function getMonthlyTransactions()
    {
        $transactions = $this->model->transactionUserAuth()
                ->whereMonth('date', date('m'))
                ->select('type', \DB::raw('COUNT(*) as total'))
                ->groupBy('type')
                ->get();
        return $transactions;
    }

    /**
     * Sum the value of the quantity and price.
     *
     * @param float $quantity Quantity of the transaction.
     * @param float $price Price of the transaction.
     *
     * @return float The total value of the transaction.
     */
    private function sumValueTotal(float $quantity, float $price): float
    {
        return $quantity * $price;
    }
}
