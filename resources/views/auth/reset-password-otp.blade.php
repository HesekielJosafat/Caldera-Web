<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Caldera Resto & Pool</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * { font-family: 'Poppins', sans-serif; }
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .card-container { max-width: 450px; width: 100%; }
        .card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .card-header-custom {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 30px;
            text-align: center;
            color: white;
        }
        .card-header-custom .icon-wrap {
            width: 60px;
            height: 60px;
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
        }
        .card-header-custom h2 { margin: 0; font-weight: 600; font-size: 22px; }
        .card-header-custom p { margin: 5px 0 0; opacity: 0.9; font-size: 14px; }
        .email-badge {
            display: inline-block;
            background: rgba(255,255,255,0.25);
            border-radius: 20px;
            padding: 4px 14px;
            font-size: 13px;
            margin-top: 8px;
            font-weight: 500;
        }
        .card-body-custom { padding: 30px; background: white; }
        .otp-inputs {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin-bottom: 6px;
        }
        .otp-inputs input {
            width: 48px;
            height: 56px;
            text-align: center;
            font-size: 22px;
            font-weight: 600;
            border: 1.5px solid #d1d5db;
            border-radius: 10px;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
            color: #111827;
        }
        .otp-inputs input:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102,126,234,0.15);
        }
        .otp-inputs input.is-invalid {
            border-color: #dc3545;
        }
        .form-control {
            border-radius: 10px;
            padding: 12px 15px;
            font-size: 14px;
        }
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102,126,234,0.15);
        }
        .input-group .form-control { border-right: none; }
        .input-group .btn-toggle-pw {
            border: 1px solid #ced4da;
            border-left: none;
            border-radius: 0 10px 10px 0;
            background: white;
            color: #6b7280;
            padding: 0 14px;
        }
        .input-group .btn-toggle-pw:hover { background: #f9fafb; }
        .btn-submit {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            width: 100%;
            padding: 12px;
            font-weight: 600;
            border-radius: 10px;
            color: white;
            font-size: 15px;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102,126,234,0.4);
            color: white;
        }
        .resend-text {
            text-align: center;
            margin-top: 16px;
            font-size: 13px;
            color: #6b7280;
        }
        .resend-text a { color: #667eea; text-decoration: none; font-weight: 500; }
        .resend-text a:hover { text-decoration: underline; }
        .section-label {
            font-size: 13px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 10px;
        }
        .otp-note {
            font-size: 12px;
            color: #9ca3af;
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<div class="card-container">
    <div class="card">
        <div class="card-header-custom">
            <div class="icon-wrap">
                <i class="fas fa-shield-alt fa-lg"></i>
            </div>
            <h2>Reset Password</h2>
            <p>Masukkan kode OTP yang dikirim ke</p>
            <span class="email-badge">{{ $email }}</span>
        </div>

        <div class="card-body-custom">

            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.otp.reset') }}" id="reset-form">
                @csrf
                <input type="hidden" name="email" value="{{ $email }}">

                {{-- OTP Input --}}
                <div class="mb-3">
                    <p class="section-label">Kode OTP</p>
                    <div class="otp-inputs">
                        @for($i = 0; $i < 6; $i++)
                            <input
                                type="text"
                                maxlength="1"
                                class="otp-digit {{ $errors->has('otp') ? 'is-invalid' : '' }}"
                                inputmode="numeric"
                                autocomplete="off"
                            >
                        @endfor
                    </div>
                    <input type="hidden" name="otp" id="otp-hidden" value="{{ old('otp') }}">
                    <p class="otp-note">Kode berlaku selama <strong>10 menit</strong></p>
                </div>

                {{-- Password Baru --}}
                <div class="mb-3">
                    <label class="form-label section-label">Password Baru</label>
                    <div class="input-group">
                        <input
                            type="password"
                            name="password"
                            id="password"
                            class="form-control @error('password') is-invalid @enderror"
                            placeholder="Minimal 8 karakter"
                            required
                        >
                        <button type="button" class="btn-toggle-pw" onclick="togglePw('password', this)">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="text-danger" style="font-size:12px; margin-top:4px;">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Konfirmasi Password --}}
                <div class="mb-4">
                    <label class="form-label section-label">Konfirmasi Password</label>
                    <div class="input-group">
                        <input
                            type="password"
                            name="password_confirmation"
                            id="password_confirmation"
                            class="form-control"
                            placeholder="Ulangi password baru"
                            required
                        >
                        <button type="button" class="btn-toggle-pw" onclick="togglePw('password_confirmation', this)">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn btn-submit">
                    <i class="fas fa-lock me-2"></i>Reset Password
                </button>
            </form>

            <div class="resend-text">
                Tidak dapat kode?
                <a href="{{ route('password.request') }}">Kirim ulang OTP</a>
            </div>

        </div>
    </div>
</div>

<script>
    const digits = document.querySelectorAll('.otp-digit');
    const hidden = document.getElementById('otp-hidden');

    function updateHidden() {
        hidden.value = [...digits].map(d => d.value).join('');
    }

    // Isi ulang dari old value jika ada
    const oldOtp = hidden.value;
    if (oldOtp) {
        oldOtp.split('').forEach(function(char, i) {
            if (digits[i]) digits[i].value = char;
        });
    }

    digits.forEach(function(input, index) {
        input.addEventListener('keypress', function(e) {
            if (!/[0-9]/.test(e.key)) e.preventDefault();
        });

        input.addEventListener('input', function() {
            this.value = this.value.replace(/\D/g, '').slice(0, 1);
            if (this.value && index < digits.length - 1) {
                digits[index + 1].focus();
            }
            updateHidden();
        });

        input.addEventListener('keydown', function(e) {
            if (e.key === 'Backspace' && !this.value && index > 0) {
                digits[index - 1].focus();
            }
        });

        input.addEventListener('paste', function(e) {
            e.preventDefault();
            const pasted = e.clipboardData.getData('text').replace(/\D/g, '').slice(0, 6);
            pasted.split('').forEach(function(char, i) {
                if (digits[i]) digits[i].value = char;
            });
            updateHidden();
            const lastFilled = Math.min(pasted.length, digits.length - 1);
            digits[lastFilled].focus();
        });
    });

    document.getElementById('reset-form').addEventListener('submit', function() {
        updateHidden();
    });

    digits[0].focus();

    function togglePw(fieldId, btn) {
        const field = document.getElementById(fieldId);
        const icon = btn.querySelector('i');
        if (field.type === 'password') {
            field.type = 'text';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            field.type = 'password';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    }
</script>
</body>
</html>