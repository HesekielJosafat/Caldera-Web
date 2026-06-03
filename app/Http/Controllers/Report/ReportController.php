<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\PoolTicket;
use App\Models\TableReservation;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        return view('admin.reports.index');
    }

    public function reservations(Request $request)
    {
        $query = TableReservation::query();

        if ($request->filled('start_date')) {
            $query->whereDate('reservation_date', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('reservation_date', '<=', $request->end_date);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $reservations = $query->latest()->paginate(15);

        $summary = [
            'total'        => TableReservation::count(),
            'confirmed'    => TableReservation::where('status', 'confirmed')->count(),
            'pending'      => TableReservation::where('status', 'pending')->count(),
            'cancelled'    => TableReservation::where('status', 'cancelled')->count(),
            'total_guests' => TableReservation::sum('number_of_guests'),
        ];

        // Chart data
        $chartData = TableReservation::selectRaw("TO_CHAR(reservation_date, 'DD Mon') as label, COUNT(*) as total")
            ->groupBy('label')
            ->orderBy('label')
            ->limit(14)
            ->pluck('total', 'label');

        $chartLabels = $chartData->keys()->toArray();
        $chartData   = $chartData->values()->toArray();

        return view('admin.reports.reservations', compact('reservations', 'summary', 'chartLabels', 'chartData'));
    }

    public function tickets(Request $request)
    {
        $query = PoolTicket::query();

        if ($request->filled('start_date')) {
            $query->whereDate('visit_date', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('visit_date', '<=', $request->end_date);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $tickets = $query->latest()->paginate(15);

        $summary = [
            'total_tickets'      => PoolTicket::sum('number_of_tickets'),
            'total_transactions' => PoolTicket::count(),
            'total_income'       => PoolTicket::where('payment_status', 'paid')->sum('total_amount'),
            'average_price'      => PoolTicket::where('payment_status', 'paid')->avg('total_amount') ?? 0,
        ];

        $typeData   = [
            PoolTicket::where('ticket_type', 'adult')->count(),
            PoolTicket::where('ticket_type', 'child')->count(),
            PoolTicket::where('ticket_type', 'family')->count(),
        ];
        $typeLabels = ['Dewasa', 'Anak', 'Keluarga'];

        $trendRaw    = PoolTicket::selectRaw("TO_CHAR(visit_date, 'DD Mon') as label, SUM(number_of_tickets) as total")
            ->groupBy('label')->orderBy('label')->limit(14)->pluck('total', 'label');
        $trendLabels = $trendRaw->keys()->toArray();
        $trendData   = $trendRaw->values()->toArray();

        return view('admin.reports.tickets', compact('tickets', 'summary', 'typeLabels', 'typeData', 'trendLabels', 'trendData'));
    }

    public function income(Request $request)
    {
        $query = Payment::where('payment_status', 'paid');

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }
        if ($request->filled('payment_type')) {
            $query->where('payment_type', $request->payment_type);
        }

        $payments = $query->latest()->paginate(15);

        $summary = [
            'total_income'       => Payment::where('payment_status', 'paid')->sum('amount'),
            'ticket_income'      => Payment::where('payment_status', 'paid')->where('payment_type', 'full_payment')->sum('amount'),
            'reservation_income' => Payment::where('payment_status', 'paid')->where('payment_type', 'down_payment')->sum('amount'),
        ];

        $dailyRaw    = Payment::where('payment_status', 'paid')
            ->selectRaw("TO_CHAR(created_at, 'DD Mon') as label, SUM(amount) as total")
            ->groupBy('label')->orderBy('label')->limit(14)->pluck('total', 'label');
        $dailyLabels = $dailyRaw->keys()->toArray();
        $dailyData   = $dailyRaw->values()->toArray();

        return view('admin.reports.income', compact('payments', 'summary', 'dailyLabels', 'dailyData'));
    }

    // ── EXPORT EXCEL ──

    public function exportReservations(Request $request)
    {
        $query = TableReservation::query();
        if ($request->filled('start_date')) $query->whereDate('reservation_date', '>=', $request->start_date);
        if ($request->filled('end_date'))   $query->whereDate('reservation_date', '<=', $request->end_date);
        if ($request->filled('status'))     $query->where('status', $request->status);

        $reservations = $query->latest()->get();

        $filename = 'laporan-reservasi-' . now()->format('Ymd-His') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($reservations) {
            $file = fopen('php://output', 'w');
            // BOM untuk Excel agar bisa baca UTF-8
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($file, ['No', 'Kode Booking', 'Nama Customer', 'Telepon', 'Tanggal', 'Jam', 'Tamu', 'DP', 'Status', 'Dibuat']);

            foreach ($reservations as $i => $r) {
                fputcsv($file, [
                    $i + 1,
                    $r->booking_code,
                    $r->customer_name,
                    $r->customer_phone,
                    $r->reservation_date->format('d/m/Y'),
                    $r->reservation_time,
                    $r->number_of_guests,
                    'Rp ' . number_format($r->down_payment ?? 0, 0, ',', '.'),
                    $r->status,
                    $r->created_at->format('d/m/Y H:i'),
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportTickets(Request $request)
    {
        $query = PoolTicket::query();
        if ($request->filled('start_date')) $query->whereDate('visit_date', '>=', $request->start_date);
        if ($request->filled('end_date'))   $query->whereDate('visit_date', '<=', $request->end_date);
        if ($request->filled('status'))     $query->where('status', $request->status);

        $tickets  = $query->latest()->get();
        $filename = 'laporan-tiket-' . now()->format('Ymd-His') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($tickets) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($file, ['No', 'Kode Tiket', 'Nama Customer', 'Telepon', 'Tanggal Kunjungan', 'Jenis', 'Jumlah', 'Total', 'Status Bayar', 'Status']);

            foreach ($tickets as $i => $t) {
                fputcsv($file, [
                    $i + 1,
                    $t->ticket_code,
                    $t->customer_name,
                    $t->customer_phone,
                    \Carbon\Carbon::parse($t->visit_date)->format('d/m/Y'),
                    ucfirst($t->ticket_type),
                    $t->number_of_tickets,
                    'Rp ' . number_format($t->total_amount, 0, ',', '.'),
                    $t->payment_status,
                    $t->status,
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportIncome(Request $request)
    {
        $query = Payment::where('payment_status', 'paid');
        if ($request->filled('start_date'))   $query->whereDate('created_at', '>=', $request->start_date);
        if ($request->filled('end_date'))     $query->whereDate('created_at', '<=', $request->end_date);
        if ($request->filled('payment_type')) $query->where('payment_type', $request->payment_type);

        $payments = $query->latest()->get();
        $filename = 'laporan-pemasukan-' . now()->format('Ymd-His') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($payments) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($file, ['No', 'Kode Pembayaran', 'Tipe', 'Metode', 'Jumlah', 'Status', 'Tanggal']);

            foreach ($payments as $i => $p) {
                fputcsv($file, [
                    $i + 1,
                    $p->payment_code,
                    $p->payment_type == 'down_payment' ? 'DP Reservasi' : 'Full Payment Tiket',
                    $p->payment_method,
                    'Rp ' . number_format($p->amount, 0, ',', '.'),
                    $p->payment_status,
                    $p->created_at->format('d/m/Y H:i'),
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}