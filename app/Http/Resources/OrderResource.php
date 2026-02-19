<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'shopId' => $this->shop_id,
            'number' => $this->number,
            'total' => (float) $this->total,
            'customerName' => $this->customer_name,
            'createdAt' => $this->created_at?->toAtomString(),
        ];
    }
}
