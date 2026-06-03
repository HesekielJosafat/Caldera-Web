<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promo;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PromoManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = Promo::query();
        
        if ($request->filled('is_active')) {
            $query->where('is_active', $request->is_active == 'true');
        }
        
        if ($request->filled('promo_type')) {
            $query->where('promo_type', $request->promo_type);
        }
        
        $promos = $query->orderBy('created_at', 'desc')->paginate(15);
        
        return view('admin.promos.index', compact('promos'));
    }
    
    public function create()
    {
        return view('admin.promos.create');
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'banner_image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'discount_type' => 'required|in:percentage,nominal',
            'discount_value' => 'required|numeric|min:0',
            'promo_code' => 'required|string|unique:promos,promo_code',
            'promo_type' => 'required|in:menu,ticket,reservation',
            'min_purchase' => 'nullable|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'max_usage' => 'nullable|integer|min:1',
            'is_active' => 'boolean'
        ]);
        
        $validated['slug'] = Str::slug($validated['title']);
        
        if ($request->hasFile('banner_image')) {
            $validated['banner_image'] = $request->file('banner_image')->store('promos', 'public');
        }
        
        Promo::create($validated);
        
        return redirect()->route('admin.promos.index')->with('success', 'Promo berhasil ditambahkan');
    }
    
    public function edit(Promo $promo)
    {
        return view('admin.promos.edit', compact('promo'));
    }
    
    public function update(Request $request, Promo $promo)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'banner_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'discount_type' => 'required|in:percentage,nominal',
            'discount_value' => 'required|numeric|min:0',
            'promo_code' => 'required|string|unique:promos,promo_code,' . $promo->id,
            'promo_type' => 'required|in:menu,ticket,reservation',
            'min_purchase' => 'nullable|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'max_usage' => 'nullable|integer|min:1',
            'is_active' => 'boolean'
        ]);
        
        if ($request->hasFile('banner_image')) {
            $validated['banner_image'] = $request->file('banner_image')->store('promos', 'public');
        }
        
        $promo->update($validated);
        
        return redirect()->route('admin.promos.index')->with('success', 'Promo berhasil diupdate');
    }
    
    public function destroy(Promo $promo)
    {
        $promo->delete();
        
        return redirect()->route('admin.promos.index')->with('success', 'Promo berhasil dihapus');
    }
}