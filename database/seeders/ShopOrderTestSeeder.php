<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Shop;
use Illuminate\Database\Seeder;

class ShopOrderTestSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $shops = [
            'Тестовый магазин 1',
            'Тестовый магазин 2',
        ];

        foreach ($shops as $shopIndex => $shopName) {
            $shop = Shop::query()->updateOrCreate(
                ['name' => $shopName],
                ['name' => $shopName],
            );

            for ($orderNumber = 1; $orderNumber <= 5; $orderNumber++) {
                $number = sprintf('TEST-%d-%03d', $shopIndex + 1, $orderNumber);

                Order::query()->updateOrCreate(
                    [
                        'shop_id' => $shop->id,
                        'number' => $number,
                    ],
                    [
                        'total' => 1000 + ($orderNumber * 111.11),
                        'customer_name' => sprintf('Тестовый клиент %d-%d', $shopIndex + 1, $orderNumber),
                        'created_at' => now()->subDays(5 - $orderNumber),
                    ],
                );
            }
        }
    }
}
