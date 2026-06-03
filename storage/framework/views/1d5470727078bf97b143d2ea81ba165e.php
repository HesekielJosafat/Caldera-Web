<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Caldera Resto & Pool</title>
    
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
            --btn-gold: #f0c67e;
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

        /* SISI KIRI - BRANDING */
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

        .brand-title {
            font-family: 'Playfair Display', serif;
            font-size: 4.5rem;
            letter-spacing: 4px;
            margin-bottom: 0;
            line-height: 1;
        }

        .brand-subtitle {
            font-size: 1.5rem;
            letter-spacing: 3px;
            font-weight: 300;
        }

        /* SISI KANAN - FORM */
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
            max-width: 400px;
        }

        .login-header {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 40px;
        }

        .login-header i {
            font-size: 60px;
        }

        .login-header h1 {
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

        .btn-login {
            background-color: var(--btn-gold);
            color: #333;
            border: none;
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 18px;
            margin-top: 10px;
            transition: 0.3s;
        }

        .btn-login:hover {
            background-color: #e5b96d;
        }

        .form-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 15px;
            font-size: 14px;
        }

        .register-link-container {
            text-align: center;
            margin-top: 30px;
            font-size: 14px;
        }

        .right-side a {
            color: white;
            text-decoration: none;
            opacity: 0.9;
        }

        .right-side a:hover {
            text-decoration: underline;
        }

        /* Custom Checkbox */
        .form-check-input {
            background-color: transparent;
            border: 2px solid white;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .main-wrapper { flex-direction: column; }
            .left-side, .right-side { flex: none; width: 100%; padding: 60px 20px; }
            .brand-title { font-size: 3rem; }
        }
    </style>
</head>
<body>
    <div class="main-wrapper">
        <!-- SISI KIRI -->
        <div class="left-side">
            <div class="logo-container">
                <svg viewBox="0 0 400 300" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <!-- Circle with landscape -->
                    <circle cx="200" cy="100" r="80" stroke="#c1a067" stroke-width="4"/>
                    <path d="M140 130 Q170 80 200 110 T260 90" stroke="#c1a067" stroke-width="3"/>
                    <path d="M140 145 Q180 110 220 140 T260 120" stroke="#c1a067" stroke-width="3"/>
                    <circle cx="185" cy="75" r="15" stroke="#c1a067" stroke-width="2"/>
                    <!-- Pool Area -->
                    <path d="M50 200 C50 180 350 180 350 200 L350 230 C350 250 50 250 50 230 Z" fill="#1fa9d6" stroke="#fffceb" stroke-width="8"/>
                    <!-- Ladders -->
                    <path d="M85 160 L85 200 M110 160 L110 200" stroke="#fffceb" stroke-width="4" stroke-linecap="round"/>
                    <!-- Umbrella & Table -->
                    <path d="M260 180 L360 180" stroke="#fffceb" stroke-width="5"/> 
                    <path d="M310 180 L310 110" stroke="#fffceb" stroke-width="3"/> 
                    <path d="M260 130 A50 50 0 0 1 360 130 Z" fill="#1fa9d6" stroke="#fffceb" stroke-width="2"/>
                </svg>
            </div>
            <h1 class="brand-title">CALDERA</h1>
            <p class="brand-subtitle">RESTO & POOL</p>
        </div>

        <!-- SISI KANAN -->
        <div class="right-side">
            <div class="form-container">
                <div class="login-header">
                    <i class="fas fa-user-group"></i>
                    <h1>LOGIN</h1>
                </div>

                <?php if($errors->any()): ?>
                    <div class="alert alert-danger py-2" style="font-size: 13px;">
                        <?php echo e($errors->first()); ?>

                    </div>
                <?php endif; ?>
                
                <form method="POST" action="<?php echo e(route('login')); ?>">
                    <?php echo csrf_field(); ?>
                    
                    <div class="form-group">
                        <input type="text" name="email" class="form-control" 
                               value="<?php echo e(old('email')); ?>" placeholder="Nama" required>
                    </div>
                    
                    <div class="form-group">
                        <input type="password" name="password" class="form-control" 
                               placeholder="Masukkan password" required>
                    </div>
                    
                    <button type="submit" class="btn-login">
                        Login
                    </button>

                    <div class="form-footer">
                        <div class="form-check">
                            <input type="checkbox" name="remember" class="form-check-input" id="remember">
                            <label class="form-check-label ms-1" for="remember">Ingatkan saya</label>
                        </div>
                        <?php if(Route::has('password.request')): ?>
                            <a href="<?php echo e(route('password.request')); ?>">Lupa Password?</a>
                        <?php elseif(Route::has('password.otp.form')): ?>
                            <a href="<?php echo e(route('password.otp.form')); ?>">Lupa Password?</a>
                        <?php endif; ?>                    
                        </div>
                </form>
                
                <div class="register-link-container">
                    Tidak mempunyai akun? <a href="<?php echo e(route('register')); ?>" style="text-decoration: underline;">Daftar.</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html><?php /**PATH D:\PA_03\PA2\resources\views/admin/auth/login.blade.php ENDPATH**/ ?>