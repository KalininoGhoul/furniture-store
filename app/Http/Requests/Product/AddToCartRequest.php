<?php

namespace App\Http\Requests\Product;

use App\Models\Product\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddToCartRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'product' => ['required', Rule::exists(Product::class, 'slug')],
            'number' => ['sometimes', 'integer'],
        ];
    }
}
