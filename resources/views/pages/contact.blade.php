@extends('layouts.app')

@section('title', 'Contact Us - Caldera Resto & Pool')

@section('content')
<div class="container py-5">
    <!-- Header -->
    <div class="text-center mb-5">
        <h1 class="display-4 fw-bold mb-2" style="font-family: 'Playfair Display', serif; color: #1c3451;">Contact Us</h1>
        <div class="section-divider"></div>
        <p class="lead text-muted">We'd love to hear from you</p>
    </div>

    <div class="row g-4">
        <!-- Contact Information -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm caldera-card h-100">
                <div class="card-body p-4">
                    <h4 class="fw-bold mb-4" style="color: #1c3451;">
                        <i class="fas fa-phone-alt me-2" style="color: #c1a067;"></i> Get in Touch
                    </h4>
                    
                    <div class="contact-info-item d-flex mb-4">
                        <div class="contact-icon me-3">
                            <i class="fas fa-map-marker-alt fa-2x" style="color: #c1a067;"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1" style="color: #1c3451;">Address</h6>
                            <p class="text-muted mb-0">Jl. Patuan Nagari, Sangkar Nihuta, Kec. Balige, Toba, Sumatera Utara 22312</p>
                        </div>
                    </div>
                    
                    <div class="contact-info-item d-flex mb-4">
                        <div class="contact-icon me-3">
                            <i class="fas fa-phone fa-2x" style="color: #c1a067;"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1" style="color: #1c3451;">Phone</h6>
                            <p class="text-muted mb-0">(022) 1234567<br>0812-3456-7890</p>
                        </div>
                    </div>
                    
                    <div class="contact-info-item d-flex mb-4">
                        <div class="contact-icon me-3">
                            <i class="fas fa-envelope fa-2x" style="color: #c1a067;"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1" style="color: #1c3451;">Email</h6>
                            <p class="text-muted mb-0">info@caldera.com</p>
                        </div>
                    </div>
                    
                    <div class="contact-info-item d-flex">
                        <div class="contact-icon me-3">
                            <i class="fas fa-clock fa-2x" style="color: #c1a067;"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1" style="color: #1c3451;">Opening Hours</h6>
                            <p class="text-muted mb-0">
                                <strong>Restaurant:</strong><br>
                                Monday - Friday: 10:00 - 22:00<br>
                                Saturday - Sunday: 09:00 - 23:00<br><br>
                                <strong>Pool:</strong><br>
                                Daily: 08:00 - 18:00
                            </p>
                        </div>
                    </div>

                    <hr class="my-4" style="border-color: #f0ebe0;">
                    
                    <!-- Social Media -->
                    <h6 class="fw-bold mb-3" style="color: #1c3451;">
                        <i class="fas fa-share-alt me-2" style="color: #c1a067;"></i> Follow Us
                    </h6>
                    <div class="d-flex gap-3">
                        <a href="#" class="social-icon" target="_blank">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="social-icon" target="_blank">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="social-icon" target="_blank">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="social-icon" target="_blank">
                            <i class="fab fa-tiktok"></i>
                        </a>
                        <a href="#" class="social-icon" target="_blank">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Form -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm caldera-card">
                <div class="card-body p-4">
                    <h4 class="fw-bold mb-4" style="color: #1c3451;">
                        <i class="fas fa-paper-plane me-2" style="color: #c1a067;"></i> Send Us a Message
                    </h4>
                    
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
                    
                    <form method="POST" action="{{ route('branding.contact.send') }}">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold" style="color: #1c3451;">
                                    <i class="fas fa-user me-1" style="color: #c1a067;"></i> Name
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="name" class="form-control caldera-input" 
                                       value="{{ old('name') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold" style="color: #1c3451;">
                                    <i class="fas fa-envelope me-1" style="color: #c1a067;"></i> Email
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="email" name="email" class="form-control caldera-input" 
                                       value="{{ old('email') }}" required>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-semibold" style="color: #1c3451;">
                                    <i class="fas fa-phone me-1" style="color: #c1a067;"></i> Phone
                                </label>
                                <input type="text" name="phone" class="form-control caldera-input" 
                                       value="{{ old('phone') }}" placeholder="0812-3456-7890">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-semibold" style="color: #1c3451;">
                                    <i class="fas fa-tag me-1" style="color: #c1a067;"></i> Subject
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="subject" class="form-control caldera-input" 
                                       value="{{ old('subject') }}" required>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-semibold" style="color: #1c3451;">
                                    <i class="fas fa-comment me-1" style="color: #c1a067;"></i> Message
                                    <span class="text-danger">*</span>
                                </label>
                                <textarea name="message" class="form-control caldera-input" 
                                          rows="5" required>{{ old('message') }}</textarea>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-submit w-100">
                                    <i class="fas fa-paper-plane me-2"></i> Send Message
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Google Maps -->
    <div class="mt-5">
        <div class="card border-0 shadow-sm overflow-hidden caldera-card">
            <div class="map-container">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15933.37470040786!2d99.131767!3d2.367627!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x302d1f97ddace8ed%3A0xbdf47207860cc8f5!2sCaldera%20Resto%20and%20Coffee!5e0!3m2!1sen!2sid!4v1744100000000!5m2!1sen!2sid" 
                    width="100%" 
                    height="350" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                    title="Caldera Resto and Coffee - Balige, Toba">
                </iframe>
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

    .caldera-card {
        border-radius: 20px !important;
        overflow: hidden;
        transition: transform 0.25s, box-shadow 0.25s;
    }

    .caldera-card:hover {
        box-shadow: 0 12px 28px rgba(28,52,81,0.12) !important;
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

    .caldera-input:hover:not(:focus) {
        border-color: #c1a067;
    }

    /* Contact Info Items */
    .contact-info-item {
        transition: all 0.2s;
    }

    .contact-info-item:hover {
        transform: translateX(5px);
    }

    .contact-icon {
        min-width: 50px;
    }

    /* Social Icons */
    .social-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 38px;
        height: 38px;
        background: #f8f6f2;
        border-radius: 50%;
        color: #c1a067;
        transition: all 0.2s;
        text-decoration: none;
        font-size: 16px;
    }

    .social-icon:hover {
        background: #c1a067;
        color: white;
        transform: translateY(-3px);
    }

    /* Submit Button */
    .btn-submit {
        background: linear-gradient(135deg, #1c3451, #01516e);
        color: white;
        border: none;
        border-radius: 12px;
        padding: 12px 20px;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.2s;
    }

    .btn-submit:hover {
        background: linear-gradient(135deg, #c1a067, #a8894f);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(193,160,103,0.3);
    }

    /* Map Container */
    .map-container {
        border-radius: 20px;
        overflow: hidden;
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

    /* Responsive */
    @media (max-width: 768px) {
        .contact-info-item {
            text-align: center;
            flex-direction: column;
        }
        .contact-icon {
            margin-bottom: 10px;
        }
        .social-icon {
            width: 34px;
            height: 34px;
            font-size: 14px;
        }
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

    body.dark-mode .social-icon {
        background: #1e1e2a;
        color: #c1a067;
    }

    body.dark-mode .social-icon:hover {
        background: #c1a067;
        color: #1c3451;
    }
</style>
@endpush