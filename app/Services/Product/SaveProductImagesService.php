<?php

namespace App\Services\Product;

use App\Models\Product\Product;
use App\Models\Product\ProductImage;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class SaveProductImagesService
{
    /**
     * @param UploadedFile[] $images
     */
    public function saveImages(Product $product, array $images, ?UploadedFile $preview = null): void
    {
        $productImages = [];

        foreach ($images as $image) {
            $productImages[] = $this->saveImage($image);
        }

        if (!is_null($preview)) {
            $previewModel = $this->saveImage($preview);
            $previewModel->is_preview = true;
            $productImages[] = $previewModel;
        }

        $product->images()->saveMany($productImages);
    }

    private function saveImage(UploadedFile $image): ProductImage
    {
        $this->disk()->put('', $image);

        return new ProductImage([
            'url' => $this->disk()->url($image->hashName()),
            'storage_path' => $this->disk()->path($image->hashName()),
        ]);
    }

    private function disk(): Filesystem
    {
        return Storage::disk('products');
    }
}
