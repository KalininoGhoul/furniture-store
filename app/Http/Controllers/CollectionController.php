<?php

namespace App\Http\Controllers;

use App\Dto\CollectionDto;
use App\Http\Requests\StoreCollectionRequest;
use App\Http\Resources\Collection\CollectionListResource;
use App\Models\Collection\Collection;
use App\Services\Collection\StoreCollectionService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CollectionController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return CollectionListResource::collection(
            Collection::query()
                ->whereHas('products')
                ->with(['products'])
                ->get()
        );
    }

    public function store(StoreCollectionRequest $request, StoreCollectionService $storeCollectionService): void
    {
        $storeCollectionService->store(new CollectionDto(
            name: $request->validated('name'),
            image: $request->validated('image'),
            products: $request->validated('products'),
        ));
    }
}
