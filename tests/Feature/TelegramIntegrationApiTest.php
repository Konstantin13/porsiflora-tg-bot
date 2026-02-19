<?php

use App\Contracts\TelegramClient;
use App\Models\Shop;
use App\Models\TelegramIntegration;
use App\Services\Telegram\TelegramSendResult;

test('при создании заказа с включенной интеграцией вызывается telegram client и пишется лог SENT', function () {
    $shop = Shop::query()->create(['name' => 'Posiflora Shop']);

    TelegramIntegration::query()->create([
        'shop_id' => $shop->id,
        'bot_token' => '123456:ABC-DEF',
        'chat_id' => '987654321',
        'enabled' => true,
    ]);

    $telegramClient = \Mockery::mock(TelegramClient::class);
    $telegramClient
        ->shouldReceive('sendMessage')
        ->once()
        ->with(
            '123456:ABC-DEF',
            '987654321',
            'Новый заказ A-1005 на сумму 2490 ₽, клиент Анна',
        )
        ->andReturn(new TelegramSendResult(sent: true));

    app()->instance(TelegramClient::class, $telegramClient);

    $response = $this->postJson("/shops/{$shop->id}/orders", [
        'number' => 'A-1005',
        'total' => 2490,
        'customerName' => 'Анна',
    ]);

    $response
        ->assertOk()
        ->assertJsonPath('sendStatus', 'sent');

    $orderId = $response->json('order.id');

    $this->assertDatabaseHas('telegram_send_log', [
        'shop_id' => $shop->id,
        'order_id' => $orderId,
        'status' => 'SENT',
        'message' => 'Новый заказ A-1005 на сумму 2490 ₽, клиент Анна',
    ]);
});

test('повторное создание заказа не создает дублей лога и не отправляет сообщение повторно', function () {
    $shop = Shop::query()->create(['name' => 'Posiflora Shop']);

    TelegramIntegration::query()->create([
        'shop_id' => $shop->id,
        'bot_token' => '123456:ABC-DEF',
        'chat_id' => '987654321',
        'enabled' => true,
    ]);

    $telegramClient = \Mockery::mock(TelegramClient::class);
    $telegramClient
        ->shouldReceive('sendMessage')
        ->once()
        ->andReturn(new TelegramSendResult(sent: true));

    app()->instance(TelegramClient::class, $telegramClient);

    $payload = [
        'number' => 'A-1006',
        'total' => 500,
        'customerName' => 'Иван',
    ];

    $firstResponse = $this->postJson("/shops/{$shop->id}/orders", $payload);
    $secondResponse = $this->postJson("/shops/{$shop->id}/orders", $payload);

    $firstResponse
        ->assertOk()
        ->assertJsonPath('sendStatus', 'sent');

    $secondResponse
        ->assertOk()
        ->assertJsonPath('sendStatus', 'skipped')
        ->assertJsonPath('order.id', $firstResponse->json('order.id'));

    $orderId = $firstResponse->json('order.id');

    expect($shop->orders()->where('number', 'A-1006')->count())->toBe(1)
        ->and($shop->telegramSendLogs()->where('order_id', $orderId)->count())->toBe(1);
});

test('при ошибке telegram client пишется лог FAILED, а заказ создается', function () {
    $shop = Shop::query()->create(['name' => 'Posiflora Shop']);

    TelegramIntegration::query()->create([
        'shop_id' => $shop->id,
        'bot_token' => '123456:ABC-DEF',
        'chat_id' => '987654321',
        'enabled' => true,
    ]);

    $telegramClient = \Mockery::mock(TelegramClient::class);
    $telegramClient
        ->shouldReceive('sendMessage')
        ->once()
        ->andReturn(new TelegramSendResult(
            sent: false,
            error: 'Mock Telegram client failure.',
        ));

    app()->instance(TelegramClient::class, $telegramClient);

    $response = $this->postJson("/shops/{$shop->id}/orders", [
        'number' => 'A-1007',
        'total' => 3500,
        'customerName' => 'Мария',
    ]);

    $response
        ->assertOk()
        ->assertJsonPath('sendStatus', 'failed')
        ->assertJsonPath('sendError', 'Mock Telegram client failure.');

    $orderId = $response->json('order.id');

    $this->assertDatabaseHas('orders', [
        'id' => $orderId,
        'shop_id' => $shop->id,
        'number' => 'A-1007',
    ]);

    $this->assertDatabaseHas('telegram_send_log', [
        'shop_id' => $shop->id,
        'order_id' => $orderId,
        'status' => 'FAILED',
        'error' => 'Mock Telegram client failure.',
    ]);
});
