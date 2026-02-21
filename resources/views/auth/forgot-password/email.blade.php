@extends('layouts.auth')

@section('title', 'Forgot Your Password ?')

@section('content')

    <style>
        .forgot-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .forgot-header h3 {
            background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-size: 26px !important;
            margin-bottom: 8px;
        }

        .forgot-header p {
            color: #64748b;
            font-weight: 500;
            margin-bottom: 0;
        }
    </style>

    <div class="card">
        <form method="POST" action="{{ route('forgot_password.send_link') }}">
            @csrf
            <div class="card-body">
                <div class="forgot-header">
                    <h3><i class="ti ti-key me-2"></i>Lupa Password?</h3>
                    <p>Masukkan email Anda untuk reset password</p>
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
                    <label class="form-label"><i class="ti ti-mail me-1"></i>Alamat Email</label>
                    <input type="email" name="email" class="form-control" id="floatingInput" placeholder="Masukkan email Anda"
                        autocomplete="off" autofocus required>
                </div>
                
                <p class="text-muted mt-3 mb-4">
                    <i class="ti ti-info-circle me-1"></i>Jangan lupa cek folder SPAM untuk email reset password.
                </p>

                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="ti ti-mail-check me-2"></i>Kirim Link Reset
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
