<?php

namespace App\Http\Controllers\Branding;

use App\Http\Controllers\Controller;
use App\Models\PoolTicket;
use Illuminate\Http\Request;

class PoolController extends Controller
{
    public function index()
    {
        $poolInfo = [
            'name' => 'Caldera Pool',
            'operational_hours' => [
                'weekdays' => '08:00 - 18:00',
                'weekend' => '08:00 - 20:00'
            ],
            'ticket_prices' => [
                'adult' => 35000,
                'child' => 25000,
                'family' => 100000
            ],
            'capacity' => 50,
            'facilities' => [
                'Kolam renang dewasa',
                'Kolam renang anak',
                'Water slide',
                'Gazebo',
                'Locker room',
                'Shower facility'
            ],
            'rules' => [
                'Menggunakan pakaian renang yang sopan',
                'Dilarang membawa makanan dan minuman dari luar',
                'Dilarang merokok di area kolam',
                'Anak-anak harus didampingi orang tua',
                'Mematuhi peraturan dari petugas'
            ]
        ];
        
        $capacity = PoolTicket::checkCapacity(now()->format('Y-m-d'));
        
        return view('pages.pool', compact('poolInfo', 'capacity'));
    }
    
    public function checkCapacity(Request $request)
    {
        $date = $request->get('date', now()->format('Y-m-d'));
        $capacity = PoolTicket::checkCapacity($date);
        
        return response()->json($capacity);
    }
    
}