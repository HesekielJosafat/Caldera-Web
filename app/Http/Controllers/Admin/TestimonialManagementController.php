<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class TestimonialManagementController extends Controller
{
    /**
     * Display a listing of testimonials.
     */
    public function index(Request $request)
    {
        $query = Testimonial::query();
        
        // Filter by approval status
        if ($request->filled('is_approved')) {
            $query->where('is_approved', $request->is_approved == 'true');
        }
        
        // Filter by featured status
        if ($request->filled('is_featured')) {
            $query->where('is_featured', $request->is_featured == 'true');
        }
        
        // Filter by rating
        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }
        
        // Filter by service type
        if ($request->filled('service_type')) {
            $query->where('service_type', $request->service_type);
        }
        
        // Search by name or comment
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('customer_name', 'like', '%' . $request->search . '%')
                  ->orWhere('comment', 'like', '%' . $request->search . '%');
            });
        }
        
        $testimonials = $query->orderBy('created_at', 'desc')->paginate(20);
        
        // Statistics
        $stats = [
            'total' => Testimonial::count(),
            'approved' => Testimonial::where('is_approved', true)->count(),
            'pending' => Testimonial::where('is_approved', false)->count(),
            'featured' => Testimonial::where('is_featured', true)->count(),
            'average_rating' => Testimonial::where('is_approved', true)->avg('rating') ?? 0,
        ];
        
        return view('admin.testimonials.index', compact('testimonials', 'stats'));
    }
    
    /**
     * Display the specified testimonial.
     */
    public function show($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        return view('admin.testimonials.show', compact('testimonial'));
    }
    
    /**
     * Approve a testimonial.
     */
    public function approve($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        $testimonial->is_approved = true;
        $testimonial->approved_at = now();
$testimonial->approved_by = Auth::id();
        $testimonial->save();
        
        return redirect()->back()->with('success', 'Testimoni berhasil disetujui.');
    }
    
    /**
     * Reject a testimonial.
     */
    public function reject($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        $testimonial->is_approved = false;
        $testimonial->approved_at = null;
        $testimonial->approved_by = null;
        $testimonial->save();
        
        return redirect()->back()->with('success', 'Testimoni ditolak.');
    }
    
    /**
     * Toggle featured status.
     */
    public function toggleFeatured($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        $testimonial->is_featured = !$testimonial->is_featured;
        $testimonial->save();
        
        $status = $testimonial->is_featured ? 'ditampilkan' : 'disembunyikan';
        return redirect()->back()->with('success', "Testimoni {$status} sebagai unggulan.");
    }
    
    /**
     * Remove the specified testimonial from storage.
     */
    public function destroy($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        
        // Delete photo if exists
        if ($testimonial->customer_photo) {
            Storage::disk('public')->delete($testimonial->customer_photo);
        }
        
        $testimonial->delete();
        
        return redirect()->route('admin.testimonials.index')
            ->with('success', 'Testimoni berhasil dihapus.');
    }
    
    /**
     * Bulk approve testimonials.
     */
    public function bulkApprove(Request $request)
    {
        $ids = $request->input('ids', []);
        
        if (empty($ids)) {
            return response()->json(['success' => false, 'message' => 'Tidak ada testimoni dipilih.']);
        }
        
        Testimonial::whereIn('id', $ids)->update([
            'is_approved' => true,
            'approved_at' => now(),
            'approved_by' => Auth::id(),
        ]);
        
        return response()->json(['success' => true, 'message' => count($ids) . ' testimoni disetujui.']);
    }
    
    /**
     * Bulk delete testimonials.
     */
    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);
        
        if (empty($ids)) {
            return response()->json(['success' => false, 'message' => 'Tidak ada testimoni dipilih.']);
        }
        
        $testimonials = Testimonial::whereIn('id', $ids)->get();
        
        foreach ($testimonials as $testimonial) {
            if ($testimonial->customer_photo) {
                Storage::disk('public')->delete($testimonial->customer_photo);
            }
        }
        
        Testimonial::whereIn('id', $ids)->delete();
        
        return response()->json(['success' => true, 'message' => count($ids) . ' testimoni dihapus.']);
    }
    
    /**
     * Export testimonials to CSV.
     */
    public function export(Request $request)
    {
        $testimonials = Testimonial::with('approver')
            ->when($request->status, function($query, $status) {
                if ($status == 'approved') {
                    $query->where('is_approved', true);
                } elseif ($status == 'pending') {
                    $query->where('is_approved', false);
                }
                return $query;
            })
            ->get();
        
        $filename = 'testimonials_' . date('Y-m-d') . '.csv';
        $handle = fopen('php://temp', 'w+');
        
        // Header
        fputcsv($handle, [
            'ID', 'Customer Name', 'Email', 'Rating', 'Comment', 
            'Service Type', 'Visit Date', 'Status', 'Featured', 
            'Approved At', 'Approved By', 'Created At'
        ]);
        
        // Data
        foreach ($testimonials as $t) {
            fputcsv($handle, [
                $t->id,
                $t->customer_name,
                $t->customer_email,
                $t->rating,
                $t->comment,
                $t->service_type,
                $t->visit_date,
                $t->is_approved ? 'Approved' : 'Pending',
                $t->is_featured ? 'Yes' : 'No',
                $t->approved_at,
                $t->approver ? $t->approver->name : '-',
                $t->created_at,
            ]);
        }
        
        rewind($handle);
        $csv = stream_get_contents($handle);
        fclose($handle);
        
        return response($csv, 200)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }
}