<?php

namespace App\Services\Product;

use App\Dto\ProductDto;
use App\Models\Product\Product;
use App\Traits\Sluggable;

class UpdateProductService
{
    use Sluggable;

    public function __construct(
        private readonly SaveProductImagesService $saveProductImagesService
    )
    {
    }

    public function update(Product $product, array $input): void
    {
        $productDto = ProductDto::from($input);

        $this->updateProduct($product, $productDto);
        $this->updateImages($product, $productDto);
    }

    private function updateProduct(Product $product, ProductDto $productDto): void
    {
        $product->update([
            'name' => $productDto->name,
            'slug' => $this->makeSlug($productDto->slug ?? $productDto->name, $product->slug),
            'description' => $productDto->description,
            'price' => $productDto->price
        ]);
    }


    private function updateImages(Product $product, ProductDto $productDto): void
    {
        $this->saveProductImagesService->saveImages($product, $productDto->addImages ?? [], $productDto->addPreview);

        if (!is_null($productDto->removeImages)) {
            $this->removeImages($product, $productDto->removeImages);
        }

        if (!is_null($productDto->setPreview)) {
            $this->setPreview($product, $productDto->setPreview);
        }
    }

    private function removeImages(Product $product, array $removeImages): void
    {
        $product
            ->images()
            ->where('id', $removeImages)
            ->delete();
    }

    private function setPreview(Product $product, string $setPreview): void
    {
        $product->images()->update(['is_preview' => false]);

        $product
            ->images()
            ->find($setPreview)
            ->update(['is_preview' => true]);
    }
}
