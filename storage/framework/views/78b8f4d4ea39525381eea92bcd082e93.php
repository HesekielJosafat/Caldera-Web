<?php $__env->startSection('title', 'Konfirmasi ke WhatsApp'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm text-center p-4">
                <div class="card-body">
                    <div class="mb-4">
                        <div class="success-icon mb-3">
                            <i class="fas fa-check-circle fa-4x" style="color: #25D366;"></i>
                        </div>
                        <h4 class="fw-bold" style="color: #1c3451;">Bukti Terupload!</h4>
                        <p class="text-muted">Silakan kirim konfirmasi ke WhatsApp Caldera</p>
                    </div>
                    
                    <div class="alert alert-success mb-4">
                        <small>Pesan otomatis sudah disiapkan. Klik tombol di bawah untuk mengirim ke WhatsApp Caldera.</small>
                    </div>
                    
                    <a href="<?php echo e($waUrl); ?>" target="_blank" class="btn btn-whatsapp w-100 mb-3">
                        <i class="fab fa-whatsapp me-2"></i> Kirim ke WhatsApp Caldera
                    </a>
                    
                    <a href="<?php echo e(route('customer.reservations')); ?>" class="btn btn-outline-secondary w-100">
                        <i class="fas fa-home me-2"></i> Ke Dashboard
                    </a>
                    
                    <p class="mt-3 small text-muted">
                        <i class="fas fa-info-circle"></i>
                        Tim Caldera akan segera mengkonfirmasi reservasi Anda setelah menerima pesan ini.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.btn-whatsapp {
    background: #25D366;
    color: white;
    border-radius: 10px;
    padding: 12px;
    font-weight: 600;
    transition: all 0.2s;
}
.btn-whatsapp:hover {
    background: #128C7E;
    color: white;
    transform: translateY(-2px);
}
.success-icon {
    animation: scaleIn 0.5s ease;
}
@keyframes scaleIn {
    from {
        transform: scale(0);
        opacity: 0;
    }
    to {
        transform: scale(1);
        opacity: 1;
    }
}
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PA_03\PA2\resources\views/reservation/table/whatsapp.blade.php ENDPATH**/ ?>