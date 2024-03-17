<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\AddToCartRequest;
use App\Http\Resources\CartProductListResource;
use App\Models\Product\Product;
use App\Models\User;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CartController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        /** @var User $user */
        $user = auth()->user();

        return CartProductListResource::collection(
            $user->activeCart?->products()->withPivot(['price', 'number'])->get() ?? []
        );
    }

    public function addToCart(AddToCartRequest $request): void
    {
        /** @var User $user */
        $user = $request->user();
        $product = Product::query()->firstWhere('slug', $request->validated('product'));

        $cart = $user->activeCart;

        if (!$cart) {
            $user->carts()->update(['is_active' => false]);
            $cart = $user->carts()->create(['is_active' => true]);
        }

        $cart->products()->syncWithoutDetaching([
            $product->id => [
                'number' => $request->validated('number') ?? 1
            ]
        ]);
    }

    public function removeFromCart(Product $product): void
    {
        /** @var User $user */
        $user = auth()->user();

        $user->activeCart->products()->detach($product);
    }
}
