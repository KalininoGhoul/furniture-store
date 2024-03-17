<?php

namespace App\Traits;

use App\Models\Product\Product;
use Illuminate\Support\Str;

trait Sluggable
{
    private function makeSlug(string $value, ?string $old = null): string
    {
        $slug = Str::slug($value);

        if ($slug === $old) return $slug;

        $count = Product::query()->where('slug', 'like', $slug.'%')->count();

        if ($count === 0) return $slug;

        return $slug . '-'.++$count;
    }
}
