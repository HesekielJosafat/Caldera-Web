@extends('layouts.admin')

@section('title', 'Edit Menu')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header bg-white px-4 py-3" style="border-bottom: 2px solid #f0ebe0;">
                <h6 class="mb-0 fw-bold" style="color: #1c3451;">
                    <i class="fas fa-edit me-2" style="color: #c1a067;"></i>Edit Menu: {{ $menu->name }}
                </h6>
            </div>
            <div class="card-body px-4 py-4">
                <form action="{{ route('admin.menus.update', $menu) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group mb-3">
                        <label class="admin-label">Menu Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control admin-input @error('name') is-invalid @enderror"
                               value="{{ old('name', $menu->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="admin-label">Category <span class="text-danger">*</span></label>
                            <select name="category" class="form-control admin-input @error('category') is-invalid @enderror" required>
                                <option value="">Select Category</option>
                                <option value="makanan" {{ old('category', $menu->category) == 'makanan' ? 'selected' : '' }}>Makanan</option>
                                <option value="minuman" {{ old('category', $menu->category) == 'minuman' ? 'selected' : '' }}>Minuman</option>
                                <option value="dessert"  {{ old('category', $menu->category) == 'dessert'  ? 'selected' : '' }}>Dessert</option>
                            </select>
                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="admin-label">Price <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text admin-input-prefix">Rp</span>
                                <input type="number" name="price"
                                       class="form-control admin-input @error('price') is-invalid @enderror"
                                       value="{{ old('price', $menu->price) }}" required>
                            </div>
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label class="admin-label">Description <span class="text-danger">*</span></label>
                        <textarea name="description" rows="4"
                                  class="form-control admin-input @error('description') is-invalid @enderror"
                                  required>{{ old('description', $menu->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Edit bagian current image --}}
                    <div class="form-group mb-3">
                        <label class="admin-label">Current Image</label>
                        @if($menu->image)
                            @php
                                $imageUrl = asset('storage/' . $menu->image);
                                // Cek apakah file benar-benar ada
                                $imageExists = Storage::disk('public')->exists($menu->image);
                            @endphp
                            
                            @if($imageExists)
                                <div class="mb-2">
                                    <img src="{{ $imageUrl }}" width="120" height="120"
                                        style="object-fit: cover; border-radius: 10px; border: 2px solid #e8e0d0;">
                                    <br>
                                    <small class="text-muted">Gambar saat ini: {{ basename($menu->image) }}</small>
                                </div>
                            @else
                                <div class="mb-2 alert alert-warning p-2">
                                    <i class="fas fa-exclamation-triangle me-1"></i>
                                    <small>File gambar tidak ditemukan. Silakan upload gambar baru.</small>
                                </div>
                            @endif
                        @else
                            <div class="mb-2">
                                <small class="text-muted">Belum ada gambar</small>
                            </div>
                        @endif
                        
                        <input type="file" name="image" id="menuImage"
                            class="form-control admin-input @error('image') is-invalid @enderror"
                            accept="image/*" onchange="previewImage(this)">
                        <small class="text-muted" style="font-size: 12px;">
                            Kosongkan untuk mempertahankan gambar saat ini. Ukuran rekomendasi: 500x500px
                        </small>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        
                        <!-- Preview Image Baru -->
                        <div id="imagePreviewContainer" class="mt-2" style="display: none;">
                            <img id="imagePreview" src="#" alt="Preview New" style="max-width: 150px; max-height: 150px; border-radius: 10px; border: 2px solid #c1a067;">
                            <br>
                            <small class="text-muted">Gambar baru yang akan diupload</small>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="admin-check-wrap">
                                <input type="checkbox" name="is_available" class="admin-check" value="1"
                                       id="is_available"
                                       {{ old('is_available', $menu->is_available) ? 'checked' : '' }}>
                                <label for="is_available" class="admin-check-label">Available</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="admin-check-wrap">
                                <input type="checkbox" name="is_recommended" class="admin-check" value="1"
                                       id="is_recommended"
                                       {{ old('is_recommended', $menu->is_recommended) ? 'checked' : '' }}>
                                <label for="is_recommended" class="admin-check-label">Recommended</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label class="admin-label">Sort Order</label>
                        <input type="number" name="sort_order" class="form-control admin-input"
                               value="{{ old('sort_order', $menu->sort_order) }}">
                    </div>

                    <div class="text-end d-flex gap-2 justify-content-end">
                        <a href="{{ route('admin.menus.index') }}" class="btn btn-admin-cancel">
                            <i class="fas fa-times me-1"></i>Cancel
                        </a>
                        <button type="submit" class="btn btn-admin-primary">
                            <i class="fas fa-save me-1"></i>Update Menu
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .admin-label {
        font-size: 13px;
        font-weight: 600;
        color: #374151;
        margin-bottom: 6px;
        display: block;
    }

    .admin-input {
        border: 1.5px solid #e5e7eb;
        border-radius: 10px;
        padding: 10px 14px;
        font-size: 14px;
        transition: border-color 0.2s, box-shadow 0.2s;
        color: #1c3451;
    }

    .admin-input:focus {
        border-color: #1c3451;
        box-shadow: 0 0 0 3px rgba(28,52,81,0.08);
        outline: none;
    }

    .admin-input-prefix {
        background: #f0ebe0;
        border: 1.5px solid #e5e7eb;
        border-right: none;
        border-radius: 10px 0 0 10px;
        color: #c1a067;
        font-weight: 600;
        font-size: 14px;
    }

    .admin-check-wrap {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px 16px;
        background: #fdfcfa;
        border: 1.5px solid #e8e0d0;
        border-radius: 10px;
    }

    .admin-check {
        width: 18px;
        height: 18px;
        accent-color: #1c3451;
        cursor: pointer;
    }

    .admin-check-label {
        font-size: 14px;
        font-weight: 500;
        color: #374151;
        cursor: pointer;
        margin: 0;
    }

    .btn-admin-primary {
        background: #1c3451;
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
        padding: 10px 24px;
        transition: all 0.2s;
    }

    .btn-admin-primary:hover {
        background: #c1a067;
        color: white;
        transform: translateY(-1px);
    }

    .btn-admin-cancel {
        background: white;
        color: #6b7280;
        border: 1.5px solid #e5e7eb;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
        padding: 10px 24px;
        transition: all 0.2s;
    }

    .btn-admin-cancel:hover {
        background: #f9fafb;
        color: #374151;
    }
</style>
@endpush