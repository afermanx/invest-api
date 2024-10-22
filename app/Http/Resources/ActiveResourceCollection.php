<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\ActiveResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ActiveResourceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => ActiveResource::collection($this->collection),
            'from' => $this->firstItem(),
            'last_page' => $this->lastPage(),
            'per_page' => $this->perPage(),
            'to' => $this->lastItem(),
            'total' => $this->total(),
            'current_page' => $this->currentPage(),
        ];
    }
}
