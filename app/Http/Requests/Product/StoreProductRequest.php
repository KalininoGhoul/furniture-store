<?php

namespace App\Http\Requests\Product;

use App\Models\Product\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'description' => ['required', 'string'],
            'price' => ['required', 'integer'],

            'images' => ['sometimes', 'array'],
            'images.*' => ['file', 'mimetypes:image/*'],

            'preview' => ['required', 'file', 'mimetypes:image/*'],
        ];
    }
}
