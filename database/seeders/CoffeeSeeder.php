<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CoffeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    // database/seeders/CoffeeSeeder.php
    public function run(): void
    {
        DB::table('coffees')->insert([
            [
                'id' => '1',
                'name' => 'Cappuccino',
                'price' => 'Rp 28.000',
                'image_url' => 'https://images.unsplash.com/photo-1534778101976-62847782c213?w=200&h=200&fit=crop',
                'description' => 'Rich espresso with creamy milk foam',
                'category' => 'hot',
                'rating' => 4.8,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // ... salin semua data kopi lainnya dari file coffee.dart di Flutter
        ]);
    }
}
