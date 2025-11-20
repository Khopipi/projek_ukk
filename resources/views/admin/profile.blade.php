@extends('layouts.dashboard')

@section('title', 'Profil Admin')

@section('content')

@include('partials.welcome-navbar')

<div class="container my-4">
    <div class="row">
        <div class="col-12 mb-3">
            <a href="{{ route('admin.verifikasi') }}" class="text-decoration-none text-muted">&larr; Kembali ke Admin</a>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm text-center">
                <div class="card-body">
                    @php $avatarUrl = $user->avatar ?? asset('assets/images/user/avatar-1.jpg'); @endphp
                    <div class="mx-auto mb-3" style="width:120px;height:120px;border-radius:50%;overflow:hidden;box-shadow:0 8px 20px rgba(0,0,0,0.08);">
                        <img src="{{ $avatarUrl }}" alt="avatar" onerror="this.style.display='none'" style="width:100%;height:100%;object-fit:cover;">
                    </div>
                    <h5 class="mb-0">{{ $user->name }}</h5>
                    <p class="text-muted small mb-2">NIK: {{ $user->nik }}</p>
                    <p class="mb-2"><span class="badge bg-primary">{{ ucfirst($user->role) }}</span></p>
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-primary btn-sm">Kembali ke Dashboard</a>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Detail Admin</h5>

                    <div class="row mb-2">
                        <div class="col-sm-4 text-muted">Email</div>
                        <div class="col-sm-8">{{ $user->email ?? '-' }}</div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-sm-4 text-muted">No. Telepon</div>
                        <div class="col-sm-8">{{ $user->no_telepon ?? '-' }}</div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-sm-4 text-muted">Verifikasi Email</div>
                        <div class="col-sm-8">
                            @if($user->is_verified)
                                <span class="badge bg-success">Terverifikasi</span>
                            @else
                                <span class="badge bg-warning">Belum</span>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>

</div>

@endsection
