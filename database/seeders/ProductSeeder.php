<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Fortnite - The Random Bundle',
                'description' => 'Get random Fortnite skins and accessories with this gift card',
                'price' => 17.29,
                'image' => 'images/products/fortnite.jpg',
                'category_id' => 1,
                'is_featured' => true,
                'stock' => 100,
            ],
            [
                'name' => 'Minecraft - Starter Pack',
                'description' => 'Start your Minecraft adventure with this gift card',
                'price' => 9.09,
                'image' => 'images/products/minecraft.jpg',
                'category_id' => 4,
                'is_featured' => true,
                'stock' => 100,
            ],
            [
                'name' => 'GTA 5 - Shark Card Bundle',
                'description' => 'Get in-game currency for GTA Online with this gift card',
                'price' => 25.29,
                'image' => 'images/products/gta5.jpg',
                'category_id' => 3,
                'is_featured' => true,
                'stock' => 100,
            ],
            [
                'name' => 'FIFA 24 - Ultimate Team Pack',
                'description' => 'Build your dream team in FIFA 24 with this gift card',
                'price' => 32.09,
                'image' => 'images/products/fifa24.jpg',
                'category_id' => 2,
                'is_featured' => false,
                'stock' => 100,
            ],
            [
                'name' => 'Minecraft Pacote Triplo',
                'description' => 'Triple Minecraft bundle for the ultimate adventure',
                'price' => 22.99,
                'image' => 'images/products/minecraft-triple.jpg',
                'category_id' => 4,
                'is_featured' => true,
                'stock' => 100,
            ],
            [
                'name' => 'Red Dead Redemption 2 - Gold',
                'description' => 'Get gold bars for Red Dead Online with this gift card',
                'price' => 25.99,
                'image' => 'images/products/rdr2.jpg',
                'category_id' => 3,
                'is_featured' => false,
                'stock' => 100,
            ],
            [
                'name' => 'Call of Duty - CP Points',
                'description' => 'Get CP Points for Call of Duty with this gift card',
                'price' => 20.00,
                'image' => 'images/products/cod.jpg',
                'category_id' => 1,
                'is_featured' => false,
                'stock' => 100,
            ],
            [
                'name' => 'Roblox - Robux Card',
                'description' => 'Get Robux for Roblox with this gift card',
                'price' => 15.36,
                'image' => 'images/products/roblox.jpg',
                'category_id' => 4,
                'is_featured' => true,
                'stock' => 100,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}