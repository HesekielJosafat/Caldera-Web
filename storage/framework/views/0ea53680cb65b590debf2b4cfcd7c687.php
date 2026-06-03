<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title'); ?> - Caldera Admin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">

    <style>
        * { font-family: 'Poppins', sans-serif; }

        body { background: #f0f2f5; }

        /* ── SIDEBAR ── */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 240px;
            height: 100vh;
            background: #1c3451;
            z-index: 1000;
            transition: all 0.3s;
            box-shadow: 2px 0 12px rgba(0,0,0,0.15);
            display: flex;
            flex-direction: column;
        }

        .sidebar-header {
            padding: 28px 20px 20px;
            text-align: center;
            border-bottom: 1px solid rgba(193,160,103,0.2);
        }

        .sidebar-brand {
            font-family: 'Playfair Display', serif;
            color: #c1a067;
            font-size: 1.2rem;
            font-weight: 700;
            line-height: 1.3;
            text-decoration: none;
            display: block;
        }

        .sidebar-brand:hover { color: #c1a067; }

        .sidebar-subtitle {
            color: rgba(255,255,255,0.45);
            font-size: 11px;
            margin: 6px 0 0;
        }

        .sidebar-nav {
            padding: 16px 0;
            flex: 1;
            overflow-y: auto;
        }

        .sidebar-nav .nav-link {
            color: rgba(255,255,255,0.65);
            padding: 11px 22px;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 14px;
            font-weight: 500;
            border-left: 3px solid transparent;
        }

        .sidebar-nav .nav-link i {
            width: 18px;
            font-size: 15px;
            color: rgba(193,160,103,0.6);
            transition: color 0.2s;
        }

        .sidebar-nav .nav-link:hover {
            background: rgba(193,160,103,0.08);
            color: #ffffff;
            border-left: 3px solid rgba(193,160,103,0.4);
        }

        .sidebar-nav .nav-link:hover i {
            color: #c1a067;
        }

        .sidebar-nav .nav-link.active {
            background: rgba(193,160,103,0.15);
            color: #ffffff;
            border-left: 3px solid #c1a067;
        }

        .sidebar-nav .nav-link.active i {
            color: #c1a067;
        }

        .sidebar-divider {
            border-color: rgba(255,255,255,0.1);
            margin: 8px 22px;
        }

        .sidebar-logout {
            padding: 16px 22px;
            border-top: 1px solid rgba(193,160,103,0.15);
        }

        .sidebar-logout button {
            background: none;
            border: none;
            width: 100%;
            text-align: left;
            color: rgba(255,255,255,0.5);
            font-size: 14px;
            font-weight: 500;
            padding: 10px 0;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: color 0.2s;
            cursor: pointer;
        }

        .sidebar-logout button i {
            width: 18px;
            color: rgba(193,160,103,0.5);
        }

        .sidebar-logout button:hover {
            color: #ff6b6b;
        }

        .sidebar-logout button:hover i {
            color: #ff6b6b;
        }

        /* ── MAIN CONTENT ── */
        .main-content {
            margin-left: 240px;
            min-height: 100vh;
        }

        /* ── TOPBAR ── */
        .topbar {
            background: white;
            padding: 14px 28px;
            box-shadow: 0 1px 8px rgba(0,0,0,0.06);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .topbar-title {
            margin: 0;
            font-weight: 600;
            font-size: 16px;
            color: #1c3451;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #1c3451;
            font-weight: 500;
            font-size: 14px;
        }

        .user-info i {
            font-size: 22px;
            color: #c1a067;
        }

        /* 🔥 NOTIFIKASI DROPDOWN 🔥 */
        .notif-icon {
            position: relative;
            cursor: pointer;
            background: rgba(0,0,0,0.05);
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.2s;
        }

        .notif-icon:hover {
            background: rgba(0,0,0,0.1);
        }

        .notif-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #dc2626;
            color: white;
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 10px;
            font-weight: 600;
            min-width: 18px;
            text-align: center;
        }

        .notification-dropdown {
            width: 360px;
            max-height: 450px;
            overflow-y: auto;
            border-radius: 12px;
            padding: 0;
            margin-top: 8px;
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }

        .notification-item {
            padding: 12px 16px;
            border-bottom: 1px solid #f0ebe0;
            transition: background 0.2s;
            text-decoration: none;
            display: block;
            cursor: pointer;
        }

        .notification-item:hover {
            background: #f9f7f3;
        }

        .notification-item.unread {
            background: #f0ebe0;
        }

        .notification-icon {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
        }

        .notification-icon.primary { background: #e6f0ff; color: #1c3451; }
        .notification-icon.success { background: #e6f7e6; color: #2e7d32; }
        .notification-icon.danger { background: #ffe6e6; color: #dc2626; }
        .notification-icon.warning { background: #fff3e6; color: #ed6c02; }
        .notification-icon.info { background: #e6f7ff; color: #0288d1; }

        .notification-title {
            font-weight: 600;
            font-size: 13px;
            color: #1c3451;
            margin-bottom: 4px;
        }

        .notification-body {
            font-size: 12px;
            color: #6b7280;
            margin-bottom: 4px;
            line-height: 1.4;
        }

        .notification-time {
            font-size: 10px;
            color: #9ca3af;
        }

        /* ── CONTENT WRAPPER ── */
        .content-wrapper {
            padding: 24px 28px;
        }

        /* ── STAT CARDS ── */
        .card {
            border: none !important;
            border-radius: 14px !important;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06) !important;
        }

        .icon.icon-shape {
            width: 48px;
            height: 48px;
            border-radius: 12px !important;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .bg-gradient-primary { background: linear-gradient(135deg, #1c3451, #01516e) !important; }
        .bg-gradient-success { background: linear-gradient(135deg, #15803d, #16a34a) !important; }
        .bg-gradient-warning { background: linear-gradient(135deg, #c1a067, #a8894f) !important; }
        .bg-gradient-danger  { background: linear-gradient(135deg, #dc2626, #b91c1c) !important; }
        .bg-gradient-info    { background: linear-gradient(135deg, #0e7490, #0891b2) !important; }

        /* Alert */
        .alert-success {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            color: #15803d;
            border-radius: 10px;
        }

        .alert-danger {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #dc2626;
            border-radius: 10px;
        }

        /* Table */
        .table thead th {
            background: #f8f9fa;
            color: #1c3451;
            font-weight: 600;
            font-size: 12px;
            letter-spacing: 0.5px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar { left: -240px; }
            .main-content { margin-left: 0; }
            .sidebar.show { left: 0; }
            .notification-dropdown { width: 320px; right: -50px; }
        }
    </style>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="sidebar-brand">
                Caldera Resto<br>& Pool
            </a>
            <p class="sidebar-subtitle">Admin Panel</p>
        </div>

        <div class="sidebar-nav">
            <nav class="nav flex-column">
                <a href="<?php echo e(route('admin.dashboard')); ?>"
                   class="nav-link <?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>">
                    <i class="fas fa-home"></i> Dashboard
                </a>
                <a href="<?php echo e(route('admin.menus.index')); ?>"
                   class="nav-link <?php echo e(request()->routeIs('admin.menus.*') ? 'active' : ''); ?>">
                    <i class="fas fa-utensils"></i> Menu
                </a>
                <a href="<?php echo e(route('admin.reports.index')); ?>"
                   class="nav-link <?php echo e(request()->routeIs('admin.reports.*') ? 'active' : ''); ?>">
                    <i class="fas fa-chart-line"></i> Report
                </a>
                <a href="<?php echo e(route('admin.tickets.index')); ?>"
                   class="nav-link <?php echo e(request()->routeIs('admin.tickets.*') ? 'active' : ''); ?>">
                    <i class="fas fa-swimming-pool"></i> Facilities
                </a>
                <a href="<?php echo e(route('admin.reservations.index')); ?>"
                   class="nav-link <?php echo e(request()->routeIs('admin.reservations.*') ? 'active' : ''); ?>">
                    <i class="fas fa-calendar-check"></i> Reservation
                </a>
                <a href="<?php echo e(route('admin.galleries.index')); ?>"
                   class="nav-link <?php echo e(request()->routeIs('admin.galleries.*') ? 'active' : ''); ?>">
                    <i class="fas fa-images"></i> Gallery
                </a>
                <a href="<?php echo e(route('admin.testimonials.index')); ?>"
                   class="nav-link <?php echo e(request()->routeIs('admin.testimonials.*') ? 'active' : ''); ?>">
                    <i class="fas fa-comment-dots"></i> Testimonial
                </a>
                <a href="<?php echo e(route('admin.promos.index')); ?>"
                   class="nav-link <?php echo e(request()->routeIs('admin.promos.*') ? 'active' : ''); ?>">
                    <i class="fas fa-tags"></i> Promos
                </a>
            </nav>
        </div>

        <div class="sidebar-logout">
            <form method="POST" action="<?php echo e(route('admin.logout')); ?>">
                <?php echo csrf_field(); ?>
                <button type="submit">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="topbar">
            <button class="btn btn-sm btn-light d-md-none me-2" id="sidebarToggle">
                <i class="fas fa-bars"></i>
            </button>
            <h5 class="topbar-title"><?php echo $__env->yieldContent('title'); ?></h5>
            <div class="d-flex align-items-center gap-3">
                <!-- 🔥 NOTIFIKASI ADMIN 🔥 -->
                <?php if(auth()->guard()->check()): ?>
                <div class="dropdown">
                    <div class="notif-icon" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                        <i class="fas fa-bell" style="color: #1c3451; font-size: 18px;"></i>
                        <span id="adminNotifBadge" class="notif-badge" style="<?php echo e(Auth::user()->unreadNotifications->count() > 0 ? '' : 'display: none;'); ?>">
                            <?php echo e(Auth::user()->unreadNotifications->count()); ?>

                        </span>
                    </div>
                    <div class="dropdown-menu dropdown-menu-end notification-dropdown">
                        <div class="dropdown-header d-flex justify-content-between align-items-center px-3 py-2 border-bottom" style="background: #fff;">
                            <span class="fw-bold" style="font-size: 14px; color: #1c3451;">
                                <i class="fas fa-bell me-2" style="color: #c1a067;"></i>Notifikasi
                            </span>
                            <form action="<?php echo e(route('admin.notifications.mark-all-read')); ?>" method="POST" id="adminMarkAllReadForm">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn btn-sm btn-link p-0" style="font-size: 11px; color: #c1a067; text-decoration: none;">
                                    Tandai semua dibaca
                                </button>
                            </form>
                        </div>
                        <div id="adminNotificationList" style="max-height: 400px; overflow-y: auto;">
                            <?php $__empty_1 = true; $__currentLoopData = Auth::user()->notifications()->latest()->take(15)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notif): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <div class="notification-item <?php echo e($notif->read_at ? '' : 'unread'); ?>" data-id="<?php echo e($notif->id); ?>">
                                    <div class="d-flex">
                                        <div class="me-3">
                                            <div class="notification-icon <?php echo e($notif->data['color'] ?? 'primary'); ?>">
                                                <i class="fas <?php echo e($notif->data['icon'] ?? 'fa-bell'); ?>"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="notification-title"><?php echo e($notif->data['title']); ?></div>
                                            <div class="notification-body"><?php echo e($notif->data['body']); ?></div>
                                            <div class="notification-time"><?php echo e($notif->created_at->diffForHumans()); ?></div>
                                        </div>
                                        <?php if(!$notif->read_at): ?>
                                            <div>
                                                <form action="<?php echo e(route('admin.notifications.mark-read', $notif->id)); ?>" method="POST" class="admin-mark-read-form">
                                                    <?php echo csrf_field(); ?>
                                                    <button type="submit" class="btn btn-sm btn-link p-0" style="color: #c1a067;">
                                                        <i class="fas fa-check-circle"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php if(!$loop->last): ?>
                                    <div class="dropdown-divider m-0"></div>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <div class="text-center py-4">
                                    <i class="fas fa-bell-slash text-muted mb-2" style="font-size: 28px;"></i>
                                    <p class="text-muted mb-0" style="font-size: 13px;">Belum ada notifikasi</p>
                                </div>
                            <?php endif; ?>
                        </div>
                        <?php if(Auth::user()->notifications()->count() > 0): ?>
                            <div class="border-top text-center py-2">
                                <a href="<?php echo e(route('admin.notifications.index')); ?>" class="small" style="color: #c1a067; text-decoration: none;">
                                    Lihat semua notifikasi <i class="fas fa-arrow-right ms-1"></i>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>

                <div class="user-info">
                    <span><?php echo e(Auth::user()->name); ?></span>
                    <i class="fas fa-user-circle"></i>
                </div>
            </div>
        </div>

        <div class="content-wrapper">
            <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i><?php echo e(session('success')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if(session('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i><?php echo e(session('error')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Sidebar toggle untuk mobile
        document.getElementById('sidebarToggle')?.addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('show');
        });

        // 🔥 Auto refresh notifikasi admin (opsional, setiap 30 detik)
        function refreshAdminNotifications() {
            fetch('<?php echo e(route("admin.notifications.latest")); ?>')
                .then(response => response.json())
                .then(data => {
                    const badge = document.getElementById('adminNotifBadge');
                    if (badge) {
                        if (data.count > 0) {
                            badge.textContent = data.count;
                            badge.style.display = '';
                        } else {
                            badge.style.display = 'none';
                        }
                    }
                })
                .catch(err => console.log('Error fetching admin notifications:', err));
        }

        // Refresh setiap 30 detik (opsional, aktifkan jika perlu)
        // setInterval(refreshAdminNotifications, 30000);
    </script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH D:\PA_03\PA2\resources\views/layouts/admin.blade.php ENDPATH**/ ?>