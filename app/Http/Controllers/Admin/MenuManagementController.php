<?php
// app/Http/Controllers/Admin/MenuManagementController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = Menu::query();
        
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        
        $menus = $query->orderBy('sort_order')->paginate(15);
        $categories = Menu::select('category')->distinct()->pluck('category');
        
        return view('admin.menus.index', compact('menus', 'categories'));
    }
    
    public function create()
    {
        return view('admin.menus.create');
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|in:makanan,minuman,dessert',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'is_available' => 'boolean',
            'is_recommended' => 'boolean',
            'sort_order' => 'integer'
        ]);
        
        // Set default values for checkboxes
        $validated['is_available'] = $request->has('is_available');
        $validated['is_recommended'] = $request->has('is_recommended');
        
        // Upload image if exists
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
            $path = $file->storeAs('menus', $filename, 'public');
            $validated['image'] = $path;
        } else {
            // Jika tidak upload gambar, set default null
            $validated['image'] = null;
        }
        
        Menu::create($validated);
        
        return redirect()->route('admin.menus.index')
            ->with('success', 'Menu berhasil ditambahkan');
    }
    
    public function show(Menu $menu)
    {
        return view('admin.menus.show', compact('menu'));
    }
    
    public function edit(Menu $menu)
    {
        return view('admin.menus.edit', compact('menu'));
    }
    
    public function update(Request $request, Menu $menu)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|in:makanan,minuman,dessert',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'is_available' => 'boolean',
            'is_recommended' => 'boolean',
            'sort_order' => 'integer'
        ]);
        
        // Set default values for checkboxes
        $validated['is_available'] = $request->has('is_available');
        $validated['is_recommended'] = $request->has('is_recommended');
        
        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($menu->image && Storage::disk('public')->exists($menu->image)) {
                Storage::disk('public')->delete($menu->image);
            }
            
            $file = $request->file('image');
            $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
            $path = $file->storeAs('menus', $filename, 'public');
            $validated['image'] = $path;
        } else {
            // 🔥 PENTING: Jangan hapus gambar yang sudah ada jika tidak upload gambar baru
            // Hapus key 'image' dari array validated agar tidak mengubah gambar yang sudah ada
            unset($validated['image']);
        }
        
        $menu->update($validated);
        
        return redirect()->route('admin.menus.index')
            ->with('success', 'Menu berhasil diupdate');
    }
    
    public function destroy(Menu $menu)
    {
        // Delete image file
        if ($menu->image && Storage::disk('public')->exists($menu->image)) {
            Storage::disk('public')->delete($menu->image);
        }
        
        $menu->delete();
        
        return redirect()->route('admin.menus.index')
            ->with('success', 'Menu berhasil dihapus');
    }
    
    public function toggleAvailability(Menu $menu)
    {
        $menu->update(['is_available' => !$menu->is_available]);
        
        return response()->json([
            'success' => true, 
            'is_available' => $menu->is_available
        ]);
    }
}