<?php $__env->startSection('title', 'Notifikasi - Caldera'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent">
                    <h4 class="mb-0 fw-bold" style="color: #1c3451;">
                        <i class="fas fa-bell me-2" style="color: #c1a067;"></i> Notifikasi Saya
                    </h4>
                </div>
                <div class="card-body p-0">
                    <?php $__empty_1 = true; $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notif): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="notification-item p-3 border-bottom <?php echo e($notif->read_at ? '' : 'bg-light'); ?>" 
                         data-id="<?php echo e($notif->id); ?>"
                         style="transition: all 0.2s;">
                        <div class="d-flex">
                            <div class="me-3">
                                <div class="notification-icon rounded-circle d-flex align-items-center justify-content-center" 
                                     style="width: 45px; height: 45px; background: <?php echo e($notif->color == 'success' ? '#e8f5e9' : '#f0ebe0'); ?>;">
                                    <i class="fas <?php echo e($notif->icon); ?> fa-lg" style="color: <?php echo e($notif->color == 'success' ? '#2e7d32' : '#c1a067'); ?>;"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-start">
                                    <h6 class="fw-bold mb-1" style="color: #1c3451;">
                                        <?php echo e($notif->title); ?>

                                        <?php if(!$notif->read_at): ?>
                                            <span class="badge bg-danger ms-2" style="font-size: 9px;">NEW</span>
                                        <?php endif; ?>
                                    </h6>
                                    <small class="text-muted"><?php echo e($notif->created_at->diffForHumans()); ?></small>
                                </div>
                                <p class="text-muted small mb-2"><?php echo e($notif->body); ?></p>
                                <?php if($notif->booking_code): ?>
                                <div class="mt-2">
                                    <a href="<?php echo e($notif->url ?? '#'); ?>" class="btn btn-sm btn-outline-caldera">
                                        <i class="fas fa-eye me-1"></i> Lihat Detail
                                    </a>
                                    <?php if(!$notif->read_at): ?>
                                    <form action="<?php echo e(route('notifications.mark-read', $notif->id)); ?>" method="POST" class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="btn btn-sm btn-link text-muted">
                                            <i class="fas fa-check-circle"></i> Tandai Dibaca
                                        </button>
                                    </form>
                                    <?php endif; ?>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="text-center py-5">
                        <i class="fas fa-bell-slash fa-4x mb-3" style="color: #c1a067; opacity: 0.4;"></i>
                        <p class="text-muted">Belum ada notifikasi</p>
                    </div>
                    <?php endif; ?>
                </div>
                <?php if($notifications->hasPages()): ?>
                <div class="card-footer bg-transparent">
                    <?php echo e($notifications->links()); ?>

                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<style>
.btn-outline-caldera {
    border: 1px solid #c1a067;
    color: #c1a067;
    background: transparent;
    border-radius: 8px;
    font-size: 12px;
    padding: 4px 12px;
    transition: all 0.2s;
}
.btn-outline-caldera:hover {
    background: #c1a067;
    color: white;
}
.notification-item:hover {
    background: #f8f6f2;
}
body.dark-mode .notification-item:hover {
    background: #2d2d3a;
}
body.dark-mode .notification-item.bg-light {
    background: #2a2a3a !important;
}
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PA_03\PA2\resources\views/customer/notifications.blade.php ENDPATH**/ ?>