@extends('layouts.dashboard')
@section('title', 'Ajukan Surat Baru')
@section('content')
    <div class="pc-content">
        <!-- Breadcrumb -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('pengajuan.index') }}">Pengajuan Surat</a></li>
                            <li class="breadcrumb-item" aria-current="page">Ajukan Surat Baru</li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Ajukan Surat Baru</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="row">
            <div class="col-sm-12">
                <form action="{{ route('pengajuan.store') }}" method="POST" enctype="multipart/form-data" id="formPengajuan">
                    @csrf

                    <!-- Pilih Jenis Surat -->
                    <div class="card">
                        <div class="card-header">
                            <h5><i class="ti ti-file-text me-2"></i>Pilih Jenis Surat</h5>
                        </div>
                        <div class="card-body">
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

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">Jenis Surat <span class="text-danger">*</span></label>
                                        <select name="jenis_surat" id="jenis_surat" class="form-select @error('jenis_surat') is-invalid @enderror" required>
                                            <option value="">-- Pilih Jenis Surat --</option>
                                            @foreach($jenisSurat as $js)
                                                @continue($js == 'Pembuatan KTP')
                                                <option value="{{ $js }}" {{ old('jenis_surat') == $js ? 'selected' : '' }}>
                                                    {{ $js }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('jenis_surat')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">Keperluan / Keterangan <span class="text-danger">*</span></label>
                                        <textarea name="keperluan" class="form-control @error('keperluan') is-invalid @enderror" rows="2" required>{{ old('keperluan') }}</textarea>
                                        @error('keperluan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>


                                <!-- Form dinamis berdasarkan jenis surat -->
                                <div id="dynamic-form-fields"></div>

                                <!-- Field dinamis berdasarkan jenis surat -->
                                <div id="dynamic-fields"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Data Pemohon -->
                    <div class="card">
                        <div class="card-header">
                            <h5><i class="ti ti-user me-2"></i>Data Pemohon</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                        <input type="text" name="nama_pemohon" class="form-control @error('nama_pemohon') is-invalid @enderror"
                                               value="{{ old('nama_pemohon', $user->name) }}" required>
                                        @error('nama_pemohon')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">NIK <span class="text-danger">*</span></label>
                                        <input type="text" name="nik_pemohon" class="form-control @error('nik_pemohon') is-invalid @enderror"
                                               value="{{ old('nik_pemohon', $user->nik) }}" maxlength="16" required readonly>
                                        @error('nik_pemohon')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Tempat Lahir <span class="text-danger">*</span></label>
                                        <input type="text" name="tempat_lahir_pemohon" class="form-control @error('tempat_lahir_pemohon') is-invalid @enderror"
                                               value="{{ old('tempat_lahir_pemohon', $user->tempat_lahir) }}" required>
                                        @error('tempat_lahir_pemohon')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                                        <input type="date" name="tanggal_lahir_pemohon" class="form-control @error('tanggal_lahir_pemohon') is-invalid @enderror"
                                               value="{{ old('tanggal_lahir_pemohon', $user->tanggal_lahir ? $user->tanggal_lahir->format('Y-m-d') : '') }}" required>
                                        @error('tanggal_lahir_pemohon')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                                        <select name="jenis_kelamin_pemohon" class="form-select @error('jenis_kelamin_pemohon') is-invalid @enderror" required>
                                            <option value="">-- Pilih --</option>
                                            <option value="Laki-laki" {{ old('jenis_kelamin_pemohon', $user->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                            <option value="Perempuan" {{ old('jenis_kelamin_pemohon', $user->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                        </select>
                                        @error('jenis_kelamin_pemohon')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Pekerjaan <span class="text-danger">*</span></label>
                                        <input type="text" name="pekerjaan_pemohon" class="form-control @error('pekerjaan_pemohon') is-invalid @enderror"
                                               value="{{ old('pekerjaan_pemohon', $user->pekerjaan) }}" required>
                                        @error('pekerjaan_pemohon')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                                        <textarea name="alamat_pemohon" class="form-control @error('alamat_pemohon') is-invalid @enderror"
                                                  rows="3" required>{{ old('alamat_pemohon', $user->alamat) }}</textarea>
                                        @error('alamat_pemohon')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">No. Telepon <span class="text-danger">*</span></label>
                                        <input type="text" name="no_telepon_pemohon" class="form-control @error('no_telepon_pemohon') is-invalid @enderror"
                                               value="{{ old('no_telepon_pemohon', $user->no_telepon) }}" maxlength="15" required>
                                        @error('no_telepon_pemohon')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Upload Dokumen -->
                    <div class="card">
                        <div class="card-header">
                            <h5><i class="ti ti-file-upload me-2"></i>Upload Dokumen Pendukung</h5>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-info">
                                <i class="ti ti-info-circle me-2"></i>
                                <strong>Informasi:</strong> File yang diupload harus berformat PDF, JPG, JPEG, atau PNG dengan ukuran maksimal 2MB
                            </div>

                            <div class="row" id="base-documents">
                                <!-- Base documents will be shown for non-Surat Nikah types -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Foto/Scan KTP <span class="text-danger">*</span></label>
                                        <input type="file" name="file_ktp" class="form-control @error('file_ktp') is-invalid @enderror"
                                               accept=".pdf,.jpg,.jpeg,.png" required>
                                        <small class="text-muted">Format: PDF, JPG, PNG | Max: 2MB</small>
                                        @error('file_ktp')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Foto/Scan Kartu Keluarga <span class="text-danger">*</span></label>
                                        <input type="file" name="file_kk" class="form-control @error('file_kk') is-invalid @enderror"
                                               accept=".pdf,.jpg,.jpeg,.png" required>
                                        <small class="text-muted">Format: PDF, JPG, PNG | Max: 2MB</small>
                                        @error('file_kk')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>



                                <div class="col-md-12">
                                    <div class="alert alert-warning mt-3">
                                        <i class="ti ti-alert-triangle me-2"></i>
                                        <strong>Catatan:</strong> Untuk jenis surat tertentu, dokumen pendukung tambahan sangat direkomendasikan.
                                        Misalnya: Surat Warisan (surat keterangan ahli waris), dll.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <a href="{{ route('pengajuan.index') }}" class="btn btn-secondary">
                                <i class="ti ti-x"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-send"></i> Ajukan Surat
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts_content')
<script>
    // Auto-hide alerts after 5 seconds and render dynamic fields
    document.addEventListener('DOMContentLoaded', function() {
        try {
            const alerts = document.querySelectorAll('.alert-dismissible');
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    if (window.bootstrap && typeof window.bootstrap.Alert === 'function') {
                        const bsAlert = new bootstrap.Alert(alert);
                        bsAlert.close();
                    } else {
                        alert.style.display = 'none';
                    }
                }, 5000);
            });
        } catch (e) {
            console.warn('Alert auto-hide skipped:', e);
        }

        // Dinamis field dan dokumen berdasarkan jenis surat
        const jenisSuratField = document.getElementById('jenis_surat');
        const dynamicFields = document.getElementById('dynamic-form-fields');
        const dynamicDocs = document.getElementById('dynamic-fields');

        // ambil nilai lama dari server (jika ada) untuk prefill ketika render oleh JS
        const oldValues = @json(old());

        // Auto pre-select surat dari URL parameter atau dari variable controller
        const urlParams = new URLSearchParams(window.location.search);
        const jenisSuratFromUrl = urlParams.get('jenis_surat') || '{{ $jenisSuratParam ?? '' }}';
        
        if (jenisSuratFromUrl && jenisSuratField) {
            // Set nilai ke dropdown
            jenisSuratField.value = jenisSuratFromUrl;
        }

        function escapeHtml(unsafe) {
            if (unsafe === null || unsafe === undefined) return '';
            return String(unsafe)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }

        // Konfigurasi tiap jenis surat: fields (input/textarea) dan dokumen yang harus diupload
        const suratConfig = {
            'Surat Nikah': {
                fields: [
                    { label: 'Nama Calon Pengantin Pria', name: 'nama_calon_pria', type: 'text', required: true },
                    { label: 'Nama Calon Pengantin Wanita', name: 'nama_calon_wanita', type: 'text', required: true },
                    { label: 'Tanggal Pernikahan Rencana', name: 'tanggal_nikah_rencana', type: 'date', required: true },
                    { label: 'Tempat Pernikahan', name: 'tempat_nikah', type: 'text', required: true }
                ],
                docs: [
                    { label: 'Surat Pengantar dari RT/RW', name: 'doc_surat_pengantar_rtrw', required: true },
                    { label: 'Surat Pengantar dari Kelurahan', name: 'doc_surat_pengantar_kelurahan', required: true },
                    { label: 'Formulir N1 (Permohonan Pencatatan Perkawinan)', name: 'doc_formulir_n1', required: true },
                    { label: 'Formulir N2 (Pernyataan Calon Pengantin)', name: 'doc_formulir_n2', required: true },
                    { label: 'Formulir N4 (Daftar Riwayat Hidup)', name: 'doc_formulir_n4', required: true },
                    { label: 'Foto/Scan KTP Calon Pengantin Pria', name: 'doc_ktp_pria', required: true },
                    { label: 'Foto/Scan KTP Calon Pengantin Wanita', name: 'doc_ktp_wanita', required: true },
                    { label: 'Kartu Keluarga (KK) Calon Pria', name: 'doc_kk_pria', required: true },
                    { label: 'Kartu Keluarga (KK) Calon Wanita', name: 'doc_kk_wanita', required: true },
                    { label: 'Akta Kelahiran Calon Pria', name: 'doc_akta_lahir_pria', required: true },
                    { label: 'Akta Kelahiran Calon Wanita', name: 'doc_akta_lahir_wanita', required: true },
                    { label: 'Pas Foto Calon Pengantin Pria (4x6)', name: 'doc_pas_foto_pria', required: true },
                    { label: 'Pas Foto Calon Pengantin Wanita (4x6)', name: 'doc_pas_foto_wanita', required: true }
                ]
            },
            // 'Pembuatan KTP' removed to disable its dynamic form
            'Surat Tanah': {
                fields: [
                    { label: 'Alamat Tanah', name: 'alamat_tanah', type: 'text', required: true },
                    { label: 'Luas Tanah (m2)', name: 'luas_tanah', type: 'text', required: true, placeholder: 'Contoh: 22 atau 25*32 atau 25.5*32.5', pattern: '\\d+(\\.\\d+)?(\\*\\d+(\\.\\d+)?)*' }
                ],
                docs: [
                    { label: 'Fotokopi KTP Pemohon', name: 'doc_ktp_pemohon', required: true },
                    { label: 'Fotokopi Kartu Keluarga (KK) Pemohon', name: 'doc_kk_pemohon', required: true },
                    { label: 'Fotokopi NPWP', name: 'doc_npwp', required: true },
                    { label: 'Bukti Pembayaran PBB Tahun Terakhir', name: 'doc_pbb', required: true },
                    { label: 'Girik/Letter C/Petok D (asli atau fotokopi legalisasi)', name: 'doc_girik', required: true },
                    { label: 'Surat Riwayat Tanah', name: 'doc_riwayat_tanah', required: true }
                ]
            },
            'Surat Warisan': {
                fields: [
                    { label: 'Nama Almarhum / Pewaris', name: 'nama_almarhum', type: 'text', required: true },
                    { label: 'Hubungan dengan Almarhum', name: 'hubungan_almarhum', type: 'text', required: true },
                    { label: 'Daftar Penerima Waris (nama & hubungan)', name: 'daftar_penerima', type: 'textarea', required: true }
                ],
                docs: [
                    { label: 'Akta Kematian Pewaris', name: 'doc_akta_kematian', required: true },
                    { label: 'KTP Pewaris', name: 'doc_ktp_pewaris', required: true },
                    { label: 'KK Pewaris', name: 'doc_kk_pewaris', required: true },
                    { label: 'KTP Ahli Waris', name: 'doc_ktp_ahli', required: true },
                    { label: 'KK Ahli Waris', name: 'doc_kk_ahli', required: true },
                    { label: 'Surat Pengantar RT/RW', name: 'doc_surat_pengantar_rtrw', required: true },
                    { label: 'Akta Kelahiran Ahli Waris', name: 'doc_akta_kelahiran_ahli', required: true },
                    { label: 'Surat Nikah Pewaris (jika ada)', name: 'doc_surat_nikah_pewaris', required: false }
                ]
            },
            'Surat Domisili': {
                fields: [
                    { label: 'Asal Desa', name: 'asal_desa', type: 'text', required: true },
                    { label: 'Asal Kota', name: 'asal_kota', type: 'text', required: true },
                    { label: 'Tujuan Desa/Kelurahan Berdomisili', name: 'tujuan_desa', type: 'text', required: true },
                    { label: 'Tujuan Kota', name: 'tujuan_kota', type: 'text', required: true },
                    { label: 'Alamat Domisili', name: 'alamat_domisili', type: 'text', required: true },
                    { label: 'RT/RW', name: 'rt_rw', type: 'text', required: true }
                ],
                docs: [
                    { label: 'Kartu Keluarga (KK) Pewaris / Pemohon', name: 'doc_kk_domisili', required: true },
                    { label: 'KTP Asli Pemohon (verifikasi)', name: 'doc_ktp_domisili', required: true },
                    { label: 'Formulir Permohonan F-1.03 (Disdukcapil)', name: 'doc_form_f103', required: true },
                    { label: 'Akta Kelahiran (jika belum punya KTP)', name: 'doc_akta_kelahiran_domisili', required: false },
                    { label: 'Surat Nikah / Cerai wajib (jika ada)', name: 'doc_surat_nikah_cerai', required: false }
                ]
            },
            'Surat Akta Kelahiran': {
                fields: [
                    { label: 'Nama Ayah', name: 'nama_ayah', type: 'text', required: true },
                    { label: 'Nama Ibu', name: 'nama_ibu', type: 'text', required: true },
                    { label: 'Nama Bayi', name: 'nama_bayi', type: 'text', required: true },
                    { label: 'Tanggal Lahir Bayi', name: 'tanggal_lahir_bayi', type: 'date', required: true },
                    { label: 'Tempat Lahir Bayi', name: 'tempat_lahir_bayi', type: 'text', required: false },
                    { label: 'Jenis Kelamin Bayi', name: 'jenis_kelamin_bayi', type: 'select', options: ['Laki-laki', 'Perempuan'], required: true }
                ],
                docs: [
                    { label: 'Surat Keterangan Lahir', name: 'doc_surat_keterangan_lahir', required: true },
                    { label: 'Akta Nikah Orang Tua', name: 'doc_akta_nikah_orangtua', required: true },
                    { label: 'Kartu Keluarga (KK)', name: 'doc_kk_kelahiran', required: true },
                    { label: 'KTP Ayah', name: 'doc_ktp_ayah', required: true },
                    { label: 'KTP Ibu', name: 'doc_ktp_ibu', required: true }
                ]
            },
            'Surat Keterangan Tidak Mampu': {
                fields: [
                    { label: 'Keterangan Tambahan', name: 'keterangan_tidak_mampu', type: 'textarea', required: false }
                ],
                docs: [
                    { label: 'Kartu Keluarga (KK)', name: 'doc_kk_tidak_mampu', required: true },
                    { label: 'Kartu Tanda Penduduk (KTP) Asli dan/atau Fotokopi', name: 'doc_ktp_tidak_mampu', required: true },
                    { label: 'Surat Pengantar dari RT/RW', name: 'doc_pengantar_rtrw_tidak_mampu', required: true },
                    { label: 'Surat Pernyataan Tidak Mampu Bermeterai', name: 'doc_pernyataan_tidak_mampu', required: true },
                    { label: 'Foto Rumah (Jika Diperlukan)', name: 'doc_foto_rumah', required: false }
                ]
            }
            ,
            'Surat Akta Kematian': {
                fields: [
                    { label: 'Nama Almarhum / Almarhumah', name: 'nama_almarhum', type: 'text', required: true },
                    { label: 'Tempat Lahir Almarhum', name: 'tempat_lahir_almarhum', type: 'text', required: true },
                    { label: 'Tanggal Lahir Almarhum', name: 'tanggal_lahir_almarhum', type: 'date', required: true },
                    { label: 'Dimakamkan di (lokasi)', name: 'tempat_makam', type: 'text', required: true }
                ],
                docs: [
                    { label: 'Surat Keterangan Kematian (asli dari dokter / Puskesmas / Rumah Sakit)', name: 'doc_surat_keterangan_kematian', required: true },
                    { label: 'KTP Almarhum / Almarhumah (asli / fotokopi)', name: 'doc_ktp_almarhum', required: false },
                    { label: 'KK Almarhum / Almarhumah (asli / fotokopi)', name: 'doc_kk_almarhum', required: false },
                    { label: 'Foto/Scan KTP Pelapor (anak kandung / ahli waris / Ketua RT/RW)', name: 'doc_ktp_pelapor', required: true },
                    { label: 'Akta Kelahiran Almarhum (jika belum memiliki KTP)', name: 'doc_akta_kelahiran_almarhum', required: false }
                ]
            }
        };

        function renderSurat(jenis) {
            if (!dynamicFields || !dynamicDocs) return;
            dynamicFields.innerHTML = '';
            dynamicDocs.innerHTML = '';

            // Tampilkan/sembunyikan base documents berdasarkan jenis surat
            const baseDocuments = document.getElementById('base-documents');
            if (baseDocuments) {
                // Hide base documents for Surat types that use custom doc fields
                if (jenis === 'Surat Nikah' || jenis === 'Surat Warisan' || jenis === 'Surat Domisili' || jenis === 'Surat Akta Kelahiran' || jenis === 'Surat Keterangan Tidak Mampu' || jenis === 'Surat Tanah' || jenis === 'Surat Akta Kematian') {
                    baseDocuments.style.display = 'none';
                    baseDocuments.querySelectorAll('input[name="file_ktp"], input[name="file_kk"]').forEach(input => {
                        input.removeAttribute('required');
                    });
                } else {
                    baseDocuments.style.display = 'block';
                    baseDocuments.querySelectorAll('input[name="file_ktp"], input[name="file_kk"]').forEach(input => {
                        input.setAttribute('required', 'required');
                    });
                }
            }

            if (!jenis || !suratConfig[jenis]) {
                // show hint (no specific fields)
                return;
            }

            // Render input fields
            suratConfig[jenis].fields.forEach(field => {
                const val = oldValues && oldValues[field.name] ? oldValues[field.name] : '';
                let fieldHtml = '';
                fieldHtml += '<div class="col-md-12">';
                fieldHtml += '<div class="form-group">';
                fieldHtml += `<label class="form-label">${field.label}`;
                if (field.required) fieldHtml += ' <span class="text-danger">*</span>';
                fieldHtml += '</label>';

                if (field.type === 'textarea') {
                    fieldHtml += `<textarea name="${field.name}" class="form-control" rows="2" ${field.required ? 'required' : ''}>${escapeHtml(val)}</textarea>`;
                } else if (field.type === 'select') {
                    fieldHtml += `<select name="${field.name}" class="form-control" ${field.required ? 'required' : ''}>`;
                    fieldHtml += '<option value="">-- Pilih --</option>';
                    if (field.options && Array.isArray(field.options)) {
                        field.options.forEach(option => {
                            const selected = val === option ? 'selected' : '';
                            fieldHtml += `<option value="${escapeHtml(option)}" ${selected}>${escapeHtml(option)}</option>`;
                        });
                    }
                    fieldHtml += '</select>';
                } else {
                    const placeholder = field.placeholder ? `placeholder="${escapeHtml(field.placeholder)}"` : '';
                    const min = field.min !== undefined ? `min="${field.min}"` : '';
                    const step = field.step !== undefined ? `step="${field.step}"` : '';
                    const pattern = field.pattern ? `pattern="${field.pattern}"` : '';
                    fieldHtml += `<input type="${field.type}" name="${field.name}" class="form-control" value="${escapeHtml(val)}" ${placeholder} ${min} ${step} ${pattern} ${field.required ? 'required' : ''}>`;
                    
                    // Show appropriate help text based on field type
                    if (field.name === 'luas_tanah') {
                        fieldHtml += '<small class="text-muted d-block mt-2"><strong>Format:</strong> Angka saja (22) atau dengan perkalian (*) untuk panjang x lebar (25*32 atau 25.5*32.5)</small>';
                    } else if (field.type === 'number') {
                        fieldHtml += '<small class="text-muted">Hanya angka (contoh: 22 atau 22.5)</small>';
                    }
                }

                fieldHtml += '</div></div>';
                dynamicFields.insertAdjacentHTML('beforeend', fieldHtml);
            });

            // Render required/optional document upload fields
            if (suratConfig[jenis].docs && suratConfig[jenis].docs.length) {
                dynamicDocs.insertAdjacentHTML('beforeend', '<div class="col-md-12"><hr><h6 class="mb-3">Dokumen Khusus Untuk Jenis Surat Ini</h6><p class="text-muted small">Semua dokumen wajib diupload</p></div>');
                suratConfig[jenis].docs.forEach((doc, index) => {
                    let docHtml = '';
                    docHtml += '<div class="col-md-6">';
                    docHtml += '<div class="form-group">';
                    docHtml += `<label class="form-label">${doc.label}`;
                    if (doc.required) docHtml += ' <span class="text-danger">*</span>';
                    docHtml += '</label>';
                    docHtml += `<input type="file" name="${doc.name}" class="form-control" accept=".pdf,.jpg,.jpeg,.png" ${doc.required ? 'required' : ''}>`;
                    docHtml += '<small class="text-muted">Format: PDF, JPG, PNG | Max: 2MB</small>';
                    docHtml += '</div></div>';
                    dynamicDocs.insertAdjacentHTML('beforeend', docHtml);
                });
            }
        }

        // attach listener and render initial if needed
        if (jenisSuratField) {
            // Event listener untuk perubahan dropdown
            jenisSuratField.addEventListener('change', function() {
                try {
                    renderSurat(this.value);
                    // Scroll ke form card setelah render
                    if (this.value) {
                        const formCard = document.querySelector('.card');
                        if (formCard) {
                            // Scroll dengan smooth behavior dan offset agar tidak tertutup header
                            setTimeout(() => {
                                formCard.scrollIntoView({ behavior: 'smooth', block: 'start' });
                                // Tambahan scroll offset untuk memberikan padding
                                window.scrollBy(0, -100);
                            }, 100);
                        }
                    }
                } catch (e) {
                    console.error('Error rendering fields for', this.value, e);
                }
            });

            // Trigger render jika ada pre-selected value dari URL atau old values
            if (jenisSuratField.value) {
                try {
                    renderSurat(jenisSuratField.value);
                    // Auto scroll ke form jika ada jenis_surat dari URL
                    if (jenisSuratFromUrl) {
                        setTimeout(() => {
                            const formCard = document.querySelector('.card');
                            if (formCard) {
                                formCard.scrollIntoView({ behavior: 'smooth', block: 'start' });
                                window.scrollBy(0, -100);
                            }
                        }, 200);
                    }
                } catch (e) {
                    console.error('Error rendering initial fields:', e);
                }
            }
        }

        // Disable submit button after form submission to prevent double submit (guarded)
        const form = document.getElementById('formPengajuan');
        if (form) {
            form.addEventListener('submit', function() {
                const submitBtn = this.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Mengirim...';
                }
            });
        }
    });
</script>
@endsection
