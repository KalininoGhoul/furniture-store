<?php

namespace App\Dto;

use Illuminate\Http\UploadedFile;

class ProductDto
{

    /**
     * @param UploadedFile[]|null $addImages
     */
    public function __construct(
        public readonly string $name,
        public readonly ?string $slug,
        public readonly string $description,
        public readonly ?array $addImages,
        public readonly ?array $removeImages,
        public readonly ?UploadedFile $addPreview,
        public readonly ?string $setPreview,
        public readonly string $price,
    )
    {
    }

    public static function from(array $input): self
    {
        return new self(
            name: $input['name'],
            slug: $input['slug'] ?? null,
            description: $input['description'],
            addImages: $input['images'] ?? $input['add_images'] ?? null,
            removeImages: $input['remove_images'] ?? null,
            addPreview: $input['preview'] ?? $input['add_preview'] ?? null,
            setPreview: $input['set_preview'] ?? null,
            price: $input['price'],
        );
    }
}
