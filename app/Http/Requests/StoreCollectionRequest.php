<?php

namespace App\Http\Requests;

use App\Models\Product\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCollectionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'image' => ['required', 'file', 'mimetypes:image/*'],

            'products' => ['required', 'array'],
            'products.*.slug' => ['required', Rule::exists(Product::class, 'slug')],
            'products.*.coords.top' => ['required', 'numeric'],
            'products.*.coords.left' => ['required', 'numeric'],
        ];
    }
}
