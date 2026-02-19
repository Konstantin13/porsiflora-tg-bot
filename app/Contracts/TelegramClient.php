<?php

namespace App\Contracts;

use App\Services\Telegram\TelegramSendResult;

interface TelegramClient
{
    public function sendMessage(string $token, string $chatId, string $text): TelegramSendResult;
}
