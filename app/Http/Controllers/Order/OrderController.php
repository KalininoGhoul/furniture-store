<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderListResource;
use App\Models\Product\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class OrderController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return OrderListResource::collection($this->user()->orders);
    }

    public function store(): JsonResponse
    {
        $activeCart = $this->user()->activeCart;

        if (!$activeCart) return response()->json([
            'message' => __('order.cart_empty')
        ], 422);

        /** @var Product[] $orderedProducts */
        $orderedProducts = $activeCart
            ->products()
            ->withPivot(['number'])
            ->get();

        $cost = 0;

        foreach ($orderedProducts as $product) {
            $cost += $product->price * $product->pivot->number;

            $product->carts()->updateExistingPivot($activeCart, [
                'price' => $product->price
            ]);
        }

        $activeCart->order()->create(['cost' => $cost]);
        $activeCart->update(['is_active' => false]);

        return response()->json([
            'message' => __('order.accepted'),
            'cost' => $cost,
        ]);
    }
}
