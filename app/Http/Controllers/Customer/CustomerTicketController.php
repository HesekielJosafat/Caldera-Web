<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\PoolTicket;
use App\Models\Promo;
use App\Models\User;
use App\Notifications\TicketNotification;
use App\Notifications\AdminNewTicketNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CustomerTicketController extends Controller
{
    /**
     * Display a listing of tickets for authenticated user.
     */
    public function index()
    {
        // Ambil tiket berdasarkan user_id yang login
        $tickets = PoolTicket::where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('customer.tickets', compact('tickets'));
    }

    /**
     * Show ticket details.
     */
    public function show($ticketCode)
    {
        $ticket = PoolTicket::where('ticket_code', $ticketCode)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('customer.ticket-show', compact('ticket'));
    }

    /**
     * Show ticket purchase form.
     */
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

    /**
     * Calculate ticket price.
     */
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

    /**
     * Store a newly created ticket.
     */
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

        try {
            DB::beginTransaction();

            $ticket = PoolTicket::create([
                'customer_name'     => $validated['customer_name'],
                'customer_email'    => $validated['customer_email'],
                'customer_phone'    => $validated['customer_phone'],
                'visit_date'        => $validated['visit_date'],
                'visit_time'        => $validated['visit_time'] ?? null,
                'ticket_type'       => $validated['ticket_type'],
                'number_of_tickets' => $validated['number_of_tickets'],
                'price_per_ticket'  => $pricePerTicket,
                'total_amount'      => $pricePerTicket * $validated['number_of_tickets'],
                'payment_status'    => 'unpaid',
                'status'            => 'active',
                'user_id'           => Auth::id(),  // Hubungkan dengan user yang login
            ]);

            // Notifikasi ke customer yang login (guard method_exists)
            $user = Auth::user();
            if ($user && is_object($user) && method_exists($user, 'notify')) {
                $user->notify(new TicketNotification($ticket, 'purchased'));
            } else {
                Log::warning('CustomerTicketController: user not notifiable', ['user' => $user?->id ?? null]);
            }

            // Notifikasi ke semua admin
            $admins = User::where('role', 'admin')->get();
            foreach ($admins as $admin) {
                if (is_object($admin) && method_exists($admin, 'notify')) {
                    $admin->notify(new AdminNewTicketNotification($ticket));
                } else {
                    Log::warning('CustomerTicketController: admin not notifiable', ['admin' => $admin?->id ?? null]);
                }
            }

            DB::commit();

            // Redirect ke halaman success dengan route yang benar
            return redirect()->route('reservation.ticket.success', $ticket->ticket_code)
                ->with('success', 'Tiket berhasil dipesan! Silakan lakukan pembayaran.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memesan tiket: ' . $e->getMessage());
        }
    }

    /**
     * Show success page.
     */
    public function success($ticketCode)
    {
        $ticket = PoolTicket::where('ticket_code', $ticketCode)
            ->where('user_id', Auth::id())
            ->firstOrFail();
            
        return view('reservation.ticket.success', compact('ticket'));
    }

    /**
     * Show ticket view.
     */
    public function view($ticketCode)
    {
        $ticket = PoolTicket::where('ticket_code', $ticketCode)
            ->where('user_id', Auth::id())
            ->firstOrFail();
            
        return view('reservation.ticket.view', compact('ticket'));
    }
}