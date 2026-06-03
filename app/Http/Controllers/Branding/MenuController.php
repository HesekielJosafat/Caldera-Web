<?php

namespace App\Http\Controllers\Branding;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $query = Menu::available();
        
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }
        
        $menus = $query->orderBy('sort_order')->paginate(12);
        $categories = Menu::select('category')->distinct()->pluck('category');
        
        return view('pages.menu', compact('menus', 'categories'));
    }
    
    public function category($category)
    {
        $menus = Menu::available()
            ->where('category', $category)
            ->orderBy('sort_order')
            ->paginate(12);
            
        $categories = Menu::select('category')->distinct()->pluck('category');
        
        return view('pages.menu', compact('menus', 'categories', 'category'));
    }
    
    public function show(Menu $menu)
    {
        // Increment view count jika perlu
        // $menu->increment('views');
        
        return view('pages.menu-detail', compact('menu'));
    }
    
    public function search(Request $request)
    {
        $search = $request->get('q');
        
        $menus = Menu::available()
            ->where('name', 'like', '%' . $search . '%')
            ->orWhere('description', 'like', '%' . $search . '%')
            ->take(10)
            ->get();
            
        return response()->json($menus);
    }
    
}