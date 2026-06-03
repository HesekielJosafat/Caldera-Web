<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Menu;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::where('is_available', true)->orderBy('sort_order')->get();
        
        return response()->json([
            'success' => true,
            'data' => $menus
        ]);
    }

    public function show($id)
    {
        $menu = Menu::findOrFail($id);
        
        return response()->json([
            'success' => true,
            'data' => $menu
        ]);
    }
}