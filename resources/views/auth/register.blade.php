@extends('layouts.auth')

@section('title', 'Pendaftaran Warga Desa')

@section('content')
    <style>
        .register-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .register-header h3 {
            background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-size: 26px !important;
            margin-bottom: 8px;
        }

        .register-header p {
            color: #64748b;
            font-weight: 500;
            margin-bottom: 12px;
        }

        .section-divider {
            border-top: 2px solid #dbeafe !important;
            padding-top: 18px !important;
            margin-top: 24px !important;
            margin-bottom: 18px !important;
        }

        .section-divider h5 {
            color: #3b82f6 !important;
            background: white;
            padding: 0 10px;
            display: inline-block;
            margin-bottom: 0;
            font-size: 13px;
            letter-spacing: 1px;
        }

        .required-indicator {
            color: #dc2626;
            font-weight: 700;
        }

        /* ===== ALIGNMENT & SPACING ===== */
        .form-group {
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .form-label {
            min-height: 40px;
            display: flex;
            align-items: center;
            margin-bottom: 8px !important;
        }

        .form-control,
        .form-select {
            flex: 1;
            min-height: 45px !important;
            display: flex;
            align-items: center;
        }

        .row {
            align-items: stretch;
        }

        /* Ensure equal heights for form groups in the same row */
        .col-md-4 .form-group,
        .col-md-6 .form-group {
            min-height: 120px;
        }

        /* Small text alignment */
        small.text-muted {
            margin-top: 6px;
            flex-shrink: 0;
        }
    </style>
    
    <div class="card">
        <form action="{{ route('register') }}" method="POST" id="formRegister">
            @csrf
            <div class="card-body">
                <div class="register-header">
                    <h3><i class="ti ti-user-plus me-2"></i>Pendaftaran Warga Desa</h3>
                    <p>Lengkapi data diri Anda untuk membuat akun</p>
                    <p class="text-muted mb-0" style="font-size: 12px;"><i class="ti ti-info-circle me-1"></i>Semua kolom yang bertanda <span class="required-indicator">*</span> harus diisi</p>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <i class="ti ti-alert-circle"></i>
                        <div>
                            <strong>Terdapat kesalahan:</strong>
                            <ul class="mb-0" style="margin-top: 8px;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <!-- BAGIAN 1: DATA IDENTITAS -->
                <div class="section-divider">
                    <h5><i class="ti ti-id me-2"></i>Data Identitas</h5>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label"><i class="ti ti-id-badge me-1"></i>NIK (16 digit) <span class="required-indicator">*</span></label>
                            <input type="text"
                                   class="form-control @error('nik') is-invalid @enderror"
                                   name="nik"
                                   placeholder="Contoh: 3578012345678901"
                                   value="{{ old('nik') }}"
                                   maxlength="16"
                                   pattern="[0-9]{16}"
                                   required>
                            @error('nik')
                                <div class="invalid-feedback"><i class="ti ti-alert-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label"><i class="ti ti-files me-1"></i>No. KK (16 digit) <span class="required-indicator">*</span></label>
                            <input type="text"
                                   class="form-control @error('no_kk') is-invalid @enderror"
                                   name="no_kk"
                                   placeholder="Contoh: 3578012345678901"
                                   value="{{ old('no_kk') }}"
                                   maxlength="16"
                                   pattern="[0-9]{16}"
                                   required>
                            @error('no_kk')
                                <div class="invalid-feedback"><i class="ti ti-alert-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label"><i class="ti ti-user me-1"></i>Nama Lengkap (Sesuai KTP) <span class="required-indicator">*</span></label>
                            <input type="text"
                                   class="form-control @error('name') is-invalid @enderror"
                                   name="name"
                                   placeholder="Contoh: Ahmad Rizki Pratama"
                                   value="{{ old('name') }}"
                                   required>
                            @error('name')
                                <div class="invalid-feedback"><i class="ti ti-alert-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- BAGIAN 2: DATA PRIBADI -->
                <div class="section-divider">
                    <h5><i class="ti ti-user-circle me-2"></i>Data Pribadi</h5>
                </div>

                <div class="row g-3">
                    <!-- Row 1: Tempat Lahir & Tanggal Lahir -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label"><i class="ti ti-map-pin me-1"></i>Tempat Lahir <span class="required-indicator">*</span></label>
                            <input type="text"
                                   class="form-control @error('tempat_lahir') is-invalid @enderror"
                                   name="tempat_lahir"
                                   placeholder="Contoh: Sidoarjo"
                                   value="{{ old('tempat_lahir') }}"
                                   required>
                            @error('tempat_lahir')
                                <div class="invalid-feedback"><i class="ti ti-alert-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label"><i class="ti ti-calendar me-1"></i>Tanggal Lahir <span class="required-indicator">*</span></label>
                            <input type="date"
                                   class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                   name="tanggal_lahir"
                                   value="{{ old('tanggal_lahir') }}"
                                   max="{{ date('Y-m-d') }}"
                                   required>
                            @error('tanggal_lahir')
                                <div class="invalid-feedback"><i class="ti ti-alert-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Row 2: Jenis Kelamin, Agama, Status Perkawinan -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label"><i class="ti ti-venus-mars me-1"></i>Jenis Kelamin <span class="required-indicator">*</span></label>
                            <select class="form-select @error('jenis_kelamin') is-invalid @enderror"
                                    name="jenis_kelamin"
                                    required>
                                <option value="">-- Pilih --</option>
                                <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('jenis_kelamin')
                                <div class="invalid-feedback"><i class="ti ti-alert-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label"><i class="ti ti-prayer me-1"></i>Agama <span class="required-indicator">*</span></label>
                            <select class="form-select @error('agama') is-invalid @enderror"
                                    name="agama"
                                    required>
                                <option value="">-- Pilih --</option>
                                <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                                <option value="Kristen" {{ old('agama') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                <option value="Katolik" {{ old('agama') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                <option value="Buddha" {{ old('agama') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                <option value="Konghucu" {{ old('agama') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                            </select>
                            @error('agama')
                                <div class="invalid-feedback"><i class="ti ti-alert-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label"><i class="ti ti-ring me-1"></i>Status Perkawinan <span class="required-indicator">*</span></label>
                            <select class="form-select @error('status_perkawinan') is-invalid @enderror"
                                    name="status_perkawinan"
                                    required>
                                <option value="">-- Pilih --</option>
                                <option value="Belum Kawin" {{ old('status_perkawinan') == 'Belum Kawin' ? 'selected' : '' }}>Belum Kawin</option>
                                <option value="Kawin" {{ old('status_perkawinan') == 'Kawin' ? 'selected' : '' }}>Kawin</option>
                                <option value="Cerai Hidup" {{ old('status_perkawinan') == 'Cerai Hidup' ? 'selected' : '' }}>Cerai Hidup</option>
                                <option value="Cerai Mati" {{ old('status_perkawinan') == 'Cerai Mati' ? 'selected' : '' }}>Cerai Mati</option>
                            </select>
                            @error('status_perkawinan')
                                <div class="invalid-feedback"><i class="ti ti-alert-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Row 3: Pekerjaan & Pendidikan -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label"><i class="ti ti-briefcase me-1"></i>Pekerjaan <span class="required-indicator">*</span></label>
                            <input type="text"
                                   class="form-control @error('pekerjaan') is-invalid @enderror"
                                   name="pekerjaan"
                                   placeholder="Contoh: Petani, Wiraswasta, PNS"
                                   value="{{ old('pekerjaan') }}"
                                   required>
                            @error('pekerjaan')
                                <div class="invalid-feedback"><i class="ti ti-alert-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label"><i class="ti ti-book me-1"></i>Pendidikan Terakhir</label>
                            <input type="text"
                                   class="form-control @error('pendidikan_terakhir') is-invalid @enderror"
                                   name="pendidikan_terakhir"
                                   placeholder="Contoh: SD, SMP, SMA, S1"
                                   value="{{ old('pendidikan_terakhir') }}">
                            @error('pendidikan_terakhir')
                                <div class="invalid-feedback"><i class="ti ti-alert-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- BAGIAN 3: DATA ALAMAT -->
                <div class="section-divider">
                    <h5><i class="ti ti-map-pin me-2"></i>Data Alamat</h5>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label"><i class="ti ti-home me-1"></i>Alamat Lengkap <span class="required-indicator">*</span></label>
                            <textarea class="form-control @error('alamat') is-invalid @enderror"
                                      name="alamat"
                                      rows="2"
                                      placeholder="Contoh: Jl. Mangga No. 12"
                                      required>{{ old('alamat') }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback"><i class="ti ti-alert-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label"><i class="ti ti-number me-1"></i>RT <span class="required-indicator">*</span></label>
                            <input type="text"
                                   class="form-control @error('rt') is-invalid @enderror"
                                   name="rt"
                                   placeholder="001"
                                   value="{{ old('rt') }}"
                                   maxlength="3"
                                   required>
                            @error('rt')
                                <div class="invalid-feedback"><i class="ti ti-alert-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label"><i class="ti ti-number me-1"></i>RW <span class="required-indicator">*</span></label>
                            <input type="text"
                                   class="form-control @error('rw') is-invalid @enderror"
                                   name="rw"
                                   placeholder="001"
                                   value="{{ old('rw') }}"
                                   maxlength="3"
                                   required>
                            @error('rw')
                                <div class="invalid-feedback"><i class="ti ti-alert-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label"><i class="ti ti-map me-1"></i>Desa <span class="required-indicator">*</span></label>
                            <input type="text"
                                   class="form-control @error('desa') is-invalid @enderror"
                                   name="desa"
                                   value="{{ old('desa', 'Sruni') }}"
                                   required>
                            @error('desa')
                                <div class="invalid-feedback"><i class="ti ti-alert-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label"><i class="ti ti-map me-1"></i>Kecamatan <span class="required-indicator">*</span></label>
                            <input type="text"
                                   class="form-control @error('kecamatan') is-invalid @enderror"
                                   name="kecamatan"
                                   placeholder="Contoh: Gedangan"
                                   value="{{ old('kecamatan') }}"
                                   required>
                            @error('kecamatan')
                                <div class="invalid-feedback"><i class="ti ti-alert-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label"><i class="ti ti-map me-1"></i>Kabupaten/Kota <span class="required-indicator">*</span></label>
                            <input type="text"
                                   class="form-control @error('kabupaten') is-invalid @enderror"
                                   name="kabupaten"
                                   placeholder="Contoh: Sidoarjo"
                                   value="{{ old('kabupaten') }}"
                                   required>
                            @error('kabupaten')
                                <div class="invalid-feedback"><i class="ti ti-alert-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label"><i class="ti ti-map me-1"></i>Provinsi <span class="required-indicator">*</span></label>
                            <input type="text"
                                   class="form-control @error('provinsi') is-invalid @enderror"
                                   name="provinsi"
                                   placeholder="Contoh: Jawa Timur"
                                   value="{{ old('provinsi') }}"
                                   required>
                            @error('provinsi')
                                <div class="invalid-feedback"><i class="ti ti-alert-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label"><i class="ti ti-mail me-1"></i>Kode Pos <span class="required-indicator">*</span></label>
                            <input type="text"
                                   class="form-control @error('kode_pos') is-invalid @enderror"
                                   name="kode_pos"
                                   placeholder="Contoh: 61254"
                                   value="{{ old('kode_pos') }}"
                                   maxlength="5"
                                   pattern="[0-9]{5}"
                                   required>
                            @error('kode_pos')
                                <div class="invalid-feedback"><i class="ti ti-alert-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- BAGIAN 4: KONTAK & AKUN -->
                <div class="section-divider">
                    <h5><i class="ti ti-phone me-2"></i>Kontak & Akun</h5>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label"><i class="ti ti-phone me-1"></i>Nomor Telepon/HP <span class="required-indicator">*</span></label>
                            <input type="text"
                                   class="form-control @error('no_telepon') is-invalid @enderror"
                                   name="no_telepon"
                                   placeholder="Contoh: 081234567890"
                                   value="{{ old('no_telepon') }}"
                                   maxlength="12"
                                   required>
                            @error('no_telepon')
                                <div class="invalid-feedback"><i class="ti ti-alert-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label"><i class="ti ti-mail me-1"></i>Email <span class="required-indicator">*</span></label>
                            <input type="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   name="email"
                                   placeholder="email@example.com"
                                   value="{{ old('email') }}"
                                   required>
                            @error('email')
                                <div class="invalid-feedback"><i class="ti ti-alert-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label"><i class="ti ti-lock me-1"></i>Password <span class="required-indicator">*</span></label>
                            <input type="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   name="password"
                                   placeholder="Minimal 8 karakter"
                                   minlength="8"
                                   required>
                            @error('password')
                                <div class="invalid-feedback"><i class="ti ti-alert-circle me-1"></i>{{ $message }}</div>
                            @enderror
                            <small class="text-muted"><i class="ti ti-info-circle me-1"></i>Minimal 8 karakter</small>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label"><i class="ti ti-lock-check me-1"></i>Konfirmasi Password <span class="required-indicator">*</span></label>
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
                <div class="section-divider mt-5">
                    <h5><i class="ti ti-shield-check me-2"></i>Verifikasi Keamanan</h5>
                </div>

                <div class="form-group">
                    <label class="form-label"><i class="ti ti-lock me-1"></i>Verifikasi CAPTCHA <span class="required-indicator">*</span></label>
                    <div style="background: linear-gradient(135deg, #f0f2ff 0%, #e9ebff 100%); padding: 16px; border-radius: 10px; border: 2px dashed #5b6ef5; margin-bottom: 12px;">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div>
                                <p class="mb-1" style="font-weight: 600; color: #2d3748;">Selesaikan operasi matematika ini:</p>
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <span style="font-size: 20px; font-weight: 800; color: #5b6ef5;" id="captchaQuestion">7 + 3 = ?</span>
                                    <button type="button" class="btn btn-sm btn-outline-primary" id="refreshCaptcha" style="padding: 6px 12px; font-size: 12px;">
                                        <i class="ti ti-refresh"></i> Baru
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="number"
                           class="form-control @error('captcha_answer') is-invalid @enderror"
                           id="captchaAnswer"
                           name="captcha_answer"
                           placeholder="Masukkan jawaban Anda di sini"
                           required
                           style="min-height: 45px; font-weight: 600;">
                    @error('captcha_answer')
                        <div class="invalid-feedback" style="display: block;"><i class="ti ti-alert-circle me-1"></i>{{ $message }}</div>
                    @enderror
                    <small class="text-muted" style="display: block; margin-top: 6px;"><i class="ti ti-info-circle me-1"></i>Jawaban Anda akan diverifikasi untuk memastikan Anda adalah manusia</small>
                </div>

                <!-- BAGIAN 6: PERSETUJUAN -->
                <div class="section-divider mt-5">
                    <h5><i class="ti ti-shield-check me-2"></i>Persetujuan</h5>
                </div>

                <div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input @error('agreement') is-invalid @enderror"
                               type="checkbox"
                               name="agreement"
                               id="agreement"
                               value="1"
                               required>
                        <label class="form-check-label" for="agreement">
                            <i class="ti ti-check me-1"></i>Saya menyatakan bahwa data yang saya berikan adalah benar dan dapat dipertanggungjawabkan. <span class="required-indicator">*</span>
                        </label>
                        @error('agreement')
                            <div class="invalid-feedback"><i class="ti ti-alert-circle me-1"></i>{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- TOMBOL SUBMIT -->
                <div class="d-grid gap-2 mt-4">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="ti ti-user-plus me-2"></i>Daftar Sekarang
                    </button>
                    <a href="/login" class="btn btn-outline-secondary">
                        <i class="ti ti-arrow-left me-2"></i>Sudah Punya Akun? Login
                    </a>
                </div>

                <div style="text-align: center; margin-top: 20px;">
                    <small class="text-muted">
                        <i class="ti ti-info-circle me-1"></i>Dengan mendaftar, Anda setuju dengan syarat dan ketentuan yang berlaku
                    </small>
                </div>
            </div>
        </form>
    </div>

    <!-- Script Validasi -->
    <script>
        // Variabel global untuk menyimpan jawaban CAPTCHA yang benar
        let correctCaptchaAnswer = null;

        // Function untuk generate CAPTCHA question
        function generateCaptcha() {
            const num1 = Math.floor(Math.random() * 20) + 1;
            const num2 = Math.floor(Math.random() * 20) + 1;
            const operations = ['+', '-', '*'];
            const operation = operations[Math.floor(Math.random() * operations.length)];

            let answer;
            if (operation === '+') {
                answer = num1 + num2;
            } else if (operation === '-') {
                answer = num1 - num2;
            } else {
                answer = num1 * num2;
            }

            const question = `${num1} ${operation} ${num2} = ?`;
            document.getElementById('captchaQuestion').textContent = question;
            document.getElementById('captchaAnswer').value = '';
            document.getElementById('captchaAnswer').classList.remove('is-invalid');
            
            correctCaptchaAnswer = answer;
            console.log('Jawaban CAPTCHA yang benar: ' + correctCaptchaAnswer);
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Generate CAPTCHA pertama kali
            generateCaptcha();

            // Event listener untuk tombol refresh CAPTCHA
            document.getElementById('refreshCaptcha').addEventListener('click', function(e) {
                e.preventDefault();
                generateCaptcha();
            });

            const form = document.getElementById('formRegister');
            const tanggalLahirInput = document.querySelector('input[name="tanggal_lahir"]');

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

            // Validasi Umur (minimal 18 tahun)
            tanggalLahirInput.addEventListener('change', function() {
                const tanggalLahir = new Date(this.value);
                const hariIni = new Date();
                const umur = hariIni.getFullYear() - tanggalLahir.getFullYear();
                const bulan = hariIni.getMonth() - tanggalLahir.getMonth();
                const hari = hariIni.getDate() - tanggalLahir.getDate();

                // Hitung umur yang tepat
                let umurSebenarnya = umur;
                if (bulan < 0 || (bulan === 0 && hari < 0)) {
                    umurSebenarnya = umur - 1;
                }

                // Tampilkan pesan error jika umur kurang dari 18
                const errorDiv = this.parentElement.querySelector('.invalid-feedback') || 
                                document.createElement('div');
                
                if (umurSebenarnya < 18) {
                    this.classList.add('is-invalid');
                    if (!this.parentElement.querySelector('.umur-error')) {
                        const msg = document.createElement('div');
                        msg.className = 'invalid-feedback umur-error';
                        msg.style.display = 'block';
                        msg.innerHTML = '<i class="ti ti-alert-circle me-1"></i>Anda harus minimal berusia 18 tahun untuk melakukan registrasi.';
                        this.parentElement.appendChild(msg);
                    }
                } else {
                    this.classList.remove('is-invalid');
                    const msg = this.parentElement.querySelector('.umur-error');
                    if (msg) {
                        msg.remove();
                    }
                }
            });

            // Validasi CAPTCHA
            const captchaAnswerInput = document.getElementById('captchaAnswer');
            captchaAnswerInput.addEventListener('blur', function() {
                if (this.value !== '') {
                    const userAnswer = parseInt(this.value);
                    if (userAnswer !== correctCaptchaAnswer) {
                        this.classList.add('is-invalid');
                        if (!this.parentElement.querySelector('.captcha-error')) {
                            const msg = document.createElement('div');
                            msg.className = 'invalid-feedback captcha-error';
                            msg.style.display = 'block';
                            msg.innerHTML = '<i class="ti ti-alert-circle me-1"></i>Jawaban CAPTCHA tidak benar. Silakan coba lagi atau klik tombol "Baru" untuk soal baru.';
                            this.parentElement.appendChild(msg);
                        }
                    } else {
                        this.classList.remove('is-invalid');
                        const msg = this.parentElement.querySelector('.captcha-error');
                        if (msg) {
                            msg.remove();
                        }
                    }
                }
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

                // Validasi CAPTCHA saat submit
                const captchaAnswer = parseInt(captchaAnswerInput.value);
                if (captchaAnswer !== correctCaptchaAnswer) {
                    e.preventDefault();
                    captchaAnswerInput.classList.add('is-invalid');
                    if (!captchaAnswerInput.parentElement.querySelector('.captcha-error')) {
                        const msg = document.createElement('div');
                        msg.className = 'invalid-feedback captcha-error';
                        msg.style.display = 'block';
                        msg.innerHTML = '<i class="ti ti-alert-circle me-1"></i>Jawaban CAPTCHA tidak benar!';
                        captchaAnswerInput.parentElement.appendChild(msg);
                    }
                    alert('Silakan jawab CAPTCHA dengan benar!');
                    return false;
                }

                // Simpan CAPTCHA answer di hidden input untuk backend validation
                const hiddenCaptcha = document.createElement('input');
                hiddenCaptcha.type = 'hidden';
                hiddenCaptcha.name = 'captcha_correct_answer';
                hiddenCaptcha.value = correctCaptchaAnswer;
                form.appendChild(hiddenCaptcha);

                // Validasi checkbox agreement
                const agreement = document.getElementById('agreement');
                if (!agreement.checked) {
                    e.preventDefault();
                    alert('Anda harus menyetujui pernyataan data!');
                    return false;
                }

                // Validasi umur saat submit
                const tanggalLahir = new Date(tanggalLahirInput.value);
                const hariIni = new Date();
                const umur = hariIni.getFullYear() - tanggalLahir.getFullYear();
                const bulan = hariIni.getMonth() - tanggalLahir.getMonth();
                const hari = hariIni.getDate() - tanggalLahir.getDate();

                let umurSebenarnya = umur;
                if (bulan < 0 || (bulan === 0 && hari < 0)) {
                    umurSebenarnya = umur - 1;
                }

                if (umurSebenarnya < 18) {
                    e.preventDefault();
                    alert('Anda belum cukup umur untuk registrasi. Minimal berusia 18 tahun.');
                    tanggalLahirInput.classList.add('is-invalid');
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
