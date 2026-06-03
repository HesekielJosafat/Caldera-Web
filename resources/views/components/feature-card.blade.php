@props(['icon', 'gradient', 'title', 'description', 'feature', 'delay' => 0])

<div class="col-md-4 mb-4 fade-in-up" style="animation-delay: {{ $delay }}s">
    <div class="card feature-card h-100 p-4 border-0 shadow-sm hover-lift" 
         onclick="showFeature('{{ $feature }}')"
         style="border-radius: 1.5rem; cursor: pointer; background: linear-gradient(135deg, #fff, #f8f9fa); transition: all 0.3s ease;">
        
        <!-- Icon Circle -->
        <div class="icon-circle bg-gradient-{{ $gradient }} mx-auto mb-4"
             style="width: 80px; height: 80px; border-radius: 20px; display: flex; align-items: center; justify-content: center; margin-top: -50px; box-shadow: 0 10px 20px -5px rgba(0,0,0,0.2); transition: all 0.3s ease;">
            <i class="fas {{ $icon }} text-white" style="font-size: 2.2rem;"></i>
        </div>
        
        <!-- Content -->
        <h4 class="fw-bold mb-3" style="color: #333;">{{ $title }}</h4>
        <p class="text-secondary mb-4" style="line-height: 1.6;">{{ $description }}</p>
        
        <!-- Learn More Link -->
        <span class="text-{{ $gradient }} fw-bold mt-auto d-inline-flex align-items-center" 
              style="gap: 0.5rem; transition: gap 0.3s ease; cursor: pointer;">
            Learn more <i class="fas fa-arrow-right"></i>
        </span>
    </div>
</div>

@push('styles')
<style>
/* Hover effects untuk feature card */
.feature-card {
    position: relative;
    overflow: hidden;
}

.feature-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #667eea, #764ba2);
    transform: scaleX(0);
    transition: transform 0.3s ease;
}

.feature-card:hover::before {
    transform: scaleX(1);
}

.feature-card:hover .icon-circle {
    transform: scale(1.1) rotate(5deg);
}

.feature-card:hover span {
    gap: 1rem !important;
}

/* Dark mode styles */
body.dark-mode .feature-card {
    background: linear-gradient(135deg, #2d2d2d, #353535) !important;
    border-color: #404040 !important;
}

body.dark-mode .feature-card h4 {
    color: #fff !important;
}

body.dark-mode .feature-card p {
    color: #ccc !important;
}

body.dark-mode .feature-card .text-primary,
body.dark-mode .feature-card .text-success,
body.dark-mode .feature-card .text-info {
    color: #ff80ab !important;
}

/* Responsive */
@media (max-width: 768px) {
    .feature-card {
        padding: 1.5rem !important;
    }
    
    .feature-card .icon-circle {
        width: 70px !important;
        height: 70px !important;
        margin-top: -40px !important;
    }
    
    .feature-card .icon-circle i {
        font-size: 1.8rem !important;
    }
    
    .feature-card h4 {
        font-size: 1.3rem;
    }
}

@media (max-width: 576px) {
    .feature-card .icon-circle {
        width: 60px !important;
        height: 60px !important;
        margin-top: -35px !important;
    }
    
    .feature-card .icon-circle i {
        font-size: 1.5rem !important;
    }
}
</style>
@endpush