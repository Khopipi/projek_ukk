@extends('layouts.dashboard')
@section('title', 'Tambah Data Kematian')
@section('content')
    <style>
        /* Prevent horizontal scrollbar */
        body, html {
            overflow-x: hidden;
            max-width: 100%;
        }

        .pc-container {
            overflow-x: hidden !important;
        }

        @media (max-width: 1400px) {
            .pc-container .pc-content {
                padding-left: 20px !important;
                padding-right: 20px !important;
            }
        }
        @media (max-width: 992px) {
            .pc-container .pc-content {
                padding-left: 15px !important;
                padding-right: 15px !important;
            }
        }
    </style>
    <div class="pc-content">
        <!-- Breadcrumb -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.kematian.index') }}">Data Kematian</a></li>
                            <li class="breadcrumb-item" aria-current="page">Tambah</li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0"><i class="ti ti-death-icon me-2"></i>Tambah Data Kematian</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Form Data Kematian Penduduk</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.kematian.store') }}" method="POST" id="kematianForm">
                            @csrf

                            <!-- Pilih Penduduk -->
                            <div class="mb-3">
                                <label class="form-label">Nama Penduduk <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" id="penduduk_search" class="form-control @error('penduduk_id') is-invalid @enderror" placeholder="Cari nama atau NIK penduduk..." autocomplete="off">
                                    <button class="btn btn-outline-secondary" type="button" id="clearBtn" style="display: none;">
                                        <i class="ti ti-x"></i>
                                    </button>
                                </div>
                                <input type="hidden" name="penduduk_id" id="penduduk_id" value="{{ old('penduduk_id') }}">
                                <input type="hidden" name="nama_warga" id="nama_warga" value="{{ old('nama_warga') }}">
                                <div id="penduduk_suggestions" class="list-group mt-2" style="display: none; max-height: 300px; overflow-y: auto;"></div>
                                @error('penduduk_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Pilih dari daftar atau ketik nama warga secara bebas</small>
                            </div>

                            <script>
                                const penduduks = @json($penduduks);
                                const searchInput = document.getElementById('penduduk_search');
                                const suggestions = document.getElementById('penduduk_suggestions');
                                const hiddenId = document.getElementById('penduduk_id');
                                const hiddenNama = document.getElementById('nama_warga');
                                const form = document.getElementById('kematianForm');
                                const clearBtn = document.getElementById('clearBtn');

                                // Tampilkan clear button saat ada input
                                searchInput.addEventListener('input', function(e) {
                                    const value = this.value.toLowerCase();
                                    
                                    if (value.length > 0) {
                                        clearBtn.style.display = 'block';
                                    } else {
                                        clearBtn.style.display = 'none';
                                        suggestions.style.display = 'none';
                                        return;
                                    }

                                    suggestions.innerHTML = '';
                                    const filtered = penduduks.filter(p => 
                                        p.nama_lengkap.toLowerCase().includes(value) || 
                                        p.nik.includes(value)
                                    );

                                    // Tampilkan suggestions dari database
                                    if (filtered.length > 0) {
                                        const heading = document.createElement('small');
                                        heading.className = 'text-muted d-block px-3 py-2';
                                        heading.textContent = 'Pilih dari daftar:';
                                        suggestions.appendChild(heading);

                                        filtered.forEach(p => {
                                            const item = document.createElement('a');
                                            item.href = '#';
                                            item.className = 'list-group-item list-group-item-action';
                                            item.innerHTML = `<strong>${p.nama_lengkap}</strong><br><small class="text-muted">NIK: ${p.nik}</small>`;
                                            item.addEventListener('click', function(e) {
                                                e.preventDefault();
                                                searchInput.value = p.nama_lengkap;
                                                hiddenId.value = p.id;
                                                hiddenNama.value = ''; // Kosongkan nama_warga jika dari database
                                                suggestions.style.display = 'none';
                                                clearBtn.style.display = 'block';
                                            });
                                            suggestions.appendChild(item);
                                        });
                                    }
                                    
                                    // Tampilkan opsi input bebas jika ada text
                                    if (value.length > 0) {
                                        const divider = document.createElement('small');
                                        divider.className = 'text-muted d-block px-3 py-2 mt-2';
                                        divider.textContent = '─ atau input secara bebas ─';
                                        suggestions.appendChild(divider);

                                        const customItem = document.createElement('a');
                                        customItem.href = '#';
                                        customItem.className = 'list-group-item list-group-item-action bg-light';
                                        customItem.innerHTML = `<i class="ti ti-pencil me-2"></i><strong>Gunakan: "${this.value}"</strong>`;
                                        customItem.addEventListener('click', function(e) {
                                            e.preventDefault();
                                            hiddenId.value = '0'; // Gunakan 0 untuk input bebas
                                            hiddenNama.value = searchInput.value; // Simpan nama di field nama_warga
                                            suggestions.style.display = 'none';
                                            clearBtn.style.display = 'block';
                                        });
                                        suggestions.appendChild(customItem);
                                    }

                                    suggestions.style.display = 'block';
                                });

                                // Clear button handler
                                clearBtn.addEventListener('click', function() {
                                    searchInput.value = '';
                                    hiddenId.value = '';
                                    hiddenNama.value = '';
                                    suggestions.style.display = 'none';
                                    clearBtn.style.display = 'none';
                                    searchInput.focus();
                                });

                                // Close suggestions when clicking outside
                                document.addEventListener('click', function(e) {
                                    if (e.target !== searchInput && e.target !== clearBtn) {
                                        suggestions.style.display = 'none';
                                    }
                                });

                                // Validasi form sebelum submit
                                form.addEventListener('submit', function(e) {
                                    if (!searchInput.value || searchInput.value.trim() === '') {
                                        e.preventDefault();
                                        searchInput.classList.add('is-invalid');
                                        const feedback = searchInput.parentElement.querySelector('.invalid-feedback');
                                        if (feedback) {
                                            feedback.style.display = 'block';
                                        }
                                        searchInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
                                        return false;
                                    }
                                });
                            </script>

                            <!-- NIK -->
                            <div class="mb-3">
                                <label class="form-label">NIK <span class="text-danger">*</span></label>
                                <input type="text" name="nik" class="form-control @error('nik') is-invalid @enderror" 
                                       placeholder="Nomor Identitas (16 digit)" value="{{ old('nik') }}" maxlength="16" required>
                                @error('nik')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Tanggal Lahir -->
                            <div class="mb-3">
                                <label class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal_lahir" class="form-control @error('tanggal_lahir') is-invalid @enderror" 
                                       value="{{ old('tanggal_lahir') }}" required>
                                @error('tanggal_lahir')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Tempat Lahir -->
                            <div class="mb-3">
                                <label class="form-label">Tempat Lahir <span class="text-danger">*</span></label>
                                <input type="text" name="tempat_lahir" class="form-control @error('tempat_lahir') is-invalid @enderror"
                                       placeholder="Contoh: Kota, Kabupaten" value="{{ old('tempat_lahir') }}" required>
                                @error('tempat_lahir')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Jenis Kelamin -->
                            <div class="mb-3">
                                <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                                <select name="jenis_kelamin" class="form-select @error('jenis_kelamin') is-invalid @enderror" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('jenis_kelamin')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Alamat Lengkap -->
                            <div class="mb-3">
                                <label class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                                <textarea name="alamat_lengkap" class="form-control @error('alamat_lengkap') is-invalid @enderror" 
                                          rows="3" placeholder="Jalan, nomor rumah, kelurahan, kecamatan, kota" required>{{ old('alamat_lengkap') }}</textarea>
                                @error('alamat_lengkap')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Tanggal Kematian -->
                            <div class="mb-3">
                                <label class="form-label">Tanggal Kematian <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal_kematian" class="form-control @error('tanggal_kematian') is-invalid @enderror" 
                                       value="{{ old('tanggal_kematian') }}" required>
                                @error('tanggal_kematian')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Penyebab Kematian -->
                            <div class="mb-3">
                                <label class="form-label">Penyebab Kematian</label>
                                <input type="text" name="penyebab_kematian" class="form-control @error('penyebab_kematian') is-invalid @enderror"
                                       placeholder="Contoh: Sakit Jantung, Kecelakaan, dll" value="{{ old('penyebab_kematian') }}">
                                @error('penyebab_kematian')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Lokasi Pemakaman -->
                            <div class="mb-3">
                                <label class="form-label">Lokasi Pemakaman</label>
                                <input type="text" name="tempat_kematian" class="form-control @error('tempat_kematian') is-invalid @enderror"
                                       placeholder="Contoh: Pemakaman Desa, PUHB, Keterangan Lokasi" value="{{ old('tempat_kematian') }}">
                                @error('tempat_kematian')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Lokasi Kematian -->
                            <div class="mb-3">
                                <label class="form-label">Lokasi Kematian</label>
                                <input type="text" name="rs_atau_rumah" class="form-control @error('rs_atau_rumah') is-invalid @enderror"
                                       placeholder="Contoh: Rumah Sakit, Rumah, Jalan, Tempat Lainnya" value="{{ old('rs_atau_rumah') }}">
                                @error('rs_atau_rumah')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Usia Saat Meninggal -->
                            <div class="mb-3">
                                <label class="form-label">Usia Saat Meninggal</label>
                                <input type="text" name="usia_saat_meninggal" class="form-control @error('usia_saat_meninggal') is-invalid @enderror"
                                       placeholder="Contoh: 45 tahun, 2 bulan, dll" value="{{ old('usia_saat_meninggal') }}">
                                @error('usia_saat_meninggal')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Keterangan -->
                            <div class="mb-3">
                                <label class="form-label">Keterangan</label>
                                <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror" 
                                          rows="4" placeholder="Catatan tambahan tentang kematian">{{ old('keterangan') }}</textarea>
                                @error('keterangan')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-footer d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-check me-1"></i>Simpan Data Kematian
                                </button>
                                <a href="{{ route('admin.kematian.index') }}" class="btn btn-secondary">
                                    <i class="ti ti-arrow-left me-1"></i>Kembali
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
