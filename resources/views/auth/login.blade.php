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
    </style>
    <div class="card my-5">
        <form method="POST" action="{{ route('login.post') }}">
            @csrf
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-end mb-4">
                    <h3 class="mb-0"><b>Login</b></h3>
                    <a href="/register" class="link-primary">Belum punya akun?</a>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="form-group mb-3">
                    <label class="form-label">NIK (Nomor Induk Kependudukan)</label>
                    <input type="text"
                           class="form-control @error('nik') is-invalid @enderror"
                           name="nik"
                           id="nik_input"
                           placeholder="Masukkan NIK 16 digit"
                           value="{{ session('registered_nik') ?? old('nik') }}"
                           maxlength="16"
                           inputmode="numeric"
                           pattern="[0-9]*"
                           autocomplete="off"
                           required>
                    @error('nik')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">NIK:16 Angka (Harus exactly 16 digit)</small>
                </div>

                <div class="form-group mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input id="password"
                           type="password"
                           class="form-control @error('password') is-invalid @enderror"
                           name="password"
                           placeholder="Masukkan Password"
                           required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex mt-1 justify-content-between">
                    <div class="form-check">
                        <input class="form-check-input input-primary" type="checkbox" id="customCheckc1" name="remember">
                        <label class="form-check-label text-muted" for="customCheckc1">Ingat Saya</label>
                    </div>
                    <a href="{{ route('forgot_password.email_form') }}" class="text-secondary f-w-400">Lupa Password?</a>
                </div>

                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-primary" id="login_btn">Login</button>
                </div>
            </div>
        </form>
    </div>

    <script>
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
                if (nikInput.value.length !== 16) {
                    e.preventDefault();
                    nikInput.classList.add('is-invalid');
                    const feedback = nikInput.parentElement.querySelector('.invalid-feedback');
                    if (!feedback) {
                        const errorDiv = document.createElement('div');
                        errorDiv.className = 'invalid-feedback d-block';
                        errorDiv.textContent = 'NIK harus exactly 16 digit!';
                        nikInput.parentElement.appendChild(errorDiv);
                    }
                    nikInput.focus();
                    return false;
                }
            });
        }
    </script>
@endsection
