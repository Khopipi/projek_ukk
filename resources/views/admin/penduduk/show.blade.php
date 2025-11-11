@extends('layouts.dashboard')
@section('title', 'Detail Data Penduduk')
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
                            <li class="breadcrumb-item" aria-current="page">Detail</li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Detail Data Penduduk</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="row">
            <div class="col-lg-4">
                <!-- Foto & Identitas Singkat -->
                <div class="card">
                    <div class="card-body text-center">
                        <img src="{{ $penduduk->foto_url }}" 
                             alt="Foto {{ $penduduk->nama_lengkap }}" 
                             class="img-fluid rounded-circle mb-3" 
                             style="width: 150px; height: 150px; object-fit: cover;">
                        
                        <h4 class="mb-1">{{ $penduduk->nama_lengkap }}</h4>
                        <p class="text-muted mb-3">NIK: {{ $penduduk->nik }}</p>
                        
                        <div class="d-flex justify-content-center gap-2 mb-3">
                            <span class="badge bg-{{ $penduduk->jenis_kelamin == 'Laki-laki' ? 'primary' : 'danger' }} p-2">
                                <i class="ti ti-{{ $penduduk->jenis_kelamin == 'Laki-laki' ? 'gender-male' : 'gender-female' }}"></i>
                                {{ $penduduk->jenis_kelamin }}
                            </span>
                            <span class="badge bg-info p-2">
                                <i class="ti ti-calendar"></i>
                                {{ $penduduk->umur }} Tahun
                            </span>
                        </div>

                        <hr>

                        <div class="text-start">
                            <p class="mb-2"><i class="ti ti-cake me-2 text-primary"></i> 
                                <strong>TTL:</strong><br>
                                <span class="ms-4">{{ $penduduk->tempat_lahir }}, {{ $penduduk->tanggal_lahir->format('d F Y') }}</span>
                            </p>
                            <p class="mb-2"><i class="ti ti-briefcase me-2 text-success"></i> 
                                <strong>Pekerjaan:</strong><br>
                                <span class="ms-4">{{ $penduduk->pekerjaan }}</span>
                            </p>
                            <p class="mb-2"><i class="ti ti-heart me-2 text-danger"></i> 
                                <strong>Status:</strong><br>
                                <span class="ms-4">{{ $penduduk->status_perkawinan }}</span>
                            </p>
                            <p class="mb-0"><i class="ti ti-book me-2 text-warning"></i> 
                                <strong>Agama:</strong><br>
                                <span class="ms-4">{{ $penduduk->agama }}</span>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Kontak -->
                <div class="card">
                    <div class="card-header">
                        <h5><i class="ti ti-phone me-2"></i>Informasi Kontak</h5>
                    </div>
                    <div class="card-body">
                        @if($penduduk->no_telepon)
                        <p class="mb-2">
                            <i class="ti ti-phone text-primary me-2"></i>
                            <strong>Telepon:</strong><br>
                            <span class="ms-4">{{ $penduduk->no_telepon }}</span>
                        </p>
                        @endif
                        
                        @if($penduduk->email)
                        <p class="mb-0">
                            <i class="ti ti-mail text-success me-2"></i>
                            <strong>Email:</strong><br>
                            <span class="ms-4">{{ $penduduk->email }}</span>
                        </p>
                        @endif

                        @if(!$penduduk->no_telepon && !$penduduk->email)
                        <p class="text-muted text-center mb-0">Tidak ada informasi kontak</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <!-- Data Identitas -->
                <div class="card">
                    <div class="card-header">
                        <h5><i class="ti ti-id me-2"></i>Data Identitas</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="text-muted mb-1">NIK</label>
                                <p class="fw-bold">{{ $penduduk->nik }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-muted mb-1">No. Kartu Keluarga</label>
                                <p class="fw-bold">{{ $penduduk->kk }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-muted mb-1">Nama Lengkap</label>
                                <p class="fw-bold">{{ $penduduk->nama_lengkap }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-muted mb-1">Jenis Kelamin</label>
                                <p class="fw-bold">{{ $penduduk->jenis_kelamin }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-muted mb-1">Tempat Lahir</label>
                                <p class="fw-bold">{{ $penduduk->tempat_lahir }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-muted mb-1">Tanggal Lahir</label>
                                <p class="fw-bold">{{ $penduduk->tanggal_lahir->format('d F Y') }} ({{ $penduduk->umur }} tahun)</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-muted mb-1">Kewarganegaraan</label>
                                <p class="fw-bold">{{ $penduduk->kewarganegaraan }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-muted mb-1">Pendidikan Terakhir</label>
                                <p class="fw-bold">{{ $penduduk->pendidikan_terakhir ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Alamat -->
                <div class="card">
                    <div class="card-header">
                        <h5><i class="ti ti-map-pin me-2"></i>Alamat Lengkap</h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-3">{{ $penduduk->alamat }}</p>
                        <div class="row">
                            <div class="col-md-3 mb-2">
                                <label class="text-muted mb-1">RT / RW</label>
                                <p class="fw-bold">{{ $penduduk->rt }} / {{ $penduduk->rw }}</p>
                            </div>
                            <div class="col-md-3 mb-2">
                                <label class="text-muted mb-1">Desa</label>
                                <p class="fw-bold">{{ $penduduk->desa }}</p>
                            </div>
                            <div class="col-md-3 mb-2">
                                <label class="text-muted mb-1">Kecamatan</label>
                                <p class="fw-bold">{{ $penduduk->kecamatan }}</p>
                            </div>
                            <div class="col-md-3 mb-2">
                                <label class="text-muted mb-1">Kabupaten</label>
                                <p class="fw-bold">{{ $penduduk->kabupaten }}</p>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label class="text-muted mb-1">Provinsi</label>
                                <p class="fw-bold">{{ $penduduk->provinsi }}</p>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label class="text-muted mb-1">Kode Pos</label>
                                <p class="fw-bold">{{ $penduduk->kode_pos }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Data Keluarga -->
                <div class="card">
                    <div class="card-header">
                        <h5><i class="ti ti-users me-2"></i>Data Keluarga</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="text-muted mb-1">Status Dalam Keluarga</label>
                                <p class="fw-bold">{{ $penduduk->status_dalam_keluarga }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-muted mb-1">Status Kependudukan</label>
                                <p class="fw-bold">{{ $penduduk->status_kependudukan }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-muted mb-1">Nama Ayah</label>
                                <p class="fw-bold">{{ $penduduk->nama_ayah ?? '-' }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-muted mb-1">Nama Ibu</label>
                                <p class="fw-bold">{{ $penduduk->nama_ibu ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Keterangan Tambahan -->
                @if($penduduk->keterangan)
                <div class="card">
                    <div class="card-header">
                        <h5><i class="ti ti-notes me-2"></i>Keterangan Tambahan</h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-0">{{ $penduduk->keterangan }}</p>
                    </div>
                </div>
                @endif

                <!-- Action Buttons -->
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-muted">
                                    <i class="ti ti-calendar me-1"></i>
                                    Dibuat: {{ $penduduk->created_at->format('d F Y, H:i') }}
                                </small>
                                <br>
                                <small class="text-muted">
                                    <i class="ti ti-refresh me-1"></i>
                                    Diupdate: {{ $penduduk->updated_at->format('d F Y, H:i') }}
                                </small>
                            </div>
                            <div class="btn-group" role="group">
                                <a href="{{ route('penduduk.index') }}" class="btn btn-secondary">
                                    <i class="ti ti-arrow-left me-1"></i> Kembali
                                </a>
                                <a href="{{ route('penduduk.edit', $penduduk->id) }}" class="btn btn-warning">
                                    <i class="ti ti-edit me-1"></i> Edit Data
                                </a>
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                    <i class="ti ti-trash me-1"></i> Hapus
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus data penduduk:</p>
                    <div class="alert alert-warning">
                        <strong>{{ $penduduk->nama_lengkap }}</strong><br>
                        NIK: {{ $penduduk->nik }}
                    </div>
                    <p class="text-danger mb-0"><i class="ti ti-alert-triangle me-1"></i>Data yang sudah dihapus tidak dapat dikembalikan!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form action="{{ route('penduduk.destroy', $penduduk->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="ti ti-trash me-1"></i> Ya, Hapus Data
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection