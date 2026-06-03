<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PoolTicket;
use Illuminate\Http\Request;

class TicketManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = PoolTicket::query();
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('date')) {
            $query->whereDate('visit_date', $request->date);
        }
        
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }
        
        $tickets = $query->orderBy('created_at', 'desc')->paginate(20);
        
        return view('admin.tickets.index', compact('tickets'));
    }
    
    public function show(PoolTicket $ticket)
    {
        return view('admin.tickets.show', compact('ticket'));
    }
    
    public function verify(PoolTicket $ticket)
    {
        $ticket->update([
            'payment_status' => 'paid',
            'status' => 'active'
        ]);
        
        return redirect()->back()->with('success', 'Tiket berhasil diverifikasi');
    }
    
    public function checkCapacity(Request $request)
    {
        $date = $request->date ?? now()->format('Y-m-d');
        $capacity = PoolTicket::checkCapacity($date);
        
        return response()->json($capacity);
    }
}