<?php

namespace App\Http\Controllers\Reservation;

use App\Http\Controllers\Controller;
use App\Models\PoolTicket;
use App\Models\Promo;
use App\Models\User;
use App\Notifications\TicketNotification;
use App\Notifications\AdminNewTicketNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TicketController extends Controller
{
    public function create()
    {
        $promos = Promo::active()
            ->where('promo_type', 'ticket')
            ->get();

        $ticketPrices = [
            'adult'  => 35000,
            'child'  => 25000,
            'family' => 100000
        ];

        return view('reservation.ticket.create', compact('promos', 'ticketPrices'));
    }

    public function calculate(Request $request)
    {
        $validated = $request->validate([
            'ticket_type'       => 'required|in:adult,child,family',
            'number_of_tickets' => 'required|integer|min:1',
            'visit_date'        => 'required|date|after_or_equal:today'
        ]);

        $prices = [
            'adult'  => 35000,
            'child'  => 25000,
            'family' => 100000
        ];

        $pricePerTicket = $prices[$validated['ticket_type']];
        $total          = $pricePerTicket * $validated['number_of_tickets'];
        $capacity       = PoolTicket::checkCapacity($validated['visit_date']);

        return response()->json([
            'price_per_ticket' => $pricePerTicket,
            'total'            => $total,
            'capacity'         => $capacity
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name'     => 'required|string|max:255',
            'customer_email'    => 'required|email|max:255',
            'customer_phone'    => 'required|string|max:20',
            'visit_date'        => 'required|date|after_or_equal:today',
            'visit_time'        => 'nullable',
            'ticket_type'       => 'required|in:adult,child,family',
            'number_of_tickets' => 'required|integer|min:1',
            'promo_code'        => 'nullable|string|exists:promos,promo_code'
        ]);

        $capacity = PoolTicket::checkCapacity($validated['visit_date']);

        if ($capacity['available'] < $validated['number_of_tickets']) {
            return back()->with('error', 'Maaf, tiket tidak tersedia untuk tanggal tersebut. Sisa tiket: ' . $capacity['available']);
        }

        $prices = [
            'adult'  => 35000,
            'child'  => 25000,
            'family' => 100000
        ];

        $pricePerTicket = $prices[$validated['ticket_type']];
        $totalAmount = $pricePerTicket * $validated['number_of_tickets'];

        try {
            DB::beginTransaction();

            // Generate ticket code unik
            $ticketCode = 'TKT-' . strtoupper(uniqid());
            while (PoolTicket::where('ticket_code', $ticketCode)->exists()) {
                $ticketCode = 'TKT-' . strtoupper(uniqid());
            }

            // 🔥 INI YANG PENTING: Simpan user_id jika user login
            $userId = Auth::check() ? Auth::id() : null;
            
            // Jika user tidak login tapi email cocok dengan user yang terdaftar
            if (!$userId) {
                $existingUser = User::where('email', $validated['customer_email'])->first();
                if ($existingUser) {
                    $userId = $existingUser->id;
                }
            }

            $ticket = PoolTicket::create([
                'ticket_code'       => $ticketCode,
                'customer_name'     => $validated['customer_name'],
                'customer_email'    => $validated['customer_email'],
                'customer_phone'    => $validated['customer_phone'],
                'visit_date'        => $validated['visit_date'],
                'visit_time'        => $validated['visit_time'] ?? null,
                'ticket_type'       => $validated['ticket_type'],
                'number_of_tickets' => $validated['number_of_tickets'],
                'price_per_ticket'  => $pricePerTicket,
                'total_amount'      => $totalAmount,
                'payment_status'    => 'unpaid',
                'status'            => 'active',
                'user_id'           => $userId, // 🔥 INI YANG HARUS ADA!
            ]);

            // Notifikasi ke customer yang login
            if ($userId) {
                $customer = User::find($userId);
                if ($customer) {
                    $customer->notify(new TicketNotification($ticket, 'purchased'));
                }
            } else {
                // Customer tidak login, kirim notifikasi ke email? Bisa dengan cara lain
                // Misalnya: kirim email (opsional)
            }

            // Notifikasi ke semua admin
            $admins = User::where('role', 'admin')->get();
            if ($admins->count() > 0) {
                foreach ($admins as $admin) {
                    $admin->notify(new AdminNewTicketNotification($ticket));
                }
            }

            DB::commit();

            return redirect()->route('reservation.ticket.success', $ticket->ticket_code)
                ->with('success', 'Pemesanan tiket berhasil. Silakan lakukan pembayaran.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memesan tiket: ' . $e->getMessage());
        }
    }

    public function success($ticketCode)
    {
        $ticket = PoolTicket::where('ticket_code', $ticketCode)->firstOrFail();
        return view('reservation.ticket.success', compact('ticket'));
    }

    public function view($ticketCode)
    {
        $ticket = PoolTicket::where('ticket_code', $ticketCode)->firstOrFail();
        return view('reservation.ticket.view', compact('ticket'));
    }
}