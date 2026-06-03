<?php $__env->startSection('title', 'Pool Info'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="display-4 fw-bold mb-3">Caldera Pool</h1>
        <div class="section-divider"></div>
        <p class="lead text-muted">Enjoy our refreshing and family-friendly swimming pool</p>
    </div>

    <div class="row align-items-center mb-5">
        <div class="col-lg-6 mb-4 mb-lg-0">
        <img src="<?php echo e(asset('storage/galleries/pool1.jpeg')); ?>" 
        class="img-fluid rounded-4 shadow-lg pool-img" 
        alt="Caldera Pool"
        style="max-width: 500px; width: 100%;">
        </div>
        <div class="col-lg-6">
            <h3 class="fw-bold mb-3" style="color: #1c3451; font-family: 'Playfair Display', serif;">Tiket Masuk Kolam Renang</h3>
            <div class="table-responsive">
                <table class="table table-bordered caldera-table">
                    <thead>
                        <tr>
                            <th>Jenis Tiket</th>
                            <th>Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Dewasa</td>
                            <td class="fw-semibold">Rp 35.000</td>
                        </tr>
                        <tr>
                            <td>Anak-anak (3-12 tahun)</td>
                            <td class="fw-semibold">Rp 25.000</td>
                        </tr>
                        <tr>
                            <td>Keluarga (4 orang)</td>
                            <td class="fw-semibold">Rp 100.000</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                <a href="<?php echo e(route('reservation.ticket')); ?>" class="btn btn-caldera btn-lg">
                    <i class="fas fa-ticket-alt me-2"></i>Beli Tiket Sekarang
                </a>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm text-center p-4 caldera-card">
                <i class="fas fa-clock fa-3x mb-3 caldera-icon"></i>
                <h5 class="fw-bold" style="color: #1c3451;">Jam Operasional</h5>
                <p class="text-muted mb-0">Setiap Hari</p>
                <p class="text-muted">08:00 - 18:00 WIB</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm text-center p-4 caldera-card">
                <i class="fas fa-check-circle fa-3x mb-3 caldera-icon"></i>
                <h5 class="fw-bold" style="color: #1c3451;">Fasilitas</h5>
                <p class="text-muted mb-0">Kolam Dewasa, Kolam Anak, Water Slide, Gazebo, Locker, Shower</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm text-center p-4 caldera-card">
                <i class="fas fa-shield-alt fa-3x mb-3 caldera-icon"></i>
                <h5 class="fw-bold" style="color: #1c3451;">Peraturan</h5>
                <p class="text-muted mb-0">Menggunakan pakaian renang, dilarang merokok, anak harus didampingi orang tua</p>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap');

    h1.display-4 {
        font-family: 'Playfair Display', serif;
        color: #1c3451;
    }

    .section-divider {
        width: 50px;
        height: 3px;
        background: #c1a067;
        margin: 12px auto 20px;
        border-radius: 2px;
    }

    .pool-img {
        border: 4px solid #e8e0d0;
    }

    .caldera-table thead tr {
        background-color: #1c3451;
        color: white;
    }

    .caldera-table thead th {
        background-color: #1c3451;
        color: white;
        border-color: #1c3451;
        font-weight: 600;
    }

    .caldera-table tbody tr:hover {
        background-color: #fdf8f0;
    }

    .caldera-table td {
        vertical-align: middle;
        border-color: #e8e0d0;
    }

    .btn-caldera {
        background-color: #1c3451;
        color: white;
        border: none;
        border-radius: 10px;
        padding: 12px 28px;
        font-weight: 600;
        transition: all 0.2s;
    }

    .btn-caldera:hover {
        background-color: #c1a067;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(28,52,81,0.2);
    }

    .caldera-card {
        border-radius: 16px !important;
        transition: transform 0.2s, box-shadow 0.2s;
        border-top: 3px solid #c1a067 !important;
    }

    .caldera-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(28,52,81,0.12) !important;
    }

    .caldera-icon {
        color: #c1a067 !important;
    }
</style>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PA_03\PA2\resources\views/pages/pool.blade.php ENDPATH**/ ?>