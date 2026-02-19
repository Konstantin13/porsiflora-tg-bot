<?php

namespace App\Services\Telegram;

use App\Data\Telegram\TelegramIntegrationStatusData;
use App\Models\Shop;
use App\Models\TelegramIntegration;
use App\Models\TelegramSendLog;

class TelegramIntegrationService
{
    /**
     * @param  array{botToken: string, chatId: string, enabled: bool}  $payload
     */
    public function connect(int $shopId, array $payload): TelegramIntegration
    {
        Shop::query()->findOrFail($shopId);

        return TelegramIntegration::query()->updateOrCreate(
            ['shop_id' => $shopId],
            [
                'bot_token' => $payload['botToken'],
                'chat_id' => $payload['chatId'],
                'enabled' => $payload['enabled'],
            ],
        );
    }

    public function status(int $shopId): TelegramIntegrationStatusData
    {
        Shop::query()->findOrFail($shopId);

        $integration = TelegramIntegration::query()
            ->where('shop_id', $shopId)
            ->first();

        $windowStart = now()->subDays(7);

        $logsQuery = TelegramSendLog::query()
            ->where('shop_id', $shopId)
            ->where('sent_at', '>=', $windowStart);

        $sentCount = (clone $logsQuery)
            ->where('status', 'SENT')
            ->count();

        $failedCount = (clone $logsQuery)
            ->where('status', 'FAILED')
            ->count();

        $lastSentAt = TelegramSendLog::query()
            ->where('shop_id', $shopId)
            ->where('status', 'SENT')
            ->orderByDesc('sent_at')
            ->first()?->sent_at;

        return new TelegramIntegrationStatusData(
            enabled: $integration?->enabled ?? false,
            chatId: $this->maskChatId($integration?->chat_id),
            lastSentAt: $lastSentAt,
            sentCount: $sentCount,
            failedCount: $failedCount,
        );
    }

    private function maskChatId(?string $chatId): ?string
    {
        if (! is_string($chatId) || $chatId === '') {
            return null;
        }

        $visibleChars = 4;
        $length = strlen($chatId);

        if ($length <= $visibleChars) {
            return str_repeat('*', $length);
        }

        return str_repeat('*', $length - $visibleChars).substr($chatId, -$visibleChars);
    }
}
