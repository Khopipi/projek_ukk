@extends('layouts.dashboard')
@section('title', 'Buat Akun User untuk Penduduk')
@section('content')
    <div class="pc-content">
        <!-- Breadcrumb -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('penduduk.index') }}">Data Penduduk</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('penduduk.show', $penduduk->id) }}">Detail</a></li>
                            <li class="breadcrumb-item" aria-current="page">Buat Akun User</li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Buat Akun User</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="card">
                    <div class="card-header" style="background: linear-gradient(135deg, #5b6ef5 0%, #667eea 100%); color: white; border-radius: 12px 12px 0 0;">
                        <h5 class="mb-0" style="color: white;"><i class="ti ti-user-plus me-2"></i>Formulir Pembuatan Akun User</h5>
                        <p class="mb-0" style="font-size: 12px; margin-top: 8px; opacity: 0.9;">Data akan otomatis terisi dari data penduduk: <strong>{{ $penduduk->nama_lengkap }}</strong></p>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('penduduk.store-account', $penduduk->id) }}" method="POST" id="formCreateAccount">
                            @csrf

                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <i class="ti ti-alert-circle me-2"></i>
                                    <strong>Terdapat kesalahan:</strong>
                                    <ul class="mb-0" style="margin-top: 8px;">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            <!-- Data dari Penduduk (Read-only info) -->
                            <div class="alert alert-info alert-dismissible fade show" role="alert" style="background: linear-gradient(135deg, rgba(23, 162, 184, 0.1) 0%, rgba(32, 201, 166, 0.1) 100%); border: 1px solid rgba(23, 162, 184, 0.2);">
                                <i class="ti ti-info-circle me-2"></i>
                                <strong>Informasi dari Data Penduduk:</strong>
                                <div class="row mt-2" style="font-size: 13px;">
                                    <div class="col-md-6">
                                        <p class="mb-1"><strong>NIK:</strong> {{ $penduduk->nik }}</p>
                                        <p class="mb-1"><strong>Nama:</strong> {{ $penduduk->nama_lengkap }}</p>
                                        <p class="mb-1"><strong>Tempat/Tgl Lahir:</strong> {{ $penduduk->tempat_lahir }}, {{ $penduduk->tanggal_lahir->format('d-m-Y') }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="mb-1"><strong>Jenis Kelamin:</strong> {{ $penduduk->jenis_kelamin }}</p>
                                        <p class="mb-1"><strong>Agama:</strong> {{ $penduduk->agama }}</p>
                                        <p class="mb-1"><strong>Status Perkawinan:</strong> {{ $penduduk->status_perkawinan }}</p>
                                    </div>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>

                            <!-- BAGIAN 1: DATA IDENTITAS -->
                            <div style="border-top: 2px solid #dbeafe; padding-top: 18px; margin-top: 24px; margin-bottom: 18px;">
                                <h5 style="color: #3b82f6; background: white; padding: 0 10px; display: inline-block; margin-bottom: 0; font-size: 13px; letter-spacing: 1px;">
                                    <i class="ti ti-id me-2"></i>DATA IDENTITAS
                                </h5>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label"><i class="ti ti-id-badge me-1"></i>NIK (16 digit) <span class="text-danger">*</span></label>
                                        <input type="text"
                                               class="form-control @error('nik') is-invalid @enderror"
                                               name="nik"
                                               value="{{ old('nik', $penduduk->nik) }}"
                                               maxlength="16"
                                               pattern="[0-9]{16}"
                                               readonly>
                                        @error('nik')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label"><i class="ti ti-files me-1"></i>No. KK (16 digit) <span class="text-danger">*</span></label>
                                        <input type="text"
                                               class="form-control @error('no_kk') is-invalid @enderror"
                                               name="no_kk"
                                               value="{{ old('no_kk', $penduduk->kk) }}"
                                               maxlength="16"
                                               pattern="[0-9]{16}"
                                               readonly>
                                        @error('no_kk')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group mb-3">
                                        <label class="form-label"><i class="ti ti-user me-1"></i>Nama Lengkap (Sesuai KTP) <span class="text-danger">*</span></label>
                                        <input type="text"
                                               class="form-control @error('name') is-invalid @enderror"
                                               name="name"
                                               value="{{ old('name', $penduduk->nama_lengkap) }}"
                                               readonly>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- BAGIAN 2: DATA PRIBADI -->
                            <div style="border-top: 2px solid #dbeafe; padding-top: 18px; margin-top: 24px; margin-bottom: 18px;">
                                <h5 style="color: #3b82f6; background: white; padding: 0 10px; display: inline-block; margin-bottom: 0; font-size: 13px; letter-spacing: 1px;">
                                    <i class="ti ti-user-circle me-2"></i>DATA PRIBADI
                                </h5>
                            </div>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label"><i class="ti ti-map-pin me-1"></i>Tempat Lahir <span class="text-danger">*</span></label>
                                        <input type="text"
                                               class="form-control @error('tempat_lahir') is-invalid @enderror"
                                               name="tempat_lahir"
                                               value="{{ old('tempat_lahir', $penduduk->tempat_lahir) }}"
                                               readonly>
                                        @error('tempat_lahir')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label"><i class="ti ti-calendar me-1"></i>Tanggal Lahir <span class="text-danger">*</span></label>
                                        <input type="date"
                                               class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                               name="tanggal_lahir"
                                               value="{{ old('tanggal_lahir', $penduduk->tanggal_lahir->format('Y-m-d')) }}"
                                               readonly>
                                        @error('tanggal_lahir')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <label class="form-label"><i class="ti ti-venus-mars me-1"></i>Jenis Kelamin <span class="text-danger">*</span></label>
                                        <input type="text"
                                               class="form-control"
                                               value="{{ $penduduk->jenis_kelamin }}"
                                               readonly>
                                        <input type="hidden" name="jenis_kelamin" value="{{ $penduduk->jenis_kelamin }}">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <label class="form-label"><i class="ti ti-prayer me-1"></i>Agama <span class="text-danger">*</span></label>
                                        <input type="text"
                                               class="form-control"
                                               value="{{ $penduduk->agama }}"
                                               readonly>
                                        <input type="hidden" name="agama" value="{{ $penduduk->agama }}">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <label class="form-label"><i class="ti ti-ring me-1"></i>Status Perkawinan <span class="text-danger">*</span></label>
                                        <input type="text"
                                               class="form-control"
                                               value="{{ $penduduk->status_perkawinan }}"
                                               readonly>
                                        <input type="hidden" name="status_perkawinan" value="{{ $penduduk->status_perkawinan }}">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label"><i class="ti ti-briefcase me-1"></i>Pekerjaan <span class="text-danger">*</span></label>
                                        <input type="text"
                                               class="form-control"
                                               value="{{ $penduduk->pekerjaan }}"
                                               readonly>
                                        <input type="hidden" name="pekerjaan" value="{{ $penduduk->pekerjaan }}">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label"><i class="ti ti-book me-1"></i>Pendidikan Terakhir</label>
                                        <input type="text"
                                               class="form-control"
                                               value="{{ $penduduk->pendidikan_terakhir ?? '-' }}"
                                               readonly>
                                        <input type="hidden" name="pendidikan_terakhir" value="{{ $penduduk->pendidikan_terakhir }}">
                                    </div>
                                </div>
                            </div>

                            <!-- BAGIAN 3: DATA ALAMAT -->
                            <div style="border-top: 2px solid #dbeafe; padding-top: 18px; margin-top: 24px; margin-bottom: 18px;">
                                <h5 style="color: #3b82f6; background: white; padding: 0 10px; display: inline-block; margin-bottom: 0; font-size: 13px; letter-spacing: 1px;">
                                    <i class="ti ti-map-pin me-2"></i>DATA ALAMAT
                                </h5>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group mb-3">
                                        <label class="form-label"><i class="ti ti-home me-1"></i>Alamat Lengkap <span class="text-danger">*</span></label>
                                        <textarea class="form-control @error('alamat') is-invalid @enderror"
                                                  name="alamat"
                                                  rows="2"
                                                  readonly>{{ old('alamat', $penduduk->alamat) }}</textarea>
                                        @error('alamat')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label class="form-label"><i class="ti ti-number me-1"></i>RT <span class="text-danger">*</span></label>
                                        <input type="text"
                                               class="form-control"
                                               value="{{ $penduduk->rt }}"
                                               readonly>
                                        <input type="hidden" name="rt" value="{{ $penduduk->rt }}">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label class="form-label"><i class="ti ti-number me-1"></i>RW <span class="text-danger">*</span></label>
                                        <input type="text"
                                               class="form-control"
                                               value="{{ $penduduk->rw }}"
                                               readonly>
                                        <input type="hidden" name="rw" value="{{ $penduduk->rw }}">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label"><i class="ti ti-map me-1"></i>Desa <span class="text-danger">*</span></label>
                                        <input type="text"
                                               class="form-control"
                                               value="{{ $penduduk->desa }}"
                                               readonly>
                                        <input type="hidden" name="desa" value="{{ $penduduk->desa }}">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label"><i class="ti ti-map me-1"></i>Kecamatan <span class="text-danger">*</span></label>
                                        <input type="text"
                                               class="form-control"
                                               value="{{ $penduduk->kecamatan }}"
                                               readonly>
                                        <input type="hidden" name="kecamatan" value="{{ $penduduk->kecamatan }}">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label"><i class="ti ti-map me-1"></i>Kabupaten/Kota <span class="text-danger">*</span></label>
                                        <input type="text"
                                               class="form-control"
                                               value="{{ $penduduk->kabupaten }}"
                                               readonly>
                                        <input type="hidden" name="kabupaten" value="{{ $penduduk->kabupaten }}">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label"><i class="ti ti-map me-1"></i>Provinsi <span class="text-danger">*</span></label>
                                        <input type="text"
                                               class="form-control"
                                               value="{{ $penduduk->provinsi }}"
                                               readonly>
                                        <input type="hidden" name="provinsi" value="{{ $penduduk->provinsi }}">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label"><i class="ti ti-mail me-1"></i>Kode Pos <span class="text-danger">*</span></label>
                                        <input type="text"
                                               class="form-control"
                                               value="{{ $penduduk->kode_pos ?? '-' }}"
                                               readonly>
                                        <input type="hidden" name="kode_pos" value="{{ $penduduk->kode_pos }}">
                                    </div>
                                </div>
                            </div>

                            <!-- BAGIAN 4: KONTAK & AKUN (YANG HARUS DIISI MANUAL) -->
                            <div style="border-top: 2px solid #dbeafe; padding-top: 18px; margin-top: 24px; margin-bottom: 18px;">
                                <h5 style="color: #3b82f6; background: white; padding: 0 10px; display: inline-block; margin-bottom: 0; font-size: 13px; letter-spacing: 1px;">
                                    <i class="ti ti-phone me-2"></i>KONTAK & AKUN
                                </h5>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label"><i class="ti ti-phone me-1"></i>Nomor Telepon/HP <span class="text-danger">*</span></label>
                                        <input type="text"
                                               class="form-control @error('no_telepon') is-invalid @enderror"
                                               name="no_telepon"
                                               placeholder="Contoh: 081234567890"
                                               value="{{ old('no_telepon') }}"
                                               maxlength="12"
                                               required>
                                        @error('no_telepon')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label"><i class="ti ti-mail me-1"></i>Email <span class="text-danger">*</span></label>
                                        <input type="email"
                                               class="form-control @error('email') is-invalid @enderror"
                                               name="email"
                                               placeholder="email@example.com"
                                               value="{{ old('email') }}"
                                               required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label"><i class="ti ti-lock me-1"></i>Password <span class="text-danger">*</span></label>
                                        <input type="password"
                                               class="form-control @error('password') is-invalid @enderror"
                                               name="password"
                                               placeholder="Minimal 8 karakter"
                                               minlength="8"
                                               required>
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted"><i class="ti ti-info-circle me-1"></i>Minimal 8 karakter</small>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label"><i class="ti ti-lock-check me-1"></i>Konfirmasi Password <span class="text-danger">*</span></label>
                                        <input type="password"
                                               class="form-control"
                                               name="password_confirmation"
                                               placeholder="Ulangi password Anda"
                                               minlength="8"
                                               required>
                                        <small class="text-muted"><i class="ti ti-info-circle me-1"></i>Harus sama dengan password di atas</small>
                                    </div>
                                </div>
                            </div>

                            <!-- BAGIAN 5: PERSETUJUAN -->
                            <div style="border-top: 2px solid #dbeafe; padding-top: 18px; margin-top: 24px; margin-bottom: 18px;">
                                <h5 style="color: #3b82f6; background: white; padding: 0 10px; display: inline-block; margin-bottom: 0; font-size: 13px; letter-spacing: 1px;">
                                    <i class="ti ti-shield-check me-2"></i>PERSETUJUAN
                                </h5>
                            </div>

                            <div class="form-group mb-4">
                                <div class="form-check">
                                    <input class="form-check-input @error('agreement') is-invalid @enderror"
                                           type="checkbox"
                                           name="agreement"
                                           id="agreement"
                                           value="1"
                                           required>
                                    <label class="form-check-label" for="agreement">
                                        <i class="ti ti-check me-1"></i>Saya menyatakan bahwa data yang saya berikan adalah benar dan dapat dipertanggungjawabkan. <span class="text-danger">*</span>
                                    </label>
                                    @error('agreement')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Alert Info Email Verification -->
                            <div class="alert alert-info alert-dismissible fade show" role="alert" style="background: linear-gradient(135deg, rgba(91, 110, 245, 0.1) 0%, rgba(102, 126, 234, 0.1) 100%); border: 1px solid rgba(91, 110, 245, 0.2);">
                                <i class="ti ti-info-circle me-2"></i>
                                <strong>Informasi Penting:</strong>
                                <p class="mb-0" style="margin-top: 8px; font-size: 13px;">Akun akan dibuat dengan status <strong>Email Belum Terverifikasi</strong>. User harus melakukan verifikasi email melalui link yang dikirim ke email mereka sebelum dapat menggunakan akun ini.</p>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>

                            <!-- Tombol Submit -->
                            <div class="d-grid gap-2 mt-4">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="ti ti-check me-2"></i>Buat Akun User
                                </button>
                                <a href="{{ route('penduduk.show', $penduduk->id) }}" class="btn btn-outline-secondary">
                                    <i class="ti ti-arrow-left me-2"></i>Kembali ke Detail Penduduk
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('formCreateAccount');

            // Validasi No Telepon hanya angka
            const noTeleponInput = document.querySelector('input[name="no_telepon"]');
            noTeleponInput.addEventListener('input', function(e) {
                this.value = this.value.replace(/[^0-9]/g, '');
            });

            // Validasi password match
            form.addEventListener('submit', function(e) {
                const password = document.querySelector('input[name="password"]').value;
                const passwordConfirmation = document.querySelector('input[name="password_confirmation"]').value;

                if (password !== passwordConfirmation) {
                    e.preventDefault();
                    alert('Password dan Konfirmasi Password tidak sama!');
                    return false;
                }

                // Validasi checkbox agreement
                const agreement = document.getElementById('agreement');
                if (!agreement.checked) {
                    e.preventDefault();
                    alert('Anda harus menyetujui pernyataan data!');
                    return false;
                }
            });
        });
    </script>
@endsection
