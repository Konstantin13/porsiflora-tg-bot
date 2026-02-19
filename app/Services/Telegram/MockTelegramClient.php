<?php

namespace App\Services\Telegram;

use App\Contracts\TelegramClient;

class MockTelegramClient implements TelegramClient
{
    public function sendMessage(string $token, string $chatId, string $text): TelegramSendResult
    {
        if (config('services.telegram.mock_should_fail', false)) {
            return new TelegramSendResult(
                sent: false,
                error: 'Mock Telegram client failure.',
            );
        }

        return new TelegramSendResult(sent: true);
    }
}
