<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Caldera Resto & Pool</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --bg-left: #01516e;
            --bg-right: #1c3451;
            --accent-gold: #c1a067;
            --input-bg: #d9d9d9;
        }

        * {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body, html {
            height: 100%;
            margin: 0;
            overflow-x: hidden;
        }

        .main-wrapper {
            display: flex;
            min-height: 100vh;
            width: 100%;
        }

        /* Sisi Kiri - Logo */
        .left-side {
            flex: 1;
            background-color: var(--bg-left);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px;
            color: var(--accent-gold);
            text-align: center;
        }

        .logo-container {
            width: 100%;
            max-width: 400px;
            margin-bottom: 20px;
        }

        .logo-container svg {
            width: 100%;
            height: auto;
        }

        .brand-title {
            font-family: 'Playfair Display', serif;
            font-size: 4rem;
            letter-spacing: 4px;
            margin-bottom: 0;
            line-height: 1;
        }

        .brand-subtitle {
            font-size: 1.5rem;
            letter-spacing: 3px;
            font-weight: 300;
        }

        /* Sisi Kanan - Form */
        .right-side {
            flex: 1;
            background-color: var(--bg-right);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
            color: white;
        }

        .form-container {
            width: 100%;
            max-width: 450px;
        }

        .register-header {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 40px;
        }

        .register-header i.header-icon {
            font-size: 60px;
        }

        .register-header h1 {
            font-size: 32px;
            font-weight: 500;
            letter-spacing: 2px;
            margin: 0;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-control {
            background-color: var(--input-bg) !important;
            border: none !important;
            border-radius: 4px !important;
            padding: 12px 15px;
            font-size: 16px;
            color: #333 !important;
        }

        .form-control::placeholder {
            color: #666;
        }

        .login-link {
            font-size: 14px;
            margin-top: 15px;
            color: rgba(255,255,255,0.8);
        }

        .login-link a {
            color: #4da3ff;
            text-decoration: underline;
        }

        .btn-register {
            background-color: var(--accent-gold);
            color: #333;
            border: none;
            padding: 10px 40px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 18px;
            float: right;
            margin-top: 20px;
            transition: 0.3s;
        }

        .btn-register:hover {
            background-color: #d4b47a;
            transform: scale(1.05);
        }

        /* Responsive */
        @media (max-width: 992px) {
            .main-wrapper {
                flex-direction: column;
            }
            .left-side, .right-side {
                flex: none;
                width: 100%;
                padding: 60px 20px;
            }
            .brand-title { font-size: 2.5rem; }
        }

        /* Custom Alert Style */
        .alert {
            font-size: 13px;
            padding: 10px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="main-wrapper">
        <!-- SISI KIRI: Logo dan Branding -->
        <div class="left-side">
            <div class="logo-container">
                <!-- SVG Logo yang menyerupai gambar -->
                <svg viewBox="0 0 400 300" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <!-- Lingkaran Matahari & Gunung -->
                    <circle cx="200" cy="100" r="80" stroke="#c1a067" stroke-width="4"/>
                    <path d="M140 130 Q170 80 200 110 T260 90" stroke="#c1a067" stroke-width="3"/>
                    <path d="M140 145 Q180 110 220 140 T260 120" stroke="#c1a067" stroke-width="3"/>
                    <circle cx="185" cy="75" r="15" stroke="#c1a067" stroke-width="2"/>
                    <!-- Kolam Renang -->
                    <path d="M50 200 C50 180 350 180 350 200 L350 230 C350 250 50 250 50 230 Z" fill="#1fa9d6" stroke="#fffceb" stroke-width="8"/>
                    <!-- Tangga Kolam -->
                    <path d="M85 160 L85 200 M110 160 L110 200" stroke="#fffceb" stroke-width="4" stroke-linecap="round"/>
                    <!-- Meja & Payung -->
                    <path d="M260 180 L360 180" stroke="#fffceb" stroke-width="5"/> <!-- Meja -->
                    <path d="M310 180 L310 110" stroke="#fffceb" stroke-width="3"/> <!-- Tiang Payung -->
                    <path d="M260 130 A50 50 0 0 1 360 130 Z" fill="#1fa9d6" stroke="#fffceb" stroke-width="2"/> <!-- Payung -->
                </svg>
            </div>
            <h1 class="brand-title">CALDERA</h1>
            <p class="brand-subtitle">RESTO & POOL</p>
        </div>

        <!-- SISI KANAN: Form Registrasi -->
        <div class="right-side">
            <div class="form-container">
                <div class="register-header">
                    <i class="fas fa-users-cog header-icon"></i>
                    <h1>REGISTER</h1>
                </div>

                <?php if($errors->any()): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <?php if(session('success')): ?>
                    <div class="alert alert-success">
                        <?php echo e(session('success')); ?>

                    </div>
                <?php endif; ?>

                <form method="POST" action="<?php echo e(route('register')); ?>">
                    <?php echo csrf_field(); ?>
                    
                    <div class="form-group">
                        <input type="text" name="name" class="form-control" 
                               value="<?php echo e(old('name')); ?>" placeholder="Nama" required>
                    </div>
                    
                    <div class="form-group">
                        <input type="email" name="email" class="form-control" 
                               value="<?php echo e(old('email')); ?>" placeholder="Email" required>
                    </div>
                    
                    <div class="form-group">
                        <input type="password" name="password" class="form-control" 
                               placeholder="Password" required>
                    </div>
                    
                    <div class="form-group">
                        <input type="password" name="password_confirmation" class="form-control" 
                               placeholder="Konfirmasi password" required>
                    </div>

                    <div class="login-link">
                        Sudah punya akun? <a href="<?php echo e(route('login')); ?>">Login.</a>
                    </div>
                    
                    <button type="submit" class="btn-register">
                        Register
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html><?php /**PATH D:\PA_03\PA2\resources\views/auth/register.blade.php ENDPATH**/ ?>