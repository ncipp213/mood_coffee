<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $menus = [
            ['name' => 'Cappuccino', 'description' => 'Rich espresso with creamy steamed milk and a layer of foam', 'price' => 28000, 'rating' => 4.8, 'category' => 'Hot Coffee'],
            ['name' => 'Gula Aren', 'description' => 'Palm sugar sweetness blended with premium espresso and milk', 'price' => 25000, 'rating' => 4.6, 'category' => 'Signature'],
            ['name' => 'Latte', 'description' => 'Smooth and creamy latte with rich espresso', 'price' => 30000, 'rating' => 4.7, 'category' => 'Hot Coffee'],
            ['name' => 'Caramel Latte', 'description' => 'Caramel infused latte with a hint of vanilla', 'price' => 32000, 'rating' => 4.9, 'category' => 'Signature'],
            ['name' => 'Coconut Cappuccino', 'description' => 'Creamy coconut flavor blended with rich cappuccino', 'price' => 33000, 'rating' => 4.8, 'category' => 'Signature'],
            ['name' => 'Iced Americano', 'description' => 'Refreshing cold brew with a bold espresso kick', 'price' => 22000, 'rating' => 4.4, 'category' => 'Iced Coffee'],
        ];

        foreach ($menus as $menu) {
            Menu::create($menu);
        }
    }
}