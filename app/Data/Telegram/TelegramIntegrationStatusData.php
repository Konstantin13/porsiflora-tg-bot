<?php

namespace App\Data\Telegram;

use Carbon\CarbonInterface;
use Spatie\LaravelData\Data;

final class TelegramIntegrationStatusData extends Data
{
    public function __construct(
        public bool $enabled,
        public ?string $chatId,
        public ?CarbonInterface $lastSentAt,
        public int $sentCount,
        public int $failedCount,
    ) {}
}
