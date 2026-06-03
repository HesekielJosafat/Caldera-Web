<!doctype html>
<html lang="en">

<head>
  <title>Material Kit 2 - Landing Page Interaktif</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <!-- Material Icons -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Material Kit CSS -->
  <link href="https://demos.creative-tim.com/material-kit/assets/css/material-kit.min.css?v=3.0.0" rel="stylesheet" />
  <style>
    /* Custom styles untuk interaksi dan animasi */
    .page-header {
      transition: transform 0.3s ease-out;
      min-height: 80vh;
      background-size: cover;
      background-position: center;
      background-attachment: fixed;
    }
    
    .hover-lift {
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    
    .hover-lift:hover {
      transform: translateY(-5px);
      box-shadow: 0 20px 30px -10px rgba(0, 0, 0, 0.2) !important;
    }
    
    .feature-card {
      cursor: pointer;
      border-radius: 1rem;
      background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
      border: none;
      min-height: 300px;
    }
    
    .feature-card .material-icons {
      transition: transform 0.3s ease;
      font-size: 2.5rem;
    }
    
    .feature-card:hover .material-icons {
      transform: scale(1.2) rotate(5deg);
      color: #e91e63 !important;
    }
    
    .stats-number {
      font-size: 2.5rem;
      font-weight: 700;
      background: linear-gradient(45deg, #667eea, #764ba2);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      display: inline-block;
    }
    
    .testimonial-card {
      background: white;
      border-radius: 1rem;
      padding: 2rem;
      box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.1);
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
    
    .fade-in-up {
      animation: fadeInUp 0.6s ease forwards;
    }
    
    .navbar-scrolled {
      background: white !important;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }
    
    .navbar-scrolled .nav-link,
    .navbar-scrolled .navbar-brand {
      color: #333 !important;
    }
    
    .navbar-scrolled .text-white {
      color: #333 !important;
    }
    
    .cta-section {
      background: linear-gradient(45deg, #667eea 0%, #764ba2 100%);
      border-radius: 2rem;
      overflow: hidden;
      position: relative;
      padding: 4rem 2rem;
    }
    
    .cta-section::before {
      content: '';
      position: absolute;
      top: -50%;
      right: -50%;
      width: 200%;
      height: 200%;
      background: rgba(255,255,255,0.1);
      transform: rotate(45deg);
      animation: shimmer 3s infinite;
    }
    
    @keyframes shimmer {
      0% { transform: rotate(45deg) translateX(-100%); }
      100% { transform: rotate(45deg) translateX(100%); }
    }
    
    .dark-mode-toggle {
      position: fixed;
      bottom: 20px;
      right: 20px;
      z-index: 999;
      background: #656565;
      color: #282040;
      width: 50px;
      height: 50px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      box-shadow: 0 5px 15px rgba(0,0,0,0.3);
      transition: all 0.3s ease;
    }
    
    .dark-mode-toggle:hover {
      transform: scale(1.1);
      background: #555;
    }
    
    body.dark-mode {
      background: #1a1a1a;
      color: #fff;
    }
    
    body.dark-mode .card {
      background: #2d2d2d;
      color: #fff;
    }
    
    body.dark-mode .feature-card {
      background: linear-gradient(135deg, #2d2d2d 0%, #353535 100%);
    }
    
    body.dark-mode .footer {
      background: #2d2d2d;
      color: #fff;
    }
    
    body.dark-mode .text-secondary {
      color: #aaa !important;
    }
    
    body.dark-mode .testimonial-card {
      background: #2d2d2d;
      color: #fff;
    }
    
    .btn i {
      margin-right: 8px;
      vertical-align: middle;
    }
    
    .icon-shape {
      width: 60px;
      height: 60px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: -30px auto 20px;
    }
    
    .rating i {
      color: #ffc107;
      margin: 0 2px;
    }
    
    .notification {
      position: fixed;
      top: 20px;
      right: 20px;
      z-index: 9999;
      animation: slideIn 0.3s ease;
    }
    
    @keyframes slideIn {
      from {
        transform: translateX(100%);
        opacity: 0;
      }
      to {
        transform: translateX(0);
        opacity: 1;
      }
    }
  </style>
</head>

<body>
  <!-- Dark Mode Toggle -->
  <div class="dark-mode-toggle" onclick="toggleDarkMode()" id="darkModeToggle">
    <i class="fas fa-moon"></i>
  </div>

  <!-- Navbar Transparent dengan efek scroll -->
  <nav class="navbar navbar-expand-lg position-absolute top-0 z-index-3 w-100 shadow-none my-3 navbar-transparent" id="mainNav">
    <div class="container">
      <a class="navbar-brand text-white" href="#" rel="tooltip" title="Designed and Coded by Creative Tim" data-placement="bottom">
        <i class="fas fa-rocket me-2"></i>
        Material Kit 2 Pro
      </a>
      <button class="navbar-toggler shadow-none ms-2" type="button" data-bs-toggle="collapse" data-bs-target="#navigation" aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon mt-2">
          <span class="navbar-toggler-bar bar1"></span>
          <span class="navbar-toggler-bar bar2"></span>
          <span class="navbar-toggler-bar bar3"></span>
        </span>
      </button>
      <div class="collapse navbar-collapse w-100 pt-3 pb-2 py-lg-0" id="navigation">
        <ul class="navbar-nav navbar-nav-hover ms-auto">
          <li class="nav-item dropdown dropdown-hover mx-2">
            <a class="nav-link ps-2 d-flex cursor-pointer align-items-center text-white" href="#" id="dropdownMenuPages" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="fas fa-th-large me-2"></i>
              Pages
              <i class="fas fa-chevron-down ms-2"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-animation" aria-labelledby="dropdownMenuPages">
              <li><a class="dropdown-item" href="#">About Us</a></li>
              <li><a class="dropdown-item" href="#">Contact Us</a></li>
              <li><a class="dropdown-item" href="#">Pricing</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="#">Sign In</a></li>
            </ul>
          </li>

          <li class="nav-item dropdown dropdown-hover mx-2">
            <a class="nav-link ps-2 d-flex cursor-pointer align-items-center text-white" href="#" id="dropdownMenuSections" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="fas fa-layer-group me-2"></i>
              Sections
              <i class="fas fa-chevron-down ms-2"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-animation" aria-labelledby="dropdownMenuSections">
              <li><a class="dropdown-item" href="#">Headers</a></li>
              <li><a class="dropdown-item" href="#">Features</a></li>
              <li><a class="dropdown-item" href="#">Testimonials</a></li>
              <li><a class="dropdown-item" href="#">Teams</a></li>
              <li><a class="dropdown-item" href="#">Footers</a></li>
            </ul>
          </li>

          <li class="nav-item dropdown dropdown-hover mx-2">
            <a class="nav-link ps-2 d-flex cursor-pointer align-items-center text-white" href="#" id="dropdownMenuDocs" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="fas fa-file-alt me-2"></i>
              Docs
              <i class="fas fa-chevron-down ms-2"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-animation" aria-labelledby="dropdownMenuDocs">
              <li><a class="dropdown-item" href="#">Getting Started</a></li>
              <li><a class="dropdown-item" href="#">Components</a></li>
              <li><a class="dropdown-item" href="#">Changelog</a></li>
            </ul>
          </li>
          
          <li class="nav-item ms-lg-auto my-auto ms-3 ms-lg-0 mt-2 mt-lg-0">
            <a href="#" class="btn btn-sm bg-gradient-primary mb-0 me-1 mt-2 mt-md-0" onclick="showNotification(event)">
              <i class="fas fa-shopping-cart me-2"></i>
              Buy Now
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- End Navbar -->

  <!-- Hero Section dengan Parallax efek -->
  <div class="page-header min-vh-80 position-relative d-flex align-items-center" style="background-image: url('https://images.unsplash.com/photo-1630752708689-02c8636b9141?ixlib=rb-1.2.1&auto=format&fit=crop&w=2490&q=80'); background-attachment: fixed;">
    <span class="mask bg-gradient-dark opacity-6"></span>
    <div class="container position-relative z-index-2">
      <div class="row">
        <div class="col-md-8 mx-auto text-center">
          <span class="badge bg-gradient-primary mb-3 px-4 py-2">✨ Welcome to the future ✨</span>
          <h1 class="text-white display-3 fw-bold">Build Beautiful Products</h1>
          <h3 class="text-white opacity-8 fw-light mb-4">with the most advanced Material Design system</h3>
          <div class="buttons d-flex justify-content-center gap-3">
            <a href="#" class="btn btn-lg bg-gradient-primary btn-lg hover-lift" onclick="showNotification(event)">
              <i class="fas fa-download me-2"></i>
              Get Started
            </a>
            <a href="#" class="btn btn-lg btn-outline-white btn-lg hover-lift" onclick="showNotification(event)">
              <i class="fas fa-play me-2"></i>
              Watch Demo
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Main Content Card dengan floating effect -->
  <div class="card card-body shadow-xl mx-3 mx-md-4 mt-n6" style="border-radius: 1rem;">
    <div class="container py-4">
      <!-- Stats Section -->
      <div class="row mb-5 text-center">
        <div class="col-lg-3 col-md-6 mb-4 fade-in-up">
          <div class="stats-number" id="counter1">0</div>
          <p class="text-lg font-weight-bold mt-2">Happy Clients</p>
          <i class="fas fa-smile text-primary" style="font-size: 2rem;"></i>
        </div>
        <div class="col-lg-3 col-md-6 mb-4 fade-in-up" style="animation-delay: 0.1s">
          <div class="stats-number" id="counter2">0</div>
          <p class="text-lg font-weight-bold mt-2">Projects Completed</p>
          <i class="fas fa-check-circle text-success" style="font-size: 2rem;"></i>
        </div>
        <div class="col-lg-3 col-md-6 mb-4 fade-in-up" style="animation-delay: 0.2s">
          <div class="stats-number" id="counter3">0</div>
          <p class="text-lg font-weight-bold mt-2">Team Members</p>
          <i class="fas fa-users text-info" style="font-size: 2rem;"></i>
        </div>
        <div class="col-lg-3 col-md-6 mb-4 fade-in-up" style="animation-delay: 0.3s">
          <div class="stats-number" id="counter4">0</div>
          <p class="text-lg font-weight-bold mt-2">Awards Won</p>
          <i class="fas fa-trophy text-warning" style="font-size: 2rem;"></i>
        </div>
      </div>

      <!-- Main Section dengan Cards Interaktif -->
      <div class="section text-center">
        <h2 class="title fw-bold mb-5">Why Choose Us?</h2>
        <div class="row">
          <div class="col-md-4 mb-4 fade-in-up">
            <div class="card feature-card h-100 p-4 hover-lift" onclick="showFeature('design')">
              <div class="icon-shape bg-gradient-primary shadow-primary mx-auto rounded-3 d-flex align-items-center justify-content-center">
                <i class="fas fa-paint-brush text-white" style="font-size: 2rem;"></i>
              </div>
              <h4 class="mt-4">Modern Design</h4>
              <p class="text-secondary">Beautiful and intuitive interface with smooth animations and interactions.</p>
              <span class="text-primary mt-3">Learn more <i class="fas fa-arrow-right ms-2"></i></span>
            </div>
          </div>
          <div class="col-md-4 mb-4 fade-in-up" style="animation-delay: 0.1s">
            <div class="card feature-card h-100 p-4 hover-lift" onclick="showFeature('code')">
              <div class="icon-shape bg-gradient-success shadow-success mx-auto rounded-3 d-flex align-items-center justify-content-center">
                <i class="fas fa-code text-white" style="font-size: 2rem;"></i>
              </div>
              <h4 class="mt-4">Clean Code</h4>
              <p class="text-secondary">Well-organized and documented code for easy customization and maintenance.</p>
              <span class="text-success mt-3">Learn more <i class="fas fa-arrow-right ms-2"></i></span>
            </div>
          </div>
          <div class="col-md-4 mb-4 fade-in-up" style="animation-delay: 0.2s">
            <div class="card feature-card h-100 p-4 hover-lift" onclick="showFeature('support')">
              <div class="icon-shape bg-gradient-info shadow-info mx-auto rounded-3 d-flex align-items-center justify-content-center">
                <i class="fas fa-headset text-white" style="font-size: 2rem;"></i>
              </div>
              <h4 class="mt-4">24/7 Support</h4>
              <p class="text-secondary">Dedicated support team ready to help you with any questions or issues.</p>
              <span class="text-info mt-3">Learn more <i class="fas fa-arrow-right ms-2"></i></span>
            </div>
          </div>
        </div>
      </div>

      <!-- Testimonial Section -->
      <div class="section text-center mt-5">
        <h2 class="title fw-bold mb-5">What Our Clients Say</h2>
        <div class="row justify-content-center">
          <div class="col-lg-8">
            <div class="testimonial-card p-5 fade-in-up">
              <i class="fas fa-quote-right text-primary opacity-2" style="font-size: 4rem; position: absolute; top: 20px; right: 20px;"></i>
              <img src="https://randomuser.me/api/portraits/women/68.jpg" class="rounded-circle mb-3" width="100" height="100" alt="client">
              <p class="text-secondary fst-italic fs-5 mb-4">"The support team is amazing! They helped me customize everything I needed within hours."</p>
              <h5 class="fw-bold">Emily Rodriguez</h5>
              <p class="text-sm text-primary">Marketing Director</p>
              <div class="rating">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- CTA Section -->
      <div class="cta-section text-white text-center mt-5">
        <div class="position-relative" style="z-index: 2;">
          <h2 class="display-5 fw-bold">Ready to Get Started?</h2>
          <p class="lead mb-4">Join thousands of satisfied customers building amazing products</p>
          <a href="#" class="btn btn-light btn-lg px-5 hover-lift" onclick="showNotification(event)">
            <i class="fas fa-download me-2"></i>
            Start Free Trial
          </a>
        </div>
      </div>
    </div>
  </div>

  <!-- Footer Enhanced -->
  <footer class="footer pt-5 mt-5">
    <div class="container">
      <div class="row">
        <div class="col-md-3 mb-4 ms-auto">
          <div>
            <img src="https://demos.creative-tim.com/material-kit/assets/img/logo-ct-dark.png" class="mb-3" alt="main_logo" style="width: 60px;">
            <h6 class="font-weight-bolder mb-4">Material Kit 2 Pro</h6>
          </div>
          <div>
            <ul class="d-flex flex-row list-unstyled gap-3">
              <li>
                <a class="text-dark" href="#"><i class="fab fa-facebook-f"></i></a>
              </li>
              <li>
                <a class="text-dark" href="#"><i class="fab fa-twitter"></i></a>
              </li>
              <li>
                <a class="text-dark" href="#"><i class="fab fa-dribbble"></i></a>
              </li>
              <li>
                <a class="text-dark" href="#"><i class="fab fa-github"></i></a>
              </li>
              <li>
                <a class="text-dark" href="#"><i class="fab fa-youtube"></i></a>
              </li>
            </ul>
          </div>
        </div>
        <div class="col-md-2 col-sm-6 col-6 mb-4">
          <h6 class="text-sm">Company</h6>
          <ul class="list-unstyled">
            <li class="mb-2"><a href="#" class="text-secondary" onclick="showNotification(event)">About Us</a></li>
            <li class="mb-2"><a href="#" class="text-secondary" onclick="showNotification(event)">Freebies</a></li>
            <li class="mb-2"><a href="#" class="text-secondary" onclick="showNotification(event)">Premium Tools</a></li>
            <li class="mb-2"><a href="#" class="text-secondary" onclick="showNotification(event)">Blog</a></li>
          </ul>
        </div>
        <div class="col-md-2 col-sm-6 col-6 mb-4">
          <h6 class="text-sm">Resources</h6>
          <ul class="list-unstyled">
            <li class="mb-2"><a href="#" class="text-secondary" onclick="showNotification(event)">Illustrations</a></li>
            <li class="mb-2"><a href="#" class="text-secondary" onclick="showNotification(event)">Bits & Snippets</a></li>
            <li class="mb-2"><a href="#" class="text-secondary" onclick="showNotification(event)">Affiliate Program</a></li>
          </ul>
        </div>
        <div class="col-md-2 col-sm-6 col-6 mb-4">
          <h6 class="text-sm">Help & Support</h6>
          <ul class="list-unstyled">
            <li class="mb-2"><a href="#" class="text-secondary" onclick="showNotification(event)">Contact Us</a></li>
            <li class="mb-2"><a href="#" class="text-secondary" onclick="showNotification(event)">Knowledge Center</a></li>
            <li class="mb-2"><a href="#" class="text-secondary" onclick="showNotification(event)">Custom Development</a></li>
            <li class="mb-2"><a href="#" class="text-secondary" onclick="showNotification(event)">Sponsorships</a></li>
          </ul>
        </div>
        <div class="col-md-2 col-sm-6 col-6 mb-4 me-auto">
          <h6 class="text-sm">Legal</h6>
          <ul class="list-unstyled">
            <li class="mb-2"><a href="#" class="text-secondary" onclick="showNotification(event)">Terms & Conditions</a></li>
            <li class="mb-2"><a href="#" class="text-secondary" onclick="showNotification(event)">Privacy Policy</a></li>
            <li class="mb-2"><a href="#" class="text-secondary" onclick="showNotification(event)">Licenses (EULA)</a></li>
          </ul>
        </div>
        <div class="col-12">
          <div class="text-center">
            <p class="text-secondary my-4 text-sm">
              All rights reserved. Copyright © <script>document.write(new Date().getFullYear())</script> Material Kit 2 Pro by Creative Tim.
            </p>
          </div>
        </div>
      </div>
    </div>
  </footer>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Navbar scroll effect
    window.addEventListener('scroll', function() {
      const nav = document.getElementById('mainNav');
      if (window.scrollY > 50) {
        nav.classList.add('navbar-scrolled');
        nav.classList.remove('navbar-transparent');
      } else {
        nav.classList.remove('navbar-scrolled');
        nav.classList.add('navbar-transparent');
      }
    });

    // Counter animation
    function animateCounter(elementId, target, duration = 2000) {
      const element = document.getElementById(elementId);
      const start = 0;
      const increment = target / (duration / 16);
      let current = start;
      
      const timer = setInterval(() => {
        current += increment;
        if (current >= target) {
          element.textContent = target + '+';
          clearInterval(timer);
        } else {
          element.textContent = Math.floor(current);
        }
      }, 16);
    }

    // Start counters when page loads
    window.onload = function() {
      animateCounter('counter1', 1500);
      animateCounter('counter2', 2500);
      animateCounter('counter3', 50);
      animateCounter('counter4', 25);
    };

    // Notification function
    function showNotification(event) {
      event.preventDefault();
      
      // Remove existing notification if any
      const existingNotif = document.querySelector('.notification');
      if (existingNotif) {
        existingNotif.remove();
      }
      
      // Create notification element
      const notification = document.createElement('div');
      notification.className = 'notification alert alert-success alert-dismissible fade show';
      notification.innerHTML = `
        <i class="fas fa-check-circle me-2"></i>
        <strong>Success!</strong> This is a demo notification.
        <button type="button" class="btn-close" onclick="this.parentElement.remove()"></button>
      `;
      document.body.appendChild(notification);
      
      // Auto remove after 3 seconds
      setTimeout(() => {
        if (notification.parentElement) {
          notification.remove();
        }
      }, 3000);
    }

    // Feature click handler
    function showFeature(feature) {
      const titles = {
        design: '✨ Modern Design Features',
        code: '💻 Clean Code Structure',
        support: '🎯 24/7 Premium Support'
      };
      
      const messages = {
        design: 'Our design system includes 1000+ components, 5 color schemes, and dark mode support.',
        code: 'All code follows best practices and includes detailed comments for easy customization.',
        support: 'Get priority support via email, chat, and video calls from our expert team.'
      };
      
      alert(`${titles[feature]}\n\n${messages[feature]}`);
    }

    // Dark mode toggle
    function toggleDarkMode() {
      document.body.classList.toggle('dark-mode');
      const toggle = document.getElementById('darkModeToggle');
      const icon = toggle.querySelector('i');
      
      if (document.body.classList.contains('dark-mode')) {
        icon.className = 'fas fa-sun';
        toggle.style.background = '#ffc107';
        toggle.style.color = '#333';
      } else {
        icon.className = 'fas fa-moon';
        toggle.style.background = '#333';
        toggle.style.color = '#white';
      }
    }

    // Smooth scroll untuk anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
          target.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
          });
        }
      });
    });

    // Parallax effect sederhana
    window.addEventListener('scroll', () => {
      const scrolled = window.pageYOffset;
      const parallax = document.querySelector('.page-header');
      if (parallax) {
        parallax.style.backgroundPositionY = `${scrolled * 0.5}px`;
      }
    });
  </script>
</body>

</html>