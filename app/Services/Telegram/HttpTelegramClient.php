<?php

namespace App\Services\Telegram;

use App\Contracts\TelegramClient;
use Illuminate\Support\Facades\Http;
use Throwable;

class HttpTelegramClient implements TelegramClient
{
    public function sendMessage(string $token, string $chatId, string $text): TelegramSendResult
    {
        try {
            $response = Http::asJson()->post("https://api.telegram.org/bot{$token}/sendMessage", [
                'chat_id' => $chatId,
                'text' => $text,
            ]);

            if ($response->successful() && $response->json('ok') === true) {
                return new TelegramSendResult(sent: true);
            }

            $error = $response->json('description');

            if (! is_string($error) || trim($error) === '') {
                $error = sprintf('Telegram API request failed with status %d.', $response->status());
            }

            return new TelegramSendResult(sent: false, error: $error);
        } catch (Throwable $exception) {
            return new TelegramSendResult(sent: false, error: $exception->getMessage());
        }
    }
}
