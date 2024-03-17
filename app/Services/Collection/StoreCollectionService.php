<?php

namespace App\Services\Collection;

use App\Dto\CollectionDto;
use App\Models\Collection\Collection as CollectionModel;
use App\Models\Product\Product;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class StoreCollectionService
{
    public function store(CollectionDto $collectionDto): void
    {
        /** @var CollectionModel $collection */
        $collection = CollectionModel::query()->create([
            'name' => $collectionDto->name,
            'image' => $this->saveImage($collectionDto->image)
        ]);

        $this->syncProducts(collect($collectionDto->products), $collection);
    }

    private function saveImage(UploadedFile $image): string
    {
        $disk = Storage::disk('products');
        $disk->put('', $image);

        return $disk->url($image->hashName());
    }

    private function syncProducts(Collection $products, CollectionModel $collection): void
    {
        $productIds = Product::query()
            ->select('id')
            ->where('slug', $products->pluck('slug'))
            ->get();

        $productCoords = $products->pluck('coords');

        $collection->products()->sync(
            $productIds->mapWithKeys(fn(Product $product, int $index) => [
                $product->id => ['coords' => $productCoords->get($index)]
            ])
        );
    }
}
