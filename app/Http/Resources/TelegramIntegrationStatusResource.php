<?php

namespace App\Http\Resources;

use App\Data\Telegram\TelegramIntegrationStatusData;
use Carbon\CarbonInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property TelegramIntegrationStatusData $resource
 */
class TelegramIntegrationStatusResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'enabled' => $this->resource->enabled,
            'chatId' => $this->resource->chatId,
            'lastSentAt' => $this->resource->lastSentAt instanceof CarbonInterface
                ? $this->resource->lastSentAt->toAtomString()
                : null,
            'sentCount' => $this->resource->sentCount,
            'failedCount' => $this->resource->failedCount,
        ];
    }
}
