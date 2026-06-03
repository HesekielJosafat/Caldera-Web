<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Promo;

class PromoController extends Controller
{
    public function index()
    {
        $promos = Promo::where('is_active', true)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->get();
        
        return response()->json([
            'success' => true,
            'data' => $promos
        ]);
    }

    public function show($slug)
    {
        $promo = Promo::where('slug', $slug)->firstOrFail();
        
        return response()->json([
            'success' => true,
            'data' => $promo
        ]);
    }
}