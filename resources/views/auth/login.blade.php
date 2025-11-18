@extends('layouts.auth')

@section('title', 'Login Page')

@section('content')
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
                           placeholder="Masukkan NIK 16 digit"
                           value="{{ session('registered_nik') ?? old('nik') }}"
                           maxlength="16"
                           autocomplete="off"
                           required>
                    @error('nik')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Contoh: 3578012345678901</small>
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
                    <button type="submit" class="btn btn-primary">Login</button>
                </div>

                <div class="saprator mt-3">
                    <span>Login dengan</span>
                </div>
                @include('auth.sso')
            </div>
        </form>
    </div>
@endsection
