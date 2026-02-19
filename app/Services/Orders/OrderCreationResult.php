<?php

namespace App\Services\Orders;

use App\Models\Order;

final readonly class OrderCreationResult
{
    public function __construct(
        public Order $order,
        public string $sendStatus,
        public ?string $sendError = null,
    ) {}
}
