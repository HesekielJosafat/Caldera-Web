<?php $__env->startSection('title', 'Testimonials'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <!-- Header -->
    <div class="text-center mb-5">
        <h1 class="display-4 fw-bold mb-2">What Our Customers Say</h1>
        <div class="section-divider"></div>
        <p class="lead text-muted">Real experiences from real people</p>
    </div>

    <!-- Rating Summary -->
    <div class="row mb-5">
        <div class="col-md-4 text-center mb-4">
            <div class="card border-0 shadow-sm p-4 h-100 caldera-card">
                <div class="display-1 fw-bold mb-1" style="color: #1c3451; font-family: 'Playfair Display', serif;"><?php echo e(number_format($ratingStats['average'], 1)); ?></div>
                <div class="mb-2">
                    <?php for($i = 1; $i <= 5; $i++): ?>
                        <?php if($i <= floor($ratingStats['average'])): ?>
                            <i class="fas fa-star fa-lg" style="color: #c1a067;"></i>
                        <?php elseif($i - $ratingStats['average'] <= 0.5): ?>
                            <i class="fas fa-star-half-alt fa-lg" style="color: #c1a067;"></i>
                        <?php else: ?>
                            <i class="far fa-star fa-lg" style="color: #c1a067;"></i>
                        <?php endif; ?>
                    <?php endfor; ?>
                </div>
                <p class="text-muted">Average Rating</p>
                <p class="mb-0">Based on <strong style="color: #1c3451;"><?php echo e($ratingStats['total']); ?></strong> reviews</p>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card border-0 shadow-sm p-4 h-100 caldera-card">
                <div class="row h-100">
                    <!-- Rating bars section -->
                    <div class="col-12 col-md-7 d-flex flex-column justify-content-center">
                        <?php $__currentLoopData = [5,4,3,2,1]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $star): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="d-flex align-items-center mb-3">
                            <div class="me-2" style="min-width: 65px;">
                                <span class="fw-bold" style="font-size: 13px;">
                                    <?php if($star == 5): ?> 5 Star
                                    <?php elseif($star == 4): ?> 4 Star
                                    <?php elseif($star == 3): ?> 3 Star
                                    <?php elseif($star == 2): ?> 2 Star
                                    <?php else: ?> 1 Star
                                    <?php endif; ?>
                                </span>
                            </div>
                            <div class="progress flex-grow-1" style="height: 8px; border-radius: 4px; background: #f0ebe0;">
                                <?php
                                    $percent = $ratingStats['total'] > 0 ? ($ratingStats[$star . '_star'] / $ratingStats['total']) * 100 : 0;
                                ?>
                                <div class="progress-bar" style="width: <?php echo e($percent); ?>%; background: #c1a067; border-radius: 4px;"></div>
                            </div>
                            <div class="ms-2" style="min-width: 35px; text-align: right;">
                                <span class="text-muted small fw-bold"><?php echo e($ratingStats[$star . '_star']); ?></span>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    
                    <!-- Buttons section - lebih rapat -->
                    <div class="col-12 col-md-5 d-flex flex-column justify-content-center">
                        <div class="d-flex flex-column gap-2">
                            <a href="<?php echo e(route('branding.testimonials.create')); ?>" class="btn btn-caldera w-100">
                                <i class="fas fa-star me-2"></i>Write a Review
                            </a>
                            <div class="dropdown w-100">
                                <button class="btn btn-filter-outline w-100 dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-filter me-2"></i>Filter Reviews
                                </button>
                                <ul class="dropdown-menu w-100">
                                    <li><a class="dropdown-item" href="<?php echo e(route('branding.testimonials')); ?>">All Reviews</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="<?php echo e(route('branding.testimonials', ['rating' => 5])); ?>">5 Star <i class="fas fa-star ms-1" style="color: #c1a067; font-size: 11px;"></i></a></li>
                                    <li><a class="dropdown-item" href="<?php echo e(route('branding.testimonials', ['rating' => 4])); ?>">4 Star <i class="fas fa-star ms-1" style="color: #c1a067; font-size: 11px;"></i></a></li>
                                    <li><a class="dropdown-item" href="<?php echo e(route('branding.testimonials', ['rating' => 3])); ?>">3 Star <i class="fas fa-star ms-1" style="color: #c1a067; font-size: 11px;"></i></a></li>
                                    <li><a class="dropdown-item" href="<?php echo e(route('branding.testimonials', ['rating' => 2])); ?>">2 Star <i class="fas fa-star ms-1" style="color: #c1a067; font-size: 11px;"></i></a></li>
                                    <li><a class="dropdown-item" href="<?php echo e(route('branding.testimonials', ['rating' => 1])); ?>">1 Star <i class="fas fa-star ms-1" style="color: #c1a067; font-size: 11px;"></i></a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="<?php echo e(route('branding.testimonials', ['service' => 'restaurant'])); ?>"><i class="fas fa-utensils me-2"></i>Restaurant</a></li>
                                    <li><a class="dropdown-item" href="<?php echo e(route('branding.testimonials', ['service' => 'pool'])); ?>"><i class="fas fa-swimmer me-2"></i>Pool</a></li>
                                    <li><a class="dropdown-item" href="<?php echo e(route('branding.testimonials', ['service' => 'event'])); ?>"><i class="fas fa-calendar-alt me-2"></i>Event</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Testimonials Grid -->
    <div class="row g-4">
        <?php $__empty_1 = true; $__currentLoopData = $testimonials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $testimonial): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm h-100 testimonial-card">
                <div class="card-body p-4">
                    <!-- Quote icon -->
                    <div class="mb-3">
                        <i class="fas fa-quote-left fa-lg" style="color: #c1a067; opacity: 0.5;"></i>
                    </div>

                    <div class="d-flex align-items-center mb-3">
                        <?php if($testimonial->customer_photo): ?>
                            <img src="<?php echo e(asset('storage/' . $testimonial->customer_photo)); ?>"
                                 class="rounded-circle me-3"
                                 width="55" height="55"
                                 style="object-fit: cover; border: 2px solid #c1a067;"
                                 alt="<?php echo e($testimonial->customer_name); ?>">
                        <?php else: ?>
                            <img src="https://ui-avatars.com/api/?name=<?php echo e(urlencode($testimonial->customer_name)); ?>&background=1c3451&color=c1a067&size=60&rounded=true"
                                 class="rounded-circle me-3"
                                 width="55" height="55"
                                 style="border: 2px solid #c1a067;"
                                 alt="<?php echo e($testimonial->customer_name); ?>">
                        <?php endif; ?>
                        <div>
                            <h6 class="fw-bold mb-0" style="color: #1c3451;"><?php echo e($testimonial->customer_name); ?></h6>
                            <small class="text-muted">
                                <?php if($testimonial->service_type): ?>
                                    <?php echo e(ucfirst($testimonial->service_type)); ?> Visitor
                                <?php else: ?>
                                    Customer
                                <?php endif; ?>
                            </small>
                        </div>
                    </div>

                    <!-- Rating Bintang 1-5 -->
                    <div class="mb-3">
                        <?php for($i = 1; $i <= 5; $i++): ?>
                            <?php if($i <= $testimonial->rating): ?>
                                <i class="fas fa-star" style="color: #c1a067;"></i>
                            <?php else: ?>
                                <i class="far fa-star" style="color: #c1a067;"></i>
                            <?php endif; ?>
                        <?php endfor; ?>
                        <span class="badge bg-light text-dark ms-2 small fw-semibold">
                            <?php echo e($testimonial->rating); ?>/5
                        </span>
                    </div>

                    <p class="fst-italic text-muted mb-3">"<?php echo e(\Illuminate\Support\Str::limit($testimonial->comment, 150)); ?>"</p>

                    <div class="mt-auto">
                        <?php if($testimonial->visit_date): ?>
                            <small class="text-muted">
                                <i class="fas fa-calendar-alt me-1" style="color: #c1a067;"></i>
                                Visited: <?php echo e(\Carbon\Carbon::parse($testimonial->visit_date)->format('d M Y')); ?>

                            </small>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="col-12 text-center py-5">
            <i class="fas fa-star fa-4x mb-3" style="color: #c1a067; opacity: 0.4;"></i>
            <h5 style="color: #1c3451;">No testimonials yet</h5>
            <p class="text-muted">Be the first to write a review!</p>
            <a href="<?php echo e(route('branding.testimonials.create')); ?>" class="btn btn-caldera">Write a Review</a>
        </div>
        <?php endif; ?>
    </div>

    <!-- Pagination -->
    <div class="mt-5">
        <?php echo e($testimonials->links()); ?>

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
        margin: 12px auto 16px;
        border-radius: 2px;
    }

    .caldera-card {
        border-radius: 16px !important;
        transition: transform 0.25s, box-shadow 0.25s;
    }

    .caldera-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 28px rgba(28,52,81,0.1) !important;
    }

    .testimonial-card {
        border-radius: 16px !important;
        border-top: 3px solid transparent !important;
        transition: transform 0.25s, box-shadow 0.25s, border-color 0.25s;
    }

    .testimonial-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 28px rgba(28,52,81,0.1) !important;
        border-top: 3px solid #c1a067 !important;
    }

    .btn-caldera {
        background: linear-gradient(135deg, #1c3451, #01516e);
        color: white;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        font-size: 14px;
        padding: 10px 20px;
        transition: all 0.2s;
    }

    .btn-caldera:hover {
        background: linear-gradient(135deg, #c1a067, #a8894f);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 14px rgba(193,160,103,0.3);
    }

    .btn-filter-outline {
        border: 1.5px solid #1c3451;
        color: #1c3451;
        border-radius: 10px;
        font-weight: 600;
        font-size: 14px;
        padding: 10px 20px;
        background: white;
        transition: all 0.2s;
    }

    .btn-filter-outline:hover {
        background: #1c3451;
        color: white;
    }

    .progress {
        background-color: #f0ebe0;
    }

    .progress-bar {
        transition: width 0.5s ease;
    }

    .dropdown-item:active {
        background-color: #1c3451;
        color: white;
    }

    .dropdown-item i {
        width: 20px;
    }

    /* Dark mode */
    body.dark-mode .testimonial-card {
        background: #1e1e2a !important;
    }

    body.dark-mode .testimonial-card .text-muted {
        color: #b0b0b0 !important;
    }

    body.dark-mode .bg-light {
        background-color: #2d2d3a !important;
        color: #c1a067 !important;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .container {
            padding-left: 1rem;
            padding-right: 1rem;
        }
        
        .display-1 {
            font-size: 3rem;
        }
    }
</style>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PA_03\PA2\resources\views/pages/testimonials.blade.php ENDPATH**/ ?>