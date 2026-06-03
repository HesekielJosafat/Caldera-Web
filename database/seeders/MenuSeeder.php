<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    public function run()
    {
        $menus = [
            // Makanan
            [
                'name' => 'Nasi Goreng Caldera',
                'category' => 'makanan',
                'description' => 'Nasi goreng spesial dengan topping ayam suwir, udang, telur mata sapi, dan kerupuk',
                'price' => 45000,
                'image' => 'menus/nasi-goreng.jpg',
                'is_available' => true,
                'is_recommended' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Mie Goreng Seafood',
                'category' => 'makanan',
                'description' => 'Mie goreng dengan udang, cumi, bakso ikan, dan sayuran segar',
                'price' => 48000,
                'image' => 'menus/mie-goreng.jpg',
                'is_available' => true,
                'is_recommended' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Ayam Bakar Madu',
                'category' => 'makanan',
                'description' => 'Ayam bakar dengan bumbu madu spesial, disajikan dengan sambal matah',
                'price' => 55000,
                'image' => 'menus/ayam-bakar.jpg',
                'is_available' => true,
                'is_recommended' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Iga Bakar',
                'category' => 'makanan',
                'description' => 'Iga sapi bakar dengan bumbu kecap pedas manis',
                'price' => 85000,
                'image' => 'menus/iga-bakar.jpg',
                'is_available' => true,
                'is_recommended' => false,
                'sort_order' => 4,
            ],
            [
                'name' => 'Sate Ayam',
                'category' => 'makanan',
                'description' => '10 tusuk sate ayam dengan bumbu kacang',
                'price' => 35000,
                'image' => 'menus/sate-ayam.jpg',
                'is_available' => true,
                'is_recommended' => false,
                'sort_order' => 5,
            ],
            [
                'name' => 'Gado-gado',
                'category' => 'makanan',
                'description' => 'Sayuran segar dengan bumbu kacang spesial',
                'price' => 28000,
                'image' => 'menus/gado-gado.jpg',
                'is_available' => true,
                'is_recommended' => false,
                'sort_order' => 6,
            ],
            
            // Minuman
            [
                'name' => 'Es Teh Manis',
                'category' => 'minuman',
                'description' => 'Teh hitam dengan gula, disajikan dingin',
                'price' => 8000,
                'image' => 'menus/es-teh.jpg',
                'is_available' => true,
                'is_recommended' => false,
                'sort_order' => 7,
            ],
            [
                'name' => 'Jus Alpukat',
                'category' => 'minuman',
                'description' => 'Jus alpukat segar dengan susu coklat',
                'price' => 18000,
                'image' => 'menus/jus-alpukat.jpg',
                'is_available' => true,
                'is_recommended' => true,
                'sort_order' => 8,
            ],
            [
                'name' => 'Jus Jeruk',
                'category' => 'minuman',
                'description' => 'Jus jeruk segar peras',
                'price' => 15000,
                'image' => 'menus/jus-jeruk.jpg',
                'is_available' => true,
                'is_recommended' => false,
                'sort_order' => 9,
            ],
            [
                'name' => 'Lemon Tea',
                'category' => 'minuman',
                'description' => 'Teh lemon segar dengan madu',
                'price' => 12000,
                'image' => 'menus/lemon-tea.jpg',
                'is_available' => true,
                'is_recommended' => false,
                'sort_order' => 10,
            ],
            [
                'name' => 'Es Kopi Susu',
                'category' => 'minuman',
                'description' => 'Kopi dengan susu dan gula aren',
                'price' => 20000,
                'image' => 'menus/es-kopi.jpg',
                'is_available' => true,
                'is_recommended' => true,
                'sort_order' => 11,
            ],
            
            // Dessert
            [
                'name' => 'Pisang Goreng Keju',
                'category' => 'dessert',
                'description' => 'Pisang goreng dengan topping keju dan coklat',
                'price' => 20000,
                'image' => 'menus/pisang-goreng.jpg',
                'is_available' => true,
                'is_recommended' => true,
                'sort_order' => 12,
            ],
            [
                'name' => 'Es Krim Campur',
                'category' => 'dessert',
                'description' => 'Es krim vanilla dengan topping buah dan coklat',
                'price' => 25000,
                'image' => 'menus/es-krim.jpg',
                'is_available' => true,
                'is_recommended' => false,
                'sort_order' => 13,
            ],
        ];

        foreach ($menus as $menu) {
            Menu::create($menu);
        }
    }
}