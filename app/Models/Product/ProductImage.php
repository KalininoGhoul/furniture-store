<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $url
 * @property string $storage_path
 * @property bool is_preview
 */
class ProductImage extends Model
{
    protected $guarded = ['id'];

    use HasFactory;
}
