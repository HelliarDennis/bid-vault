<?php

namespace App\Data;

use App\Models\ItemCategory;
use Carbon\Carbon;
use Spatie\LaravelData\Data;

class ItemCategoryData extends Data
{
    public function __construct(
        public int $id,
        public string $name,
        public string $slug,
        public ?string $description,
        public Carbon $created_at,
        public Carbon $updated_at,
    ) {
    }

    public static function fromModel(ItemCategory $category): self
    {
        return new self(
            id: $category->id,
            name: $category->name,
            slug: $category->slug,
            description: $category->description,
            created_at: $category->created_at,
            updated_at: $category->updated_at,
        );
    }
}
