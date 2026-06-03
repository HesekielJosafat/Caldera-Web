<?php
// app/Http/Controllers/Branding/ContactController.php

namespace App\Http\Controllers\Branding;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        $contactInfo = [
            'address' => 'Jl. Raya Caldera No. 123, Kota Bandung, Jawa Barat',
            'phone' => '(022) 1234567',
            'mobile' => '0812-3456-7890',
            'email' => 'info@caldera.com',
            'instagram' => '@caldera_resto',
            'facebook' => 'Caldera Resto and Pool',
            'maps_url' => 'https://maps.google.com/?q=Caldera+Resto'
        ];
        
        return view('pages.contact', compact('contactInfo'));
    }
    
    public function sendMessage(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10'
        ]);
        
        // Here you can send email or save to database
        // Mail::to('info@caldera.com')->send(new ContactMail($validated));
        
        return redirect()->back()->with('success', 'Pesan berhasil dikirim. Kami akan segera menghubungi Anda.');
    }
    
}