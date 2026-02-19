<?php

namespace App\Services\Orders;

use App\Models\Order;
use App\Models\Shop;
use App\Models\TelegramIntegration;
use App\Models\TelegramSendLog;
use App\Services\Telegram\TelegramMessageService;
use Illuminate\Database\QueryException;

class OrderService
{
    public function __construct(
        private readonly TelegramMessageService $telegramMessageService,
    ) {}

    /**
     * @param  array{number: string, total: int|float|string, customerName: string}  $payload
     */
    public function create(int $shopId, array $payload): OrderCreationResult
    {
        Shop::query()->findOrFail($shopId);

        $order = Order::query()->firstOrCreate([
            'shop_id' => $shopId,
            'number' => $payload['number'],
        ], [
            'total' => $payload['total'],
            'customer_name' => $payload['customerName'],
            'created_at' => now(),
        ]);

        $integration = TelegramIntegration::query()
            ->where('shop_id', $shopId)
            ->first();

        if (! $integration || ! $integration->enabled) {
            return new OrderCreationResult(order: $order, sendStatus: 'skipped');
        }

        $existingLog = TelegramSendLog::query()
            ->where('shop_id', $shopId)
            ->where('order_id', $order->id)
            ->first();

        if ($existingLog) {
            return new OrderCreationResult(order: $order, sendStatus: 'skipped');
        }

        $dispatchResult = $this->telegramMessageService->sendOrderNotification($integration, $order);

        $logStatus = $dispatchResult->result->sent ? 'SENT' : 'FAILED';

        try {
            TelegramSendLog::query()->create([
                'shop_id' => $shopId,
                'order_id' => $order->id,
                'message' => $dispatchResult->message,
                'status' => $logStatus,
                'error' => $dispatchResult->result->error,
                'sent_at' => now(),
            ]);
        } catch (QueryException $exception) {
            if ($this->isUniqueConstraintViolation($exception)) {
                return new OrderCreationResult(order: $order, sendStatus: 'skipped');
            }

            throw $exception;
        }

        if (! $dispatchResult->result->sent) {
            return new OrderCreationResult(
                order: $order,
                sendStatus: 'failed',
                sendError: $dispatchResult->result->error,
            );
        }

        return new OrderCreationResult(order: $order, sendStatus: 'sent');
    }

    private function isUniqueConstraintViolation(QueryException $exception): bool
    {
        $sqlState = $exception->errorInfo[0] ?? null;
        $driverCode = $exception->errorInfo[1] ?? null;

        return in_array($sqlState, ['23000', '23505'], true)
            || (int) $driverCode === 19;
    }
}
