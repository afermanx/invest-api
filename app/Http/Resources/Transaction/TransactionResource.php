<?php

namespace App\Http\Resources\Transaction;

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Http\Resources\ActiveResource;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'quantity' => $this->quantity,
            'type' => $this->type,
            'price' => $this->price,
            'date' => $this->date->format('Y-m-d H:i:s'),
            'total' =>number_format($this->total, 2, ',', '.'),
            'active' => new ActiveResource($this->active),
            'user' => new UserResource($this->user),

        ];
    }
}
