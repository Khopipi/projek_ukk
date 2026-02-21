@extends('layouts.auth')

@section('title', 'Resetting Your Password ?')

@section('content')

    <style>
        .reset-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .reset-header h3 {
            background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-size: 26px !important;
            margin-bottom: 12px;
        }

        .user-info {
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            border: 2px solid #dbeafe;
            border-radius: 10px;
            padding: 16px;
            margin-bottom: 24px;
        }

        .user-info p {
            margin-bottom: 6px;
            font-weight: 500;
            color: #1e3c72;
        }

        .user-info b {
            color: #3b82f6;
        }
    </style>

    <div class="card">
        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="email" value="{{ $user->email }}">
            <div class="card-body">
                <div class="reset-header">
                    <h3><i class="ti ti-lock-reset me-2"></i>Reset Password</h3>
                    <p class="text-muted mb-0">Buat password baru yang kuat dan aman</p>
                </div>

                <div class="user-info">
                    <p><i class="ti ti-user me-2"></i>Nama: <b>{{ $user->name }}</b></p>
                    <p><i class="ti ti-mail me-2"></i>Email: <b>{{ $user->email }}</b></p>
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

                <div class="form-group">
                    <label class="form-label"><i class="ti ti-lock me-1"></i>Password Baru</label>
                    <input type="password" name="password" class="form-control" placeholder="Masukkan password baru (minimal 8 karakter)" required>
                    <small class="text-muted">
                        <i class="ti ti-info-circle me-1"></i>Minimal 8 karakter, kombinasi huruf, angka, dan simbol
                    </small>
                </div>

                <div class="form-group">
                    <label class="form-label"><i class="ti ti-lock-check me-1"></i>Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password baru" required>
                </div>

                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="ti ti-lock-reset me-2"></i>Reset Password
                    </button>
                </div>

                <div style="text-align: center; margin-top: 20px;">
                    <a href="{{ route('login') }}" class="text-primary fw-bold">
                        <i class="ti ti-arrow-left me-1"></i>Kembali ke Login
                    </a>
                </div>
            </div>
        </form>
    </div>
@endsection
