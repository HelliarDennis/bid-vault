<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\ItemCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ItemSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            // Electronics
            ['name' => 'Vintage Macintosh Computer', 'description' => 'Rare 1984 Macintosh 128K in excellent condition', 'starting_price' => 5000, 'category' => 'Electronics'],
            ['name' => 'Limited Edition Gaming Console', 'description' => 'Rare gold-plated PlayStation 5', 'starting_price' => 2000, 'category' => 'Electronics'],
            ['name' => 'Vintage Camera Collection', 'description' => 'Set of 5 Leica cameras from the 1950s', 'starting_price' => 15000, 'category' => 'Electronics'],

            // Collectibles
            ['name' => 'First Edition Comic Book', 'description' => 'Mint condition Action Comics #1', 'starting_price' => 100000, 'category' => 'Collectibles'],
            ['name' => 'Rare Trading Card', 'description' => 'Pokemon Illustrator Card', 'starting_price' => 50000, 'category' => 'Collectibles'],
            ['name' => 'Vintage Action Figure', 'description' => 'Original 1977 Star Wars Darth Vader', 'starting_price' => 2000, 'category' => 'Collectibles'],

            // Art
            ['name' => 'Modern Abstract Painting', 'description' => 'Original contemporary art piece', 'starting_price' => 8000, 'category' => 'Art'],
            ['name' => 'Sculpture Collection', 'description' => 'Set of 3 bronze sculptures', 'starting_price' => 25000, 'category' => 'Art'],
            ['name' => 'Vintage Print', 'description' => 'Limited edition Salvador Dali print', 'starting_price' => 5000, 'category' => 'Art'],

            // Jewelry
            ['name' => 'Diamond Necklace', 'description' => '18k gold necklace with 5ct diamond', 'starting_price' => 30000, 'category' => 'Jewelry'],
            ['name' => 'Vintage Rolex', 'description' => '1950s Rolex Submariner', 'starting_price' => 25000, 'category' => 'Jewelry'],
            ['name' => 'Emerald Ring', 'description' => 'Platinum ring with 3ct emerald', 'starting_price' => 15000, 'category' => 'Jewelry'],

            // Antiques
            ['name' => 'Victorian Clock', 'description' => 'Ornate grandfather clock from 1890', 'starting_price' => 12000, 'category' => 'Antiques'],
            ['name' => 'Antique Desk', 'description' => 'Mahogany writing desk from 1800s', 'starting_price' => 8000, 'category' => 'Antiques'],
            ['name' => 'Vintage Globe', 'description' => 'Rare 1920s terrestrial globe', 'starting_price' => 3000, 'category' => 'Antiques'],

            // Sports Memorabilia
            ['name' => 'Signed Baseball', 'description' => 'Babe Ruth signed baseball', 'starting_price' => 75000, 'category' => 'Sports Memorabilia'],
            ['name' => 'Championship Ring', 'description' => 'NBA Championship ring from 1960s', 'starting_price' => 25000, 'category' => 'Sports Memorabilia'],
            ['name' => 'Vintage Jersey', 'description' => 'Game-worn jersey from famous player', 'starting_price' => 15000, 'category' => 'Sports Memorabilia'],

            // Wine & Spirits
            ['name' => 'Vintage Wine Collection', 'description' => 'Set of 6 bottles from 1945', 'starting_price' => 50000, 'category' => 'Wine & Spirits'],
            ['name' => 'Rare Whiskey', 'description' => 'Macallan 1926 Fine & Rare', 'starting_price' => 100000, 'category' => 'Wine & Spirits'],
            ['name' => 'Champagne Set', 'description' => 'Vintage Dom Perignon collection', 'starting_price' => 25000, 'category' => 'Wine & Spirits'],

            // Luxury Fashion
            ['name' => 'Designer Handbag', 'description' => 'Limited edition Hermes Birkin', 'starting_price' => 50000, 'category' => 'Luxury Fashion'],
            ['name' => 'Vintage Watch', 'description' => 'Patek Philippe from 1950s', 'starting_price' => 75000, 'category' => 'Luxury Fashion'],
            ['name' => 'Designer Suit', 'description' => 'Custom tailored Brioni suit', 'starting_price' => 8000, 'category' => 'Luxury Fashion'],

            // Coins & Stamps
            ['name' => 'Rare Coin Collection', 'description' => 'Set of ancient Roman coins', 'starting_price' => 15000, 'category' => 'Coins & Stamps'],
            ['name' => 'Stamp Album', 'description' => 'Complete collection of rare stamps', 'starting_price' => 25000, 'category' => 'Coins & Stamps'],
            ['name' => 'Gold Coin', 'description' => 'Double Eagle gold coin from 1907', 'starting_price' => 20000, 'category' => 'Coins & Stamps'],

            // Musical Instruments
            ['name' => 'Vintage Guitar', 'description' => '1959 Gibson Les Paul', 'starting_price' => 250000, 'category' => 'Musical Instruments'],
            ['name' => 'Grand Piano', 'description' => 'Steinway Model D from 1920s', 'starting_price' => 100000, 'category' => 'Musical Instruments'],
            ['name' => 'Violin', 'description' => 'Antique Stradivarius violin', 'starting_price' => 500000, 'category' => 'Musical Instruments'],
        ];

        foreach ($items as $item) {
            $category = ItemCategory::where('name', $item['category'])->first();

            Item::updateOrCreate(
                ['slug' => Str::slug($item['name'])],
                [
                    'name' => $item['name'],
                    'description' => $item['description'],
                    'starting_price' => $item['starting_price'],
                    'item_category_id' => $category->id,
                    'start_at' => now()->addDays(rand(1, 30)),
                    'end_at' => now()->addDays(rand(31, 60)),
                ]
            );
        }
    }
}
