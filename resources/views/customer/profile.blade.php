@extends('layouts.app')

@section('title', 'My Profile - Caldera')

@section('content')
<div class="container py-5">
    <!-- Header -->
    <div class="text-center mb-4">
        <h1 class="display-4 fw-bold mb-2" style="font-family: 'Playfair Display', serif; color: #1c3451;">My Profile</h1>
        <div class="section-divider"></div>
        <p class="lead text-muted">Manage your account settings and preferences</p>
    </div>

    <div class="row g-4">
        <!-- Sidebar -->
        <div class="col-md-4 col-lg-3">
            <div class="card border-0 shadow-sm caldera-sidebar-card">
                <div class="card-body text-center p-4">
                    <div class="profile-avatar mb-3">
                        <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&background=c1a067&color=fff&size=100&rounded=true" 
                             class="rounded-circle" 
                             width="100" 
                             height="100"
                             style="border: 3px solid #c1a067; padding: 3px;">
                    </div>
                    <h5 class="fw-bold mb-1" style="color: #1c3451;">{{ Auth::user()->name }}</h5>
                    <p class="text-muted small mb-3">{{ Auth::user()->email }}</p>
                    
                    <hr class="my-3">
                    
                    <div class="d-grid gap-2">
                        <a href="{{ route('customer.profile') }}" class="btn btn-sidebar active">
                            <i class="fas fa-user me-2"></i> My Profile
                        </a>
                        <a href="{{ route('customer.reservations') }}" class="btn btn-sidebar">
                            <i class="fas fa-calendar-alt me-2"></i> My Reservations
                        </a>
                        <a href="{{ route('customer.tickets') }}" class="btn btn-sidebar">
                            <i class="fas fa-ticket-alt me-2"></i> My Tickets
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-8 col-lg-9">
            <!-- Profile Update Form -->
            <div class="card border-0 shadow-sm caldera-form-card mb-4">
                <div class="card-header bg-transparent border-bottom-0 pt-4 px-4">
                    <h5 class="mb-0 fw-bold" style="color: #1c3451;">
                        <i class="fas fa-user-edit me-2" style="color: #c1a067;"></i> Informasi Profil
                    </h5>
                </div>
                <div class="card-body p-4">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    
                    <form method="POST" action="{{ route('customer.profile.update') }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="color: #1c3451;">
                                <i class="fas fa-user me-1" style="color: #c1a067;"></i> Nama Lengkap
                            </label>
                            <input type="text" name="name" class="form-control caldera-input" 
                                   value="{{ old('name', $user->name) }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="color: #1c3451;">
                                <i class="fas fa-envelope me-1" style="color: #c1a067;"></i> Email
                            </label>
                            <input type="email" name="email" class="form-control caldera-input" 
                                   value="{{ old('email', $user->email) }}" required>
                            <small class="text-muted">Email tidak dapat diubah sendiri, hubungi admin untuk perubahan email.</small>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="color: #1c3451;">
                                <i class="fas fa-phone me-1" style="color: #c1a067;"></i> Nomor Telepon
                            </label>
                            <input type="text" name="phone" class="form-control caldera-input" 
                                   value="{{ old('phone', $user->phone) }}" placeholder="0812-3456-7890">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="color: #1c3451;">
                                <i class="fas fa-calendar-alt me-1" style="color: #c1a067;"></i> Member Since
                            </label>
                            <input type="text" class="form-control caldera-input" 
                                   value="{{ $user->created_at->format('d F Y') }}" disabled>
                        </div>
                        
                        <button type="submit" class="btn btn-update">
                            <i class="fas fa-save me-2"></i> Update Profile
                        </button>
                    </form>
                </div>
            </div>

            <!-- Change Password Form -->
            <div class="card border-0 shadow-sm caldera-form-card">
                <div class="card-header bg-transparent border-bottom-0 pt-4 px-4">
                    <h5 class="mb-0 fw-bold" style="color: #1c3451;">
                        <i class="fas fa-key me-2" style="color: #c1a067;"></i> Ganti Password
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('customer.password.change') }}">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="color: #1c3451;">Password Lama</label>
                            <input type="password" name="current_password" class="form-control caldera-input" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="color: #1c3451;">Password Baru</label>
                            <input type="password" name="new_password" class="form-control caldera-input" required>
                            <small class="text-muted">Minimal 8 karakter</small>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="color: #1c3451;">Konfirmasi Password Baru</label>
                            <input type="password" name="new_password_confirmation" class="form-control caldera-input" required>
                        </div>
                        
                        <button type="submit" class="btn btn-password">
                            <i class="fas fa-lock me-2"></i> Ganti Password
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
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

    /* Sidebar Card */
    .caldera-sidebar-card {
        border-radius: 20px !important;
        overflow: hidden;
    }

    .profile-avatar img {
        object-fit: cover;
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
        transform: translateX(5px);
    }

    .btn-sidebar.active {
        background: linear-gradient(135deg, #1c3451, #01516e);
        color: white;
        border-color: #1c3451;
        box-shadow: 0 4px 12px rgba(28,52,81,0.2);
    }

    /* Form Cards */
    .caldera-form-card {
        border-radius: 20px !important;
        overflow: hidden;
    }

    /* Form Input Styling */
    .caldera-input {
        border: 1.5px solid #e8e0d0;
        border-radius: 12px;
        padding: 10px 16px;
        font-size: 14px;
        transition: all 0.2s;
        background: #fff;
    }

    .caldera-input:focus {
        border-color: #c1a067;
        box-shadow: 0 0 0 3px rgba(193,160,103,0.1);
        outline: none;
    }

    .caldera-input:disabled {
        background: #f8f6f2;
        color: #6c757d;
    }

    /* Buttons */
    .btn-update {
        background: linear-gradient(135deg, #1c3451, #01516e);
        color: white;
        border: none;
        border-radius: 12px;
        padding: 10px 24px;
        font-weight: 600;
        transition: all 0.2s;
    }

    .btn-update:hover {
        background: linear-gradient(135deg, #c1a067, #a8894f);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(193,160,103,0.3);
    }

    .btn-password {
        background: transparent;
        color: #c1a067;
        border: 2px solid #c1a067;
        border-radius: 12px;
        padding: 10px 24px;
        font-weight: 600;
        transition: all 0.2s;
    }

    .btn-password:hover {
        background: #c1a067;
        color: white;
        transform: translateY(-2px);
    }

    /* Alert Styling */
    .alert-success {
        background: #e8f5e9;
        border: none;
        border-left: 4px solid #4caf50;
        color: #2e7d32;
    }

    .alert-danger {
        background: #ffebee;
        border: none;
        border-left: 4px solid #f44336;
        color: #c62828;
    }

    /* Dark Mode */
    body.dark-mode .caldera-input {
        background: #1e1e2a;
        border-color: #2d2d3a;
        color: #dce8f0;
    }

    body.dark-mode .caldera-input:focus {
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
        background: #c1a067;
        color: #1c3451;
    }

    body.dark-mode .btn-password {
        border-color: #c1a067;
        color: #c1a067;
    }

    body.dark-mode .btn-password:hover {
        background: #c1a067;
        color: #1c3451;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .btn-sidebar {
            text-align: center;
        }
        
        .btn-sidebar:hover {
            transform: translateY(-2px);
        }
    }
</style>
@endpush