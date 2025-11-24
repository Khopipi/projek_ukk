@extends('layouts.dashboard')
<<<<<<< HEAD
@section('title', 'Profil Saya')
@section('content')
<div class="pc-content">
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item" aria-current="page">Profil Saya</li>
                    </ul>
                </div>
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h2 class="mb-0">Profil Saya</h2>
                    </div>
=======

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

>>>>>>> 36c3a9abf4ae6071b205f688feb77fd66a9aaaf8
                </div>
            </div>
        </div>
    </div>
<<<<<<< HEAD

    <div class="row">
        <div class="col-md-12">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('user.profile.update') }}" method="POST" id="formProfile">
                @csrf

                <div class="card">
                    <div class="card-header">
                        <h5>Data Identitas & Kontak</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">NIK (16 digit) <span class="text-danger">*</span></label>
                                    <input type="text" name="nik" class="form-control @error('nik') is-invalid @enderror" value="{{ old('nik', $user->nik) }}" maxlength="16" required>
                                    @error('nik')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Nomor KK (16 digit) <span class="text-danger">*</span></label>
                                    <input type="text" name="no_kk" class="form-control @error('no_kk') is-invalid @enderror" value="{{ old('no_kk', $user->no_kk) }}" maxlength="16" required>
                                    @error('no_kk')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Tempat Lahir <span class="text-danger">*</span></label>
                                    <input type="text" name="tempat_lahir" class="form-control @error('tempat_lahir') is-invalid @enderror" value="{{ old('tempat_lahir', $user->tempat_lahir) }}" required>
                                    @error('tempat_lahir')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                                    <input type="date" name="tanggal_lahir" class="form-control @error('tanggal_lahir') is-invalid @enderror" value="{{ old('tanggal_lahir', optional($user->tanggal_lahir)->format('Y-m-d')) }}" required>
                                    @error('tanggal_lahir')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                                    <select name="jenis_kelamin" class="form-select @error('jenis_kelamin') is-invalid @enderror" required>
                                        <option value="">-- Pilih --</option>
                                        <option value="Laki-laki" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="Perempuan" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                    @error('jenis_kelamin')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Pekerjaan <span class="text-danger">*</span></label>
                                    <input type="text" name="pekerjaan" class="form-control @error('pekerjaan') is-invalid @enderror" value="{{ old('pekerjaan', $user->pekerjaan) }}" required>
                                    @error('pekerjaan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                                    <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="3" required>{{ old('alamat', $user->alamat) }}</textarea>
                                    @error('alamat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="form-label">RT <span class="text-danger">*</span></label>
                                    <input type="text" name="rt" class="form-control @error('rt') is-invalid @enderror" value="{{ old('rt', $user->rt) }}" maxlength="3" required>
                                    @error('rt')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="form-label">RW <span class="text-danger">*</span></label>
                                    <input type="text" name="rw" class="form-control @error('rw') is-invalid @enderror" value="{{ old('rw', $user->rw) }}" maxlength="3" required>
                                    @error('rw')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Desa <span class="text-danger">*</span></label>
                                    <input type="text" name="desa" class="form-control @error('desa') is-invalid @enderror" value="{{ old('desa', $user->desa) }}" required>
                                    @error('desa')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Kecamatan <span class="text-danger">*</span></label>
                                    <input type="text" name="kecamatan" class="form-control @error('kecamatan') is-invalid @enderror" value="{{ old('kecamatan', $user->kecamatan) }}" required>
                                    @error('kecamatan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Kabupaten/Kota <span class="text-danger">*</span></label>
                                    <input type="text" name="kabupaten" class="form-control @error('kabupaten') is-invalid @enderror" value="{{ old('kabupaten', $user->kabupaten) }}" required>
                                    @error('kabupaten')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Provinsi <span class="text-danger">*</span></label>
                                    <input type="text" name="provinsi" class="form-control @error('provinsi') is-invalid @enderror" value="{{ old('provinsi', $user->provinsi) }}" required>
                                    @error('provinsi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Kode Pos <span class="text-danger">*</span></label>
                                    <input type="text" name="kode_pos" class="form-control @error('kode_pos') is-invalid @enderror" value="{{ old('kode_pos', $user->kode_pos) }}" maxlength="5" required>
                                    @error('kode_pos')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Agama <span class="text-danger">*</span></label>
                                    <select name="agama" class="form-select @error('agama') is-invalid @enderror" required>
                                        <option value="">-- Pilih --</option>
                                        @foreach(['Islam','Kristen','Katolik','Hindu','Buddha','Konghucu'] as $agama)
                                            <option value="{{ $agama }}" {{ old('agama', $user->agama) == $agama ? 'selected' : '' }}>{{ $agama }}</option>
                                        @endforeach
                                    </select>
                                    @error('agama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Status Perkawinan <span class="text-danger">*</span></label>
                                    <select name="status_perkawinan" class="form-select @error('status_perkawinan') is-invalid @enderror" required>
                                        <option value="">-- Pilih --</option>
                                        @foreach(['Belum Kawin','Kawin','Cerai Hidup','Cerai Mati'] as $s)
                                            <option value="{{ $s }}" {{ old('status_perkawinan', $user->status_perkawinan) == $s ? 'selected' : '' }}>{{ $s }}</option>
                                        @endforeach
                                    </select>
                                    @error('status_perkawinan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">No. Telepon <span class="text-danger">*</span></label>
                                    <input type="text" name="no_telepon" class="form-control @error('no_telepon') is-invalid @enderror" value="{{ old('no_telepon', $user->no_telepon) }}" maxlength="15" required>
                                    @error('no_telepon')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Password (kosongkan jika tidak ingin mengubah)</label>
                                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" minlength="8">
                                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Konfirmasi Password</label>
                                    <input type="password" name="password_confirmation" class="form-control" minlength="8">
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <a href="{{ route('dashboard') }}" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
=======
</div>

>>>>>>> 36c3a9abf4ae6071b205f688feb77fd66a9aaaf8
@endsection
