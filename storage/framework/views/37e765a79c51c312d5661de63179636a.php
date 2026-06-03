<?php $__env->startSection('title', 'Lupa Password'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent">
                    <h5 class="mb-0">Lupa Password</h5>
                </div>
                <div class="card-body">
                    <?php if(session('success')): ?>
                        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
                    <?php endif; ?>
                    
                    <p class="text-muted">Masukkan email Anda, kami akan mengirimkan link reset password</p>
                    
                    <form method="POST" action="<?php echo e(route('password.otp.send')); ?>">
                        <?php echo csrf_field(); ?>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Kirim Link Reset</button>
                    </form>
                    
                    <div class="text-center mt-3">
                        <a href="<?php echo e(route('login')); ?>">Kembali ke Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PA_03\PA2\resources\views/auth/forgot-password.blade.php ENDPATH**/ ?>