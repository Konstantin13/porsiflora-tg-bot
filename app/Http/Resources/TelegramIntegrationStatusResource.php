<?php

namespace App\Http\Resources;

use Carbon\CarbonInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TelegramIntegrationStatusResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $lastSentAt = data_get($this->resource, 'lastSentAt');

        return [
            'enabled' => (bool) data_get($this->resource, 'enabled', false),
            'chatId' => data_get($this->resource, 'chatId'),
            'lastSentAt' => $lastSentAt instanceof CarbonInterface
                ? $lastSentAt->toAtomString()
                : null,
            'sentCount' => (int) data_get($this->resource, 'sentCount', 0),
            'failedCount' => (int) data_get($this->resource, 'failedCount', 0),
        ];
    }
}
