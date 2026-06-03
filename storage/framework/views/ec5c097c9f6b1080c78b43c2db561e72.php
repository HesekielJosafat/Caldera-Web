

<?php $__env->startSection('title', 'Menu Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3 px-4">
        <h6 class="mb-0 fw-bold" style="color: #1c3451;">Daftar Menu</h6>
        <a href="<?php echo e(route('admin.menus.create')); ?>" class="btn btn-sm btn-admin-primary">
            <i class="fas fa-plus me-1"></i> Tambah Menu
        </a>
    </div>
    <div class="card-body px-4">
        <!-- Filter -->
        <div class="row mb-3">
            <div class="col-md-6">
                <form method="GET" class="d-flex gap-2">
                    <select name="category" class="form-select w-auto" onchange="this.form.submit()">
                        <option value="">Semua Kategori</option>
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($cat); ?>" <?php echo e(request('category') == $cat ? 'selected' : ''); ?>>
                                <?php echo e(ucfirst($cat)); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <input type="text" name="search" class="form-control" placeholder="Cari menu..." 
                           value="<?php echo e(request('search')); ?>" onchange="this.form.submit()">
                </form>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Gambar</th>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Status</th>
                        <th>Rekomendasi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $menus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td>
                            <?php if($menu->image && Storage::disk('public')->exists($menu->image)): ?>
                                <img src="<?php echo e(asset('storage/' . $menu->image)); ?>" 
                                     width="52" height="52"
                                     style="object-fit: cover; border-radius: 10px; border: 2px solid #e8e0d0;"
                                     onerror="this.onerror=null; this.src='https://placehold.co/52x52/e8e0d0/c1a067?text=No+Image';">
                            <?php else: ?>
                                <div class="d-flex align-items-center justify-content-center"
                                     style="width: 52px; height: 52px; border-radius: 10px; background: #f0ebe0;">
                                    <i class="fas fa-utensils" style="color: #c1a067;"></i>
                                </div>
                            <?php endif; ?>
                        </td>
                        <td class="fw-bold" style="color: #1c3451;"><?php echo e($menu->name); ?></td>
                        <td>
                            <span class="badge-category"><?php echo e(ucfirst($menu->category)); ?></span>
                        </td>
                        <td class="fw-semibold" style="color: #c1a067;">
                            Rp <?php echo e(number_format($menu->price, 0, ',', '.')); ?>

                        </td>
                        <td><?php echo $menu->status_label; ?></td>
                        <td>
                            <?php if($menu->is_recommended): ?>
                                <span class="badge" style="background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; border-radius: 20px; padding: 4px 10px; font-size: 11px;">Ya</span>
                            <?php else: ?>
                                <span class="badge" style="background: #f9fafb; color: #6b7280; border: 1px solid #e5e7eb; border-radius: 20px; padding: 4px 10px; font-size: 11px;">Tidak</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="<?php echo e(route('admin.menus.show', $menu)); ?>" class="btn btn-action btn-action-view" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="<?php echo e(route('admin.menus.edit', $menu)); ?>" class="btn btn-action btn-action-edit" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="<?php echo e(route('admin.menus.destroy', $menu)); ?>" method="POST" class="d-inline">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-action btn-action-delete" title="Hapus"
                                            onclick="return confirm('Yakin hapus menu ini?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                <button onclick="toggleAvailability(<?php echo e($menu->id); ?>)"
                                        class="btn btn-action <?php echo e($menu->is_available ? 'btn-action-warning' : 'btn-action-success'); ?>"
                                        title="<?php echo e($menu->is_available ? 'Nonaktifkan' : 'Aktifkan'); ?>">
                                    <i class="fas <?php echo e($menu->is_available ? 'fa-times' : 'fa-check'); ?>"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <i class="fas fa-utensils fa-3x mb-3 d-block" style="color: #c1a067; opacity: 0.4;"></i>
                            <span class="text-muted">Belum ada data menu</span>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            <?php echo e($menus->links()); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .btn-admin-primary {
        background: #1c3451;
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        padding: 7px 16px;
        transition: all 0.2s;
    }

    .btn-admin-primary:hover {
        background: #c1a067;
        color: white;
    }

    .badge-category {
        background: #eef2ff;
        color: #1c3451;
        border-radius: 20px;
        padding: 4px 12px;
        font-size: 12px;
        font-weight: 500;
    }

    .table thead th {
        background: #f8f9fa;
        color: #1c3451;
        font-weight: 600;
        font-size: 12px;
        letter-spacing: 0.4px;
        border-bottom: 2px solid #f0ebe0;
        padding: 12px 16px;
    }

    .table tbody td {
        padding: 12px 16px;
        border-bottom: 1px solid #f5f5f5;
        font-size: 14px;
    }

    .table tbody tr:hover {
        background: #fdfcfa;
    }

    .btn-action {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        border: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        transition: all 0.2s;
        padding: 0;
    }

    .btn-action-view    { background: #eef2ff; color: #1c3451; }
    .btn-action-view:hover { background: #1c3451; color: white; }

    .btn-action-edit    { background: #fef9ec; color: #c1a067; }
    .btn-action-edit:hover { background: #c1a067; color: white; }

    .btn-action-delete  { background: #fef2f2; color: #dc2626; }
    .btn-action-delete:hover { background: #dc2626; color: white; }

    .btn-action-warning { background: #fff7ed; color: #ea580c; }
    .btn-action-warning:hover { background: #ea580c; color: white; }

    .btn-action-success { background: #f0fdf4; color: #15803d; }
    .btn-action-success:hover { background: #15803d; color: white; }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    function toggleAvailability(id) {
        fetch(`/admin/menus/${id}/toggle-availability`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                'Content-Type': 'application/json'
            }
        }).then(response => response.json()).then(data => {
            if(data.success) location.reload();
        }).catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan, silakan refresh halaman dan coba lagi.');
        });
    }
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\PA2_Kel6\resources\views/admin/menus/index.blade.php ENDPATH**/ ?>