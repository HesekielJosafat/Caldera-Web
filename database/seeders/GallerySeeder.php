<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Gallery;
use App\Models\Menu;
use App\Models\Event;
use App\Models\Promo;
use App\Models\Testimonial;

class GallerySeeder extends Seeder
{
    public function run()
    {
        // Gallery untuk Menu
        $menus = Menu::all();
        foreach ($menus as $index => $menu) {
            Gallery::create([
                'title' => $menu->name,
                'type' => 'image',
                'file_path' => 'galleries/menus/menu-' . ($index + 1) . '.jpg',
                'galleryable_id' => $menu->id,
                'galleryable_type' => Menu::class,
                'category' => 'menu',
                'is_featured' => $index === 0,
                'sort_order' => $index + 1
            ]);
        }

        // Gallery untuk Event
        $events = Event::all();
        foreach ($events as $index => $event) {
            Gallery::create([
                'title' => $event->title,
                'type' => 'image',
                'file_path' => 'galleries/events/event-' . ($index + 1) . '.jpg',
                'galleryable_id' => $event->id,
                'galleryable_type' => Event::class,
                'category' => 'event',
                'is_featured' => true,
                'sort_order' => 1
            ]);
        }

        // Gallery untuk Promo
        $promos = Promo::all();
        foreach ($promos as $index => $promo) {
            Gallery::create([
                'title' => $promo->title,
                'type' => 'image',
                'file_path' => 'galleries/promos/promo-' . ($index + 1) . '.jpg',
                'galleryable_id' => $promo->id,
                'galleryable_type' => Promo::class,
                'category' => 'promo',
                'is_featured' => true,
                'sort_order' => 1
            ]);
        }

        // Gallery untuk Testimonial (foto customer)
        $testimonials = Testimonial::all();
        foreach ($testimonials as $index => $testimonial) {
            Gallery::create([
                'title' => $testimonial->customer_name,
                'type' => 'image',
                'file_path' => 'galleries/testimonials/customer-' . ($index + 1) . '.jpg',
                'galleryable_id' => $testimonial->id,
                'galleryable_type' => Testimonial::class,
                'category' => 'testimonial',
                'is_featured' => $testimonial->is_featured,
                'sort_order' => 1
            ]);
        }
    }
}