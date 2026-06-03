<?php

namespace App\Http\Controllers\Branding;

use App\Http\Controllers\Controller;
use App\Models\Promo;
use App\Models\Event;
use Illuminate\Http\Request;

class PromoController extends Controller
{
    /**
     * Daftar promo menu
     */
    public function index()
    {
        $promos = Promo::active()
            ->where('promo_type', 'menu')
            ->latest()
            ->paginate(9);
            
        return view('pages.promos', compact('promos'));
    }
    
    /**
     * Detail promo
     */
    public function detail($slug)
    {
        $promo = Promo::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();
            
        return view('pages.promo-detail', compact('promo'));
    }
    
    /**
     * Daftar event (hanya untuk informasi, tidak untuk booking)
     */
    public function events()
    {
        $events = Event::where('is_active', true)
            ->where('start_date', '>=', now())
            ->orderBy('start_date')
            ->paginate(9);
            
        return view('pages.events', compact('events'));
    }
    
    /**
     * Detail event (hanya informasi, tanpa booking)
     */
    public function eventDetail($slug)
    {
        $event = Event::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();
            
        return view('pages.event-detail', compact('event'));
    }

    
}