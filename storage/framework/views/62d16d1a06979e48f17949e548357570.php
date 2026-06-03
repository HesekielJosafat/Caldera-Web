<?php $__env->startSection('title', $promo->title); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm overflow-hidden">
                <img src="<?php echo e(asset('storage/' . $promo->banner_image)); ?>" class="card-img-top" alt="<?php echo e($promo->title); ?>">
                <div class="card-body p-4">
                    <span class="badge bg-danger mb-3">Promo</span>
                    <h1 class="display-5 fw-bold mb-3"><?php echo e($promo->title); ?></h1>
                    <div class="mb-3">
                        <span class="text-primary fw-bold fs-4">
                            <?php if($promo->discount_type == 'percentage'): ?>
                                Diskon <?php echo e($promo->discount_value); ?>%
                            <?php else: ?>
                                Diskon Rp <?php echo e(number_format($promo->discount_value, 0, ',', '.')); ?>

                            <?php endif; ?>
                        </span>
                    </div>
                    <p class="text-muted"><?php echo e($promo->description); ?></p>
                    <div class="alert alert-info">
                        <strong>Promo Code:</strong> <?php echo e($promo->promo_code); ?>

                    </div>
                    <div class="alert alert-warning">
                        <strong>Valid until:</strong> <?php echo e(\Carbon\Carbon::parse($promo->end_date)->format('d F Y')); ?>

                    </div>
                    <a href="<?php echo e(route('branding.menu')); ?>" class="btn btn-primary">Order Now</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PA_03\PA2\resources\views/pages/promo-detail.blade.php ENDPATH**/ ?>