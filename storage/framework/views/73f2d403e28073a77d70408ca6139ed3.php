<?php $__env->startSection('title', 'Promos'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="display-4 fw-bold mb-3">Special Promos</h1>
        <p class="lead text-muted">Get exciting discounts and offers</p>
    </div>

    <div class="row g-4">
        <?php $__empty_1 = true; $__currentLoopData = $promos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $promo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <img src="<?php echo e(asset('storage/' . $promo->banner_image)); ?>" class="card-img-top" alt="<?php echo e($promo->title); ?>" style="height: 200px; object-fit: cover;">
                <div class="card-body">
                    <span class="badge bg-danger mb-2">Promo</span>
                    <h5 class="fw-bold"><?php echo e($promo->title); ?></h5>
                    <p class="text-muted small"><?php echo e(Str::limit($promo->description, 100)); ?></p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-primary fw-bold">
                            <?php if($promo->discount_type == 'percentage'): ?>
                                Diskon <?php echo e($promo->discount_value); ?>%
                            <?php else: ?>
                                Diskon Rp <?php echo e(number_format($promo->discount_value, 0, ',', '.')); ?>

                            <?php endif; ?>
                        </span>
                        <small class="text-muted">Code: <?php echo e($promo->promo_code); ?></small>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 pb-3">
                    <a href="<?php echo e(route('branding.promos.detail', $promo->slug)); ?>" class="btn btn-outline-primary w-100">View Details</a>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="col-12 text-center py-5">
            <i class="fas fa-tags fa-4x text-muted mb-3"></i>
            <p class="text-muted">Belum ada promo</p>
        </div>
        <?php endif; ?>
    </div>

    <?php echo e($promos->links()); ?>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PA_03\PA2\resources\views/pages/promos.blade.php ENDPATH**/ ?>