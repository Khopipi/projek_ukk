@extends('layouts.auth')

@section('title', 'Login Page')

@section('content')
    <style>
        /* Hide number input spinner */
        input[type="number"]::-webkit-outer-spin-button,
        input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        input[type="number"] {
            -moz-appearance: textfield;
        }

        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .login-header h3 {
            background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-size: 28px !important;
            margin-bottom: 8px;
        }

        .login-header p {
            color: #64748b;
            font-weight: 500;
            margin-bottom: 0;
        }

        .login-links {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 16px;
            padding: 12px 0;
            flex-wrap: wrap;
            gap: 8px;
        }

        .login-links a {
            font-size: 13px;
            font-weight: 600;
        }

        .form-check-label {
            font-size: 13px;
        }
    </style>
    
    <div class="card">
        <form method="POST" action="{{ route('login.post') }}">
            @csrf
            <div class="card-body">
                <div class="login-header">
                    <h3><i class="ti ti-login me-2"></i>Login Akun</h3>
                    <p>Masuk ke akun Anda untuk lanjut</p>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <i class="ti ti-alert-circle"></i>
                        <div>
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success">
                        <i class="ti ti-check"></i>
                        <div>{{ session('success') }}</div>
                    </div>
                @endif

                <div class="form-group">
                    <label class="form-label"><i class="ti ti-id-badge me-1"></i>NIK (Nomor Induk Kependudukan)</label>
                    <input type="text"
                           class="form-control @error('nik') is-invalid @enderror"
                           name="nik"
                           id="nik_input"
                           placeholder="Masukkan 16 digit NIK Anda"
                           value="{{ session('registered_nik') ?? old('nik') }}"
                           maxlength="16"
                           inputmode="numeric"
                           pattern="[0-9]*"
                           autocomplete="off"
                           required>
                    @error('nik')
                        <div class="invalid-feedback"><i class="ti ti-alert-circle me-1"></i>{{ $message }}</div>
                    @enderror
                    <small><i class="ti ti-info-circle me-1"></i>Harus 16 digit (0-9)</small>
                </div>

                <div class="form-group">
                    <label class="form-label"><i class="ti ti-lock me-1"></i>Password</label>
                    <input id="password"
                           type="password"
                           class="form-control @error('password') is-invalid @enderror"
                           name="password"
                           placeholder="Masukkan password Anda"
                           required>
                    @error('password')
                        <div class="invalid-feedback"><i class="ti ti-alert-circle me-1"></i>{{ $message }}</div>
                    @enderror
                </div>

                <!-- CAPTCHA VERIFICATION -->
                <div class="form-group">
                    <label class="form-label"><i class="ti ti-lock me-1"></i>Verifikasi CAPTCHA <span style="color: #dc3545;">*</span></label>
                    <div style="background: linear-gradient(135deg, #f0f2ff 0%, #e9ebff 100%); padding: 16px; border-radius: 10px; border: 2px dashed #5b6ef5; margin-bottom: 12px;">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div>
                                <p class="mb-1" style="font-weight: 600; color: #2d3748;">Selesaikan operasi matematika ini:</p>
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <span style="font-size: 20px; font-weight: 800; color: #5b6ef5;" id="captchaQuestion">7 + 3 = ?</span>
                                    <button type="button" class="btn btn-sm btn-outline-primary" id="refreshCaptcha" style="padding: 6px 12px; font-size: 12px;">
                                        <i class="ti ti-refresh"></i> Baru
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="number"
                           class="form-control @error('captcha_answer') is-invalid @enderror"
                           id="captchaAnswer"
                           name="captcha_answer"
                           placeholder="Masukkan jawaban Anda di sini"
                           required
                           style="min-height: 45px; font-weight: 600;">
                    @error('captcha_answer')
                        <div class="invalid-feedback" style="display: block;"><i class="ti ti-alert-circle me-1"></i>{{ $message }}</div>
                    @enderror
                    <small class="text-muted" style="display: block; margin-top: 6px;"><i class="ti ti-info-circle me-1"></i>Jawaban Anda akan diverifikasi untuk memastikan Anda adalah manusia</small>
                </div>

                <div class="login-links">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="customCheckc1" name="remember">
                        <label class="form-check-label" for="customCheckc1">Ingat Saya</label>
                    </div>
                    <a href="{{ route('forgot_password.email_form') }}" class="text-primary"><i class="ti ti-help me-1"></i>Lupa Password?</a>
                </div>

                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-primary btn-lg" id="login_btn">
                        <i class="ti ti-login me-2"></i>Masuk
                    </button>
                </div>

                <div style="text-align: center; margin-top: 20px;">
                    <p class="text-muted mb-0">Belum punya akun? <a href="/register" class="fw-bold">Daftar di sini</a></p>
                </div>
            </div>
        </form>
    </div>

    <script>
        // Variabel global untuk menyimpan jawaban CAPTCHA yang benar
        let correctCaptchaAnswer = null;

        // Function untuk generate CAPTCHA question
        function generateCaptcha() {
            const num1 = Math.floor(Math.random() * 20) + 1;
            const num2 = Math.floor(Math.random() * 20) + 1;
            const operations = ['+', '-', '*'];
            const operation = operations[Math.floor(Math.random() * operations.length)];

            let answer;
            if (operation === '+') {
                answer = num1 + num2;
            } else if (operation === '-') {
                answer = num1 - num2;
            } else {
                answer = num1 * num2;
            }

            const question = `${num1} ${operation} ${num2} = ?`;
            document.getElementById('captchaQuestion').textContent = question;
            document.getElementById('captchaAnswer').value = '';
            document.getElementById('captchaAnswer').classList.remove('is-invalid');
            
            correctCaptchaAnswer = answer;
            console.log('Jawaban CAPTCHA yang benar: ' + correctCaptchaAnswer);
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Generate CAPTCHA pertama kali
            generateCaptcha();

            // Event listener untuk tombol refresh CAPTCHA
            document.getElementById('refreshCaptcha').addEventListener('click', function(e) {
                e.preventDefault();
                generateCaptcha();
            });
        });

        // Validate NIK input - only allow digits and max 16 characters
        const nikInput = document.getElementById('nik_input');
        const loginBtn = document.getElementById('login_btn');

        if (nikInput) {
            // Prevent non-numeric input
            nikInput.addEventListener('input', function(e) {
                // Remove non-digit characters
                this.value = this.value.replace(/[^0-9]/g, '');
                
                // Enforce max length
                if (this.value.length > 16) {
                    this.value = this.value.slice(0, 16);
                }
            });

            // Prevent paste of non-numeric content
            nikInput.addEventListener('paste', function(e) {
                e.preventDefault();
                const pastedText = (e.clipboardData || window.clipboardData).getData('text');
                const numericOnly = pastedText.replace(/[^0-9]/g, '');
                this.value = numericOnly.slice(0, 16);
            });

            // Validate form before submit
            nikInput.form.addEventListener('submit', function(e) {
                const captchaAnswer = document.getElementById('captchaAnswer').value;
                
                // Validasi NIK
                if (nikInput.value.length !== 16) {
                    e.preventDefault();
                    nikInput.classList.add('is-invalid');
                    const feedback = nikInput.parentElement.querySelector('.invalid-feedback');
                    if (!feedback) {
                        const errorDiv = document.createElement('div');
                        errorDiv.className = 'invalid-feedback d-block';
                        errorDiv.innerHTML = '<i class="ti ti-alert-circle me-1"></i>NIK harus exactly 16 digit!';
                        nikInput.parentElement.appendChild(errorDiv);
                    }
                    nikInput.focus();
                    return false;
                }
                
                // Validasi CAPTCHA
                if (parseInt(captchaAnswer) !== correctCaptchaAnswer) {
                    e.preventDefault();
                    const captchaInput = document.getElementById('captchaAnswer');
                    captchaInput.classList.add('is-invalid');
                    let feedback = captchaInput.parentElement.querySelector('.invalid-feedback');
                    if (feedback) {
                        feedback.innerHTML = '<i class="ti ti-alert-circle me-1"></i>Jawaban CAPTCHA salah!';
                        feedback.style.display = 'block';
                    }
                    captchaInput.focus();
                    return false;
                }
            });
        }
    </script>
@endsection
