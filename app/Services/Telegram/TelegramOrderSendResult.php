<?php

namespace App\Services\Telegram;

final readonly class TelegramOrderSendResult
{
    public function __construct(
        public string $message,
        public TelegramSendResult $result,
    ) {}
}
