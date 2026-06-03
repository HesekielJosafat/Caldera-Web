<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Promo;
use Carbon\Carbon;

class PromoSeeder extends Seeder
{
    public function run()
    {
        $promos = [
            [
                'title' => 'Diskon 20% Menu Makanan',
                'slug' => 'diskon-20-menu-makanan',
                'description' => 'Dapatkan diskon 20% untuk semua menu makanan',
                'banner_image' => 'promos/diskon-20.jpg',
                'discount_type' => 'percentage',
                'discount_value' => 20,
                'promo_code' => 'MAKAN20',
                'promo_type' => 'menu',
                'min_purchase' => 50000,
                'max_discount' => 50000,
                'start_date' => Carbon::now(),
                'end_date' => Carbon::now()->addDays(30),
                'applicable_for' => json_encode(['menu']),
                'max_usage' => 100,
                'used_count' => 0,
                'is_active' => true,
            ],
            [
                'title' => 'Buy 1 Get 1 Tiket Kolam',
                'slug' => 'buy-1-get-1-tiket-kolam',
                'description' => 'Beli 1 tiket kolam gratis 1 tiket',
                'banner_image' => 'promos/b1g1-pool.jpg',
                'discount_type' => 'nominal',
                'discount_value' => 35000,
                'promo_code' => 'POOLB1G1',
                'promo_type' => 'ticket',
                'min_purchase' => 1,
                'max_discount' => 35000,
                'start_date' => Carbon::now(),
                'end_date' => Carbon::now()->addDays(15),
                'applicable_for' => json_encode(['ticket']),
                'max_usage' => 50,
                'used_count' => 0,
                'is_active' => true,
            ],
            [
                'title' => 'Early Bird Reservasi',
                'slug' => 'early-bird-reservasi',
                'description' => 'Diskon 10% untuk reservasi H-7',
                'banner_image' => 'promos/early-bird.jpg',
                'discount_type' => 'percentage',
                'discount_value' => 10,
                'promo_code' => 'EARLY10',
                'promo_type' => 'reservation',
                'min_purchase' => 200000,
                'max_discount' => 50000,
                'start_date' => Carbon::now(),
                'end_date' => Carbon::now()->addDays(45),
                'applicable_for' => json_encode(['reservation']),
                'max_usage' => 200,
                'used_count' => 0,
                'is_active' => true,
            ],
            [
                'title' => 'Weekend Special',
                'slug' => 'weekend-special',
                'description' => 'Diskon 15% setiap Sabtu dan Minggu',
                'banner_image' => 'promos/weekend.jpg',
                'discount_type' => 'percentage',
                'discount_value' => 15,
                'promo_code' => 'WEEKEND15',
                'promo_type' => 'menu',
                'min_purchase' => 100000,
                'max_discount' => 75000,
                'start_date' => Carbon::now(),
                'end_date' => Carbon::now()->addDays(60),
                'applicable_for' => json_encode(['menu']),
                'max_usage' => null,
                'used_count' => 0,
                'is_active' => true,
            ],
        ];

        foreach ($promos as $promo) {
            Promo::create($promo);
        }
    }
}