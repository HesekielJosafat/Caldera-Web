<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PoolTicket;
use App\Models\Payment;
use App\Models\User;
use App\Notifications\TicketNotification;
use App\Notifications\AdminNewTicketNotification;
use App\Notifications\AdminPaymentNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class TicketController extends Controller
{
    /**
     * GET /api/tickets
     * Daftar tiket milik user yang sedang login
     */
    public function index()
    {
        $tickets = PoolTicket::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data'    => $tickets->map(fn($t) => $this->formatTicket($t)),
        ]);
    }

    /**
     * POST /api/tickets
     * Beli tiket baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name'     => 'required|string|max:255',
            'customer_email'    => 'required|email|max:255',
            'customer_phone'    => 'required|string|max:20',
            'visit_date'        => 'required|date|after_or_equal:today',
            'ticket_type'       => 'required|in:adult,child,family',
            'number_of_tickets' => 'required|integer|min:1|max:20',
        ]);

        // Cek kapasitas
        $capacity = PoolTicket::checkCapacity($validated['visit_date']);
        if ($capacity['available'] < $validated['number_of_tickets']) {
            return response()->json([
                'success' => false,
                'message' => 'Tiket tidak tersedia untuk tanggal ini. Sisa tiket: ' . $capacity['available'],
            ], 422);
        }

        $prices         = ['adult' => 35000, 'child' => 25000, 'family' => 100000];
        $pricePerTicket = $prices[$validated['ticket_type']];
        $totalAmount    = $pricePerTicket * $validated['number_of_tickets'];

        try {
            DB::beginTransaction();

            // Generate unique ticket code
            do {
                $ticketCode = 'TKT-' . strtoupper(uniqid());
            } while (PoolTicket::where('ticket_code', $ticketCode)->exists());

            $user = Auth::user();

            $ticket = PoolTicket::create([
                'ticket_code'       => $ticketCode,
                'customer_name'     => $validated['customer_name'],
                'customer_email'    => $validated['customer_email'],
                'customer_phone'    => $validated['customer_phone'],
                'visit_date'        => $validated['visit_date'],
                'ticket_type'       => $validated['ticket_type'],
                'number_of_tickets' => $validated['number_of_tickets'],
                'price_per_ticket'  => $pricePerTicket,
                'total_amount'      => $totalAmount,
                'payment_status'    => 'unpaid',
                'status'            => 'active',
                'user_id'           => $user->id,
            ]);

            // Notifikasi ke customer
            try { $user->notify(new TicketNotification($ticket, 'purchased')); }
            catch (\Exception $e) { Log::error('Ticket notification: ' . $e->getMessage()); }

            // Notifikasi ke semua admin
            User::where('role', 'admin')->get()->each(function ($admin) use ($ticket) {
                try { $admin->notify(new AdminNewTicketNotification($ticket)); }
                catch (\Exception $e) { Log::error('Admin ticket notif: ' . $e->getMessage()); }
            });

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Tiket berhasil dipesan!',
                'data'    => $this->formatTicket($ticket),
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Buy ticket API error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal memesan tiket: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * GET /api/tickets/{id}
     * Detail tiket (by ID atau ticket_code)
     */
    public function show($id)
    {
        $ticket = PoolTicket::where(function ($q) use ($id) {
                $q->where('id', $id)->orWhere('ticket_code', $id);
            })
            ->where('user_id', Auth::id())
            ->first();

        if (!$ticket) {
            return response()->json(['success' => false, 'message' => 'Tiket tidak ditemukan'], 404);
        }

        return response()->json(['success' => true, 'data' => $this->formatTicket($ticket)]);
    }

    /**
     * POST /api/tickets/check-capacity
     * Cek ketersediaan tiket berdasarkan tanggal
     */
    public function checkCapacity(Request $request)
    {
        $request->validate(['visit_date' => 'required|date|after_or_equal:today']);

        $capacity = PoolTicket::checkCapacity($request->visit_date);

        return response()->json(['success' => true, 'data' => $capacity]);
    }

    /**
     * POST /api/tickets/{ticketCode}/payment
     * Upload bukti pembayaran tiket via mobile
     */
    public function uploadPayment(Request $request, $ticketCode)
    {
        $request->validate([
            'bank_from'     => 'required|string',
            'account_name'  => 'required|string',
            'payment_proof' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $ticket = PoolTicket::where('ticket_code', $ticketCode)
            ->where('user_id', Auth::id())
            ->first();

        if (!$ticket) {
            return response()->json(['success' => false, 'message' => 'Tiket tidak ditemukan'], 404);
        }

        if ($ticket->payment_status === 'paid') {
            return response()->json(['success' => false, 'message' => 'Tiket sudah lunas'], 422);
        }

        try {
            DB::beginTransaction();

            $file     = $request->file('payment_proof');
            $filename = 'payment_ticket_' . $ticketCode . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path     = $file->storeAs('payment_proofs', $filename, 'public');

            $ticket->payment_proof  = $path;
            $ticket->payment_status = 'payment_verified';
            $ticket->payment_method = $request->bank_from;
            $ticket->save();

            Payment::create([
                'payment_code'   => 'PAY-' . strtoupper(Str::random(10)),
                'payable_type'   => PoolTicket::class,
                'payable_id'     => $ticket->id,
                'amount'         => $ticket->total_amount,
                'payment_type'   => 'full_payment',
                'payment_method' => 'transfer',
                'bank_name'      => $request->bank_from,
                'account_name'   => $request->account_name,
                'payment_proof'  => $path,
                'payment_status' => 'pending',
                'notes'          => 'Pembayaran tiket via mobile app',
            ]);

            // Notifikasi ke admin
            User::where('role', 'admin')->get()->each(function ($admin) use ($ticket) {
                try { $admin->notify(new AdminPaymentNotification($ticket)); }
                catch (\Exception $e) { Log::error('Admin payment notif: ' . $e->getMessage()); }
            });

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Bukti pembayaran berhasil diupload. Menunggu verifikasi admin.',
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal upload bukti: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Format tiket untuk JSON response
     */
    private function formatTicket(PoolTicket $ticket): array
    {
        $typeLabels = [
            'adult'  => 'Dewasa',
            'child'  => 'Anak-anak',
            'family' => 'Keluarga',
        ];

        return [
            'id'                => $ticket->id,
            'ticket_code'       => $ticket->ticket_code,
            'customer_name'     => $ticket->customer_name,
            'customer_email'    => $ticket->customer_email,
            'customer_phone'    => $ticket->customer_phone,
            'visit_date'        => $ticket->visit_date,
            'ticket_type'       => $ticket->ticket_type,
            'ticket_type_label' => $typeLabels[$ticket->ticket_type] ?? $ticket->ticket_type,
            'number_of_tickets' => $ticket->number_of_tickets,
            'price_per_ticket'  => $ticket->price_per_ticket,
            'total_amount'      => $ticket->total_amount,
            'payment_status'    => $ticket->payment_status,
            'status'            => $ticket->status,
            'created_at'        => $ticket->created_at?->toIso8601String(),
        ];
    }
}