@extends('layouts.admin')

@section('title', 'Tambah Gallery')

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
    .report-page-header .header-icon i { color: #c1a067; font-size: 18px; }
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
    .btn-back:hover { background: rgba(255,255,255,0.25); color: #fff; }
    .report-main-card {
        border: none;
        border-radius: 16px;
        border-top: 3px solid #c1a067 !important;
        box-shadow: 0 4px 20px rgba(28,52,81,0.08);
    }
    .report-main-card .card-body { padding: 28px; }
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
    .form-control, .form-select {
        border-radius: 10px;
        border: 1px solid #dde2e8;
        font-size: 13px;
        padding: 9px 13px;
        color: #1c3451;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .form-control:focus, .form-select:focus {
        border-color: #c1a067;
        box-shadow: 0 0 0 3px rgba(193,160,103,0.15);
    }
    .form-control.is-invalid, .form-select.is-invalid { border-color: #dc2626; }
    .form-text { font-size: 11px; color: #9ca3af; margin-top: 4px; }
    .form-check-input:checked { background-color: #1c3451; border-color: #1c3451; }
    .form-check-label { font-size: 13px; color: #374151; }

    /* Upload area */
    .upload-area {
        border: 2px dashed #dde2e8;
        border-radius: 12px;
        padding: 28px 16px;
        text-align: center;
        background: #f8fafc;
        cursor: pointer;
        transition: border-color 0.2s, background 0.2s;
        position: relative;
    }
    .upload-area:hover, .upload-area.drag-over {
        border-color: #c1a067;
        background: #fffbf5;
    }
    .upload-area input[type="file"] {
        position: absolute;
        inset: 0;
        opacity: 0;
        cursor: pointer;
        width: 100%;
        height: 100%;
    }
    .upload-area .upload-icon { font-size: 28px; color: #c1a067; margin-bottom: 8px; }
    .upload-area .upload-text { font-size: 13px; color: #6b7280; }
    .upload-area .upload-text strong { color: #1c3451; }

    /* Preview */
    .preview-wrap {
        margin-top: 12px;
        border-radius: 10px;
        overflow: hidden;
        background: #f1f5f9;
        display: none;
        position: relative;
    }
    .preview-wrap img, .preview-wrap video {
        width: 100%;
        max-height: 220px;
        object-fit: cover;
        display: block;
    }
    .preview-remove {
        position: absolute;
        top: 8px;
        right: 8px;
        width: 28px;
        height: 28px;
        background: rgba(220,38,38,0.85);
        color: #fff;
        border: none;
        border-radius: 50%;
        font-size: 12px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Category chips */
    .category-chips { display: flex; flex-wrap: wrap; gap: 6px; margin-top: 8px; }
    .chip {
        font-size: 11px;
        font-weight: 600;
        padding: 4px 12px;
        border-radius: 20px;
        border: 1px solid #dde2e8;
        background: #f8fafc;
        color: #374151;
        cursor: pointer;
        transition: all 0.15s;
        user-select: none;
    }
    .chip:hover, .chip.active {
        background: #1c3451;
        border-color: #1c3451;
        color: #fff;
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
    <div class="d-flex align-items-center">
        <div class="header-icon"><i class="fas fa-plus-circle"></i></div>
        <h6>Tambah Gallery Baru</h6>
    </div>
    <a href="{{ route('admin.galleries.index') }}" class="btn-back">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="card report-main-card">
    <div class="card-body">
        <form action="{{ route('admin.galleries.store') }}" method="POST" enctype="multipart/form-data" id="galleryForm">
            @csrf

            {{-- ── Informasi Dasar ── --}}
            <div class="form-section-title">
                <i class="fas fa-info-circle"></i> Informasi Dasar
            </div>

            <div class="row g-3">
                {{-- Judul --}}
                <div class="col-md-8">
                    <label class="form-label">Judul <span class="text-danger">*</span></label>
                    <input type="text" name="title"
                           class="form-control @error('title') is-invalid @enderror"
                           value="{{ old('title') }}"
                           placeholder="Masukkan judul gallery…" required>
                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                {{-- Tipe --}}
                <div class="col-md-4">
                    <label class="form-label">Tipe Media <span class="text-danger">*</span></label>
                    <select name="type" id="mediaType"
                            class="form-select @error('type') is-invalid @enderror" required>
                        <option value="image" {{ old('type') !== 'video' ? 'selected' : '' }}>🖼 Gambar</option>
                        <option value="video" {{ old('type') === 'video' ? 'selected' : '' }}>🎬 Video</option>
                    </select>
                    @error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <hr class="section-divider">

            {{-- ── Upload File ── --}}
            <div class="form-section-title">
                <i class="fas fa-cloud-upload-alt"></i> Upload File
            </div>

            {{-- Panel Gambar --}}
            <div id="panelImage">
                <div class="upload-area" id="dropImage">
                    {{-- ✅ FIX: disabled dikelola via JS, bukan hidden --}}
                    <input type="file" name="file" id="inputImage"
                           accept="image/jpeg,image/png,image/jpg"
                           class="@error('file') is-invalid @enderror">
                    <div class="upload-icon"><i class="fas fa-image"></i></div>
                    <div class="upload-text">
                        <strong>Klik untuk pilih gambar</strong> atau drag & drop di sini<br>
                        <span>JPG, JPEG, PNG — maks. 2 MB</span>
                    </div>
                </div>
                <div class="preview-wrap" id="previewImage">
                    <button type="button" class="preview-remove" onclick="clearFile('image')">
                        <i class="fas fa-times"></i>
                    </button>
                    <img id="previewImageEl" src="" alt="preview">
                </div>
                @error('file')<div class="text-danger mt-1" style="font-size:12px">{{ $message }}</div>@enderror
            </div>

            {{-- Panel Video --}}
            <div id="panelVideo" style="display:none">
                <div class="upload-area" id="dropVideo">
                    {{-- ✅ FIX: disabled=true sejak awal karena default tipe adalah image --}}
                    <input type="file" name="file" id="inputVideo"
                           accept="video/mp4,video/mov,video/avi"
                           disabled
                           class="@error('file') is-invalid @enderror">
                    <div class="upload-icon"><i class="fas fa-video"></i></div>
                    <div class="upload-text">
                        <strong>Klik untuk pilih video</strong> atau drag & drop di sini<br>
                        <span>MP4, MOV, AVI — maks. 10 MB</span>
                    </div>
                </div>
                <div class="preview-wrap" id="previewVideo">
                    <button type="button" class="preview-remove" onclick="clearFile('video')">
                        <i class="fas fa-times"></i>
                    </button>
                    <video id="previewVideoEl" controls></video>
                </div>
            </div>

            <hr class="section-divider">

            {{-- ── Pengaturan ── --}}
            <div class="form-section-title">
                <i class="fas fa-sliders-h"></i> Pengaturan
            </div>

            <div class="row g-3">
                {{-- Kategori + chips --}}
                <div class="col-md-6">
                    <label class="form-label">Kategori</label>
                    <input type="text" name="category" id="categoryInput"
                           class="form-control @error('category') is-invalid @enderror"
                           value="{{ old('category') }}"
                           placeholder="Ketik atau pilih kategori di bawah">
                    <div class="category-chips">
                        @foreach(['pool', 'restaurant', 'event', 'exterior', 'interior', 'room'] as $cat)
                            <span class="chip" onclick="setCategory('{{ $cat }}')">{{ ucfirst($cat) }}</span>
                        @endforeach
                    </div>
                    @error('category')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                {{-- Sort order --}}
                <div class="col-md-3">
                    <label class="form-label">Sort Order</label>
                    <input type="number" name="sort_order"
                           class="form-control @error('sort_order') is-invalid @enderror"
                           value="{{ old('sort_order', 0) }}" min="0">
                    <div class="form-text">Semakin kecil, semakin awal tampil.</div>
                    @error('sort_order')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                {{-- Featured --}}
                <div class="col-md-3 d-flex align-items-center pt-3">
                    <div class="form-check form-switch">
                        <input type="checkbox" name="is_featured" class="form-check-input"
                               id="isFeatured" value="1" {{ old('is_featured') ? 'checked' : '' }}
                               style="width:40px; height:22px;">
                        <label class="form-check-label ms-2" for="isFeatured">
                            <strong>Featured</strong><br>
                            <span style="font-size:11px;color:#6b7280">Tampil di halaman utama</span>
                        </label>
                    </div>
                </div>

                {{-- Deskripsi --}}
                <div class="col-12">
                    <label class="form-label">Deskripsi <span style="font-weight:400;text-transform:none;color:#9ca3af">(opsional)</span></label>
                    <textarea name="description"
                              class="form-control @error('description') is-invalid @enderror"
                              rows="3"
                              placeholder="Tambahkan keterangan singkat…">{{ old('description') }}</textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <hr class="section-divider">

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.galleries.index') }}" class="btn-cancel">Batal</a>
                <button type="submit" class="btn-save">
                    <i class="fas fa-save me-1"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    const mediaTypeEl  = document.getElementById('mediaType');
    const panelImage   = document.getElementById('panelImage');
    const panelVideo   = document.getElementById('panelVideo');
    const inputImage   = document.getElementById('inputImage');
    const inputVideo   = document.getElementById('inputVideo');

    // ── Toggle panel image / video ──────────────────────────────────────────
    // ✅ FIX: saat ganti tipe, disable input yang tidak aktif
    mediaTypeEl.addEventListener('change', function () {
        const isVideo = this.value === 'video';

        panelImage.style.display = isVideo ? 'none' : 'block';
        panelVideo.style.display = isVideo ? 'block' : 'none';

        // Hanya input yang aktif yang bisa dikirim ke server
        inputImage.disabled = isVideo;
        inputVideo.disabled = !isVideo;

        // Reset preview & value panel yang disembunyikan
        if (isVideo) {
            clearFile('image');
        } else {
            clearFile('video');
        }
    });

    // ✅ FIX: Set initial disabled state sesuai nilai default (image)
    // inputVideo sudah disabled via atribut HTML, tapi kita pastikan lagi di sini
    inputImage.disabled = false;
    inputVideo.disabled = true;

    // ── Preview gambar ──────────────────────────────────────────────────────
    inputImage.addEventListener('change', function () {
        if (!this.files[0]) return;
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('previewImageEl').src = e.target.result;
            document.getElementById('previewImage').style.display = 'block';
        };
        reader.readAsDataURL(this.files[0]);
    });

    // ── Preview video ───────────────────────────────────────────────────────
    inputVideo.addEventListener('change', function () {
        if (!this.files[0]) return;
        const url = URL.createObjectURL(this.files[0]);
        document.getElementById('previewVideoEl').src = url;
        document.getElementById('previewVideo').style.display = 'block';
    });

    // ── Clear file ──────────────────────────────────────────────────────────
    function clearFile(type) {
        if (type === 'image') {
            inputImage.value = '';
            document.getElementById('previewImage').style.display = 'none';
            document.getElementById('previewImageEl').src = '';
        } else {
            inputVideo.value = '';
            document.getElementById('previewVideo').style.display = 'none';
            document.getElementById('previewVideoEl').src = '';
        }
    }

    // ── Category chips ──────────────────────────────────────────────────────
    function setCategory(val) {
        document.getElementById('categoryInput').value = val;
        document.querySelectorAll('.chip').forEach(c => c.classList.remove('active'));
        event.target.classList.add('active');
    }

    // Sync chip aktif saat ada old value
    (function syncChip() {
        const current = document.getElementById('categoryInput').value.toLowerCase();
        if (!current) return;
        document.querySelectorAll('.chip').forEach(c => {
            if (c.textContent.trim().toLowerCase() === current) c.classList.add('active');
        });
    })();

    // ── Drag & drop visual ──────────────────────────────────────────────────
    ['dropImage', 'dropVideo'].forEach(id => {
        const el = document.getElementById(id);
        if (!el) return;
        el.addEventListener('dragover',  e => { e.preventDefault(); el.classList.add('drag-over'); });
        el.addEventListener('dragleave', ()  => el.classList.remove('drag-over'));
        el.addEventListener('drop',      e => { e.preventDefault(); el.classList.remove('drag-over'); });
    });
</script>
@endpush

@endsection