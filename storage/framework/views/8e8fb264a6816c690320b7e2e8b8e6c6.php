<?php $__env->startSection('title', 'Caldera Resto & Pool - Home'); ?>

<?php $__env->startSection('content'); ?>


<section class="hero-section d-flex align-items-center"
         style="background-image: linear-gradient(rgba(28,52,81,0.6), rgba(28,52,81,0.7)), url('<?php echo e(asset('storage/galleries/home.jpeg')); ?>');">
    <div class="container text-center text-white">
        <h1 class="hero-title display-3 fw-bold mb-3">
            <span class="gold-text">Caldera</span> Resto & Pool
        </h1>
        <p class="hero-subtitle lead mb-4">Experience the perfect blend of culinary delight and refreshing pool experience</p>
        <div class="hero-buttons">
            <a href="<?php echo e(route('reservation.table')); ?>" class="btn btn-primary btn-lg me-3">
                <i class="fas fa-calendar-alt me-2"></i> Book a Table
            </a>
            <a href="<?php echo e(route('reservation.ticket')); ?>" class="btn btn-outline-light btn-lg">
                <i class="fas fa-ticket-alt me-2"></i> Buy Pool Ticket
            </a>
        </div>
    </div>
</section>


<section class="offers-section py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title fw-bold">Special Offers</h2>
            <div class="section-divider"></div>
            <p class="section-subtitle text-muted">Exclusive deals every week at Caldera</p>
        </div>

        <div class="row g-4">
            <?php
                // Optimasi query dengan caching
                $activePromos = Cache::remember('homepage_promos', 3600, function () {
                    return \App\Models\Promo::where('is_active', true)
                                    ->whereDate('start_date', '<=', now())
                                    ->whereDate('end_date', '>=', now())
                                    ->latest()
                                    ->take(3)
                                    ->get();
                });
            ?>
            
            <?php $__empty_1 = true; $__currentLoopData = $activePromos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $promo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="col-md-4">
                <div class="offer-card text-center p-4">
                    <div class="offer-day"><?php echo e($promo->promo_type == 'ticket' ? 'Ticket Promo' : 'Food Promo'); ?></div>
                    <div class="offer-title"><?php echo e($promo->title); ?></div>
                    <div class="offer-price"><?php echo e($promo->discount_percent ? $promo->discount_percent . '% OFF' : 'Special Price'); ?></div>
                    <div class="offer-desc"><?php echo e(Str::limit($promo->description, 80)); ?></div>
                    <div class="offer-badge">Valid until <?php echo e(\Carbon\Carbon::parse($promo->end_date)->format('d M Y')); ?></div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-12 text-center">
                <p class="text-muted">No active promos at the moment</p>
            </div>
            <?php endif; ?>
        </div>

        <div class="text-center mt-4">
            <a href="<?php echo e(route('branding.promos')); ?>" class="btn btn-outline-gold">
                View All Promos <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>


<section class="atmosphere-section py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <h2 class="section-title fw-bold">Legendary Atmosphere</h2>
                <div class="section-divider-left"></div>
                <p class="lead">There's nothing better than spending time with family and friends in the best atmosphere.</p>
                <p class="text-muted">Whether you're looking for a relaxing swim, a delicious meal with loved ones, or a place to celebrate special occasions, Caldera offers the perfect setting. Our pool area is well-maintained, our restaurant serves authentic Indonesian and international cuisine, and our staff is always ready to serve you with a smile.</p>
                <div class="mt-4">
                    <a href="<?php echo e(route('branding.about')); ?>" class="btn btn-gold">
                        Learn More <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="atmosphere-gallery">
                    <img src="<?php echo e(asset('storage/galleries/about.jpeg')); ?>" alt="Caldera Atmosphere" class="img-fluid rounded-4 shadow-lg">
                </div>
            </div>
        </div>
    </div>
</section>


<section class="featured-menu-section py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title fw-bold">Discover What's New</h2>
            <div class="section-divider"></div>
            <p class="section-subtitle text-muted">Fresh flavors, new creations, and fan favorites</p>
        </div>

        <div class="row g-4">
            <?php
                $featuredMenus = Cache::remember('homepage_featured_menus', 3600, function () {
                    return \App\Models\Menu::where('is_available', true)
                                    ->where('is_recommended', true)
                                    ->latest()
                                    ->take(4)
                                    ->get();
                });
            ?>
            
            <?php $__empty_1 = true; $__currentLoopData = $featuredMenus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="col-md-3 col-sm-6">
                <div class="menu-card-featured text-center">
                    <div class="menu-img-wrapper mb-3">
                        <?php if($menu->image && Storage::disk('public')->exists($menu->image)): ?>
                            <img src="<?php echo e(asset('storage/' . $menu->image)); ?>" 
                                 alt="<?php echo e($menu->name); ?>"
                                 style="width: 80px; height: 80px; object-fit: cover; border-radius: 50%; border: 2px solid #c1a067;">
                        <?php else: ?>
                            <i class="fas fa-utensils fa-3x" style="color: #c1a067;"></i>
                        <?php endif; ?>
                    </div>
                    <h5 class="fw-bold"><?php echo e($menu->name); ?></h5>
                    <p class="text-muted small"><?php echo e(Str::limit($menu->description, 60)); ?></p>
                    <div class="price">Rp <?php echo e(number_format($menu->price, 0, ',', '.')); ?></div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-12 text-center">
                <p class="text-muted">No featured menus available</p>
            </div>
            <?php endif; ?>
        </div>

        <div class="text-center mt-4">
            <a href="<?php echo e(route('branding.menu')); ?>" class="btn btn-gold">
                View Full Menu <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>


<section class="testimonials-section py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title fw-bold">What Our Customers Say</h2>
            <div class="section-divider"></div>
            <p class="section-subtitle text-muted">Real experiences from real people</p>
        </div>

        <div class="row g-4">
            <?php
                // PERBAIKAN: Gunakan kolom is_approved (boolean)
                $testimonials = Cache::remember('homepage_testimonials', 3600, function () {
                    return \App\Models\Testimonial::where('is_approved', true)
                                    ->where('is_featured', true)  // Ambil yang difeatured dulu
                                    ->latest()
                                    ->take(3)
                                    ->get();
                });
                
                // Jika kurang dari 3, ambil dari yang approved lainnya
                if ($testimonials->count() < 3) {
                    $moreTestimonials = \App\Models\Testimonial::where('is_approved', true)
                                    ->whereNotIn('id', $testimonials->pluck('id'))
                                    ->latest()
                                    ->take(3 - $testimonials->count())
                                    ->get();
                    $testimonials = $testimonials->merge($moreTestimonials);
                }
            ?>
            
            <?php $__empty_1 = true; $__currentLoopData = $testimonials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $testimonial): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="col-md-4">
                <div class="testimonial-card">
                    <div class="testimonial-quote mb-3">
                        <i class="fas fa-quote-left fa-2x" style="color: #c1a067; opacity: 0.3;"></i>
                    </div>
                    <div class="testimonial-rating mb-2">
                        <?php for($i = 1; $i <= 5; $i++): ?>
                            <?php if($i <= $testimonial->rating): ?>
                                <i class="fas fa-star" style="color: #c1a067;"></i>
                            <?php else: ?>
                                <i class="far fa-star" style="color: #c1a067;"></i>
                            <?php endif; ?>
                        <?php endfor; ?>
                    </div>
                    <p class="testimonial-comment">"<?php echo e(Str::limit($testimonial->comment, 120)); ?>"</p>
                    <div class="testimonial-author">
                        <div class="d-flex align-items-center">
                            <?php if($testimonial->customer_photo): ?>
                                <img src="<?php echo e(asset('storage/' . $testimonial->customer_photo)); ?>" 
                                     class="rounded-circle me-2" 
                                     width="32" height="32"
                                     style="object-fit: cover;">
                            <?php else: ?>
                                <div class="rounded-circle bg-light me-2 d-flex align-items-center justify-content-center"
                                     style="width: 32px; height: 32px;">
                                    <i class="fas fa-user fa-sm" style="color: #c1a067;"></i>
                                </div>
                            <?php endif; ?>
                            <div>
                                <h6 class="fw-bold mb-0"><?php echo e($testimonial->customer_name); ?></h6>
                                <small class="text-muted">
                                    <?php if($testimonial->service_type): ?>
                                        <?php echo e(ucfirst($testimonial->service_type)); ?> Visitor
                                    <?php else: ?>
                                        Customer
                                    <?php endif; ?>
                                    • <?php echo e($testimonial->created_at->diffForHumans()); ?>

                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-12 text-center">
                <div class="testimonial-card p-4">
                    <i class="fas fa-star fa-3x mb-3" style="color: #c1a067; opacity: 0.4;"></i>
                    <p class="text-muted">No testimonials yet. Be the first to write a review!</p>
                    <a href="<?php echo e(route('branding.testimonials.create')); ?>" class="btn btn-gold btn-sm">
                        <i class="fas fa-star me-2"></i> Write a Review
                    </a>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <div class="text-center mt-4">
            <a href="<?php echo e(route('branding.testimonials')); ?>" class="btn btn-outline-gold">
                Read All Reviews <i class="fas fa-arrow-right ms-2"></i>
            </a>
            <a href="<?php echo e(route('branding.testimonials.create')); ?>" class="btn btn-gold ms-2">
                <i class="fas fa-star me-2"></i> Write a Review
            </a>
        </div>
    </div>
</section>


<section class="events-section py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title fw-bold">Events Not to Be Missed</h2>
            <div class="section-divider"></div>
            <p class="section-subtitle text-muted">Get in on the action at Caldera</p>
        </div>

        <div class="row g-4 justify-content-center">
            <?php
                $events = Cache::remember('homepage_events', 3600, function () {
                    return \App\Models\Promo::where('promo_type', 'event')
                                    ->where('is_active', true)
                                    ->whereDate('end_date', '>=', now())
                                    ->latest()
                                    ->take(3)
                                    ->get();
                });
            ?>
            
            <?php if($events->count() > 0): ?>
                <?php $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-4">
                    <div class="event-card">
                        <div class="event-icon mb-3">
                            <i class="fas fa-calendar-alt fa-3x" style="color: #c1a067;"></i>
                        </div>
                        <h5 class="fw-bold"><?php echo e($event->title); ?></h5>
                        <p class="text-muted"><?php echo e(Str::limit($event->description, 80)); ?></p>
                        <span class="badge bg-gold">
                            <?php echo e(\Carbon\Carbon::parse($event->start_date)->format('d M')); ?> - 
                            <?php echo e(\Carbon\Carbon::parse($event->end_date)->format('d M Y')); ?>

                        </span>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
                <div class="col-md-4">
                    <div class="event-card">
                        <div class="event-icon mb-3">
                            <i class="fas fa-music fa-3x" style="color: #c1a067;"></i>
                        </div>
                        <h5 class="fw-bold">Live Music Every Friday</h5>
                        <p class="text-muted">Enjoy live acoustic performances<br>7 PM - 10 PM</p>
                        <span class="badge bg-gold">Free Entry</span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="event-card">
                        <div class="event-icon mb-3">
                            <i class="fas fa-birthday-cake fa-3x" style="color: #c1a067;"></i>
                        </div>
                        <h5 class="fw-bold">Birthday Celebration</h5>
                        <p class="text-muted">Book your special day with us<br>Get special discounts</p>
                        <span class="badge bg-gold">Free Cake</span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="event-card">
                        <div class="event-icon mb-3">
                            <i class="fas fa-glass-cheers fa-3x" style="color: #c1a067;"></i>
                        </div>
                        <h5 class="fw-bold">Family Gathering</h5>
                        <p class="text-muted">Special package for family events<br>Call for reservation</p>
                        <span class="badge bg-gold">Best Offer</span>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    /* Hero Section */
    .hero-section {
        background-size: cover;
        background-position: center;
        min-height: 600px;
        position: relative;
    }

    .hero-title {
        font-family: 'Playfair Display', serif;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
    }

    .gold-text {
        color: #c1a067;
    }

    /* Buttons */
    .btn-primary {
        background: #c1a067;
        border: none;
        border-radius: 30px;
        padding: 12px 30px;
        font-weight: 600;
        transition: all 0.3s;
    }

    .btn-primary:hover {
        background: #a8894f;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(193,160,103,0.3);
    }

    .btn-outline-light {
        border: 2px solid white;
        border-radius: 30px;
        padding: 12px 30px;
        font-weight: 600;
        transition: all 0.3s;
    }

    .btn-outline-light:hover {
        background: white;
        color: #1c3451;
        transform: translateY(-2px);
    }

    /* Section Styles */
    .section-title {
        font-family: 'Playfair Display', serif;
        color: #1c3451;
        font-size: 2.2rem;
    }

    .section-divider {
        width: 60px;
        height: 3px;
        background: #c1a067;
        margin: 12px auto;
        border-radius: 2px;
    }

    .section-divider-left {
        width: 60px;
        height: 3px;
        background: #c1a067;
        margin: 12px 0;
        border-radius: 2px;
    }

    /* Offer Cards */
    .offer-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(28,52,81,0.08);
        transition: transform 0.3s, box-shadow 0.3s;
        height: 100%;
        border-top: 3px solid #c1a067;
    }

    .offer-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 30px rgba(28,52,81,0.12);
    }

    .offer-day {
        background: #c1a067;
        color: white;
        display: inline-block;
        padding: 5px 15px;
        border-radius: 20px;
        font-weight: bold;
        font-size: 12px;
        margin-bottom: 15px;
    }

    .offer-title {
        font-size: 1.2rem;
        font-weight: bold;
        color: #1c3451;
        margin-bottom: 10px;
    }

    .offer-price {
        font-size: 1.3rem;
        font-weight: bold;
        color: #c1a067;
        margin-bottom: 10px;
    }

    .offer-desc {
        color: #6c757d;
        font-size: 0.9rem;
        margin-bottom: 10px;
    }

    .offer-badge {
        background: #f8f6f2;
        padding: 5px 10px;
        border-radius: 15px;
        font-size: 11px;
        color: #6c757d;
    }

    .btn-gold {
        background: #c1a067;
        color: white;
        border: none;
        border-radius: 30px;
        padding: 12px 30px;
        font-weight: 600;
        transition: all 0.3s;
    }

    .btn-gold:hover {
        background: #a8894f;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(193,160,103,0.3);
    }

    .btn-outline-gold {
        border: 2px solid #c1a067;
        color: #c1a067;
        background: transparent;
        border-radius: 30px;
        padding: 10px 25px;
        font-weight: 600;
        transition: all 0.3s;
    }

    .btn-outline-gold:hover {
        background: #c1a067;
        color: white;
        transform: translateY(-2px);
    }

    /* Featured Menu */
    .menu-card-featured {
        background: white;
        border-radius: 16px;
        padding: 20px;
        transition: all 0.3s;
        height: 100%;
        border: 1px solid #e8e0d0;
    }

    .menu-card-featured:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(28,52,81,0.1);
        border-color: #c1a067;
    }

    .menu-card-featured .price {
        color: #c1a067;
        font-weight: bold;
        font-size: 1.1rem;
        margin-top: 10px;
    }

    /* Testimonial Cards */
    .testimonial-card {
        background: white;
        border-radius: 16px;
        padding: 25px;
        transition: all 0.3s;
        height: 100%;
        border: 1px solid #e8e0d0;
    }

    .testimonial-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(28,52,81,0.1);
        border-color: #c1a067;
    }

    .testimonial-comment {
        font-style: italic;
        color: #4a5568;
        line-height: 1.6;
        margin-bottom: 15px;
    }

    .testimonial-rating {
        margin-bottom: 10px;
    }

    /* Event Cards */
    .event-card {
        background: white;
        border-radius: 16px;
        padding: 25px;
        text-align: center;
        transition: all 0.3s;
        height: 100%;
        border: 1px solid #e8e0d0;
    }

    .event-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(28,52,81,0.1);
        border-color: #c1a067;
    }

    .badge.bg-gold {
        background: #c1a067;
        color: white;
        padding: 5px 12px;
        border-radius: 20px;
        font-weight: 500;
    }

    /* Atmosphere Section */
    .atmosphere-section {
        background: #f8f6f2;
    }

    .bg-light {
        background-color: #f8f9fa !important;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .hero-section {
            min-height: 450px;
        }
        .hero-title {
            font-size: 2rem;
        }
        .hero-subtitle {
            font-size: 1rem;
        }
        .section-title {
            font-size: 1.6rem;
        }
        .btn-primary, .btn-outline-light, .btn-gold, .btn-outline-gold {
            padding: 8px 20px;
            font-size: 0.9rem;
        }
    }

    /* Dark Mode Support */
    body.dark-mode .offer-card,
    body.dark-mode .menu-card-featured,
    body.dark-mode .testimonial-card,
    body.dark-mode .event-card {
        background: #1e1e2a;
        border-color: #2d2d3a;
    }

    body.dark-mode .offer-card:hover,
    body.dark-mode .menu-card-featured:hover,
    body.dark-mode .testimonial-card:hover,
    body.dark-mode .event-card:hover {
        border-color: #c1a067;
    }

    body.dark-mode .atmosphere-section {
        background: #161622;
    }

    body.dark-mode .bg-light {
        background-color: #1a1a2a !important;
    }
</style>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PA_03\PA2\resources\views/pages/home.blade.php ENDPATH**/ ?>