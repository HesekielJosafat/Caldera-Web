<?php

namespace App\Http\Controllers\Branding;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Promo;
use App\Models\Event;
use App\Models\Testimonial;
use App\Models\Gallery;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $activePromos = Promo::active()->where('is_active', true)->latest()->take(3)->get();
        $recommendedMenus = Menu::recommended()->available()->latest()->take(6)->get();
        $upcomingEvents = Event::where('is_active', true)
            ->where('start_date', '>=', now())
            ->orderBy('start_date')
            ->take(3)
            ->get();
        $testimonials = Testimonial::approved()->featured()->latest()->take(6)->get();
        $featuredGallery = Gallery::where('is_featured', true)
            ->where('type', 'image')
            ->take(8)
            ->get();
        
        $stats = [
            ['id' => 'counter1', 'value' => Testimonial::approved()->count() * 100 ?: 1500, 'label' => 'Happy Clients', 'icon' => 'fa-smile', 'color' => 'primary'],
            ['id' => 'counter2', 'value' => Menu::available()->count() ?: 2500, 'label' => 'Menu Variants', 'icon' => 'fa-utensils', 'color' => 'success'],
            ['id' => 'counter3', 'value' => Event::where('is_active', true)->count() ?: 50, 'label' => 'Events', 'icon' => 'fa-calendar', 'color' => 'info'],
            ['id' => 'counter4', 'value' => Testimonial::approved()->count() ?: 25, 'label' => 'Testimonials', 'icon' => 'fa-star', 'color' => 'warning'],
        ];

        $features = [
            [
                'icon' => 'fa-paint-brush',
                'gradient' => 'primary',
                'title' => 'Modern Design',
                'description' => 'Beautiful and intuitive interface with smooth animations and interactions.',
                'feature' => 'design'
            ],
            [
                'icon' => 'fa-code',
                'gradient' => 'success',
                'title' => 'Clean Code',
                'description' => 'Well-organized and documented code for easy customization and maintenance.',
                'feature' => 'code'
            ],
            [
                'icon' => 'fa-headset',
                'gradient' => 'info',
                'title' => '24/7 Support',
                'description' => 'Dedicated support team ready to help you with any questions or issues.',
                'feature' => 'support'
            ],
        ];

        $testimonialsData = [
            [
                'image' => 'https://randomuser.me/api/portraits/women/68.jpg',
                'quote' => 'The support team is amazing! They helped me customize everything I needed within hours.',
                'name' => 'Emily Rodriguez',
                'position' => 'Marketing Director',
                'rating' => 5
            ],
            [
                'image' => 'https://randomuser.me/api/portraits/men/32.jpg',
                'quote' => 'Incredible attention to detail and the animations are buttery smooth. Highly recommended!',
                'name' => 'Michael Chen',
                'position' => 'Product Designer',
                'rating' => 5
            ],
            [
                'image' => 'https://randomuser.me/api/portraits/women/44.jpg',
                'quote' => 'This is by far the best template I\'ve ever used. The design is stunning and the code is so clean!',
                'name' => 'Sarah Johnson',
                'position' => 'CEO, TechStart',
                'rating' => 5
            ],
        ];

        return view('pages.home', compact('stats', 'features', 'testimonialsData', 
            'activePromos', 'recommendedMenus', 'upcomingEvents', 'featuredGallery'));
    }

    
}