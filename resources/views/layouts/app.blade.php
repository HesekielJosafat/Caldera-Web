<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>@yield('title', 'Caldera Resto & Pool')</title>
    
    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Fonts and icons -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
    <style>
        body {
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        /* Hapus padding-top karena navbar bukan fixed/sticky */
        main {
            min-height: 100vh;
        }

        /* Dark mode toggle button */
        .dark-mode-toggle {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: #333;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 9999;
            transition: all 0.3s ease;
            border: none;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }
        
        .dark-mode-toggle:hover {
            transform: scale(1.1);
        }
        
        body.dark-mode .dark-mode-toggle {
            background: #ffc107;
            color: #333;
        }
        
        /* Dark mode body */
        body.dark-mode {
            background-color: #121212;
            color: #ffffff;
        }
        
        body.dark-mode .card {
            background-color: #1e1e2a;
            border-color: #2d2d3a;
        }
        
        body.dark-mode .text-muted,
        body.dark-mode .text-secondary {
            color: #b0b0b0 !important;
        }
    </style>
    
    @stack('styles')
</head>

<body>
    <!-- Dark Mode Toggle -->
    @include('components.dark-mode-toggle')

    <!-- Navbar -->
    @include('components.navbar')

    <!-- ALERT VERIFIKASI EMAIL -->
    @auth
        @if(!Auth::user()->hasVerifiedEmail())
            <div class="alert alert-warning text-center mb-0 rounded-0">
                <i class="fas fa-exclamation-triangle me-2"></i>
                Email Anda belum diverifikasi.
                <a href="{{ route('verification.notice') }}" class="alert-link">Klik di sini</a> untuk verifikasi.
            </div>
        @endif
    @endauth

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    @include('components.footer')

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        function toggleDarkMode() {
            document.body.classList.toggle('dark-mode');
            const isDarkMode = document.body.classList.contains('dark-mode');
            localStorage.setItem('darkMode', isDarkMode);
            
            const toggleIcon = document.querySelector('#darkModeToggle i');
            if (toggleIcon) {
                if (isDarkMode) {
                    toggleIcon.className = 'fas fa-sun';
                } else {
                    toggleIcon.className = 'fas fa-moon';
                }
            }
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            const savedDarkMode = localStorage.getItem('darkMode');
            if (savedDarkMode === 'true') {
                document.body.classList.add('dark-mode');
                const toggleIcon = document.querySelector('#darkModeToggle i');
                if (toggleIcon) {
                    toggleIcon.className = 'fas fa-sun';
                }
            }
        });
    </script>

    @stack('scripts')
</body>

</html>