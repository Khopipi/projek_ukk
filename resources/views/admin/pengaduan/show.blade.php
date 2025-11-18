@extends('layouts.dashboard')
@section('title', 'Detail Pengaduan')
@section('content')
    <div class="pc-content">
        <!-- Breadcrumb -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.pengaduan.index') }}">Verifikasi Pengaduan</a></li>
                            <li class="breadcrumb-item" aria-current="page">Detail</li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Detail Pengaduan</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Alert Messages -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="ti ti-check me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="ti ti-alert-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row">
            <!-- Status & Info -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <span class="badge {{ $pengaduan->status_badge }} p-3" style="font-size: 1.2rem;">
                                {{ $pengaduan->status }}
                            </span>
                        </div>

                        <h4 class="mb-1">{{ $pengaduan->nomor_pengaduan }}</h4>
                        <p class="text-muted mb-3">Nomor Pengaduan</p>

                        <div class="text-start mb-3">
                            <p class="mb-2">
                                <i class="{{ $pengaduan->kategori_icon }} me-2 text-primary"></i>
                                <strong>Kategori:</strong><br>
                                <span class="ms-4">{{ $pengaduan->kategori }}</span>
                            </p>

                            <p class="mb-2">
                                <span class="badge {{ $pengaduan->prioritas_badge }} w-100">
                                    Prioritas: {{ $pengaduan->prioritas }}
                                </span>
                            </p>

                            <p class="mb-2">
                                <i class="ti ti-calendar me-2 text-success"></i>
                                <strong>Tanggal Laporan:</strong><br>
                                <span class="ms-4">{{ $pengaduan->created_at->format('d F Y, H:i') }}</span>
                            </p>

                            @if($pengaduan->lokasi)
                            <p class="mb-2">
                                <i class="ti ti-map-pin me-2 text-info"></i>
                                <strong>Lokasi:</strong><br>
                                <span class="ms-4">{{ $pengaduan->lokasi }}</span>
                            </p>
                            @endif

                            @if($pengaduan->tanggal_ditanggapi)
                            <p class="mb-2">
                                <i class="ti ti-message-circle me-2 text-success"></i>
                                <strong>Ditanggapi:</strong><br>
                                <span class="ms-4">{{ $pengaduan->tanggal_ditanggapi->format('d F Y, H:i') }}</span>
                            </p>
                            @endif

                            @if($pengaduan->tanggal_selesai)
                            <p class="mb-0">
                                <i class="ti ti-circle-check me-2 text-primary"></i>
                                <strong>Selesai:</strong><br>
                                <span class="ms-4">{{ $pengaduan->tanggal_selesai->format('d F Y, H:i') }}</span>
                            </p>
                            @endif
                        </div>

                        @if($pengaduan->tanggapan_admin)
                        <div class="alert alert-success text-start mt-3">
                            <strong><i class="ti ti-message-circle me-1"></i> Tanggapan Admin:</strong>
                            <p class="mb-0 mt-2">{{ $pengaduan->tanggapan_admin }}</p>
                            @if($pengaduan->admin)
                            <small class="text-muted">Oleh: {{ $pengaduan->admin->name }}</small>
                            @endif
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="card">
                    <div class="card-header">
                        <h5>Aksi Verifikasi</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            @if($pengaduan->status == 'Menunggu')
                            <form action="{{ route('admin.pengaduan.proses', $pengaduan->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-warning w-100" onclick="return confirm('Tandai pengaduan ini sedang diproses?')">
                                    <i class="ti ti-refresh me-1"></i> Tandai Diproses
                                </button>
                            </form>
                            @endif

                            @if(in_array($pengaduan->status, ['Menunggu', 'Diproses']))
                            <button type="button" class="btn btn-success w-100" data-bs-toggle="modal" data-bs-target="#tanggapiModal">
                                <i class="ti ti-message-circle me-1"></i> Beri Tanggapan
                            </button>
                            @endif

                            @if($pengaduan->status == 'Diproses')
                            <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#selesaiModal">
                                <i class="ti ti-check me-1"></i> Selesaikan Pengaduan
                            </button>
                            @endif

                            @if(in_array($pengaduan->status, ['Menunggu', 'Diproses']))
                            <button type="button" class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#tolakModal">
                                <i class="ti ti-x me-1"></i> Tolak Pengaduan
                            </button>
                            @endif

                            <hr>

                            <a href="{{ route('admin.pengaduan.index') }}" class="btn btn-secondary w-100">
                                <i class="ti ti-arrow-left me-1"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Info Pelapor -->
                <div class="card">
                    <div class="card-header">
                        <h5>Info Pelapor</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="flex-shrink-0">
                                <div class="avtar avtar-l bg-light-primary">
                                    <i class="ti ti-user f-24"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-0">{{ $pengaduan->user->name }}</h6>
                                <small class="text-muted">{{ $pengaduan->user->email }}</small>
                            </div>
                        </div>
                        <p class="mb-1"><strong>Role:</strong> {{ ucfirst($pengaduan->user->role) }}</p>
                    </div>
                </div>
            </div>

            <!-- Detail Data -->
            <div class="col-lg-8">
                <!-- Judul & Isi Pengaduan -->
                <div class="card">
                    <div class="card-header">
                        <h5><i class="ti ti-file-text me-2"></i>Detail Pengaduan</h5>
                    </div>
                    <div class="card-body">
                        <h4 class="mb-3">{{ $pengaduan->judul }}</h4>
                        <p class="mb-0" style="white-space: pre-line;">{{ $pengaduan->isi_pengaduan }}</p>
                    </div>
                </div>

                <!-- Foto-foto -->
                @if($pengaduan->foto_1 || $pengaduan->foto_2 || $pengaduan->foto_3)
                <div class="card">
                    <div class="card-header">
                        <h5><i class="ti ti-photo me-2"></i>Foto Lampiran</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @if($pengaduan->foto_1 && $pengaduan->foto_1_url)
                            <div class="col-md-4 mb-3">
                                <div class="position-relative overflow-hidden rounded border bg-light" style="aspect-ratio: 1;">
                                    <img src="{{ $pengaduan->foto_1_url }}"
                                         alt="Foto 1"
                                         class="img-fluid w-100 h-100"
                                         style="object-fit: cover; cursor: pointer;"
                                         data-bs-toggle="modal" 
                                         data-bs-target="#fotoModal1">
                                </div>
                                <div class="d-grid gap-2 mt-2">
                                    <button class="btn btn-sm btn-outline-primary" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#fotoModal1">
                                        <i class="ti ti-eye me-1"></i> Lihat Fullscreen
                                    </button>
                                    <a href="{{ $pengaduan->foto_1_url }}" 
                                       download="pengaduan-{{ $pengaduan->nomor_pengaduan }}-foto-1"
                                       class="btn btn-sm btn-outline-success">
                                        <i class="ti ti-download me-1"></i> Download
                                    </a>
                                </div>
                            </div>
                            @else
                            <div class="col-md-4 mb-3">
                                <div class="alert alert-warning text-center">
                                    <i class="ti ti-photo-off"></i> File tidak ditemukan
                                </div>
                            </div>
                            @endif

                            @if($pengaduan->foto_2 && $pengaduan->foto_2_url)
                            <div class="col-md-4 mb-3">
                                <div class="position-relative overflow-hidden rounded border bg-light" style="aspect-ratio: 1;">
                                    <img src="{{ $pengaduan->foto_2_url }}"
                                         alt="Foto 2"
                                         class="img-fluid w-100 h-100"
                                         style="object-fit: cover; cursor: pointer;"
                                         data-bs-toggle="modal" 
                                         data-bs-target="#fotoModal2">
                                </div>
                                <div class="d-grid gap-2 mt-2">
                                    <button class="btn btn-sm btn-outline-primary" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#fotoModal2">
                                        <i class="ti ti-eye me-1"></i> Lihat Fullscreen
                                    </button>
                                    <a href="{{ $pengaduan->foto_2_url }}" 
                                       download="pengaduan-{{ $pengaduan->nomor_pengaduan }}-foto-2"
                                       class="btn btn-sm btn-outline-success">
                                        <i class="ti ti-download me-1"></i> Download
                                    </a>
                                </div>
                            </div>
                            @else
                            <div class="col-md-4 mb-3">
                                <div class="alert alert-warning text-center">
                                    <i class="ti ti-photo-off"></i> File tidak ditemukan
                                </div>
                            </div>
                            @endif

                            @if($pengaduan->foto_3 && $pengaduan->foto_3_url)
                            <div class="col-md-4 mb-3">
                                <div class="position-relative overflow-hidden rounded border bg-light" style="aspect-ratio: 1;">
                                    <img src="{{ $pengaduan->foto_3_url }}"
                                         alt="Foto 3"
                                         class="img-fluid w-100 h-100"
                                         style="object-fit: cover; cursor: pointer;"
                                         data-bs-toggle="modal" 
                                         data-bs-target="#fotoModal3">
                                </div>
                                <div class="d-grid gap-2 mt-2">
                                    <button class="btn btn-sm btn-outline-primary" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#fotoModal3">
                                        <i class="ti ti-eye me-1"></i> Lihat Fullscreen
                                    </button>
                                    <a href="{{ $pengaduan->foto_3_url }}" 
                                       download="pengaduan-{{ $pengaduan->nomor_pengaduan }}-foto-3"
                                       class="btn btn-sm btn-outline-success">
                                        <i class="ti ti-download me-1"></i> Download
                                    </a>
                                </div>
                            </div>
                            @else
                            <div class="col-md-4 mb-3">
                                <div class="alert alert-warning text-center">
                                    <i class="ti ti-photo-off"></i> File tidak ditemukan
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endif

                <!-- Timeline Status -->
                <div class="card">
                    <div class="card-header">
                        <h5><i class="ti ti-timeline me-2"></i>Riwayat Status</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item px-0">
                                <div class="d-flex align-items-start">
                                    <div class="flex-shrink-0">
                                        <div class="avtar avtar-s bg-light-success">
                                            <i class="ti ti-plus text-success"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-0">Pengaduan Dibuat</h6>
                                        <small class="text-muted">{{ $pengaduan->created_at->format('d F Y, H:i') }}</small>
                                    </div>
                                </div>
                            </li>

                            @if($pengaduan->tanggal_ditanggapi)
                            <li class="list-group-item px-0">
                                <div class="d-flex align-items-start">
                                    <div class="flex-shrink-0">
                                        <div class="avtar avtar-s bg-light-info">
                                            <i class="ti ti-message-circle text-info"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-0">Ditanggapi Admin</h6>
                                        <small class="text-muted">{{ $pengaduan->tanggal_ditanggapi->format('d F Y, H:i') }}</small>
                                        @if($pengaduan->admin)
                                        <br><small class="text-muted">Oleh: {{ $pengaduan->admin->name }}</small>
                                        @endif
                                    </div>
                                </div>
                            </li>
                            @endif

                            @if($pengaduan->tanggal_selesai)
                            <li class="list-group-item px-0">
                                <div class="d-flex align-items-start">
                                    <div class="flex-shrink-0">
                                        <div class="avtar avtar-s bg-light-primary">
                                            <i class="ti ti-circle-check text-primary"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-0">Pengaduan Selesai</h6>
                                        <small class="text-muted">{{ $pengaduan->tanggal_selesai->format('d F Y, H:i') }}</small>
                                    </div>
                                </div>
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tanggapi Modal -->
    @if(in_array($pengaduan->status, ['Menunggu', 'Diproses']))
    <div class="modal fade" id="tanggapiModal" tabindex="-1">
        <div class="modal-dialog">
            <form action="{{ route('admin.pengaduan.tanggapi', $pengaduan->id) }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title">Tanggapi Pengaduan</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <div class="alert alert-info">
                            <strong>{{ $pengaduan->nomor_pengaduan }}</strong><br>
                            {{ $pengaduan->judul }}
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">Prioritas</label>
                            <select name="prioritas" class="form-select">
                                <option value="Rendah" {{ $pengaduan->prioritas == 'Rendah' ? 'selected' : '' }}>Rendah</option>
                                <option value="Sedang" {{ $pengaduan->prioritas == 'Sedang' ? 'selected' : '' }}>Sedang</option>
                                <option value="Tinggi" {{ $pengaduan->prioritas == 'Tinggi' ? 'selected' : '' }}>Tinggi</option>
                                <option value="Mendesak" {{ $pengaduan->prioritas == 'Mendesak' ? 'selected' : '' }}>Mendesak</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Tanggapan <span class="text-danger">*</span></label>
                            <textarea name="tanggapan_admin" class="form-control @error('tanggapan_admin') is-invalid @enderror" rows="4" required
                                      placeholder="Berikan tanggapan...">{{ old('tanggapan_admin', $pengaduan->tanggapan_admin) }}</textarea>
                            @error('tanggapan_admin')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">
                            <i class="ti ti-send me-1"></i> Kirim Tanggapan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @endif

    <!-- Selesai Modal -->
    @if($pengaduan->status == 'Diproses')
    <div class="modal fade" id="selesaiModal" tabindex="-1">
        <div class="modal-dialog">
            <form action="{{ route('admin.pengaduan.selesai', $pengaduan->id) }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Selesaikan Pengaduan</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <p>Apakah Anda yakin masalah ini sudah diselesaikan?</p>
                        <div class="alert alert-success">
                            <strong>{{ $pengaduan->nomor_pengaduan }}</strong><br>
                            {{ $pengaduan->judul }}
                        </div>
                        <div class="form-group">
                            <label class="form-label">Laporan Penyelesaian <span class="text-danger">*</span></label>
                            <textarea name="tanggapan_admin" class="form-control @error('tanggapan_admin') is-invalid @enderror" rows="4" required
                                      placeholder="Jelaskan hasil penyelesaian pengaduan...">{{ old('tanggapan_admin') }}</textarea>
                            @error('tanggapan_admin')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-check me-1"></i> Ya, Selesaikan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @endif

    <!-- Tolak Modal -->
    @if(in_array($pengaduan->status, ['Menunggu', 'Diproses']))
    <div class="modal fade" id="tolakModal" tabindex="-1">
        <div class="modal-dialog">
            <form action="{{ route('admin.pengaduan.tolak', $pengaduan->id) }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title">Tolak Pengaduan</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <p>Apakah Anda yakin ingin menolak pengaduan ini?</p>
                        <div class="alert alert-warning">
                            <strong>{{ $pengaduan->nomor_pengaduan }}</strong><br>
                            {{ $pengaduan->judul }}
                        </div>
                        <div class="form-group">
                            <label class="form-label">Alasan Penolakan <span class="text-danger">*</span></label>
                            <textarea name="tanggapan_admin" class="form-control @error('tanggapan_admin') is-invalid @enderror" 
                                      rows="4" required placeholder="Jelaskan alasan penolakan...">{{ old('tanggapan_admin') }}</textarea>
                            @error('tanggapan_admin')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">
                            <i class="ti ti-x me-1"></i> Ya, Tolak
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @endif
@endsection

