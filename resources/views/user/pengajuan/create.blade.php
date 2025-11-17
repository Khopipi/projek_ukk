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


                                <!-- Debug/Status for dynamic rendering (hidden in production) -->
                                <div id="dynamic-debug" style="display:block;margin-bottom:8px;font-size:13px;color:#6c757d;
                                    "></div>

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
                                               value="{{ old('nama_pemohon', Auth::user()->name) }}" required>
                                        @error('nama_pemohon')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">NIK <span class="text-danger">*</span></label>
                                        <input type="text" name="nik_pemohon" class="form-control @error('nik_pemohon') is-invalid @enderror"
                                               value="{{ old('nik_pemohon') }}" maxlength="16" required>
                                        @error('nik_pemohon')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Tempat Lahir <span class="text-danger">*</span></label>
                                        <input type="text" name="tempat_lahir_pemohon" class="form-control @error('tempat_lahir_pemohon') is-invalid @enderror"
                                               value="{{ old('tempat_lahir_pemohon') }}" required>
                                        @error('tempat_lahir_pemohon')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                                        <input type="date" name="tanggal_lahir_pemohon" class="form-control @error('tanggal_lahir_pemohon') is-invalid @enderror"
                                               value="{{ old('tanggal_lahir_pemohon') }}" required>
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
                                            <option value="Laki-laki" {{ old('jenis_kelamin_pemohon') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                            <option value="Perempuan" {{ old('jenis_kelamin_pemohon') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
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
                                               value="{{ old('pekerjaan_pemohon') }}" required>
                                        @error('pekerjaan_pemohon')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                                        <textarea name="alamat_pemohon" class="form-control @error('alamat_pemohon') is-invalid @enderror"
                                                  rows="3" required>{{ old('alamat_pemohon') }}</textarea>
                                        @error('alamat_pemohon')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">No. Telepon <span class="text-danger">*</span></label>
                                        <input type="text" name="no_telepon_pemohon" class="form-control @error('no_telepon_pemohon') is-invalid @enderror"
                                               value="{{ old('no_telepon_pemohon') }}" maxlength="15" required>
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

                            <div class="row">
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
                                    <hr>
                                    <h6 class="mb-3">Dokumen Pendukung Tambahan (Opsional)</h6>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Dokumen Pendukung 1</label>
                                        <input type="file" name="file_pendukung_1" class="form-control"
                                               accept=".pdf,.jpg,.jpeg,.png">
                                        <small class="text-muted">Format: PDF, JPG, PNG | Max: 2MB</small>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Dokumen Pendukung 2</label>
                                        <input type="file" name="file_pendukung_2" class="form-control"
                                               accept=".pdf,.jpg,.jpeg,.png">
                                        <small class="text-muted">Format: PDF, JPG, PNG | Max: 2MB</small>
                                    </div>
                                </div>


                                <div class="col-md-12">
                                    <div class="alert alert-warning mt-3">
                                        <i class="ti ti-alert-triangle me-2"></i>
                                        <strong>Catatan:</strong> Untuk jenis surat tertentu, dokumen pendukung tambahan sangat direkomendasikan.
                                        Misalnya: Surat Nikah (foto/scan buku nikah), Surat Warisan (surat keterangan ahli waris), dll.
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

        // Konfigurasi tiap jenis surat: fields (input/textarea) dan dokumen yang harus diupload
        const suratConfig = {
            'Surat Nikah': {
                fields: [
                    { label: 'Nama Suami', name: 'nama_suami', type: 'text', required: true },
                    { label: 'Nama Istri', name: 'nama_istri', type: 'text', required: true },
                    { label: 'Tanggal Pernikahan', name: 'tanggal_nikah', type: 'date', required: true },
                    { label: 'Tempat Pernikahan', name: 'tempat_nikah', type: 'text', required: true }
                ],
                docs: [
                    { label: 'Foto/Scan Buku Nikah (jika ada)', name: 'doc_buku_nikah', required: false }
                ]
            },
            'Pembuatan KTP': {
                fields: [
                    { label: 'Alasan Pembuatan KTP (baru/hilang/perubahan)', name: 'alasan_ktp', type: 'text', required: true }
                ],
                docs: [
                    { label: 'Surat Keterangan Kehilangan (jika hilang)', name: 'doc_kehilangan', required: false }
                ]
            },
            'Surat Tanah': {
                fields: [
                    { label: 'Alamat Tanah', name: 'alamat_tanah', type: 'text', required: true },
                    { label: 'Luas Tanah (m2)', name: 'luas_tanah', type: 'text', required: false }
                ],
                docs: [
                    { label: 'Foto/Scan Sertifikat atau Bukti Kepemilikan (opsional)', name: 'doc_sertifikat', required: false }
                ]
            },
            'Surat Warisan': {
                fields: [
                    { label: 'Nama Almarhum', name: 'nama_almarhum', type: 'text', required: true },
                    { label: 'Hubungan dengan Almarhum', name: 'hubungan_almarhum', type: 'text', required: true },
                    { label: 'Daftar Penerima Waris (nama & hubungan)', name: 'daftar_penerima', type: 'textarea', required: true }
                ],
                docs: [
                    { label: 'Surat Keterangan Ahli Waris (opsional)', name: 'doc_ahli_waris', required: false }
                ]
            },
            'Surat Domisili': {
                fields: [
                    { label: 'Alamat Domisili', name: 'alamat_domisili', type: 'text', required: true },
                    { label: 'RT/RW', name: 'rt_rw', type: 'text', required: true }
                ],
                docs: [
                    { label: 'Surat Pernyataan RT/RW (opsional)', name: 'doc_rt_rw', required: false }
                ]
            },
            'Surat Kelahiran': {
                fields: [
                    { label: 'Nama Bayi', name: 'nama_bayi', type: 'text', required: true },
                    { label: 'Tanggal Lahir Bayi', name: 'tanggal_lahir_bayi', type: 'date', required: true },
                    { label: 'Tempat Lahir Bayi', name: 'tempat_lahir_bayi', type: 'text', required: false },
                    { label: 'Jenis Kelamin Bayi', name: 'jenis_kelamin_bayi', type: 'text', required: false }
                ],
                docs: [
                    { label: 'Foto/Scan Surat Kelahiran (opsional)', name: 'doc_surat_kelahiran', required: false }
                ]
            },
            'Surat Keterangan Tidak Mampu': {
                fields: [
                    { label: 'Keterangan Tambahan', name: 'keterangan_tidak_mampu', type: 'textarea', required: false }
                ],
                docs: [
                    { label: 'Foto/Scan Bukti Penghasilan (opsional)', name: 'doc_bukti_penghasilan', required: false }
                ]
            }
        };

        function renderSurat(jenis) {
            if (!dynamicFields || !dynamicDocs) return;
            dynamicFields.innerHTML = '';
            dynamicDocs.innerHTML = '';

            if (!jenis || !suratConfig[jenis]) {
                // show hint
                return;
            }

            // Render input fields
            suratConfig[jenis].fields.forEach(field => {
                let fieldHtml = '';
                fieldHtml += '<div class="col-md-12">';
                fieldHtml += '<div class="form-group">';
                fieldHtml += `<label class="form-label">${field.label}`;
                if (field.required) fieldHtml += ' <span class="text-danger">*</span>';
                fieldHtml += '</label>';

                if (field.type === 'textarea') {
                    fieldHtml += `<textarea name="${field.name}" class="form-control" rows="2"`;
                    if (field.required) fieldHtml += ' required';
                    fieldHtml += `>{{ old('${field.name}') }}</textarea>`;
                } else {
                    fieldHtml += `<input type="${field.type}" name="${field.name}" class="form-control"`;
                    fieldHtml += ` value="{{ old('${field.name}') }}"`;
                    if (field.required) fieldHtml += ' required';
                    fieldHtml += '>';
                }

                fieldHtml += '</div></div>';
                dynamicFields.insertAdjacentHTML('beforeend', fieldHtml);
            });

            // Render required/optional document upload fields
            if (suratConfig[jenis].docs && suratConfig[jenis].docs.length) {
                dynamicDocs.insertAdjacentHTML('beforeend', '<div class="col-md-12"><hr><h6 class="mb-3">Dokumen Khusus Untuk Jenis Surat Ini</h6></div>');
                suratConfig[jenis].docs.forEach(doc => {
                    let docHtml = '';
                    docHtml += '<div class="col-md-6">';
                    docHtml += '<div class="form-group">';
                    docHtml += `<label class="form-label">${doc.label}`;
                    if (doc.required) docHtml += ' <span class="text-danger">*</span>';
                    docHtml += '</label>';
                    docHtml += `<input type="file" name="${doc.name}" class="form-control" accept=",.pdf,.jpg,.jpeg,.png"`;
                    if (doc.required) docHtml += ' required';
                    docHtml += '>';
                    docHtml += '<small class="text-muted">Format: PDF, JPG, PNG | Max: 2MB</small>';
                    docHtml += '</div></div>';
                    dynamicDocs.insertAdjacentHTML('beforeend', docHtml);
                });
            }
        }

        // guard: only attach listener if element exists
        const debugDiv = document.getElementById('dynamic-debug');
        function debug(msg) {
            if (debugDiv) {
                debugDiv.textContent = msg;
            }
            if (console && console.log) console.log('[dynamic-form] ' + msg);
        }

        debug('script loaded');

        if (jenisSuratField) {
            debug('select found');
            jenisSuratField.addEventListener('change', function() {
                try {
                    debug('changed -> ' + this.value);
                    renderSurat(this.value);
                    debug('rendered for ' + this.value);
                } catch (e) {
                    console.error('Error rendering fields for', this.value, e);
                }
            });

            // Render saat ada nilai (misal setelah validasi gagal)
            if (jenisSuratField.value) {
                try {
                    debug('initial value -> ' + jenisSuratField.value);
                    renderSurat(jenisSuratField.value);
                    debug('initial rendered for ' + jenisSuratField.value);
                } catch (e) {
                    console.error('Error rendering initial fields:', e);
                    debug('error: ' + e.message);
                }
            }
        } else {
            console.warn('jenis_surat select not found; dynamic fields disabled');
            debug('select not found');
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
