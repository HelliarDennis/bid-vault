<?php

namespace App\Data;

use App\Models\Item;
use Carbon\Carbon;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Lazy;
use Spatie\LaravelData\Optional;

class ItemData extends Data
{
    public function __construct(
        public int $id,
        public string $name,
        public string $description,
        public float $starting_price,
        public Carbon $start_at,
        public Carbon $end_at,
        public Carbon $created_at,
        public Carbon $updated_at,
        public ?ItemCategoryData $category,
        public Lazy|Optional|ItemBidData $highest_bid,
        public string $status,
    ) {
    }

    public static function fromModel(Item $item): self
    {
        $instance = new self(
            id: $item->id,
            name: $item->name,
            description: $item->description,
            starting_price: $item->starting_price,
            start_at: $item->start_at,
            end_at: $item->end_at,
            created_at: $item->created_at,
            updated_at: $item->updated_at,
            category: $item->category ? ItemCategoryData::fromModel($item->category) : null,
            highest_bid: Lazy::when(
                fn () => $item->relationLoaded('bids'),
                fn () => $item->highestBid() ? ItemBidData::fromModel($item->highestBid()) : Optional::create()
            ),
            status: self::calculateStatus($item->start_at, $item->end_at),
        );

        return $instance;
    }

    private static function calculateStatus(Carbon $start_at, Carbon $end_at): string
    {
        $now = now();

        if ($now < $start_at) {
            return 'upcoming';
        }

        if ($now >= $start_at && $now < $end_at) {
            return 'active';
        }

        return 'ended';
    }

    public function getStatus(): string
    {
        return $this->status;
    }
}
