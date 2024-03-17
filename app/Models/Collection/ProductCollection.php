<?php

namespace App\Models\Collection;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ProductCollection extends Pivot
{
    protected $table = 'product_collection';

    protected $guarded = ['id'];

    protected $casts = [
        'coords' => 'array',
    ];
}
