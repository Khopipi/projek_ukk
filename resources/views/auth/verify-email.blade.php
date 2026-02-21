@extends('layouts.auth')

@section('title', 'Verify Email')

@section('content')

    <style>
        .verify-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .verify-header h3 {
            background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-size: 26px !important;
            margin-bottom: 8px;
        }

        .verify-header p {
            color: #64748b;
            font-weight: 500;
            margin-bottom: 0;
        }

        .otp-container {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 10px;
            margin: 30px 0;
        }

        .otp-input {
            width: 100% !important;
            height: 50px !important;
            font-size: 20px !important;
            font-weight: 700;
            text-align: center;
            border: 2px solid #dbeafe !important;
            border-radius: 10px !important;
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%) !important;
            color: #1e3c72 !important;
            transition: all 0.3s ease;
        }

        .otp-input:focus {
            border-color: #3b82f6 !important;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1) !important;
            outline: none;
        }

        .otp-input::-webkit-outer-spin-button,
        .otp-input::-webkit-inner-spin-button {
            display: none;
        }

        .resend-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 20px;
            border-top: 1px solid #dbeafe;
            margin-top: 24px;
        }

        .resend-section p {
            font-size: 13px;
            margin-bottom: 0;
        }

        #resendBtn {
            font-size: 13px !important;
            padding: 6px 12px !important;
            transition: all 0.3s ease;
        }

        #resendBtn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }
    </style>

    <div class="card">
        @if (session('verify_email'))
            <div class="card-body">
                <div class="verify-header">
                    <h3><i class="ti ti-mail-check me-2"></i>Verifikasi Email</h3>
                    <p>Masukkan kode verifikasi yang dikirim ke email Anda</p>
                </div>

                @if (session('success'))
                    <div class="alert alert-success">
                        <i class="ti ti-check"></i>
                        <div>{{ session('success') }}</div>
                    </div>
                @else
                    <div class="alert alert-info">
                        <i class="ti ti-info-circle"></i>
                        <div>Kami telah mengirimkan kode verifikasi ke <b>{{ session('verify_email') }}</b></div>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger mt-3">
                        <i class="ti ti-alert-circle"></i>
                        <div>
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Form Verifikasi OTP --}}
                <form action="{{ route('verify.otp') }}" method="POST" id="verifyForm">
                    @csrf
                    <input type="hidden" name="email" value="{{ session('verify_email') }}">
                    
                    <label class="form-label text-center d-block mb-3"><i class="ti ti-key me-1"></i>Kode Verifikasi (6 digit)</label>
                    
                    <div class="otp-container">
                        @for ($i = 0; $i < 6; $i++)
                            <input type="text" maxlength="1" class="form-control otp-input" name="otp[]" required>
                        @endfor
                    </div>

                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="ti ti-check me-2"></i>Verifikasi
                        </button>
                    </div>
                </form>

                {{-- Resend OTP --}}
                <div class="resend-section">
                    <p class="text-muted">Tidak menerima kode? Cek folder spam atau</p>
                    <form action="{{ route('send.otp') }}" method="POST" id="resendForm">
                        @csrf
                        <input type="hidden" name="email" value="{{ session('verify_email') }}">
                        <button type="submit" id="resendBtn" class="btn btn-link p-0" disabled>
                            <i class="ti ti-refresh me-1"></i>Kirim ulang (<span id="timer"></span>s)
                        </button>
                    </form>
                </div>
            </div>
        @else
            <div class="card-body">
                <div style="text-align: center; padding: 40px 20px;">
                    <div style="font-size: 48px; color: #ffa500; margin-bottom: 20px;">
                        <i class="ti ti-alert-triangle"></i>
                    </div>
                    <h4 style="color: #1e3c72; margin-bottom: 12px;">Akses Ditolak</h4>
                    <p class="text-muted mb-4">Halaman ini khusus untuk verifikasi email. Silakan lakukan registrasi terlebih dahulu.</p>
                    <a href="{{ route('register') }}" class="btn btn-primary">
                        <i class="ti ti-user-plus me-2"></i>Ke Halaman Registrasi
                    </a>
                </div>
            </div>
        @endif
    </div>

@endsection

@section('scripts_content')

    {{-- Script untuk OTP & Timer --}}
    @if (session('verify_email'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                // -------------------
                // 1. Handle Input OTP
                // -------------------
                const inputs = document.querySelectorAll(".otp-input");
                inputs.forEach((input, index) => {
                    input.addEventListener("input", (e) => {
                        e.target.value = e.target.value.replace(/[^0-9]/g, "");

                        if (e.target.value.length === 1 && index < inputs.length - 1) {
                            inputs[index + 1].focus();
                        }
                    });

                    input.addEventListener("keydown", (e) => {
                        if (e.key === "Backspace" && !e.target.value && index > 0) {
                            inputs[index - 1].focus();
                        }
                    });

                    input.addEventListener("paste", (e) => {
                        e.preventDefault();
                        const pasteData = (e.clipboardData || window.clipboardData).getData("text");
                        const digits = pasteData.replace(/[^0-9]/g, "").split("");

                        digits.forEach((digit, i) => {
                            if (i < inputs.length) {
                                inputs[i].value = digit;
                            }
                        });

                        const filledIndex = Math.min(digits.length, inputs.length) - 1;
                        if (filledIndex >= 0) inputs[filledIndex].focus();
                    });
                });

                document.getElementById("verifyForm").addEventListener("submit", function(e) {
                    e.preventDefault();
                    let otpValue = "";
                    inputs.forEach(input => otpValue += input.value);
                    let hiddenInput = document.createElement("input");
                    hiddenInput.type = "hidden";
                    hiddenInput.name = "otp";
                    hiddenInput.value = otpValue;
                    this.appendChild(hiddenInput);
                    this.submit();
                });

                // -------------------
                // 2. Countdown Timer
                // -------------------
                let resendBtn = document.getElementById("resendBtn");
                let timerSpan = document.getElementById("timer");

                let endTime = localStorage.getItem("otp_end_time");
                let setResendOtp = {{ $timeResendOtp }}
                let timer = {{ $cooldown }} < setResendOtp ? setResendOtp : 0

                if (!endTime) {
                    endTime = Date.now() + (timer * 1000);
                    localStorage.setItem("otp_end_time", endTime);
                } else {
                    endTime = parseInt(endTime);
                }

                let countdown = setInterval(() => {
                    let remaining = Math.floor((endTime - Date.now()) / 1000);

                    if (remaining <= 0) {
                        clearInterval(countdown);
                        resendBtn.disabled = false;
                        resendBtn.innerHTML = '<i class="ti ti-refresh me-1"></i>Kirim ulang';
                        localStorage.removeItem("otp_end_time");
                    } else {
                        timerSpan.textContent = remaining;
                        resendBtn.disabled = true;
                        resendBtn.innerHTML = `<i class="ti ti-refresh me-1"></i>Kirim ulang (<span id="timer">${remaining}</span>s)`;
                    }
                }, 1000);

                document.getElementById("resendForm").addEventListener("submit", function() {
                    let newEndTime = Date.now() + (setResendOtp * 1000);
                    localStorage.setItem("otp_end_time", newEndTime);
                });
            });
        </script>
    @endif

@endsection
