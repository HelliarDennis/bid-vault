<?php

namespace App\Data;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

class PaginationData extends Data
{
    public function __construct(
        public int $current_page,
        public int $last_page,
        public int $per_page,
        public int $total,
        #[DataCollectionOf(Data::class)]
        public DataCollection $data,
    ) {
    }

    public static function fromPaginator(LengthAwarePaginator $paginator, string $dataClass): self
    {
        return new self(
            current_page: $paginator->currentPage(),
            last_page: $paginator->lastPage(),
            per_page: $paginator->perPage(),
            total: $paginator->total(),
            data: new DataCollection($dataClass, $dataClass::collect($paginator->items())),
        );
    }
}
