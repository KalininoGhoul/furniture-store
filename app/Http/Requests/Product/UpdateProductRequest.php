<?php

namespace App\Http\Requests\Product;

use App\Models\Product\ProductImage;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'description' => ['required', 'string'],
            'price' => ['required', 'integer'],

            'add_images' => ['sometimes', 'array'],
            'add_images.*' => ['file', 'mimetypes:image/*'],

            'remove_images' => ['sometimes', 'array'],
            'remove_images.*' => [Rule::exists(ProductImage::class, 'id')],

            'add_preview' => ['sometimes', 'file', 'mimetypes:image/*'],
            'set_preview' => ['sometimes', Rule::exists(ProductImage::class, 'id')],
        ];
    }
}
