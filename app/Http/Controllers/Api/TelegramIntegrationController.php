<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ConnectTelegramIntegrationRequest;
use App\Http\Requests\Api\ShowTelegramStatusRequest;
use App\Http\Resources\TelegramIntegrationResource;
use App\Http\Resources\TelegramIntegrationStatusResource;
use App\Services\Telegram\TelegramIntegrationService;
use Illuminate\Http\JsonResponse;

class TelegramIntegrationController extends Controller
{
    public function __construct(
        private readonly TelegramIntegrationService $telegramIntegrationService,
    ) {}

    public function connect(ConnectTelegramIntegrationRequest $request): JsonResponse
    {
        $integration = $this->telegramIntegrationService->connect(
            shopId: $request->integer('shopId'),
            payload: $request->safe()->only(['botToken', 'chatId', 'enabled']),
        );

        return (new TelegramIntegrationResource($integration))
            ->response()
            ->setStatusCode(200);
    }

    public function status(ShowTelegramStatusRequest $request): TelegramIntegrationStatusResource
    {
        $status = $this->telegramIntegrationService->status(
            shopId: $request->integer('shopId'),
        );

        return new TelegramIntegrationStatusResource($status);
    }
}
