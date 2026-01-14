@extends('layouts.dashboard')
@section('title', 'Edit Pengajuan Surat')
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
                            <li class="breadcrumb-item" aria-current="page">Edit</li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Edit Pengajuan Surat</h2>
                            <small class="text-muted">{{ $pengajuan->nomor_pengajuan }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Alert Messages -->
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="ti ti-alert-circle me-2"></i><strong>Terdapat kesalahan:</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Main Content -->
        <div class="row">
            <div class="col-sm-12">
                <form action="{{ route('pengajuan.update', $pengajuan->id) }}" method="POST" enctype="multipart/form-data" id="formEditPengajuan">
                    @csrf
                    @method('PUT')

                    <!-- Jenis Surat (Read-Only) -->
                    <div class="card">
                        <div class="card-header">
                            <h5><i class="ti ti-file-text me-2"></i>Informasi Pengajuan</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Jenis Surat</label>
                                        <input type="text" class="form-control" value="{{ $pengajuan->data_tambahan['jenis_surat_asli'] ?? $pengajuan->jenis_surat }}" readonly disabled>
                                        <small class="text-muted">Jenis surat tidak dapat diubah</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Nomor Pengajuan</label>
                                        <input type="text" class="form-control" value="{{ $pengajuan->nomor_pengajuan }}" readonly disabled>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">Keperluan / Keterangan <span class="text-danger">*</span></label>
                                        <textarea name="keperluan" class="form-control @error('keperluan') is-invalid @enderror" rows="2" required>{{ old('keperluan', $pengajuan->keperluan) }}</textarea>
                                        @error('keperluan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Dynamic fields based on jenis surat -->
                                <div id="dynamic-form-fields"></div>
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
                                               value="{{ old('nama_pemohon', $pengajuan->nama_pemohon) }}" required>
                                        @error('nama_pemohon')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">NIK <span class="text-danger">*</span></label>
                                        <input type="text" name="nik_pemohon" class="form-control @error('nik_pemohon') is-invalid @enderror"
                                               value="{{ old('nik_pemohon', $pengajuan->nik_pemohon) }}" maxlength="16" required readonly>
                                        @error('nik_pemohon')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Tempat Lahir <span class="text-danger">*</span></label>
                                        <input type="text" name="tempat_lahir_pemohon" class="form-control @error('tempat_lahir_pemohon') is-invalid @enderror"
                                               value="{{ old('tempat_lahir_pemohon', $pengajuan->tempat_lahir_pemohon) }}" required>
                                        @error('tempat_lahir_pemohon')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                                        <input type="date" name="tanggal_lahir_pemohon" class="form-control @error('tanggal_lahir_pemohon') is-invalid @enderror"
                                               value="{{ old('tanggal_lahir_pemohon', $pengajuan->tanggal_lahir_pemohon ? $pengajuan->tanggal_lahir_pemohon->format('Y-m-d') : '') }}" required>
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
                                            <option value="Laki-laki" {{ old('jenis_kelamin_pemohon', $pengajuan->jenis_kelamin_pemohon) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                            <option value="Perempuan" {{ old('jenis_kelamin_pemohon', $pengajuan->jenis_kelamin_pemohon) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
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
                                               value="{{ old('pekerjaan_pemohon', $pengajuan->pekerjaan_pemohon) }}" required>
                                        @error('pekerjaan_pemohon')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                                        <textarea name="alamat_pemohon" class="form-control @error('alamat_pemohon') is-invalid @enderror"
                                                  rows="3" required>{{ old('alamat_pemohon', $pengajuan->alamat_pemohon) }}</textarea>
                                        @error('alamat_pemohon')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">No. Telepon <span class="text-danger">*</span></label>
                                        <input type="text" name="no_telepon_pemohon" class="form-control @error('no_telepon_pemohon') is-invalid @enderror"
                                               value="{{ old('no_telepon_pemohon', $pengajuan->no_telepon_pemohon) }}" maxlength="15" required>
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
                                <!-- Base documents (KTP, KK) -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Foto/Scan KTP</label>
                                        <input type="file" name="file_ktp" class="form-control @error('file_ktp') is-invalid @enderror" accept=".pdf,.jpg,.jpeg,.png">
                                        @if($pengajuan->file_ktp)
                                            <small class="text-success d-block mt-2">
                                                <i class="ti ti-check me-1"></i>File sudah diupload
                                            </small>
                                        @endif
                                        @error('file_ktp')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Foto/Scan KK</label>
                                        <input type="file" name="file_kk" class="form-control @error('file_kk') is-invalid @enderror" accept=".pdf,.jpg,.jpeg,.png">
                                        @if($pengajuan->file_kk)
                                            <small class="text-success d-block mt-2">
                                                <i class="ti ti-check me-1"></i>File sudah diupload
                                            </small>
                                        @endif
                                        @error('file_kk')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="alert alert-warning mt-3">
                                        <i class="ti ti-alert-triangle me-2"></i>
                                        <strong>Catatan:</strong> Jika tidak mengupload file baru, file yang sebelumnya akan tetap digunakan.
                                    </div>
                                </div>
                            </div>

                            <!-- Dynamic doc fields based on jenis surat -->
                            <div id="dynamic-fields"></div>
                        </div>
                        <div class="card-footer text-end">
                            <a href="{{ route('pengajuan.show', $pengajuan->id) }}" class="btn btn-secondary">
                                <i class="ti ti-x"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-send"></i> Simpan Perubahan
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
    document.addEventListener('DOMContentLoaded', function() {
        const dynamicFields = document.getElementById('dynamic-form-fields');
        const dynamicDocs = document.getElementById('dynamic-fields');
        
        // Jenis surat dari data pengajuan
        const jenisSurat = '{{ $pengajuan->data_tambahan["jenis_surat_asli"] ?? $pengajuan->jenis_surat }}';
        const dataTambahan = @json($pengajuan->data_tambahan ?? []);

        function escapeHtml(unsafe) {
            if (unsafe === null || unsafe === undefined) return '';
            return String(unsafe)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }

        // Konfigurasi field untuk setiap jenis surat (sama seperti di create.blade.php)
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
                    { label: 'Kartu Keluarga (KK) Pemohon', name: 'doc_kk_domisili', required: true },
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
            },
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

            // Tampilkan/sembunyikan base documents
            const baseDocuments = document.getElementById('base-documents');
            if (baseDocuments) {
                if (jenis === 'Surat Nikah' || jenis === 'Surat Warisan' || jenis === 'Surat Domisili' || jenis === 'Surat Akta Kelahiran' || jenis === 'Surat Keterangan Tidak Mampu' || jenis === 'Surat Tanah' || jenis === 'Surat Akta Kematian') {
                    baseDocuments.style.display = 'none';
                } else {
                    baseDocuments.style.display = 'block';
                }
            }

            if (!jenis || !suratConfig[jenis]) {
                return;
            }

            // Render input fields
            suratConfig[jenis].fields.forEach(field => {
                const val = dataTambahan && dataTambahan[field.name] ? dataTambahan[field.name] : '';
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
                    const pattern = field.pattern ? `pattern="${field.pattern}"` : '';
                    fieldHtml += `<input type="${field.type}" name="${field.name}" class="form-control" value="${escapeHtml(val)}" ${placeholder} ${pattern} ${field.required ? 'required' : ''}>`;
                    
                    if (field.name === 'luas_tanah') {
                        fieldHtml += '<small class="text-muted d-block mt-2"><strong>Format:</strong> Angka saja (22) atau dengan perkalian (*) untuk panjang x lebar (25*32 atau 25.5*32.5)</small>';
                    }
                }

                fieldHtml += '</div></div>';
                dynamicFields.insertAdjacentHTML('beforeend', fieldHtml);
            });

            // Render document upload fields
            if (suratConfig[jenis].docs && suratConfig[jenis].docs.length) {
                dynamicDocs.insertAdjacentHTML('beforeend', '<div class="col-md-12"><hr><h6 class="mb-3">Dokumen Khusus Untuk Jenis Surat Ini</h6><p class="text-muted small">Upload dokumen pendukung sesuai jenis surat</p></div>');
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

        // Render initial based on jenis surat
        if (jenisSurat) {
            renderSurat(jenisSurat);
        }
    });
</script>
@endsection