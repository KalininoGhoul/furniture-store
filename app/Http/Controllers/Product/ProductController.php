<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Resources\Product\ProductListResource;
use App\Http\Resources\Product\ProductResource;
use App\Models\Product\Product;
use App\Services\Product\StoreProductService;
use App\Services\Product\UpdateProductService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $products = Product::with(['preview'])->get();

        return ProductListResource::collection($products);
    }

    public function store(StoreProductRequest $request, StoreProductService $saveProductService): void
    {
        $saveProductService->save($request->validated());
    }

    public function update(UpdateProductRequest $request, Product $product, UpdateProductService $updateProductService): void
    {
        $updateProductService->update($product, $request->validated());
    }

    public function show(Product $product): JsonResource
    {
        return new ProductResource($product);
    }
}
