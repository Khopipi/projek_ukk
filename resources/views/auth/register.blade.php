@extends('layouts.auth')

@section('title', 'Pendaftaran Warga Desa')

@section('content')
    <div class="card my-5">
        <form action="{{ route('register') }}" method="POST" id="formRegister">
            @csrf
            <div class="card-body">
                <div class="text-center mb-4">
                    <h3 class="mb-2"><b>Pendaftaran Warga Desa Sruni</b></h3>
                    <p class="text-muted">Lengkapi data diri Anda untuk membuat akun</p>
                    <a href="/login" class="link-primary">Sudah punya akun? Login di sini</a>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Terdapat kesalahan:</strong>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- BAGIAN 1: DATA IDENTITAS -->
                <div class="mb-4">
                    <h5 class="border-bottom pb-2 mb-3">
                        <i class="ti ti-id me-2"></i>Data Identitas
                    </h5>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">NIK (16 digit) <span class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control @error('nik') is-invalid @enderror"
                                       name="nik"
                                       placeholder="Contoh: 3578012345678901"
                                       value="{{ old('nik') }}"
                                       maxlength="16"
                                       pattern="[0-9]{16}"
                                       required>
                                @error('nik')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Nomor KK (16 digit) <span class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control @error('no_kk') is-invalid @enderror"
                                       name="no_kk"
                                       placeholder="Contoh: 3578012345678901"
                                       value="{{ old('no_kk') }}"
                                       maxlength="16"
                                       pattern="[0-9]{16}"
                                       required>
                                @error('no_kk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label class="form-label">Nama Lengkap (Sesuai KTP) <span class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control @error('name') is-invalid @enderror"
                                       name="name"
                                       placeholder="Contoh: Ahmad Rizki Pratama"
                                       value="{{ old('name') }}"
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- BAGIAN 2: DATA PRIBADI -->
                <div class="mb-4">
                    <h5 class="border-bottom pb-2 mb-3">
                        <i class="ti ti-user me-2"></i>Data Pribadi
                    </h5>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Tempat Lahir <span class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control @error('tempat_lahir') is-invalid @enderror"
                                       name="tempat_lahir"
                                       placeholder="Contoh: Sidoarjo"
                                       value="{{ old('tempat_lahir') }}"
                                       required>
                                @error('tempat_lahir')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                                <input type="date"
                                       class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                       name="tanggal_lahir"
                                       value="{{ old('tanggal_lahir') }}"
                                       max="{{ date('Y-m-d') }}"
                                       required>
                                @error('tanggal_lahir')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                                <select class="form-select @error('jenis_kelamin') is-invalid @enderror"
                                        name="jenis_kelamin"
                                        required>
                                    <option value="">-- Pilih Jenis Kelamin --</option>
                                    <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('jenis_kelamin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Agama <span class="text-danger">*</span></label>
                                <select class="form-select @error('agama') is-invalid @enderror"
                                        name="agama"
                                        required>
                                    <option value="">-- Pilih Agama --</option>
                                    <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                                    <option value="Kristen" {{ old('agama') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                    <option value="Katolik" {{ old('agama') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                    <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                    <option value="Buddha" {{ old('agama') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                    <option value="Konghucu" {{ old('agama') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                                </select>
                                @error('agama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Status Perkawinan <span class="text-danger">*</span></label>
                                <select class="form-select @error('status_perkawinan') is-invalid @enderror"
                                        name="status_perkawinan"
                                        required>
                                    <option value="">-- Pilih Status --</option>
                                    <option value="Belum Kawin" {{ old('status_perkawinan') == 'Belum Kawin' ? 'selected' : '' }}>Belum Kawin</option>
                                    <option value="Kawin" {{ old('status_perkawinan') == 'Kawin' ? 'selected' : '' }}>Kawin</option>
                                    <option value="Cerai Hidup" {{ old('status_perkawinan') == 'Cerai Hidup' ? 'selected' : '' }}>Cerai Hidup</option>
                                    <option value="Cerai Mati" {{ old('status_perkawinan') == 'Cerai Mati' ? 'selected' : '' }}>Cerai Mati</option>
                                </select>
                                @error('status_perkawinan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Pekerjaan <span class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control @error('pekerjaan') is-invalid @enderror"
                                       name="pekerjaan"
                                       placeholder="Contoh: Petani, Wiraswasta, PNS"
                                       value="{{ old('pekerjaan') }}"
                                       required>
                                @error('pekerjaan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label class="form-label">Pendidikan Terakhir</label>
                                <input type="text"
                                       class="form-control @error('pendidikan_terakhir') is-invalid @enderror"
                                       name="pendidikan_terakhir"
                                       placeholder="Contoh: SD, SMP, SMA, S1"
                                       value="{{ old('pendidikan_terakhir') }}">
                                @error('pendidikan_terakhir')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- BAGIAN 3: DATA ALAMAT -->
                <div class="mb-4">
                    <h5 class="border-bottom pb-2 mb-3">
                        <i class="ti ti-map-pin me-2"></i>Data Alamat
                    </h5>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('alamat') is-invalid @enderror"
                                          name="alamat"
                                          rows="2"
                                          placeholder="Contoh: Jl. Mangga No. 12"
                                          required>{{ old('alamat') }}</textarea>
                                @error('alamat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <label class="form-label">RT <span class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control @error('rt') is-invalid @enderror"
                                       name="rt"
                                       placeholder="001"
                                       value="{{ old('rt') }}"
                                       maxlength="3"
                                       required>
                                @error('rt')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <label class="form-label">RW <span class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control @error('rw') is-invalid @enderror"
                                       name="rw"
                                       placeholder="001"
                                       value="{{ old('rw') }}"
                                       maxlength="3"
                                       required>
                                @error('rw')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Desa <span class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control @error('desa') is-invalid @enderror"
                                       name="desa"
                                       value="{{ old('desa', 'Sruni') }}"
                                       required>
                                @error('desa')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Kecamatan <span class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control @error('kecamatan') is-invalid @enderror"
                                       name="kecamatan"
                                       placeholder="Contoh: Gedangan"
                                       value="{{ old('kecamatan') }}"
                                       required>
                                @error('kecamatan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Kabupaten/Kota <span class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control @error('kabupaten') is-invalid @enderror"
                                       name="kabupaten"
                                       placeholder="Contoh: Sidoarjo"
                                       value="{{ old('kabupaten') }}"
                                       required>
                                @error('kabupaten')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Provinsi <span class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control @error('provinsi') is-invalid @enderror"
                                       name="provinsi"
                                       placeholder="Contoh: Jawa Timur"
                                       value="{{ old('provinsi') }}"
                                       required>
                                @error('provinsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Kode Pos <span class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control @error('kode_pos') is-invalid @enderror"
                                       name="kode_pos"
                                       placeholder="Contoh: 61254"
                                       value="{{ old('kode_pos') }}"
                                       maxlength="5"
                                       pattern="[0-9]{5}"
                                       required>
                                @error('kode_pos')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- BAGIAN 4: KONTAK & AKUN -->
                <div class="mb-4">
                    <h5 class="border-bottom pb-2 mb-3">
                        <i class="ti ti-phone me-2"></i>Kontak & Akun
                    </h5>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Nomor Telepon/HP <span class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control @error('no_telepon') is-invalid @enderror"
                                       name="no_telepon"
                                       placeholder="Contoh: 081234567890"
                                       value="{{ old('no_telepon') }}"
                                       maxlength="15"
                                       required>
                                @error('no_telepon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
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
                                <label class="form-label

                                ">Password <span class="text-danger">*</span></label>
                                <input type="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       name="password"
                                       placeholder="Minimal 8 karakter"
                                       minlength="8"
                                       required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Password minimal 8 karakter</small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Konfirmasi Password <span class="text-danger">*</span></label>
                                <input type="password"
                                       class="form-control"
                                       name="password_confirmation"
                                       placeholder="Ulangi password"
                                       minlength="8"
                                       required>
                                <small class="form-text text-muted">Masukkan password yang sama</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- BAGIAN 5: PERSETUJUAN -->
                <div class="mb-4">
                    <div class="form-check">
                        <input class="form-check-input @error('agreement') is-invalid @enderror"
                               type="checkbox"
                               name="agreement"
                               id="agreement"
                               value="1"
                               required>
                        <label class="form-check-label" for="agreement">
                            Saya menyatakan bahwa data yang saya berikan adalah benar dan dapat dipertanggungjawabkan.
                            <span class="text-danger">*</span>
                        </label>
                        @error('agreement')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- TOMBOL SUBMIT -->
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="ti ti-user-plus me-2"></i>Daftar Sekarang
                    </button>
                    <a href="/login" class="btn btn-outline-secondary">
                        <i class="ti ti-arrow-left me-2"></i>Kembali ke Login
                    </a>
                </div>

                <div class="text-center mt-3">
                    <small class="text-muted">
                        <i class="ti ti-info-circle"></i>
                        Dengan mendaftar, Anda setuju dengan syarat dan ketentuan yang berlaku
                    </small>
                </div>
            </div>
        </form>
    </div>

    <!-- Script Validasi -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('formRegister');

            // Validasi NIK hanya angka
            const nikInput = document.querySelector('input[name="nik"]');
            nikInput.addEventListener('input', function(e) {
                this.value = this.value.replace(/[^0-9]/g, '');
            });

            // Validasi No KK hanya angka
            const noKkInput = document.querySelector('input[name="no_kk"]');
            noKkInput.addEventListener('input', function(e) {
                this.value = this.value.replace(/[^0-9]/g, '');
            });

            // Validasi Kode Pos hanya angka
            const kodePosInput = document.querySelector('input[name="kode_pos"]');
            kodePosInput.addEventListener('input', function(e) {
                this.value = this.value.replace(/[^0-9]/g, '');
            });

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

            // Auto format RT/RW dengan leading zero
            const rtInput = document.querySelector('input[name="rt"]');
            const rwInput = document.querySelector('input[name="rw"]');

            [rtInput, rwInput].forEach(input => {
                input.addEventListener('blur', function() {
                    if (this.value.length > 0 && this.value.length < 3) {
                        this.value = this.value.padStart(3, '0');
                    }
                });

                input.addEventListener('input', function(e) {
                    this.value = this.value.replace(/[^0-9]/g, '');
                });
            });
        });
    </script>
@endsection
