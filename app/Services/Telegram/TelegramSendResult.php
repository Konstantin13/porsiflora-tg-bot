<?php

namespace App\Services\Telegram;

final readonly class TelegramSendResult
{
    public function __construct(
        public bool $sent,
        public ?string $error = null,
    ) {}
}
