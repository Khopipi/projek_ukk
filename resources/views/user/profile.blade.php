@extends('layouts.dashboard')

@section('title', 'Profil Saya')

@section('content')

@include('partials.welcome-navbar')

<div class="container my-4">
    <div class="row">
        <div class="col-12 mb-3">
            <a href="{{ route('dashboard') }}" class="text-decoration-none text-muted">&larr; Kembali ke Dashboard</a>
        </div>

        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    @php
                        // Determine avatar: use uploaded avatar if present, otherwise generate a simple SVG placeholder by gender
                        function gender_avatar_svg($name, $gender = null, $size = 140) {
                            $initials = collect(explode(' ', trim($name)))->map(function($p){ return strtoupper(substr($p,0,1)); })->take(2)->join('');
                            $bg = '#6a11cb';
                            $fg = '#ffffff';
                            if ($gender) {
                                if (stripos($gender, 'laki') !== false || stripos($gender, 'l') === 0) {
                                    $bg = '#2575fc';
                                } elseif (stripos($gender, 'perempuan') !== false || stripos($gender, 'p') === 0) {
                                    $bg = '#ff6b81';
                                }
                            }
                            $svg = "<svg xmlns='http://www.w3.org/2000/svg' width='$size' height='$size' viewBox='0 0 $size $size'>".
                                   "<rect width='100%' height='100%' rx='50%' fill='$bg'/>".
                                   "<text x='50%' y='54%' font-family='Arial, Helvetica, sans-serif' font-size='".($size*0.36)."' fill='$fg' text-anchor='middle' dominant-baseline='middle'>".$initials."</text>".
                                   "</svg>";
                            return 'data:image/svg+xml;utf8,'.rawurlencode($svg);
                        }

                        $avatarUrl = $user->avatar ?? gender_avatar_svg($user->name, $user->jenis_kelamin, 320);
                        $avatarThumb = $user->avatar ?? gender_avatar_svg($user->name, $user->jenis_kelamin, 80);
                    @endphp

                    <div class="mx-auto mb-3" style="width:140px;height:140px;border-radius:50%;overflow:hidden;box-shadow:0 8px 24px rgba(34,41,47,0.12);position:relative;">
                        <img src="{{ $avatarUrl }}" alt="avatar" onerror="this.style.display='none'" style="width:100%;height:100%;object-fit:cover;display:block;">
                    </div>

                    <h4 class="mb-0">
                        <img src="{{ $avatarThumb }}" alt="avatar-sm" style="width:36px;height:36px;object-fit:cover;border-radius:50%;vertical-align:middle;margin-right:8px;box-shadow:0 6px 18px rgba(0,0,0,0.08);">{{ $user->name }}
                    </h4>
                    <p class="text-muted mb-1">NIK: <strong class="text-dark">{{ $user->nik }}</strong></p>
                    <p class="text-muted small">Role: <span class="badge bg-primary text-white">{{ ucfirst($user->role) }}</span></p>

                    <div class="d-grid gap-2 mt-3">
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary" role="button">Kembali ke Dashboard</a>
                    </div>
                </div>
            </div>

            <div class="card mt-3 shadow-sm">
                <div class="card-body">
                    <h6 class="mb-3">Ringkasan</h6>
                    <p class="mb-1"><strong>{{ $user->pengajuanSurat()->count() }}</strong> Pengajuan</p>
                    <p class="mb-0"><strong>{{ $user->pengaduans()->count() }}</strong> Pengaduan</p>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-3">Detail Profil</h5>

                    <div class="row">
                        <div class="col-md-4 text-muted">Email</div>
                        <div class="col-md-8">{{ $user->email ?? '-' }}</div>
                    </div>
                    <hr>

                    <div class="row">
                        <div class="col-md-4 text-muted">No. KK</div>
                        <div class="col-md-8">{{ $user->no_kk ?? '-' }}</div>
                    </div>
                    <hr>

                    <div class="row">
                        <div class="col-md-4 text-muted">Tempat, Tanggal Lahir</div>
                        <div class="col-md-8">{{ $user->tempat_lahir ?? '-' }}, {{ $user->tanggal_lahir ? $user->tanggal_lahir->format('d M Y') : '-' }}</div>
                    </div>
                    <hr>

                    <div class="row">
                        <div class="col-md-4 text-muted">Jenis Kelamin</div>
                        <div class="col-md-8">{{ $user->jenis_kelamin ?? '-' }}</div>
                    </div>
                    <hr>

                    <div class="row">
                        <div class="col-md-4 text-muted">Alamat Lengkap</div>
                        <div class="col-md-8">{{ $user->alamat_lengkap ?? '-' }}</div>
                    </div>
                    <hr>

                    <div class="row">
                        <div class="col-md-4 text-muted">Agama</div>
                        <div class="col-md-8">{{ $user->agama ?? '-' }}</div>
                    </div>
                    <hr>

                    <div class="row">
                        <div class="col-md-4 text-muted">Status Perkawinan</div>
                        <div class="col-md-8">{{ $user->status_perkawinan ?? '-' }}</div>
                    </div>
                    <hr>

                    <div class="row">
                        <div class="col-md-4 text-muted">Pekerjaan</div>
                        <div class="col-md-8">{{ $user->pekerjaan ?? '-' }}</div>
                    </div>
                    <hr>

                    <div class="row">
                        <div class="col-md-4 text-muted">Pendidikan Terakhir</div>
                        <div class="col-md-8">{{ $user->pendidikan_terakhir ?? '-' }}</div>
                    </div>
                    <hr>

                    <div class="row">
                        <div class="col-md-4 text-muted">No. Telepon</div>
                        <div class="col-md-8">{{ $user->no_telepon ?? '-' }}</div>
                    </div>
                    <hr>

                    <div class="row align-items-center">
                        <div class="col-md-4 text-muted">Verifikasi Email</div>
                        <div class="col-md-8">
                            @if($user->is_verified)
                                <span class="badge bg-success">Terverifikasi</span>
                            @else
                                <span class="badge bg-warning">Belum</span>
                                <a href="{{ route('verify.form') }}" class="btn btn-sm btn-link">Verifikasi Sekarang</a>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
