<!-- HEADER UTAMA -->
<header>
    <!-- BARIS 1: BRANDING (Navy) -->
    <div style="background-color: #1c3451; padding: 20px 0;">
        <div class="container">
            <div class="row align-items-center">
                <!-- Logo/Judul -->
                <div class="col-6 col-md-5">
                    <a href="{{ route('branding.home') }}" style="text-decoration: none;">
                        <div style="font-family: 'Playfair Display', serif; color: #c1a067; line-height: 1.2; font-weight: 700; font-size: 1.6rem;">
                            Caldera Resto<br>& Pool
                        </div>
                    </a>
                </div>
                
                <!-- Search + Auth + Notifikasi -->
                <div class="col-6 col-md-7 d-flex align-items-center justify-content-end gap-2">

                    @auth
                        <!-- 🔥 NOTIFIKASI BELL ICON 🔥 -->
                        <div class="dropdown">
                            <button class="btn btn-sm dropdown-toggle position-relative" 
                               style="background: rgba(255,255,255,0.15); color: #c1a067; border: 1px solid rgba(193,160,103,0.5); font-size: 13px; border-radius: 20px; padding: 6px 12px;"
                               data-bs-toggle="dropdown" id="notificationBell">
                                <i class="fas fa-bell"></i>
                                <span id="notificationBadge" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" 
                                      style="font-size: 9px; padding: 2px 5px; margin-top: -2px; {{ Auth::user()->unreadNotifications->count() > 0 ? '' : 'display: none;' }}">
                                    {{ Auth::user()->unreadNotifications->count() }}
                                </span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end shadow border-0 notification-dropdown" 
                                 style="border-radius: 12px; min-width: 350px; padding: 0; margin-top: 8px;">
                                <div class="dropdown-header d-flex justify-content-between align-items-center px-3 py-2 border-bottom" style="background: #fff;">
                                    <span class="fw-bold" style="font-size: 14px; color: #1c3451;">
                                        <i class="fas fa-bell me-2" style="color: #c1a067;"></i>Notifikasi
                                    </span>
                                    <form action="{{ route('notifications.mark-all-read') }}" method="POST" id="markAllReadForm">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-link p-0" style="font-size: 11px; color: #c1a067; text-decoration: none;">
                                            Tandai semua dibaca
                                        </button>
                                    </form>
                                </div>
                                <div id="notificationList" style="max-height: 400px; overflow-y: auto;">
                                    @forelse(Auth::user()->notifications()->latest()->take(10)->get() as $notif)
                                        <div class="notification-item {{ $notif->read_at ? '' : 'unread' }}" data-id="{{ $notif->id }}">
                                            <div class="d-flex">
                                                <div class="me-3">
                                                    <div class="notification-icon {{ $notif->data['color'] ?? 'primary' }}">
                                                        <i class="fas {{ $notif->data['icon'] ?? 'fa-bell' }}"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <div class="notification-title">{{ $notif->data['title'] ?? 'Notifikasi' }}</div>
                                                    <div class="notification-body">{{ $notif->data['body'] ?? '' }}</div>
                                                    <div class="notification-time">{{ $notif->created_at->diffForHumans() }}</div>
                                                </div>
                                                @if(!$notif->read_at)
                                                    <div>
                                                        <form action="{{ route('notifications.mark-read', $notif->id) }}" method="POST" class="mark-read-form">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-link p-0" style="color: #c1a067;">
                                                                <i class="fas fa-check-circle"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        @if(!$loop->last)
                                            <div class="dropdown-divider m-0"></div>
                                        @endif
                                    @empty
                                        <div class="text-center py-4">
                                            <i class="fas fa-bell-slash text-muted mb-2" style="font-size: 32px;"></i>
                                            <p class="text-muted mb-0" style="font-size: 13px;">Belum ada notifikasi</p>
                                        </div>
                                    @endforelse
                                </div>
                                @if(Auth::user()->notifications()->count() > 0)
                                    <div class="border-top text-center py-2">
                                        <a href="{{ route('notifications.index') }}" class="small" style="color: #c1a067; text-decoration: none;">
                                            Lihat semua notifikasi <i class="fas fa-arrow-right ms-1"></i>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- User Dropdown -->
                        <div class="dropdown">
                            <button class="btn btn-sm dropdown-toggle"
                               style="background: rgba(255,255,255,0.15); color: #c1a067; border: 1px solid rgba(193,160,103,0.5); font-size: 13px; border-radius: 20px; padding: 6px 14px;"
                               data-bs-toggle="dropdown">
                                <i class="fas fa-user me-1"></i>{{ Auth::user()->name }}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0" 
                                style="border-radius: 12px; min-width: 200px; padding: 8px; margin-top: 8px;">
                                <li>
                                    <a class="dropdown-item caldera-dropdown-item" href="{{ route('customer.profile') }}">
                                        <i class="fas fa-user me-2" style="color: #c1a067; width: 16px;"></i>Profile
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item caldera-dropdown-item" href="{{ route('customer.reservations') }}">
                                        <i class="fas fa-calendar me-2" style="color: #c1a067; width: 16px;"></i>Reservasi Saya
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item caldera-dropdown-item" href="{{ route('customer.tickets') }}">
                                        <i class="fas fa-ticket-alt me-2" style="color: #c1a067; width: 16px;"></i>Tiket Saya
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider" style="border-color: #f0ebe0; margin: 6px 0;"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item caldera-dropdown-item-danger">
                                            <i class="fas fa-sign-out-alt me-2" style="width: 16px;"></i>Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-sm"
                           style="background: rgba(255,255,255,0.15); color: white; border: 1px solid rgba(255,255,255,0.3); font-size: 13px; border-radius: 20px; padding: 6px 14px;">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="btn btn-sm"
                           style="background: #c1a067; color: white; border: none; font-size: 13px; border-radius: 20px; padding: 6px 14px;">
                            Daftar
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <!-- BARIS 2: NAVIGASI (Putih) -->
    <div style="background: #ffffff; border-bottom: 1px solid #e5e7eb; box-shadow: 0 1px 4px rgba(0,0,0,0.06);">
        <div class="container">
            <!-- Desktop Nav -->
        <div class="d-none d-lg-flex align-items-center">
            <a class="nav-custom-link {{ request()->routeIs('branding.home') ? 'active' : '' }}"
            href="{{ route('branding.home') }}">
                <i class="fas fa-home me-1"></i>Home
            </a>
            <a class="nav-custom-link {{ request()->routeIs('branding.about') ? 'active' : '' }}"
            href="{{ route('branding.about') }}">
                <i class="fas fa-mug-hot me-1"></i>About Us
            </a>
            <a class="nav-custom-link {{ request()->routeIs('branding.pool*') ? 'active' : '' }}"
            href="{{ route('branding.pool') }}">
                <i class="fas fa-swimmer me-1"></i>Pool
            </a>
            <!-- Reserving Meja - Menu Baru -->
            <a class="nav-custom-link {{ request()->routeIs('reservation.table*') ? 'active' : '' }}"
            href="{{ route('reservation.table') }}">
                <i class="fas fa-chair me-1"></i>Reservasi Meja
            </a>
            <a class="nav-custom-link {{ request()->routeIs('branding.events*') ? 'active' : '' }}"
            href="{{ route('branding.promos') }}">
                <i class="fas fa-bullhorn me-1"></i>Promo
            </a>
            <a class="nav-custom-link {{ request()->routeIs('branding.gallery*') ? 'active' : '' }}"
            href="{{ route('branding.gallery') }}">
                <i class="fas fa-image me-1"></i>Gallery
            </a>
            <a class="nav-custom-link {{ request()->routeIs('branding.menu*') ? 'active' : '' }}"
            href="{{ route('branding.menu') }}">
                <i class="fas fa-utensils me-1"></i>Menu
            </a>
            <a class="nav-custom-link {{ request()->routeIs('branding.testimonials*') ? 'active' : '' }}"
            href="{{ route('branding.testimonials') }}">
                <i class="fas fa-comments me-1"></i>Testimoni
            </a>

        </div>
            </div>

            <!-- Mobile Nav Toggle -->
            <div class="d-flex d-lg-none align-items-center py-2">
                <button class="btn border-0 p-0" type="button" data-bs-toggle="collapse" data-bs-target="#mobileNav">
                    <i class="fas fa-bars text-dark"></i>
                </button>
            </div>

            <!-- Mobile Nav Dropdown -->
            <div class="collapse d-lg-none" id="mobileNav">
                <div class="py-2 d-flex flex-column">
                    <a class="nav-custom-link-mobile {{ request()->routeIs('branding.home') ? 'active' : '' }}"
                       href="{{ route('branding.home') }}"><i class="fas fa-home me-2"></i>Home</a>
                    <a class="nav-custom-link-mobile {{ request()->routeIs('branding.about') ? 'active' : '' }}"
                       href="{{ route('branding.about') }}"><i class="fas fa-mug-hot me-2"></i>About Us</a>
                    <a class="nav-custom-link-mobile {{ request()->routeIs('branding.pool*') ? 'active' : '' }}"
                       href="{{ route('branding.pool') }}"><i class="fas fa-swimmer me-2"></i>Pool</a>
                    <a class="nav-custom-link-mobile {{ request()->routeIs('branding.events*') ? 'active' : '' }}"
                       href="{{ route('branding.events') }}"><i class="fas fa-bullhorn me-2"></i>Promo</a>
                    <a class="nav-custom-link-mobile {{ request()->routeIs('branding.gallery*') ? 'active' : '' }}"
                       href="{{ route('branding.gallery') }}"><i class="fas fa-image me-2"></i>Gallery</a>
                    <a class="nav-custom-link-mobile {{ request()->routeIs('branding.menu*') ? 'active' : '' }}"
                       href="{{ route('branding.menu') }}"><i class="fas fa-utensils me-2"></i>Menu</a>
                    <a class="nav-custom-link-mobile {{ request()->routeIs('reservation.table*') ? 'active' : '' }}"
                       href="{{ route('reservation.table') }}"><i class="fas fa-chair me-2"></i>Reservasi Meja</a>
                </div>
            </div>
        </div>
    </div>
</header>

<style>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap');

header {
    position: relative;
    z-index: 100;
    width: 100%;
}

.nav-custom-link {
    color: #4a5568;
    font-weight: 500;
    font-size: 0.88rem;
    padding: 1rem 1.1rem;
    border-bottom: 3px solid transparent;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    white-space: nowrap;
    transition: all 0.2s;
}

.nav-custom-link:hover,
.nav-custom-link.active {
    color: #1c3451;
    border-bottom: 3px solid #c1a067;
}

.nav-custom-link-mobile {
    color: #4a5568;
    font-weight: 500;
    font-size: 0.9rem;
    padding: 10px 16px;
    text-decoration: none;
    display: flex;
    align-items: center;
    border-radius: 6px;
    transition: background 0.2s;
}

.nav-custom-link-mobile:hover,
.nav-custom-link-mobile.active {
    background: #f3f4f6;
    color: #1c3451;
}

.caldera-dropdown-item {
    color: #1c3451;
    font-size: 14px;
    font-weight: 500;
    border-radius: 8px;
    padding: 8px 14px;
    transition: all 0.15s;
}

.caldera-dropdown-item:hover {
    background: #f0ebe0;
    color: #1c3451;
}

.caldera-dropdown-item-danger {
    width: 100%;
    text-align: left;
    background: none;
    border: none;
    color: #dc2626;
    font-size: 14px;
    font-weight: 500;
    border-radius: 8px;
    padding: 8px 14px;
    transition: all 0.15s;
}

