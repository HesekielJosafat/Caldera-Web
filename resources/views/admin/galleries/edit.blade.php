@extends('layouts.admin')

@section('title', 'Edit Gallery')

@push('styles')
<style>
    .report-page-header {
        background: linear-gradient(135deg, #1c3451 0%, #2a4a6b 100%);
        border-radius: 16px;
        padding: 24px 28px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .report-page-header h6 {
        color: #fff;
        font-size: 18px;
        font-weight: 700;
        margin: 0;
    }

    .report-page-header .header-icon {
        width: 44px;
        height: 44px;
        background: rgba(193,160,103,0.2);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 14px;
    }

    .report-page-header .header-icon i {
        color: #c1a067;
        font-size: 18px;
    }

    .gallery-title-badge {
        background: rgba(193,160,103,0.2);
        color: #c1a067;
        border: 1px solid rgba(193,160,103,0.4);
        border-radius: 8px;
        font-size: 13px;
        font-weight: 700;
        padding: 5px 14px;
        max-width: 260px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .btn-back {
        background: rgba(255,255,255,0.15);
        color: #fff;
        border: 1px solid rgba(255,255,255,0.3);
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
        padding: 8px 16px;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-back:hover {
        background: rgba(255,255,255,0.25);
        color: #fff;
    }

    .report-main-card {
        border: none;
        border-radius: 16px;
        border-top: 3px solid #c1a067 !important;
        box-shadow: 0 4px 20px rgba(28,52,81,0.08);
    }

    .report-main-card .card-body {
        padding: 28px;
    }

    .form-section-title {
        font-size: 13px;
        font-weight: 700;
        color: #1c3451;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        padding-bottom: 10px;
        border-bottom: 2px solid #c1a067;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .form-section-title i { color: #c1a067; }

    .form-label {
        font-size: 12px;
        font-weight: 600;
        color: #1c3451;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        margin-bottom: 6px;
    }

    .form-control,
    .form-select {
        border-radius: 10px;
        border: 1px solid #dde2e8;
        font-size: 13px;
        padding: 9px 13px;
        color: #1c3451;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #c1a067;
        box-shadow: 0 0 0 3px rgba(193,160,103,0.15);
    }

    .form-control.is-invalid,
    .form-select.is-invalid {
        border-color: #dc2626;
    }

    .form-text {
        font-size: 11px;
        color: #9ca3af;
        margin-top: 4px;
    }

    .form-check-input:checked {
        background-color: #1c3451;
        border-color: #1c3451;
    }

    .form-check-label {
        font-size: 13px;
        color: #374151;
    }

    .current-file-wrap {
        background: #f8fafc;
        border: 1px solid #e8edf2;
        border-radius: 12px;
        padding: 12px;
        margin-bottom: 12px;
        display: inline-block;
    }

    .current-file-wrap img,
    .current-file-wrap video {
        max-width: 200px;
        max-height: 160px;
        border-radius: 8px;
        display: block;
    }

    .current-file-label {
        font-size: 11px;
        font-weight: 600;
        color: #9ca3af;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        margin-bottom: 8px;
    }

    .image-preview-wrap {
        border: 2px dashed #dde2e8;
        border-radius: 12px;
        padding: 12px;
        margin-top: 10px;
        text-align: center;
        background: #f8fafc;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .image-preview-wrap img,
    .image-preview-wrap video {
        max-width: 100%;
        max-height: 160px;
        border-radius: 8px;
    }

    .section-divider {
        height: 1px;
        background: linear-gradient(90deg, #c1a067 0%, transparent 100%);
        margin: 24px 0;
        border: none;
    }

    .btn-cancel {
        background: #f1f5f9;
        color: #1c3451;
        border: none;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
        padding: 10px 22px;
        transition: all 0.2s;
        text-decoration: none;
    }

    .btn-cancel:hover { background: #e2e8f0; color: #1c3451; }

    .btn-save {
        background: linear-gradient(135deg, #1c3451, #2a4a6b);
        color: #fff;
        border: none;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
        padding: 10px 28px;
        transition: all 0.2s;
        box-shadow: 0 4px 12px rgba(28,52,81,0.25);
    }

    .btn-save:hover {
        background: linear-gradient(135deg, #c1a067, #a98750);
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(193,160,103,0.3);
    }
</style>
@endpush

@section('content')

<div class="report-page-header">
    <div class="d-flex align-items-center gap-3">
        <div class="header-icon">
            <i class="fas fa-edit"></i>
        </div>
        <h6>Edit Gallery</h6>
        <span class="gallery-title-badge">{{ $gallery->title }}</span>
    </div>
    <a href="{{ route('admin.galleries.index') }}" class="btn-back">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="card report-main-card">
    <div class="card-body">
        <form action="{{ route('admin.galleries.update', $gallery) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-section-title">
                <i class="fas fa-info-circle"></i> Informasi Media
            </div>

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Judul Gallery <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $gallery->title) }}" required>
                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Tipe Media <span class="text-danger">*</span></label>
                    <select name="type" class="form-control @error('type') is-invalid @enderror" id="mediaType" required>
                        <option value="image" {{ $gallery->type == 'image' ? 'selected' : '' }}>Gambar</option>
                        <option value="video" {{ $gallery->type == 'video' ? 'selected' : '' }}>Video</option>
                    </select>
                    @error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <div class="current-file-label">File Saat Ini</div>
                    <div class="current-file-wrap">
                        @if($gallery->type == 'image')
                            <img src="{{ asset('storage/' . $gallery->file_path) }}" alt="{{ $gallery->title }}">
                        @else
                            <video controls>
                                <source src="{{ asset('storage/' . $gallery->file_path) }}" type="video/mp4">
                            </video>
                        @endif
                    </div>

                    <label class="form-label">Ganti File <span class="text-muted" style="font-size:11px; text-transform:none;">(Opsional)</span></label>
                    <input type="file" name="file" class="form-control @error('file') is-invalid @enderror" accept="{{ $gallery->type == 'image' ? 'image/*' : 'video/*' }}" id="fileInput">
                    <div class="form-text">Kosongkan jika tidak ingin mengganti file</div>
                    <div class="image-preview-wrap mt-2" id="filePreview" style="display:none;"></div>
                    @error('file')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    {{-- spacer column --}}
                </div>
            </div>

            <hr class="section-divider">

            <div class="form-section-title">
                <i class="fas fa-sitemap"></i> Relasi & Kategori
            </div>

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Tipe Parent <span class="text-danger">*</span></label>
                    <select name="parent_type" class="form-control @error('parent_type') is-invalid @enderror" id="parentType" required>
                        <option value="">Pilih Tipe</option>
                        <option value="menu" {{ $gallery->menu_id ? 'selected' : '' }}>Menu</option>
                        <option value="event" {{ $gallery->event_id ? 'selected' : '' }}>Event</option>
                        <option value="promo" {{ $gallery->promo_id ? 'selected' : '' }}>Promo</option>
                        <option value="testimonial" {{ $gallery->testimonial_id ? 'selected' : '' }}>Testimonial</option>
                    </select>
                    @error('parent_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Parent ID <span class="text-danger">*</span></label>
                    <select name="parent_id" class="form-control @error('parent_id') is-invalid @enderror" id="parentId" required>
                        <option value="">Pilih Parent</option>
                    </select>
                    @error('parent_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Kategori</label>
                    <input type="text" name="category" class="form-control @error('category') is-invalid @enderror" value="{{ old('category', $gallery->category) }}" placeholder="Contoh: restaurant, pool, event">
                    @error('category')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Sort Order</label>
                    <input type="number" name="sort_order" class="form-control @error('sort_order') is-invalid @enderror" value="{{ old('sort_order', $gallery->sort_order) }}">
                    <div class="form-text">Urutan tampilan (semakin kecil semakin awal)</div>
                    @error('sort_order')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-12">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="3">{{ old('description', $gallery->description) }}</textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-12">
                    <div class="form-check">
                        <input type="checkbox" name="is_featured" class="form-check-input" id="isFeatured" value="1" {{ old('is_featured', $gallery->is_featured) ? 'checked' : '' }}>
                        <label class="form-check-label" for="isFeatured">Jadikan Featured</label>
                    </div>
                </div>
            </div>

            <hr class="section-divider">

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.galleries.index') }}" class="btn-cancel">Batal</a>
                <button type="submit" class="btn-save">
                    <i class="fas fa-save me-1"></i> Update
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('fileInput')?.addEventListener('change', function() {
        const preview = document.getElementById('filePreview');
        preview.innerHTML = '';

        if (this.files && this.files[0]) {
            const reader = new FileReader();
            const fileType = document.getElementById('mediaType').value;
            reader.onload = function(e) {
                if (fileType === 'image') {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    preview.appendChild(img);
                } else {
                    const video = document.createElement('video');
                    video.src = e.target.result;
                    video.controls = true;
                    preview.appendChild(video);
                }
                preview.style.display = 'flex';
            }
            reader.readAsDataURL(this.files[0]);
        }
    });

    function getCurrentParent() {
        @php
            if($gallery->menu_id) $currentParent = $gallery->menu_id;
            elseif($gallery->event_id) $currentParent = $gallery->event_id;
            elseif($gallery->promo_id) $currentParent = $gallery->promo_id;
            elseif($gallery->testimonial_id) $currentParent = $gallery->testimonial_id;
            else $currentParent = null;
        @endphp
        return {{ $currentParent ?? 'null' }};
    }

    document.getElementById('parentType')?.addEventListener('change', function() {
        const parentType = this.value;
        const parentIdSelect = document.getElementById('parentId');
        const currentParent = getCurrentParent();

        if (!parentType) {
            parentIdSelect.innerHTML = '<option value="">Pilih Parent</option>';
            return;
        }

        fetch(`/admin/galleries/get-parents?type=${parentType}`)
            .then(response => response.json())
            .then(data => {
                parentIdSelect.innerHTML = '<option value="">Pilih Parent</option>';
                data.forEach(item => {
                    const option = document.createElement('option');
                    option.value = item.id;
                    option.textContent = item.name;
                    if (currentParent && item.id == currentParent) option.selected = true;
                    parentIdSelect.appendChild(option);
                });
            })
            .catch(error => console.error('Error:', error));
    });

    document.getElementById('parentType')?.dispatchEvent(new Event('change'));
</script>
@endpush

@endsection