<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;
use Carbon\Carbon;

class EventSeeder extends Seeder
{
    public function run()
    {
        $events = [
            [
                'title' => 'Live Music Night',
                'slug' => 'live-music-night',
                'description' => 'Nikmati malam minggu dengan live music dari band lokal',
                'banner_image' => 'events/live-music.jpg',
                'start_date' => Carbon::now()->addDays(7),
                'end_date' => Carbon::now()->addDays(7)->addHours(4),
                'location' => 'Caldera Resto Main Hall',
                'max_participants' => 100,
                'ticket_price' => 50000,
                'event_schedule' => json_encode(['19:00' => 'Open Gate', '20:00' => 'Live Music Start']),
                'contact_info' => json_encode(['phone' => '08123456789', 'email' => 'event@caldera.com']),
                'is_featured' => true,
                'is_active' => true
            ],
            [
                'title' => 'Pool Party Weekend',
                'slug' => 'pool-party-weekend',
                'description' => 'Pool party seru dengan DJ dan free flow minuman',
                'banner_image' => 'events/pool-party.jpg',
                'start_date' => Carbon::now()->addDays(14),
                'end_date' => Carbon::now()->addDays(14)->addHours(6),
                'location' => 'Caldera Pool Area',
                'max_participants' => 50,
                'ticket_price' => 100000,
                'event_schedule' => json_encode(['14:00' => 'Check-in', '15:00' => 'DJ Performance']),
                'contact_info' => json_encode(['phone' => '08123456789', 'email' => 'event@caldera.com']),
                'is_featured' => true,
                'is_active' => true
            ],
            [
                'title' => 'Cooking Class with Chef',
                'slug' => 'cooking-class',
                'description' => 'Belajar masak menu spesial langsung dari chef',
                'banner_image' => 'events/cooking-class.jpg',
                'start_date' => Carbon::now()->addDays(21),
                'end_date' => Carbon::now()->addDays(21)->addHours(3),
                'location' => 'Caldera Kitchen Studio',
                'max_participants' => 20,
                'ticket_price' => 150000,
                'event_schedule' => json_encode(['10:00' => 'Welcome', '10:30' => 'Cooking Session']),
                'contact_info' => json_encode(['phone' => '08123456789', 'email' => 'event@caldera.com']),
                'is_featured' => false,
                'is_active' => true
            ],
        ];

        foreach ($events as $event) {
            Event::create($event);
        }
    }
}