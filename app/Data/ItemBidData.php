<?php

namespace App\Data;

use App\Models\ItemBid;
use Carbon\Carbon;
use Spatie\LaravelData\Data;

class ItemBidData extends Data
{
    public function __construct(
        public int $id,
        public int $item_id,
        public int $user_id,
        public float $amount,
        public Carbon $created_at,
        public Carbon $updated_at,
        public ?string $bidder_name = null,
    ) {
    }

    public static function fromModel(ItemBid $bid): self
    {
        return new self(
            id: $bid->id,
            item_id: $bid->item_id,
            user_id: $bid->user_id,
            amount: $bid->amount,
            created_at: $bid->created_at,
            updated_at: $bid->updated_at,
            bidder_name: $bid->user?->name,
        );
    }
}
