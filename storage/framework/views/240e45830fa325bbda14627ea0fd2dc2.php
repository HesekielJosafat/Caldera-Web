

<?php $__env->startSection('title', 'Edit Menu'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header bg-white px-4 py-3" style="border-bottom: 2px solid #f0ebe0;">
                <h6 class="mb-0 fw-bold" style="color: #1c3451;">
                    <i class="fas fa-edit me-2" style="color: #c1a067;"></i>Edit Menu: <?php echo e($menu->name); ?>

                </h6>
            </div>
            <div class="card-body px-4 py-4">
                <form action="<?php echo e(route('admin.menus.update', $menu)); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>

                    <div class="form-group mb-3">
                        <label class="admin-label">Menu Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control admin-input <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               value="<?php echo e(old('name', $menu->name)); ?>" required>
                        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="admin-label">Category <span class="text-danger">*</span></label>
                            <select name="category" class="form-control admin-input <?php $__errorArgs = ['category'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                <option value="">Select Category</option>
                                <option value="makanan" <?php echo e(old('category', $menu->category) == 'makanan' ? 'selected' : ''); ?>>Makanan</option>
                                <option value="minuman" <?php echo e(old('category', $menu->category) == 'minuman' ? 'selected' : ''); ?>>Minuman</option>
                                <option value="dessert"  <?php echo e(old('category', $menu->category) == 'dessert'  ? 'selected' : ''); ?>>Dessert</option>
                            </select>
                            <?php $__errorArgs = ['category'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="admin-label">Price <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text admin-input-prefix">Rp</span>
                                <input type="number" name="price"
                                       class="form-control admin-input <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       value="<?php echo e(old('price', $menu->price)); ?>" required>
                            </div>
                            <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label class="admin-label">Description <span class="text-danger">*</span></label>
                        <textarea name="description" rows="4"
                                  class="form-control admin-input <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                  required><?php echo e(old('description', $menu->description)); ?></textarea>
                        <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    
                    <div class="form-group mb-3">
                        <label class="admin-label">Current Image</label>
                        <?php if($menu->image): ?>
                            <?php
                                $imageUrl = asset('storage/' . $menu->image);
                                // Cek apakah file benar-benar ada
                                $imageExists = Storage::disk('public')->exists($menu->image);
                            ?>
                            
                            <?php if($imageExists): ?>
                                <div class="mb-2">
                                    <img src="<?php echo e($imageUrl); ?>" width="120" height="120"
                                        style="object-fit: cover; border-radius: 10px; border: 2px solid #e8e0d0;">
                                    <br>
                                    <small class="text-muted">Gambar saat ini: <?php echo e(basename($menu->image)); ?></small>
                                </div>
                            <?php else: ?>
                                <div class="mb-2 alert alert-warning p-2">
                                    <i class="fas fa-exclamation-triangle me-1"></i>
                                    <small>File gambar tidak ditemukan. Silakan upload gambar baru.</small>
                                </div>
                            <?php endif; ?>
                        <?php else: ?>
                            <div class="mb-2">
                                <small class="text-muted">Belum ada gambar</small>
                            </div>
                        <?php endif; ?>
                        
                        <input type="file" name="image" id="menuImage"
                            class="form-control admin-input <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            accept="image/*" onchange="previewImage(this)">
                        <small class="text-muted" style="font-size: 12px;">
                            Kosongkan untuk mempertahankan gambar saat ini. Ukuran rekomendasi: 500x500px
                        </small>
                        <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        
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
                                       <?php echo e(old('is_available', $menu->is_available) ? 'checked' : ''); ?>>
                                <label for="is_available" class="admin-check-label">Available</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="admin-check-wrap">
                                <input type="checkbox" name="is_recommended" class="admin-check" value="1"
                                       id="is_recommended"
                                       <?php echo e(old('is_recommended', $menu->is_recommended) ? 'checked' : ''); ?>>
                                <label for="is_recommended" class="admin-check-label">Recommended</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label class="admin-label">Sort Order</label>
                        <input type="number" name="sort_order" class="form-control admin-input"
                               value="<?php echo e(old('sort_order', $menu->sort_order)); ?>">
                    </div>

                    <div class="text-end d-flex gap-2 justify-content-end">
                        <a href="<?php echo e(route('admin.menus.index')); ?>" class="btn btn-admin-cancel">
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
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
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
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\PA2_Kel6\resources\views/admin/menus/edit.blade.php ENDPATH**/ ?>