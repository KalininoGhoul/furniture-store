<?php

namespace App\Models\Collection;

use App\Models\Product\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property string $name
 * @property string $image
 * @property string $description
 * @property Product[]|Collection $products
 */
class Collection extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_collection')
            ->using(ProductCollection::class)
            ->withPivot(['coords']);
    }
}
