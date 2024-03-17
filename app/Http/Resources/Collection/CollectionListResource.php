<?php

namespace App\Http\Resources\Collection;

use App\Models\Collection\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Collection
 */
class CollectionListResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'image' => $this->image,
            'description' => $this->description,
            'products' => CollectionProductListResource::collection($this->products),
        ];
    }
}
