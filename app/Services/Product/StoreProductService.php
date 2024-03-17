<?php

namespace App\Services\Product;

use App\Dto\ProductDto;
use App\Models\Product\Product;
use App\Traits\Sluggable;

class StoreProductService
{
    use Sluggable;

    public function __construct(
        private readonly SaveProductImagesService $saveProductImagesService
    )
    {
    }

    public function save(array $input, ?Product $product = null): void
    {
        $productDto = ProductDto::from($input);

        $product = $this->createProduct($productDto);
        $this->saveProductImagesService->saveImages($product, $productDto->addImages, $productDto->addPreview);
    }

    private function createProduct(ProductDto $productDto): Product
    {
        /** @type Product */
        return Product::query()->create([
            'name' => $productDto->name,
            'slug' => $this->makeSlug($productDto->slug ?? $productDto->name),
            'description' => $productDto->description,
            'price' => $productDto->price,
        ]);
    }
}
