<?php

namespace App\Services\Telegram;

use App\Contracts\TelegramClient;
use App\Models\Order;
use App\Models\TelegramIntegration;

class TelegramMessageService
{
    public function __construct(
        private readonly TelegramClient $telegramClient,
    ) {}

    public function sendOrderNotification(TelegramIntegration $integration, Order $order): TelegramOrderSendResult
    {
        $message = $this->buildOrderMessage($order);

        $result = $this->telegramClient->sendMessage(
            token: $integration->bot_token,
            chatId: $integration->chat_id,
            text: $message,
        );

        return new TelegramOrderSendResult(
            message: $message,
            result: $result,
        );
    }

    private function buildOrderMessage(Order $order): string
    {
        $normalizedTotal = rtrim(rtrim(number_format((float) $order->total, 2, '.', ''), '0'), '.');

        return sprintf(
            'Новый заказ %s на сумму %s ₽, клиент %s',
            $order->number,
            $normalizedTotal,
            $order->customer_name,
        );
    }
}
