<?php

namespace App\Dto;

use Illuminate\Http\UploadedFile;

class CollectionDto
{
    public function __construct(
        public readonly string $name,
        public readonly UploadedFile $image,
        public readonly array $products,
    )
    {
    }

    public static function from(array $input): self
    {
        return new self(
            name: $input['name'],
            image: $input['image'],
            products: $input['products']
        );
    }
}
