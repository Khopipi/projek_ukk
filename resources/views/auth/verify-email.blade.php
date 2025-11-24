@extends('layouts.auth')

@section('title', 'Verify Email')

@section('content')
    <div class="card my-5">
        @if (session('verify_email'))
            <div class="card-body">
                <div class="mb-4">
                    <h3 class="mb-2"><b>Enter Verification Code</b></h3>

                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @else
                        <div>
                            We`ve send you code on {{ session('verify_email') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger my-2">

                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach

                        </div>
                    @endif
                </div>

                {{-- Form Verifikasi OTP --}}

                <form action="{{ route('verify.otp') }}" method="POST" id="verifyForm">
                    @csrf
                    <input type="hidden" name="email" value="{{ session('verify_email') }}">
                    <div class="row text-center">
                        @for ($i = 0; $i < 6; $i++)
                            <div class="col">
                                <input type="text" maxlength="1" class="form-control text-center otp-input"
                                    style="font-size:16px;" name="otp[]" required>
                            </div>
                        @endfor
                    </div>

                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary">Continue</button>
                    </div>
                </form>


                {{-- Resend OTP --}}

                <div class="d-flex justify-content-between align-items-end mt-3">
                    <p class="mb-0" style="font-size:12px;">Did not receive the email? Check your spam filter, or</p>
                    <form action="{{ route('send.otp') }}" method="POST" id="resendForm">
                        @csrf
                        <input type="hidden" name="email" value="{{ session('verify_email') }}">
                        <button style="font-size:12px;" type="submit" id="resendBtn" class="btn btn-link p-0"
                            disabled>Resend
                            code (<span id="timer"></span>s)</button>
                    </form>
                </div>

            </div>
        @else
            <div class="card-body">
                {{-- buat pesan bahwa ini halaman untuk memverifikasi email melalui , jadi anda harus melakukan register email dulu baru nanti bisa mengakses konten halaman ini --}}
                <div class="alert alert-warning">
                    This page is for email verification. Please register your email first before accessing this content.
                </div>
                <div class="d-flex justify-content-center">
                    <a href="{{ route('register') }}" class="btn btn-primary">Go to Register</a>
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
                // Ambil semua elemen input OTP
                const inputs = document.querySelectorAll(".otp-input");
                inputs.forEach((input, index) => {
                    // Hanya boleh angka
                    input.addEventListener("input", (e) => {
                        e.target.value = e.target.value.replace(/[^0-9]/g, "");

                        if (e.target.value.length === 1 && index < inputs.length - 1) {
                            inputs[index + 1].focus();
                        }
                    });

                    // Fokus ke input sebelumnya kalau backspace
                    input.addEventListener("keydown", (e) => {
                        if (e.key === "Backspace" && !e.target.value && index > 0) {
                            inputs[index - 1].focus();
                        }
                    });

                    // Kalau paste langsung isi ke semua kotak
                    input.addEventListener("paste", (e) => {
                        e.preventDefault();
                        const pasteData = (e.clipboardData || window.clipboardData).getData("text");
                        const digits = pasteData.replace(/[^0-9]/g, "").split("");

                        digits.forEach((digit, i) => {
                            if (i < inputs.length) {
                                inputs[i].value = digit;
                            }
                        });

                        // Fokus ke input terakhir yang terisi
                        const filledIndex = Math.min(digits.length, inputs.length) - 1;
                        if (filledIndex >= 0) inputs[filledIndex].focus();
                    });
                });
                // Gabungkan OTP sebelum submit
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
                // 2. Countdown Timer (localStorage)
                // -------------------
                let resendBtn = document.getElementById("resendBtn");
                let timerSpan = document.getElementById("timer");

                // Ambil waktu akhir dari localStorage
                let endTime = localStorage.getItem("otp_end_time");


                let setResendOtp = {{ $timeResendOtp }}
                let timer = {{ $cooldown }} < setResendOtp ? setResendOtp : 0
                console.log(timer)
                if (!endTime) {
                    console.log('masuk a')
                    endTime = Date.now() + (timer * 1000);
                    localStorage.setItem("otp_end_time", endTime);
                } else {
                    console.log('masuk b')
                    endTime = parseInt(endTime);
                }


                let countdown = setInterval(() => {
                    let remaining = Math.floor((endTime - Date.now()) / 1000);

                    if (remaining <= 0) {
                        clearInterval(countdown);
                        resendBtn.disabled = false;
                        resendBtn.textContent = "Resend code";
                        localStorage.removeItem("otp_end_time");
                    } else {
                        timerSpan.textContent = remaining;
                        resendBtn.disabled = true;
                        resendBtn.innerHTML = `Resend code (<span id="timer">${remaining}</span>s)`;
                    }
                }, 1000);


                // -------------------
                // 3. Reset Timer saat Resend
                // -------------------
                document.getElementById("resendForm").addEventListener("submit", function() {
                    let newEndTime = Date.now() + (setResendOtp * 1000); // selalu reset ke 60 detik
                    localStorage.setItem("otp_end_time", newEndTime);
                });
            });
        </script>
    @endif

@endsection
