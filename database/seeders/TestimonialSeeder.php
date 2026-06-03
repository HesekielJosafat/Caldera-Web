<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Testimonial;
use Carbon\Carbon;

class TestimonialSeeder extends Seeder
{
    public function run()
    {
        $testimonials = [
            [
                'customer_name' => 'Budi Santoso',
                'customer_email' => 'budi@customer.com',
                'customer_photo' => null,
                'rating' => 5,
                'comment' => 'Makanannya enak banget! Kolamnya juga bersih dan nyaman. Pelayanannya ramah. Recommended banget buat keluarga!',
                'service_type' => 'restaurant',
                'visit_date' => Carbon::now()->subDays(5),
                'is_approved' => true,
                'is_featured' => true,
                'approved_at' => Carbon::now(),
                'approved_by' => 1,
            ],
            [
                'customer_name' => 'Siti Aminah',
                'customer_email' => 'siti@customer.com',
                'customer_photo' => null,
                'rating' => 5,
                'comment' => 'Tempatnya bagus, cocok buat staycation keluarga. Anak-anak senang main di kolam. Makanannya juga enak-enak.',
                'service_type' => 'pool',
                'visit_date' => Carbon::now()->subDays(3),
                'is_approved' => true,
                'is_featured' => true,
                'approved_at' => Carbon::now(),
                'approved_by' => 1,
            ],
            [
                'customer_name' => 'Ahmad Rizki',
                'customer_email' => 'ahmad@customer.com',
                'customer_photo' => null,
                'rating' => 4,
                'comment' => 'Live musicnya bagus, makanannya enak. Harga terjangkau. Akan datang lagi!',
                'service_type' => 'event',
                'visit_date' => Carbon::now()->subDays(7),
                'is_approved' => true,
                'is_featured' => true,
                'approved_at' => Carbon::now(),
                'approved_by' => 1,
            ],
            [
                'customer_name' => 'Dewi Lestari',
                'customer_email' => 'dewi@example.com',
                'customer_photo' => null,
                'rating' => 5,
                'comment' => 'Pelayanan cepat, tempat bersih, harga bersahabat. Suasananya cozy banget!',
                'service_type' => 'restaurant',
                'visit_date' => Carbon::now()->subDays(2),
                'is_approved' => true,
                'is_featured' => false,
                'approved_at' => Carbon::now(),
                'approved_by' => 1,
            ],
            [
                'customer_name' => 'Rudi Hermawan',
                'customer_email' => 'rudi@example.com',
                'customer_photo' => null,
                'rating' => 4,
                'comment' => 'Tiket kolam online memudahkan, tidak perlu antri. Kolamnya bersih dan petugasnya ramah.',
                'service_type' => 'pool',
                'visit_date' => Carbon::now()->subDays(1),
                'is_approved' => true,
                'is_featured' => false,
                'approved_at' => Carbon::now(),
                'approved_by' => 1,
            ],
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::create($testimonial);
        }
    }
}