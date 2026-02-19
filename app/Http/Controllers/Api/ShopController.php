<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ShopResource;
use App\Models\Shop;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ShopController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $shops = Shop::query()
            ->orderBy('id')
            ->get();

        return ShopResource::collection($shops);
    }
}