.caldera-dropdown-item-danger:hover {
    background: #fef2f2;
    color: #dc2626;
}

/* Dropdown Notifikasi */
.notification-dropdown {
    width: 380px;
    max-height: 500px;
    overflow-y: auto;
    border-radius: 12px;
    padding: 0;
}

.notification-item {
    padding: 12px 16px;
    border-bottom: 1px solid #f0ebe0;
    transition: background 0.2s;
    text-decoration: none;
    display: block;
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

.notification-icon.primary {
    background: #e6f0ff;
    color: #1c3451;
}

.notification-icon.success {
    background: #e6f7e6;
    color: #2e7d32;
}

.notification-icon.danger {
    background: #ffe6e6;
    color: #dc2626;
}

.notification-icon.warning {
    background: #fff3e6;
    color: #ed6c02;
}

.notification-icon.info {
    background: #e6f7ff;
    color: #0288d1;
}

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

/* Search bar */
#searchInput {
    outline: none;
}

#searchInput:focus {
    box-shadow: none;
    border-color: #c1a067;
}

/* Responsive */
@media (max-width: 768px) {
    .notification-dropdown {
        width: 95vw;
        right: -50px;
    }
}
</style>

<script>
// Real-time search functionality
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                window.location.href = '{{ route("branding.menu") }}?search=' + encodeURIComponent(this.value);
            }
        });
    }
});

// Refresh notifikasi badge
function refreshNotificationBadge() {
    fetch('{{ route("notifications.latest") }}')
        .then(response => response.json())
        .then(data => {
            const badge = document.getElementById('notificationBadge');
            if (badge) {
                if (data.count > 0) {
                    badge.textContent = data.count;
                    badge.style.display = '';
                } else {
                    badge.style.display = 'none';
                }
            }
        })
        .catch(err => console.log('Error fetching notifications'));
}

// Optional: refresh every 30 seconds
// setInterval(refreshNotificationBadge, 30000);
</script>