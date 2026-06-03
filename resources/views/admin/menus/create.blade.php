@extends('layouts.admin')

@section('title', 'Add New Menu')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header bg-white px-4 py-3" style="border-bottom: 2px solid #f0ebe0;">
                <h6 class="mb-0 fw-bold" style="color: #1c3451;">
                    <i class="fas fa-plus me-2" style="color: #c1a067;"></i>Add New Menu
                </h6>
            </div>
            <div class="card-body px-4 py-4">
                <form action="{{ route('admin.menus.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group mb-3">
                        <label class="admin-label">Menu Name <span class="text-danger">*</span></label>
                        <input type="text" name="name"
                               class="form-control admin-input @error('name') is-invalid @enderror"
                               value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="admin-label">Category <span class="text-danger">*</span></label>
                            <select name="category"
                                    class="form-control admin-input @error('category') is-invalid @enderror"
                                    required>
                                <option value="">Select Category</option>
                                <option value="makanan" {{ old('category') == 'makanan' ? 'selected' : '' }}>Makanan</option>
                                <option value="minuman" {{ old('category') == 'minuman' ? 'selected' : '' }}>Minuman</option>
                                <option value="dessert"  {{ old('category') == 'dessert'  ? 'selected' : '' }}>Dessert</option>
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
                                       value="{{ old('price') }}" required>
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
                                  required>{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Tambahkan di bagian form-group image --}}
                    <div class="form-group mb-3">
                        <label class="admin-label">Menu Image</label>
                        <input type="file" name="image" id="menuImage"
                            class="form-control admin-input @error('image') is-invalid @enderror"
                            accept="image/*" onchange="previewImage(this)">
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted" style="font-size: 12px;">Ukuran rekomendasi: 500x500px</small>
                        
                        <!-- Preview Image -->
                        <div id="imagePreviewContainer" class="mt-2" style="display: none;">
                            <img id="imagePreview" src="#" alt="Preview" style="max-width: 150px; max-height: 150px; border-radius: 10px; border: 2px solid #c1a067;">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <div class="admin-check-wrap">
                                <input type="checkbox" name="is_available" class="admin-check"
                                       id="is_available" value="1" checked>
                                <label for="is_available" class="admin-check-label">Available</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="admin-check-wrap">
                                <input type="checkbox" name="is_recommended" class="admin-check"
                                       id="is_recommended" value="1">
                                <label for="is_recommended" class="admin-check-label">Recommended</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label class="admin-label">Sort Order</label>
                        <input type="number" name="sort_order" class="form-control admin-input"
                               value="{{ old('sort_order', 0) }}">
                    </div>

                    <div class="d-flex gap-2 justify-content-end">
                        <a href="{{ route('admin.menus.index') }}" class="btn btn-admin-cancel">
                            <i class="fas fa-times me-1"></i>Cancel
                        </a>
                        <button type="submit" class="btn btn-admin-primary">
                            <i class="fas fa-save me-1"></i>Save Menu
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
{{-- Tambahkan script di akhir --}}
@push('scripts')
<script>
    function previewImage(input) {
        const previewContainer = document.getElementById('imagePreviewContainer');
        const preview = document.getElementById('imagePreview');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                previewContainer.style.display = 'block';
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            previewContainer.style.display = 'none';
        }
    }
</script>
@endpush