<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $notifications = DB::table('notifications')
            ->where('notifiable_type', 'App\Models\User')
            ->where('notifiable_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        foreach ($notifications as $notif) {
            $data = json_decode($notif->data, true);
            $notif->data = $data;
            $notif->type = $data['type'] ?? 'general';
            $notif->title = $data['title'] ?? 'Notifikasi';
            $notif->body = $data['body'] ?? '';
            $notif->icon = $data['icon'] ?? 'fa-bell';
            $notif->color = $data['color'] ?? 'primary';
            $notif->booking_code = $data['booking_code'] ?? null;
            $notif->url = $data['url'] ?? null;
            $notif->created_at = Carbon::parse($notif->created_at);
        }
        
        $unreadCount = DB::table('notifications')
            ->where('notifiable_type', 'App\Models\User')
            ->where('notifiable_id', $user->id)
            ->whereNull('read_at')
            ->count();
        
        return view('customer.notifications', compact('notifications', 'unreadCount'));
    }
    
    public function markAsRead($id)
    {
        $user = Auth::user();
        
        DB::table('notifications')
            ->where('id', $id)
            ->where('notifiable_type', 'App\Models\User')
            ->where('notifiable_id', $user->id)
            ->update(['read_at' => now()]);
        
        return redirect()->back()->with('success', 'Notifikasi ditandai dibaca');
    }
    
    public function markAllAsRead()
    {
        $user = Auth::user();
        
        DB::table('notifications')
            ->where('notifiable_type', 'App\Models\User')
            ->where('notifiable_id', $user->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
        
        return redirect()->back()->with('success', 'Semua notifikasi ditandai dibaca');
    }
    
    public function getLatest()
    {
        $user = Auth::user();
        
        $notifications = DB::table('notifications')
            ->where('notifiable_type', 'App\Models\User')
            ->where('notifiable_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        $unreadCount = DB::table('notifications')
            ->where('notifiable_type', 'App\Models\User')
            ->where('notifiable_id', $user->id)
            ->whereNull('read_at')
            ->count();
        
        $formatted = [];
        foreach ($notifications as $notif) {
            $data = json_decode($notif->data, true);
            $formatted[] = [
                'id' => $notif->id,
                'type' => $data['type'] ?? 'general',
                'title' => $data['title'] ?? 'Notifikasi',
                'body' => $data['body'] ?? '',
                'icon' => $data['icon'] ?? 'fa-bell',
                'color' => $data['color'] ?? 'primary',
                'booking_code' => $data['booking_code'] ?? null,
                'url' => $data['url'] ?? null,
                'read_at' => $notif->read_at,
                'created_at' => $notif->created_at,
            ];
        }
        
        return response()->json([
            'count' => $unreadCount,
            'notifications' => $formatted
        ]);
    }

    public function getAll()
{
    $user = auth::user();

    $notifications = DB::table('notifications')
        ->where('notifiable_type', 'App\Models\User')
        ->where('notifiable_id', $user->id)
        ->orderBy('created_at', 'desc')
        ->get();

    $formatted = [];

    foreach ($notifications as $notif) {
        $data = json_decode($notif->data, true);

        $formatted[] = [
            'id' => $notif->id,
            'title' => $data['title'] ?? 'Notifikasi',
            'body' => $data['body'] ?? '',
            'read_at' => $notif->read_at,
            'created_at' => $notif->created_at,
        ];
    }

    return response()->json([
        'notifications' => $formatted
    ]);
}
    
    private function getTimeAgo($timestamp)
    {
        $diff = now()->diffInMinutes($timestamp);
        if ($diff < 1) return 'Baru saja';
        if ($diff < 60) return $diff . ' menit lalu';
        if ($diff < 1440) return floor($diff / 60) . ' jam lalu';
        return floor($diff / 1440) . ' hari lalu';
    }
}