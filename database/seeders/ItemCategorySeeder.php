<?php

namespace Database\Seeders;

use App\Models\ItemCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ItemCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Electronics' => 'High-end electronics and gadgets',
            'Collectibles' => 'Rare and valuable collectible items',
            'Art' => 'Fine art, paintings, and sculptures',
            'Jewelry' => 'Luxury jewelry and watches',
            'Antiques' => 'Vintage and antique items',
            'Sports Memorabilia' => 'Sports collectibles and memorabilia',
            'Wine & Spirits' => 'Fine wines and rare spirits',
            'Luxury Fashion' => 'Designer clothing and accessories',
            'Coins & Stamps' => 'Rare coins and philatelic items',
            'Musical Instruments' => 'Vintage and rare musical instruments',
        ];

        foreach ($categories as $name => $description) {
            ItemCategory::updateOrCreate(
                ['slug' => Str::slug($name)],
                [
                    'name' => $name,
                    'description' => $description,
                ]
            );
        }
    }
} 