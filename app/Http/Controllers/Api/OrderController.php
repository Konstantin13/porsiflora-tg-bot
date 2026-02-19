<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreOrderRequest;
use App\Http\Resources\OrderCreationResource;
use App\Services\Orders\OrderService;

class OrderController extends Controller
{
    public function __construct(
        private readonly OrderService $orderService,
    ) {}

    public function store(StoreOrderRequest $request): OrderCreationResource
    {
        $result = $this->orderService->create(
            shopId: $request->integer('shopId'),
            payload: $request->safe()->only(['number', 'total', 'customerName']),
        );

        return new OrderCreationResource($result);
    }
}
