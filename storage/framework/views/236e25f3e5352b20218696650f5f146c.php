

<?php $__env->startSection('title', 'About Us - Caldera Resto & Pool'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <!-- Header -->
    <div class="text-center mb-5">
        <h1 class="display-4 fw-bold mb-2" style="font-family: 'Playfair Display', serif; color: #1c3451;">About Caldera</h1>
        <div class="section-divider"></div>
        <p class="lead text-muted">Experience the perfect blend of culinary delight and refreshing pool experience</p>
    </div>

    <!-- Hero Section -->
    <div class="row align-items-center mb-5">
        <div class="col-lg-6 mb-4 mb-lg-0">
            <h2 class="fw-bold mb-3" style="color: #1c3451; font-family: 'Playfair Display', serif;">Our Story</h2>
            <p class="text-muted" style="text-align: justify; line-height: 1.8;">
                Caldera Resto and Pool berdiri sejak tahun 2020 dengan konsep restoran keluarga yang dilengkapi fasilitas kolam renang. 
                Berawal dari keinginan menciptakan tempat berkumpul yang nyaman untuk keluarga dan teman, Caldera kini telah menjadi 
                salah satu destinasi favorit di kota.
            </p>
            <p class="text-muted mt-3" style="text-align: justify; line-height: 1.8;">
                Kami berkomitmen untuk memberikan pelayanan terbaik, makanan berkualitas, dan pengalaman yang tak terlupakan 
                bagi setiap pengunjung. Dengan suasana yang hangat dan pelayanan ramah, Caldera siap menjadi rumah kedua bagi Anda 
                dan keluarga.
            </p>
            <div class="mt-4">
                <a href="<?php echo e(route('reservation.table')); ?>" class="btn btn-caldera">
                    <i class="fas fa-calendar-alt me-2"></i> Book a Table
                </a>
                <a href="<?php echo e(route('branding.menu')); ?>" class="btn btn-outline-caldera ms-2">
                    <i class="fas fa-utensils me-2"></i> View Menu
                </a>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="position-relative">
                <img src="<?php echo e(asset('storage/galleries/about.jpeg')); ?>" class="img-fluid rounded-4 shadow-lg" alt="About Caldera" style="width: 100%; object-fit: cover; height: 400px;">
            </div>
        </div>
    </div>

    <!-- Feature Cards -->
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 p-4 caldera-feature-card">
                <div class="feature-icon mb-3">
                    <i class="fas fa-utensils fa-3x"></i>
                </div>
                <h5 class="fw-bold mb-2" style="color: #1c3451;">Delicious Cuisine</h5>
                <p class="text-muted mb-0">Authentic Indonesian and international dishes prepared by our expert chefs using fresh ingredients.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 p-4 caldera-feature-card">
                <div class="feature-icon mb-3">
                    <i class="fas fa-swimmer fa-3x"></i>
                </div>
                <h5 class="fw-bold mb-2" style="color: #1c3451;">Refreshing Pool</h5>
                <p class="text-muted mb-0">Clean and well-maintained swimming pool perfect for family fun and relaxation.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 p-4 caldera-feature-card">
                <div class="feature-icon mb-3">
                    <i class="fas fa-music fa-3x"></i>
                </div>
                <h5 class="fw-bold mb-2" style="color: #1c3451;">Live Entertainment</h5>
                <p class="text-muted mb-0">Regular live music and special events to enhance your dining experience.</p>
            </div>
        </div>
    </div>

    <!-- Vision & Mission -->
    <div class="row">
        <div class="col-12 text-center mb-4">
            <h2 class="fw-bold" style="color: #1c3451; font-family: 'Playfair Display', serif;">Our Vision & Mission</h2>
            <div class="section-divider mx-auto"></div>
        </div>
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm h-100 p-4 vision-card">
                <div class="d-flex align-items-center mb-3">
                    <div class="vision-icon me-3">
                        <i class="fas fa-eye fa-2x"></i>
                    </div>
                    <h5 class="fw-bold mb-0" style="color: #1c3451;">Vision</h5>
                </div>
                <p class="text-muted mb-0" style="font-style: italic;">
                    "Menjadi destinasi kuliner dan rekreasi terbaik di Indonesia yang dikenal dengan pelayanan prima dan pengalaman tak terlupakan bagi setiap pelanggan."
                </p>
            </div>
        </div>
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm h-100 p-4 mission-card">
                <div class="d-flex align-items-center mb-3">
                    <div class="mission-icon me-3">
                        <i class="fas fa-bullseye fa-2x"></i>
                    </div>
                    <h5 class="fw-bold mb-0" style="color: #1c3451;">Mission</h5>
                </div>
                <ul class="text-muted mb-0" style="padding-left: 20px;">
                    <li class="mb-2">Menyediakan makanan berkualitas dengan harga terjangkau</li>
                    <li class="mb-2">Memberikan pelayanan terbaik dan ramah kepada pelanggan</li>
                    <li class="mb-2">Menciptakan suasana yang nyaman dan menyenangkan</li>
                    <li>Mengembangkan inovasi menu dan fasilitas secara berkelanjutan</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="row g-4 mt-3 pt-3">
        <div class="col-md-3 col-6 text-center">
            <div class="stat-card p-3">
                <h3 class="fw-bold mb-0" style="color: #c1a067;">5+</h3>
                <small class="text-muted">Years of Excellence</small>
            </div>
        </div>
        <div class="col-md-3 col-6 text-center">
            <div class="stat-card p-3">
                <h3 class="fw-bold mb-0" style="color: #c1a067;">50+</h3>
                <small class="text-muted">Menu Items</small>
            </div>
        </div>
        <div class="col-md-3 col-6 text-center">
            <div class="stat-card p-3">
                <h3 class="fw-bold mb-0" style="color: #c1a067;">10K+</h3>
                <small class="text-muted">Happy Customers</small>
            </div>
        </div>
        <div class="col-md-3 col-6 text-center">
            <div class="stat-card p-3">
                <h3 class="fw-bold mb-0" style="color: #c1a067;">20+</h3>
                <small class="text-muted">Expert Staff</small>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&display=swap');

    .display-4 {
        font-family: 'Playfair Display', serif;
        color: #1c3451;
    }

    .section-divider {
        width: 60px;
        height: 3px;
        background: #c1a067;
        margin: 12px auto 16px;
        border-radius: 2px;
    }

    /* Feature Cards */
    .caldera-feature-card {
        border-radius: 20px !important;
        transition: all 0.3s ease;
        text-align: center;
    }

    .caldera-feature-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 28px rgba(28,52,81,0.15) !important;
    }

    .feature-icon i {
        color: #c1a067;
        transition: transform 0.3s ease;
    }

    .caldera-feature-card:hover .feature-icon i {
        transform: scale(1.1);
    }

    /* Vision & Mission Cards */
    .vision-card, .mission-card {
        border-radius: 20px !important;
        transition: all 0.3s ease;
        border-left: 4px solid #c1a067 !important;
    }

    .vision-card:hover, .mission-card:hover {
        transform: translateX(5px);
        box-shadow: 0 12px 28px rgba(28,52,81,0.12) !important;
    }

    .vision-icon i, .mission-icon i {
        color: #c1a067;
    }

    /* Stat Cards */
    .stat-card {
        background: #f8f6f2;
        border-radius: 16px;
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        background: #1c3451;
        transform: translateY(-3px);
    }

    .stat-card:hover h3,
    .stat-card:hover small {
        color: white !important;
    }

    /* Buttons */
    .btn-caldera {
        background: linear-gradient(135deg, #1c3451, #01516e);
        color: white;
        border: none;
        border-radius: 12px;
        padding: 12px 28px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-caldera:hover {
        background: linear-gradient(135deg, #c1a067, #a8894f);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(193,160,103,0.3);
    }

    .btn-outline-caldera {
        background: transparent;
        color: #1c3451;
        border: 2px solid #1c3451;
        border-radius: 12px;
        padding: 12px 28px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-outline-caldera:hover {
        background: #1c3451;
        color: white;
        transform: translateY(-2px);
    }

    /* Image */
    .img-fluid.rounded-4 {
        border: 4px solid #e8e0d0;
    }

    /* Dark Mode */
    body.dark-mode .stat-card {
        background: #1e1e2a;
    }

    body.dark-mode .stat-card:hover {
        background: #c1a067;
    }

    body.dark-mode .stat-card:hover h3,
    body.dark-mode .stat-card:hover small {
        color: #1c3451 !important;
    }

    body.dark-mode .btn-outline-caldera {
        border-color: #c1a067;
        color: #c1a067;
    }

    body.dark-mode .btn-outline-caldera:hover {
        background: #c1a067;
        color: #1c3451;
    }
</style>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\PA2_Kel6\resources\views/pages/about.blade.php ENDPATH**/ ?>