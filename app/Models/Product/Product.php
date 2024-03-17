<?php

namespace App\Models\Product;

use App\Models\Order\Cart;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property int $price
 * @property ProductImage[]|Collection $images
 * @property ProductImage $preview
 */
class Product extends Model
{
    use HasFactory;

    protected $casts = [
        'price' => 'integer',
    ];

    protected $guarded = ['id'];

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    public function preview(): HasOne
    {
        return $this
            ->hasOne(ProductImage::class)
            ->where('is_preview', true);
    }

    public function carts(): BelongsToMany
    {
        return $this->belongsToMany(Cart::class);
    }
}
