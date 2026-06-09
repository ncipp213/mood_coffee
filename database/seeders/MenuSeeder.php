<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $menus = [
            [
                'name' => 'Cappuccino',
                'slug' => 'cappuccino',
                'description' => 'Rich espresso with creamy steamed milk and a layer of velvety foam',
                'price' => 28000,
                'rating' => 4.8,
                'image_url' => '/images/cappuccino.jpg',
                'category' => 'Menu Kopi'
            ],
            [
                'name' => 'Gula Aren',
                'slug' => 'gula-aren',
                'description' => 'Palm sugar sweetness perfectly blended with rich espresso and milk',
                'price' => 25000,
                'rating' => 4.6,
                'image_url' => '/images/gula-aren.jpg',
                'category' => 'Menu Kopi'
            ],
            [
                'name' => 'Latte',
                'slug' => 'latte',
                'description' => 'Smooth and creamy latte with a perfect espresso-to-milk ratio',
                'price' => 30000,
                'rating' => 4.7,
                'image_url' => '/images/latte.jpg',
                'category' => 'Menu Kopi'
            ],
            [
                'name' => 'Ramell Latte',
                'slug' => 'ramell-latte',
                'description' => 'Caramel infused latte with a hint of vanilla and whipped cream',
                'price' => 32000,
                'rating' => 4.9,
                'image_url' => '/images/ramell-latte.jpg',
                'category' => 'Menu Kopi'
            ],
            [
                'name' => 'Coconut Cappuccino',
                'slug' => 'coconut-cappuccino',
                'description' => 'Creamy coconut-infused cappuccino with a tropical twist',
                'price' => 33000,
                'rating' => 4.8,
                'image_url' => '/images/coconut-cappuccino.jpg',
                'category' => 'Menu Kopi'
            ],
            [
                'name' => 'Iced Americano',
                'slug' => 'iced-americano',
                'description' => 'Refreshing cold brew espresso with chilled water and ice',
                'price' => 22000,
                'rating' => 4.4,
                'image_url' => '/images/iced-americano.jpg',
                'category' => 'Menu Kopi'
            ],
        ];

        foreach ($menus as $menu) {
            Menu::create($menu);
        }
    }
}