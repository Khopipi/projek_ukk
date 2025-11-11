@extends('layouts.dashboard')
@section('title', 'Edit Data Penduduk')
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
                            <li class="breadcrumb-item" aria-current="page">Edit Data</li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Edit Data Penduduk</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="row">
            <div class="col-sm-12">
                <form action="{{ route('penduduk.update', $penduduk->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="card">
                        <div class="card-header">
                            <h5>Data Identitas</h5>
                        </div>
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="row">
                                <!-- NIK -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">NIK <span class="text-danger">*</span></label>
                                        <input type="text" name="nik" class="form-control @error('nik') is-invalid @enderror" 
                                               value="{{ old('nik', $penduduk->nik) }}" maxlength="16" required>
                                        @error('nik')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- KK -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">No. KK <span class="text-danger">*</span></label>
                                        <input type="text" name="kk" class="form-control @error('kk') is-invalid @enderror" 
                                               value="{{ old('kk', $penduduk->kk) }}" maxlength="16" required>
                                        @error('kk')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Nama Lengkap -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                        <input type="text" name="nama_lengkap" class="form-control @error('nama_lengkap') is-invalid @enderror" 
                                               value="{{ old('nama_lengkap', $penduduk->nama_lengkap) }}" required>
                                        @error('nama_lengkap')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Jenis Kelamin -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                                        <select name="jenis_kelamin" class="form-select @error('jenis_kelamin') is-invalid @enderror" required>
                                            <option value="">Pilih Jenis Kelamin</option>
                                            <option value="Laki-laki" {{ old('jenis_kelamin', $penduduk->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                            <option value="Perempuan" {{ old('jenis_kelamin', $penduduk->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                        </select>
                                        @error('jenis_kelamin')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Tempat Lahir -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Tempat Lahir <span class="text-danger">*</span></label>
                                        <input type="text" name="tempat_lahir" class="form-control @error('tempat_lahir') is-invalid @enderror" 
                                               value="{{ old('tempat_lahir', $penduduk->tempat_lahir) }}" required>
                                        @error('tempat_lahir')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Tanggal Lahir -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                                        <input type="date" name="tanggal_lahir" class="form-control @error('tanggal_lahir') is-invalid @enderror" 
                                               value="{{ old('tanggal_lahir', $penduduk->tanggal_lahir->format('Y-m-d')) }}" required>
                                        @error('tanggal_lahir')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h5>Data Alamat</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- Alamat -->
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                                        <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" 
                                                  rows="3" required>{{ old('alamat', $penduduk->alamat) }}</textarea>
                                        @error('alamat')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- RT/RW -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">RT <span class="text-danger">*</span></label>
                                        <input type="text" name="rt" class="form-control @error('rt') is-invalid @enderror" 
                                               value="{{ old('rt', $penduduk->rt) }}" maxlength="3" required>
                                        @error('rt')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">RW <span class="text-danger">*</span></label>
                                        <input type="text" name="rw" class="form-control @error('rw') is-invalid @enderror" 
                                               value="{{ old('rw', $penduduk->rw) }}" maxlength="3" required>
                                        @error('rw')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Desa <span class="text-danger">*</span></label>
                                        <input type="text" name="desa" class="form-control @error('desa') is-invalid @enderror" 
                                               value="{{ old('desa', $penduduk->desa) }}" required>
                                        @error('desa')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Kecamatan -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Kecamatan <span class="text-danger">*</span></label>
                                        <input type="text" name="kecamatan" class="form-control @error('kecamatan') is-invalid @enderror" 
                                               value="{{ old('kecamatan', $penduduk->kecamatan) }}" required>
                                        @error('kecamatan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Kabupaten -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Kabupaten <span class="text-danger">*</span></label>
                                        <input type="text" name="kabupaten" class="form-control @error('kabupaten') is-invalid @enderror" 
                                               value="{{ old('kabupaten', $penduduk->kabupaten) }}" required>
                                        @error('kabupaten')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Provinsi -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Provinsi <span class="text-danger">*</span></label>
                                        <input type="text" name="provinsi" class="form-control @error('provinsi') is-invalid @enderror" 
                                               value="{{ old('provinsi', $penduduk->provinsi) }}" required>
                                        @error('provinsi')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Kode Pos -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Kode Pos <span class="text-danger">*</span></label>
                                        <input type="text" name="kode_pos" class="form-control @error('kode_pos') is-invalid @enderror" 
                                               value="{{ old('kode_pos', $penduduk->kode_pos) }}" maxlength="5" required>
                                        @error('kode_pos')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h5>Data Lainnya</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- Agama -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Agama <span class="text-danger">*</span></label>
                                        <select name="agama" class="form-select @error('agama') is-invalid @enderror" required>
                                            <option value="">Pilih Agama</option>
                                            <option value="Islam" {{ old('agama', $penduduk->agama) == 'Islam' ? 'selected' : '' }}>Islam</option>
                                            <option value="Kristen" {{ old('agama', $penduduk->agama) == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                            <option value="Katolik" {{ old('agama', $penduduk->agama) == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                            <option value="Hindu" {{ old('agama', $penduduk->agama) == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                            <option value="Buddha" {{ old('agama', $penduduk->agama) == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                            <option value="Konghucu" {{ old('agama', $penduduk->agama) == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                                        </select>
                                        @error('agama')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Status Perkawinan -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Status Perkawinan <span class="text-danger">*</span></label>
                                        <select name="status_perkawinan" class="form-select @error('status_perkawinan') is-invalid @enderror" required>
                                            <option value="">Pilih Status</option>
                                            <option value="Belum Kawin" {{ old('status_perkawinan', $penduduk->status_perkawinan) == 'Belum Kawin' ? 'selected' : '' }}>Belum Kawin</option>
                                            <option value="Kawin" {{ old('status_perkawinan', $penduduk->status_perkawinan) == 'Kawin' ? 'selected' : '' }}>Kawin</option>
                                            <option value="Cerai Hidup" {{ old('status_perkawinan', $penduduk->status_perkawinan) == 'Cerai Hidup' ? 'selected' : '' }}>Cerai Hidup</option>
                                            <option value="Cerai Mati" {{ old('status_perkawinan', $penduduk->status_perkawinan) == 'Cerai Mati' ? 'selected' : '' }}>Cerai Mati</option>
                                        </select>
                                        @error('status_perkawinan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Pekerjaan -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Pekerjaan <span class="text-danger">*</span></label>
                                        <input type="text" name="pekerjaan" class="form-control @error('pekerjaan') is-invalid @enderror" 
                                               value="{{ old('pekerjaan', $penduduk->pekerjaan) }}" required>
                                        @error('pekerjaan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Pendidikan Terakhir -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Pendidikan Terakhir</label>
                                        <input type="text" name="pendidikan_terakhir" class="form-control @error('pendidikan_terakhir') is-invalid @enderror" 
                                               value="{{ old('pendidikan_terakhir', $penduduk->pendidikan_terakhir) }}">
                                        @error('pendidikan_terakhir')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Kewarganegaraan -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Kewarganegaraan <span class="text-danger">*</span></label>
                                        <select name="kewarganegaraan" class="form-select @error('kewarganegaraan') is-invalid @enderror" required>
                                            <option value="WNI" {{ old('kewarganegaraan', $penduduk->kewarganegaraan) == 'WNI' ? 'selected' : '' }}>WNI</option>
                                            <option value="WNA" {{ old('kewarganegaraan', $penduduk->kewarganegaraan) == 'WNA' ? 'selected' : '' }}>WNA</option>
                                        </select>
                                        @error('kewarganegaraan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Status Dalam Keluarga -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Status Dalam Keluarga <span class="text-danger">*</span></label>
                                        <select name="status_dalam_keluarga" class="form-select @error('status_dalam_keluarga') is-invalid @enderror" required>
                                            <option value="">Pilih Status</option>
                                            <option value="Kepala Keluarga" {{ old('status_dalam_keluarga', $penduduk->status_dalam_keluarga) == 'Kepala Keluarga' ? 'selected' : '' }}>Kepala Keluarga</option>
                                            <option value="Istri" {{ old('status_dalam_keluarga', $penduduk->status_dalam_keluarga) == 'Istri' ? 'selected' : '' }}>Istri</option>
                                            <option value="Anak" {{ old('status_dalam_keluarga', $penduduk->status_dalam_keluarga) == 'Anak' ? 'selected' : '' }}>Anak</option>
                                            <option value="Menantu" {{ old('status_dalam_keluarga', $penduduk->status_dalam_keluarga) == 'Menantu' ? 'selected' : '' }}>Menantu</option>
                                            <option value="Cucu" {{ old('status_dalam_keluarga', $penduduk->status_dalam_keluarga) == 'Cucu' ? 'selected' : '' }}>Cucu</option>
                                            <option value="Orang Tua" {{ old('status_dalam_keluarga', $penduduk->status_dalam_keluarga) == 'Orang Tua' ? 'selected' : '' }}>Orang Tua</option>
                                            <option value="Mertua" {{ old('status_dalam_keluarga', $penduduk->status_dalam_keluarga) == 'Mertua' ? 'selected' : '' }}>Mertua</option>
                                            <option value="Famili Lain" {{ old('status_dalam_keluarga', $penduduk->status_dalam_keluarga) == 'Famili Lain' ? 'selected' : '' }}>Famili Lain</option>
                                            <option value="Pembantu" {{ old('status_dalam_keluarga', $penduduk->status_dalam_keluarga) == 'Pembantu' ? 'selected' : '' }}>Pembantu</option>
                                            <option value="Lainnya" {{ old('status_dalam_keluarga', $penduduk->status_dalam_keluarga) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                        </select>
                                        @error('status_dalam_keluarga')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Status Kependudukan -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Status Kependudukan <span class="text-danger">*</span></label>
                                        <select name="status_kependudukan" class="form-select @error('status_kependudukan') is-invalid @enderror" required>
                                            <option value="">Pilih Status</option>
                                            <option value="Tetap" {{ old('status_kependudukan', $penduduk->status_kependudukan) == 'Tetap' ? 'selected' : '' }}>Tetap</option>
                                            <option value="Tidak Tetap" {{ old('status_kependudukan', $penduduk->status_kependudukan) == 'Tidak Tetap' ? 'selected' : '' }}>Tidak Tetap</option>
                                            <option value="Pendatang" {{ old('status_kependudukan', $penduduk->status_kependudukan) == 'Pendatang' ? 'selected' : '' }}>Pendatang</option>
                                        </select>
                                        @error('status_kependudukan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Nama Ayah -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Nama Ayah</label>
                                        <input type="text" name="nama_ayah" class="form-control @error('nama_ayah') is-invalid @enderror" 
                                               value="{{ old('nama_ayah', $penduduk->nama_ayah) }}">
                                        @error('nama_ayah')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Nama Ibu -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Nama Ibu</label>
                                        <input type="text" name="nama_ibu" class="form-control @error('nama_ibu') is-invalid @enderror" 
                                               value="{{ old('nama_ibu', $penduduk->nama_ibu) }}">
                                        @error('nama_ibu')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- No Telepon -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">No. Telepon</label>
                                        <input type="text" name="no_telepon" class="form-control @error('no_telepon') is-invalid @enderror" 
                                               value="{{ old('no_telepon', $penduduk->no_telepon) }}" maxlength="15">
                                        @error('no_telepon')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Email</label>
                                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                               value="{{ old('email', $penduduk->email) }}">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Foto -->
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">Foto</label>
                                        @if($penduduk->foto)
                                        <div class="mb-2">
                                            <img src="{{ $penduduk->foto_url }}" alt="Foto Saat Ini" class="img-thumbnail" style="max-width: 150px;">
                                            <p class="text-muted small mb-0">Foto saat ini</p>
                                        </div>
                                        @endif
                                        <input type="file" name="foto" class="form-control @error('foto') is-invalid @enderror" 
                                               accept="image/*">
                                        <small class="text-muted">Format: JPG, JPEG, PNG. Max: 2MB. Kosongkan jika tidak ingin mengubah foto.</small>
                                        @error('foto')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Keterangan -->
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">Keterangan</label>
                                        <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror" 
                                                  rows="3">{{ old('keterangan', $penduduk->keterangan) }}</textarea>
                                        @error('keterangan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <a href="{{ route('penduduk.show', $penduduk->id) }}" class="btn btn-secondary">
                                <i class="ti ti-x"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-device-floppy"></i> Update Data
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection