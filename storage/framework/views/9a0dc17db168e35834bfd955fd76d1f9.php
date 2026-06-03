

<?php $__env->startSection('title', 'My Reservations - Caldera'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <!-- Header -->
    <div class="text-center mb-5">
        <h1 class="display-4 fw-bold mb-2" style="font-family: 'Playfair Display', serif; color: #1c3451;">My Reservations</h1>
        <div class="section-divider"></div>
        <p class="lead text-muted">Manage your table bookings</p>
    </div>

    <div class="row g-4">
        <!-- Sidebar Profile -->
        <div class="col-md-4 col-lg-3">
            <div class="card border-0 shadow-sm caldera-card">
                <div class="card-body text-center p-4">
                    <div class="profile-avatar mb-3">
                        <img src="https://ui-avatars.com/api/?name=<?php echo e(Auth::user()->name); ?>&background=1c3451&color=c1a067&size=100&rounded=true" 
                             class="rounded-circle" 
                             width="90" 
                             height="90"
                             style="border: 3px solid #c1a067; padding: 3px;">
                    </div>
                    <h5 class="fw-bold mb-1" style="color: #1c3451;"><?php echo e(Auth::user()->name); ?></h5>
                    <p class="text-muted small mb-3"><?php echo e(Auth::user()->email); ?></p>
                    
                    <hr class="my-3" style="border-color: #f0ebe0;">
                    
                    <div class="d-grid gap-2">
                        <a href="<?php echo e(route('customer.profile')); ?>" class="btn btn-sidebar">
                            <i class="fas fa-user me-2"></i> My Profile
                        </a>
                        <a href="<?php echo e(route('customer.reservations')); ?>" class="btn btn-sidebar active">
                            <i class="fas fa-calendar-alt me-2"></i> My Reservations
                        </a>
                        <a href="<?php echo e(route('customer.tickets')); ?>" class="btn btn-sidebar">
                            <i class="fas fa-ticket-alt me-2"></i> My Tickets
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-8 col-lg-9">
            <div class="card border-0 shadow-sm caldera-card">
                <div class="card-header bg-transparent border-bottom-0 pt-4 px-4">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <h5 class="mb-0 fw-bold" style="color: #1c3451; font-family: 'Playfair Display', serif; font-size: 1.3rem;">
                            <i class="fas fa-calendar-alt me-2" style="color: #c1a067;"></i> Booking History
                        </h5>
                        <span class="badge" style="background: #f0ebe0; color: #1c3451; padding: 8px 16px; border-radius: 20px;">
                            <i class="fas fa-chart-line me-1"></i> Total: <?php echo e($reservations->total()); ?> Reservations
                        </span>
                    </div>
                </div>
                
                <div class="card-body p-4">
                    <?php $__empty_1 = true; $__currentLoopData = $reservations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reservation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>  
                    <div class="reservation-item mb-3">
                        <div class="row align-items-center g-3">
                            <div class="col-lg-3 col-md-12">
                                <div class="booking-code">
                                    <small class="text-muted text-uppercase fw-semibold">Booking Code</small>
                                    <p class="fw-bold mb-0" style="color: #1c3451; font-size: 1rem;">
                                        <i class="fas fa-tag me-1" style="color: #c1a067; font-size: 12px;"></i>
                                        <?php echo e($reservation->booking_code); ?>

                                    </p>
                                </div>
                            </div>
                            
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="date-time">
                                    <small class="text-muted text-uppercase fw-semibold">Date & Time</small>
                                    <p class="mb-0 fw-semibold" style="color: #1c3451;">
                                        <i class="fas fa-calendar-day me-1" style="color: #c1a067;"></i>
                                        <?php echo e(\Carbon\Carbon::parse($reservation->reservation_date)->format('d M Y')); ?>

                                    </p>
                                    <small class="text-muted">
                                        <i class="far fa-clock me-1"></i><?php echo e($reservation->reservation_time); ?>

                                    </small>
                                </div>
                            </div>
                            
                            <div class="col-lg-2 col-md-4 col-sm-6">
                                <div class="guests">
                                    <small class="text-muted text-uppercase fw-semibold">Guests</small>
                                    <p class="mb-0 fw-semibold" style="color: #1c3451;">
                                        <i class="fas fa-users me-1" style="color: #c1a067;"></i>
                                        <?php echo e($reservation->number_of_guests); ?> people
                                    </p>
                                </div>
                            </div>
                            
                            <div class="col-lg-2 col-md-4 col-sm-6">
                                <div class="status">
                                    <small class="text-muted text-uppercase fw-semibold">Status</small>
                                    <div class="mt-1">
                                        <?php
                                            $statusClass = match($reservation->status) {
                                                'confirmed' => 'status-confirmed',
                                                'pending' => 'status-pending',
                                                'cancelled' => 'status-cancelled',
                                                'completed' => 'status-completed',
                                                default => 'status-default'
                                            };
                                            $statusText = match($reservation->status) {
                                                'confirmed' => 'Confirmed',
                                                'pending' => 'Pending',
                                                'cancelled' => 'Cancelled',
                                                'completed' => 'Completed',
                                                default => ucfirst($reservation->status)
                                            };
                                        ?>
                                        <span class="status-badge <?php echo e($statusClass); ?>">
                                            <i class="fas 
                                                <?php if($reservation->status == 'confirmed'): ?> fa-check-circle
                                                <?php elseif($reservation->status == 'pending'): ?> fa-clock
                                                <?php elseif($reservation->status == 'cancelled'): ?> fa-times-circle
                                                <?php elseif($reservation->status == 'completed'): ?> fa-check-double
                                                <?php else: ?> fa-info-circle
                                                <?php endif; ?> me-1"></i>
                                            <?php echo e($statusText); ?>

                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-lg-2 col-md-12">
                                <a href="<?php echo e(route('reservation.table.view', $reservation->booking_code)); ?>" 
                                   class="btn btn-detail w-100">
                                    <i class="fas fa-eye me-1"></i> Details
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="empty-state text-center py-5">
                        <div class="empty-icon mb-4">
                            <i class="fas fa-calendar-alt fa-4x" style="color: #c1a067; opacity: 0.4;"></i>
                        </div>
                        <h5 style="color: #1c3451; font-family: 'Playfair Display', serif;">No Reservations Yet</h5>
                        <p class="text-muted mb-4">You haven't made any table reservations.</p>
                        <a href="<?php echo e(route('reservation.table')); ?>" class="btn btn-book">
                            <i class="fas fa-plus me-2"></i> Book a Table Now
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
                
                <!-- Pagination -->
                <?php if($reservations->hasPages()): ?>
                <div class="card-footer bg-transparent border-top-0 pb-4 px-4">
                    <?php echo e($reservations->links()); ?>

                </div>
                <?php endif; ?>
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
        width: 50px;
        height: 3px;
        background: #c1a067;
        margin: 12px auto 16px;
        border-radius: 2px;
    }

    .caldera-card {
        border-radius: 20px !important;
        overflow: hidden;
        transition: transform 0.25s, box-shadow 0.25s;
    }

    .caldera-card:hover {
        box-shadow: 0 12px 28px rgba(28,52,81,0.12) !important;
    }

    /* Sidebar Buttons */
    .btn-sidebar {
        background: white;
        color: #1c3451;
        border: 1.5px solid #e8e0d0;
        border-radius: 12px;
        padding: 10px 16px;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.2s;
        text-align: left;
    }

    .btn-sidebar:hover {
        background: #1c3451;
        color: white;
        border-color: #1c3451;
        transform: translateX(4px);
    }

    .btn-sidebar.active {
        background: linear-gradient(135deg, #1c3451, #01516e);
        color: white;
        border-color: #1c3451;
        box-shadow: 0 4px 12px rgba(28,52,81,0.2);
    }

    /* Reservation Item */
    .reservation-item {
        background: white;
        border: 1px solid #f0ebe0;
        border-radius: 16px;
        padding: 20px;
        transition: all 0.25s;
        position: relative;
        overflow: hidden;
    }

    .reservation-item::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        width: 4px;
        height: 100%;
        background: #c1a067;
        opacity: 0;
        transition: opacity 0.25s;
    }

    .reservation-item:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 24px rgba(28,52,81,0.1);
        border-color: #c1a067;
    }

    .reservation-item:hover::before {
        opacity: 1;
    }

    .reservation-item small.text-muted {
        font-size: 11px;
        letter-spacing: 0.5px;
        font-weight: 600;
    }

    .booking-code p,
    .date-time p,
    .guests p {
        margin-top: 4px;
    }

    /* Status Badges */
    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        gap: 6px;
    }

    .status-confirmed {
        background: #e8f5e9;
        color: #2e7d32;
    }

    .status-pending {
        background: #fff3e0;
        color: #e65100;
    }

    .status-cancelled {
        background: #ffebee;
        color: #c62828;
    }

    .status-completed {
        background: #e3f2fd;
        color: #1565c0;
    }

    .status-default {
        background: #f0ebe0;
        color: #1c3451;
    }

    /* Detail Button */
    .btn-detail {
        background: white;
        color: #1c3451;
        border: 1.5px solid #1c3451;
        border-radius: 10px;
        padding: 8px 16px;
        font-weight: 600;
        font-size: 13px;
        transition: all 0.2s;
    }

    .btn-detail:hover {
        background: #1c3451;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(28,52,81,0.2);
    }

    /* Book Button */
    .btn-book {
        background: linear-gradient(135deg, #1c3451, #01516e);
        color: white;
        border: none;
        border-radius: 12px;
        padding: 12px 28px;
        font-weight: 600;
        transition: all 0.2s;
    }

    .btn-book:hover {
        background: linear-gradient(135deg, #c1a067, #a8894f);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(193,160,103,0.3);
    }

    /* Empty State */
    .empty-state {
        padding: 60px 20px;
    }

    .empty-icon {
        animation: fadeInUp 0.5s ease;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Responsive */
    @media (max-width: 768px) {
        .reservation-item {
            padding: 16px;
        }
        
        .btn-sidebar {
            text-align: center;
        }
        
        .btn-sidebar:hover {
            transform: translateY(-2px);
        }
        
        .card-header .d-flex {
            flex-direction: column;
            align-items: flex-start !important;
        }
    }

    /* Dark Mode */
    body.dark-mode .reservation-item {
        background: #1e1e2a;
        border-color: #2d2d3a;
    }

    body.dark-mode .reservation-item:hover {
        border-color: #c1a067;
    }

    body.dark-mode .btn-sidebar {
        background: #1e1e2a;
        border-color: #2d2d3a;
        color: #dce8f0;
    }

    body.dark-mode .btn-sidebar:hover {
        background: #c1a067;
        color: #1c3451;
    }

    body.dark-mode .btn-sidebar.active {
        background: linear-gradient(135deg, #c1a067, #a8894f);
        color: #1c3451;
    }

    body.dark-mode .btn-detail {
        background: #1e1e2a;
        border-color: #c1a067;
        color: #c1a067;
    }

    body.dark-mode .btn-detail:hover {
        background: #c1a067;
        color: #1c3451;
    }

    body.dark-mode .status-pending {
        background: #1a2a1a;
        color: #ffb74d;
    }

    body.dark-mode .status-confirmed {
        background: #1a2a1a;
        color: #81c784;
    }

    body.dark-mode .status-cancelled {
        background: #2a1a1a;
        color: #ef9a9a;
    }
</style>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\PA2_Kel6\resources\views/customer/reservations.blade.php ENDPATH**/ ?>