@section('scripts_content')
<!-- Foto Modals -->
@if($pengaduan->foto_1 && $pengaduan->foto_1_url)
<div class="modal fade" id="fotoModal1" tabindex="-1">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content bg-dark">
            <div class="modal-header bg-dark border-secondary">
                <h5 class="modal-title text-white">Foto 1 - {{ $pengaduan->nomor_pengaduan }}</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body d-flex align-items-center justify-content-center bg-dark p-0">
                <img src="{{ $pengaduan->foto_1_url }}"
                     alt="Foto 1"
                     class="img-fluid"
                     style="max-height: 85vh; max-width: 100%; object-fit: contain;">
            </div>
            <div class="modal-footer bg-dark border-secondary">
                <a href="{{ $pengaduan->foto_1_url }}" 
                   download="pengaduan-{{ $pengaduan->nomor_pengaduan }}-foto-1"
                   class="btn btn-success">
                    <i class="ti ti-download me-1"></i> Download
                </a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endif

@if($pengaduan->foto_2 && $pengaduan->foto_2_url)
<div class="modal fade" id="fotoModal2" tabindex="-1">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content bg-dark">
            <div class="modal-header bg-dark border-secondary">
                <h5 class="modal-title text-white">Foto 2 - {{ $pengaduan->nomor_pengaduan }}</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body d-flex align-items-center justify-content-center bg-dark p-0">
                <img src="{{ $pengaduan->foto_2_url }}"
                     alt="Foto 2"
                     class="img-fluid"
                     style="max-height: 85vh; max-width: 100%; object-fit: contain;">
            </div>
            <div class="modal-footer bg-dark border-secondary">
                <a href="{{ $pengaduan->foto_2_url }}" 
                   download="pengaduan-{{ $pengaduan->nomor_pengaduan }}-foto-2"
                   class="btn btn-success">
                    <i class="ti ti-download me-1"></i> Download
                </a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endif

@if($pengaduan->foto_3 && $pengaduan->foto_3_url)
<div class="modal fade" id="fotoModal3" tabindex="-1">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content bg-dark">
            <div class="modal-header bg-dark border-secondary">
                <h5 class="modal-title text-white">Foto 3 - {{ $pengaduan->nomor_pengaduan }}</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body d-flex align-items-center justify-content-center bg-dark p-0">
                <img src="{{ $pengaduan->foto_3_url }}"
                     alt="Foto 3"
                     class="img-fluid"
                     style="max-height: 85vh; max-width: 100%; object-fit: contain;">
            </div>
            <div class="modal-footer bg-dark border-secondary">
                <a href="{{ $pengaduan->foto_3_url }}" 
                   download="pengaduan-{{ $pengaduan->nomor_pengaduan }}-foto-3"
                   class="btn btn-success">
                    <i class="ti ti-download me-1"></i> Download
                </a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endif

<script>
    // Auto-hide alerts
    setTimeout(function() {
        if (typeof bootstrap === 'undefined') return;
        const alerts = document.querySelectorAll('.alert-dismissible');
        alerts.forEach(alert => {
            try {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            } catch (e) {
                // fail silently
            }
        });
    }, 5000);
</script>
@endsection
