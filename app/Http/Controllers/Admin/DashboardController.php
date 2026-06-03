<?php
// app/Http/Controllers/Admin/DashboardController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TableReservation;
use App\Models\PoolTicket;
use App\Models\Payment;
use App\Models\Menu;
use App\Models\Testimonial;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        
        $stats = [
            'today_reservations' => TableReservation::whereDate('created_at', $today)->count(),
            'today_tickets' => PoolTicket::whereDate('created_at', $today)->count(),
            'today_income' => Payment::whereDate('created_at', $today)->where('payment_status', 'verified')->sum('amount'),
            'pending_reservations' => TableReservation::where('status', 'pending')->count(),
            'pending_testimonials' => Testimonial::where('is_approved', false)->count(),
            'out_of_stock_menus' => Menu::where('is_available', false)->count(),
        ];
        
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $chartData[] = [
                'date' => $date->format('d M'),
                'reservations' => TableReservation::whereDate('created_at', $date)->count(),
                'tickets' => PoolTicket::whereDate('created_at', $date)->count(),
                'income' => Payment::whereDate('created_at', $date)->where('payment_status', 'verified')->sum('amount')
            ];
        }
        
        return view('admin.dashboard', compact('stats', 'chartData'));
    }
}