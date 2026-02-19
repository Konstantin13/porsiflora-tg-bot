<?php

namespace App\Http\Resources;

use App\Models\TelegramIntegration;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property TelegramIntegration $resource
 */
class TelegramIntegrationResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'shopId' => $this->resource->shop_id,
            'chatId' => $this->resource->chat_id,
            'enabled' => $this->resource->enabled,
            'createdAt' => $this->resource->created_at,
            'updatedAt' => $this->resource->updated_at,
        ];
    }
}
