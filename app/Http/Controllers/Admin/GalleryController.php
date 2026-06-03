<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class GalleryController extends Controller
{
    /**
     * Display a listing of galleries.
     */
    public function index(Request $request)
    {
        $query = Gallery::query();

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('is_featured')) {
            $query->where('is_featured', $request->is_featured === '1');
        }

        $galleries = $query
            ->orderBy('sort_order')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        $categories = Gallery::select('category')
            ->whereNotNull('category')
            ->distinct()
            ->pluck('category');

        return view('admin.galleries.index', compact('galleries', 'categories'));
    }

    /**
     * Show the form for creating a new gallery item.
     */
    public function create()
    {
        return view('admin.galleries.create');
    }

    /**
     * Store a newly created gallery item.
     */
    public function store(Request $request)
    {
        // ✅ FIX 1: Ambil type lebih awal sebelum validasi
        $type = $request->input('type', 'image');

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'type'        => ['required', Rule::in(['image', 'video'])],
            // ✅ FIX 2: Gunakan $type yang sudah diambil, bukan inline input()
            'file'        => $this->fileValidationRules($type),
            'category'    => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'is_featured' => 'nullable|boolean',
            'sort_order'  => 'nullable|integer|min:0',
            // ✅ FIX 3: Hapus galleryable_id & galleryable_type — tidak ada di migration
        ]);

        $filePath = $this->handleFileUpload($request);

        Gallery::create([
            'title'       => $validated['title'],
            'type'        => $validated['type'],
            'file_path'   => $filePath,
            'category'    => $validated['category'] ?? null,
            'description' => $validated['description'] ?? null,
            'is_featured' => $request->boolean('is_featured'),
            'sort_order'  => $validated['sort_order'] ?? 0,
        ]);

        return redirect()
            ->route('admin.galleries.index')
            ->with('success', 'Gallery berhasil ditambahkan.');
    }

    /**
     * Display the specified gallery item.
     */
    public function show(Gallery $gallery)
    {
        return view('admin.galleries.show', compact('gallery'));
    }

    /**
     * Show the form for editing the specified gallery item.
     */
    public function edit(Gallery $gallery)
    {
        return view('admin.galleries.edit', compact('gallery'));
    }

    /**
     * Update the specified gallery item.
     */
    public function update(Request $request, Gallery $gallery)
    {
        // ✅ FIX: Ambil type lebih awal sebelum validasi
        $type = $request->input('type', 'image');

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'type'        => ['required', Rule::in(['image', 'video'])],
            'file'        => $this->fileValidationRules($type, optional: true),
            'category'    => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'is_featured' => 'nullable|boolean',
            'sort_order'  => 'nullable|integer|min:0',
        ]);

        $data = [
            'title'       => $validated['title'],
            'type'        => $validated['type'],
            'category'    => $validated['category'] ?? null,
            'description' => $validated['description'] ?? null,
            'is_featured' => $request->boolean('is_featured'),
            'sort_order'  => $validated['sort_order'] ?? 0,
        ];

        if ($request->hasFile('file')) {
            $this->deleteFile($gallery->file_path);
            $data['file_path'] = $this->handleFileUpload($request);
        }

        $gallery->update($data);

        return redirect()
            ->route('admin.galleries.index')
            ->with('success', 'Gallery berhasil diperbarui.');
    }

    /**
     * Remove the specified gallery item.
     */
    public function destroy(Gallery $gallery)
    {
        $this->deleteFile($gallery->file_path);
        $gallery->delete();

        return redirect()
            ->route('admin.galleries.index')
            ->with('success', 'Gallery berhasil dihapus.');
    }

    /**
     * Toggle featured status via AJAX.
     */
    public function toggleFeatured(Gallery $gallery)
    {
        $gallery->update(['is_featured' => !$gallery->is_featured]);

        return response()->json([
            'success'     => true,
            'is_featured' => $gallery->is_featured,
            'message'     => $gallery->is_featured
                ? 'Gallery ditandai sebagai featured.'
                : 'Gallery dihapus dari featured.',
        ]);
    }

    /**
     * Update sort order via AJAX (drag & drop).
     */
    public function updateOrder(Request $request)
    {
        $request->validate([
            'items'         => 'required|array',
            'items.*.id'    => 'required|exists:galleries,id',
            'items.*.order' => 'required|integer|min:0',
        ]);

        foreach ($request->items as $item) {
            Gallery::where('id', $item['id'])->update(['sort_order' => $item['order']]);
        }

        return response()->json(['success' => true, 'message' => 'Urutan berhasil disimpan.']);
    }

    // -------------------------------------------------------------------------
    // Private Helpers
    // -------------------------------------------------------------------------

    /**
     * Return validation rules for the uploaded file.
     */
    private function fileValidationRules(string $type = 'image', bool $optional = false): array
    {
        $required = $optional ? 'nullable' : 'required';

        if ($type === 'video') {
            return [$required, 'file', 'mimes:mp4,mov,avi', 'max:10240']; // 10 MB
        }

        return [$required, 'file', 'image', 'mimes:jpg,jpeg,png', 'max:2048']; // 2 MB
    }

    /**
     * Upload file and return its stored path.
     */
    private function handleFileUpload(Request $request): string
    {
        $type      = $request->input('type', 'image');
        $directory = $type === 'video' ? 'galleries/videos' : 'galleries/images';

        return $request->file('file')->store($directory, 'public');
    }

    /**
     * Delete a file from storage.
     */
    private function deleteFile(?string $filePath): void
    {
        if ($filePath && Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
        }
    }
}