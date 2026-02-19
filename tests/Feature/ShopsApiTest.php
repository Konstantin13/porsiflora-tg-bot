<?php

use App\Models\Shop;

test('возвращается полный список магазинов', function () {
    $firstShop = Shop::query()->create(['name' => 'First Shop']);
    $secondShop = Shop::query()->create(['name' => 'Second Shop']);

    $response = $this->getJson(route('api.shops.index'));

    $response
        ->assertOk()
        ->assertJsonCount(2)
        ->assertJsonPath('0.id', $firstShop->id)
        ->assertJsonPath('0.name', $firstShop->name)
        ->assertJsonPath('1.id', $secondShop->id)
        ->assertJsonPath('1.name', $secondShop->name);
});
