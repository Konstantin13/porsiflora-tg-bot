<?php

use App\Contracts\TelegramClient;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('telegram:test-send', function (TelegramClient $telegramClient) {

    var_dump($telegramClient->sendMessage(
        token: env('TELEGRAM_API_KEY'),
        chatId: -4991574250,
        text: 'Hello world',
    ));

})->purpose('Send a test Telegram message to a specific chat_id');
