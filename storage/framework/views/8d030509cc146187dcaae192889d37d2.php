<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email - Caldera Resto & Pool</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Poppins', sans-serif; }
        body {
            background: linear-gradient(135deg, #1c3451 0%, #01516e 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
            overflow: hidden;
            max-width: 440px;
            width: 100%;
        }
        .card-header-custom {
            background: linear-gradient(135deg, #1c3451 0%, #01516e 100%);
            padding: 30px;
            text-align: center;
            color: white;
        }
        .icon-wrap {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            background: rgba(193,160,103,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
        }
        .card-header-custom h4 { margin: 0; font-weight: 700; }
        .card-header-custom p { margin: 6px 0 0; opacity: 0.8; font-size: 14px; }
        .email-badge {
            display: inline-block;
            background: rgba(193,160,103,0.25);
            border-radius: 20px;
            padding: 4px 16px;
            font-size: 13px;
            font-weight: 600;
            color: #c1a067;
            margin-top: 8px;
        }
        .card-body-custom { padding: 32px; background: white; }
        .otp-inputs {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin-bottom: 8px;
        }
        .otp-inputs input {
            width: 50px;
            height: 58px;
            text-align: center;
            font-size: 24px;
            font-weight: 700;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            outline: none;
            transition: all 0.2s;
            color: #1c3451;
        }
        .otp-inputs input:focus {
            border-color: #c1a067;
            box-shadow: 0 0 0 3px rgba(193,160,103,0.15);
        }
        .otp-inputs input.filled { border-color: #1c3451; background: #f8faff; }
        .attempts-info {
            font-size: 12px;
            text-align: center;
            color: #6b7280;
            margin-bottom: 16px;
        }
        .attempts-info.danger { color: #dc2626; font-weight: 600; }
        .btn-verify {
            background: linear-gradient(135deg, #1c3451, #01516e);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 600;
            padding: 13px;
            width: 100%;
            transition: all 0.2s;
        }
        .btn-verify:hover {
            background: linear-gradient(135deg, #c1a067, #a8894f);
            color: white;
            transform: translateY(-1px);
        }
        .resend-section {
            text-align: center;
            margin-top: 20px;
            font-size: 13px;
            color: #6b7280;
        }
        .btn-resend {
            background: none;
            border: none;
            color: #c1a067;
            font-weight: 600;
            font-size: 13px;
            cursor: pointer;
            padding: 0;
        }
        .btn-resend:disabled { color: #9ca3af; cursor: not-allowed; }
        .countdown { color: #dc2626; font-weight: 600; font-size: 13px; }
        .otp-note {
            font-size: 11px;
            color: #9ca3af;
            text-align: center;
            margin-top: 8px;
        }
        .alert-custom {
            border-radius: 10px;
            font-size: 13px;
            padding: 10px 14px;
            margin-bottom: 16px;
        }
    </style>
</head>
<body>
<div class="card">
    <div class="card-header-custom">
        <div class="icon-wrap">
            <i class="fas fa-envelope-open-text fa-xl" style="color: #c1a067;"></i>
        </div>
        <h4>Verifikasi Email</h4>
        <p>Masukkan kode 6 digit yang dikirim ke</p>
        <div class="email-badge"><?php echo e(auth()->user()->email); ?></div>
    </div>

    <div class="card-body-custom">

        <?php if(session('success')): ?>
            <div class="alert alert-success alert-custom">
                <i class="fas fa-check-circle me-2"></i><?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <?php if(session('warning')): ?>
            <div class="alert alert-warning alert-custom">
                <i class="fas fa-exclamation-triangle me-2"></i><?php echo e(session('warning')); ?>

            </div>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <div class="alert alert-danger alert-custom">
                <i class="fas fa-times-circle me-2"></i><?php echo e($errors->first()); ?>

            </div>
        <?php endif; ?>

        <form method="POST" action="<?php echo e(route('verification.otp.verify')); ?>" id="otp-form">
            <?php echo csrf_field(); ?>
            <div class="otp-inputs">
                <?php for($i = 0; $i < 6; $i++): ?>
                    <input type="text" maxlength="1" class="otp-digit"
                           inputmode="numeric" autocomplete="off">
                <?php endfor; ?>
            </div>
            <input type="hidden" name="otp" id="otp-hidden">

            <p class="otp-note mb-3">Kode berlaku selama <strong>10 menit</strong></p>

            <button type="submit" class="btn-verify" id="verifyBtn">
                <i class="fas fa-shield-check me-2"></i>Verifikasi Sekarang
            </button>
        </form>

        <div class="resend-section">
            Tidak dapat kode?
            <form method="POST" action="<?php echo e(route('verification.otp.send')); ?>" class="d-inline" id="resend-form">
                <?php echo csrf_field(); ?>
                <button type="submit" class="btn-resend" id="resendBtn">
                    Kirim ulang OTP
                </button>
            </form>
            <span id="countdownWrap" style="display:none;">
                dalam <span class="countdown" id="countdown">60</span> detik
            </span>
        </div>

        <div class="text-center mt-3">
            <form method="POST" action="<?php echo e(route('logout')); ?>">
                <?php echo csrf_field(); ?>
                <button type="submit" style="background:none; border:none; color:#9ca3af; font-size:12px; cursor:pointer;">
                    <i class="fas fa-sign-out-alt me-1"></i>Keluar dari akun ini
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    // ── OTP Input Logic ──
    const digits  = document.querySelectorAll('.otp-digit');
    const hidden  = document.getElementById('otp-hidden');
    const verifyBtn = document.getElementById('verifyBtn');

    function updateHidden() {
        hidden.value = [...digits].map(d => d.value).join('');
        // Enable button only when all 6 filled
        verifyBtn.disabled = hidden.value.length < 6;
    }

    digits.forEach((input, index) => {
        input.addEventListener('keypress', e => {
            if (!/[0-9]/.test(e.key)) e.preventDefault();
        });

        input.addEventListener('input', function() {
            this.value = this.value.replace(/\D/g, '').slice(0, 1);
            this.classList.toggle('filled', this.value !== '');
            if (this.value && index < digits.length - 1) digits[index + 1].focus();
            updateHidden();
        });

        input.addEventListener('keydown', e => {
            if (e.key === 'Backspace' && !input.value && index > 0) {
                digits[index - 1].focus();
                digits[index - 1].classList.remove('filled');
            }
        });

        input.addEventListener('paste', e => {
            e.preventDefault();
            const pasted = e.clipboardData.getData('text').replace(/\D/g, '').slice(0, 6);
            pasted.split('').forEach((char, i) => {
                if (digits[i]) {
                    digits[i].value = char;
                    digits[i].classList.add('filled');
                }
            });
            updateHidden();
            if (digits[pasted.length - 1]) digits[pasted.length - 1].focus();
        });
    });

    verifyBtn.disabled = true;
    digits[0].focus();

    // ── Countdown Resend ──
    function startCountdown(seconds) {
        const resendBtn     = document.getElementById('resendBtn');
        const countdownWrap = document.getElementById('countdownWrap');
        const countdown     = document.getElementById('countdown');

        resendBtn.disabled = true;
        resendBtn.style.display = 'none';
        countdownWrap.style.display = 'inline';

        let remaining = seconds;
        countdown.textContent = remaining;

        const timer = setInterval(() => {
            remaining--;
            countdown.textContent = remaining;
            if (remaining <= 0) {
                clearInterval(timer);
                resendBtn.disabled = false;
                resendBtn.style.display = 'inline';
                countdownWrap.style.display = 'none';
            }
        }, 1000);
    }

    // Start countdown on page load
    startCountdown(60);

    document.getElementById('resend-form').addEventListener('submit', function() {
        startCountdown(60);
    });

    document.getElementById('otp-form').addEventListener('submit', updateHidden);
</script>
</body>
</html><?php /**PATH D:\PA_03\PA2\resources\views/auth/otp-verification.blade.php ENDPATH**/ ?>