<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TableReservation; 
use App\Models\PoolTicket;
use App\Models\Menu;
use App\Models\Promo;
use App\Models\Testimonial;
use App\Models\Gallery;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $today = today();

        // 1. Data Grafik (7 hari terakhir)
        $chartLabels = [];
        $chartRes =[];
        $chartTickets = [];
        $chartIncome =[];

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $chartLabels[] = $date->format('d M'); 
            $chartRes[] = TableReservation::whereDate('created_at', $date)->count();
            $chartTickets[] = PoolTicket::whereDate('created_at', $date)->count();
            // Income dibagi 1000 agar grafik proporsional
            $chartIncome[] = PoolTicket::whereDate('created_at', $date)->sum('total_amount') / 1000;
        }

        // 2. Gabungkan semua data
        $data =[
            'today_reservations' => TableReservation::whereDate('created_at', $today)->count(),
            'today_tickets' => PoolTicket::whereDate('created_at', $today)->count(),
            'today_income' => PoolTicket::whereDate('created_at', $today)->sum('total_amount'), 
            'pending_reservations' => TableReservation::where('status', 'pending')->count(),
            
            'quick_stats' =>[
                'total_menus' => Menu::count(),
                'active_promos' => Promo::where('is_active', true)->count(),
                'pending_testimonials' => Testimonial::where('is_approved', false)->count(),
                'gallery_items' => Gallery::count(),
            ],
            
            'chart' =>[
                'labels' => $chartLabels,
                'reservations' => $chartRes,
                'tickets' => $chartTickets,
                'income' => $chartIncome,
            ],
            
            'recent_reservations' => TableReservation::latest()->take(5)->get(),
        ];

        return response()->json(['success' => true, 'data' => $data]);
    }
}