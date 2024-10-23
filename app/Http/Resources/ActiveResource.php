<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ActiveResource extends JsonResource
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
            'name' => $this->name,
            'ticker' => $this->ticker,
            'purchase_date' => Carbon::parse($this->purchase_date)->format('Y-m-d H:i:s'),
            'quantity' => $this->quantity,
            // price in R$ format
            'price' => number_format($this->price, 2, ',', '.'),
            'type' => $this->type,
            'user' => new UserResource($this->user),
        ];
    }
}
