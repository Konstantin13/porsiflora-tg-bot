<?php

namespace App\Http\Resources;

use App\Services\Orders\OrderCreationResult;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin OrderCreationResult */
class OrderCreationResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'order' => new OrderResource($this->resource->order),
            'sendStatus' => $this->resource->sendStatus,
        ];

        if ($this->resource->sendError !== null) {
            $data['sendError'] = $this->resource->sendError;
        }

        return $data;
    }
}
