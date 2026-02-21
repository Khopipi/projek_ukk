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
                            <li class="breadcrumb-item"><a href="{{ route('pengaduan.index') }}">Pengaduan</a></li>
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
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="card">
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('pengaduan.index') }}" class="btn btn-secondary">
                                <i class="ti ti-arrow-left me-1"></i> Kembali
                            </a>

                            @if(in_array($pengaduan->status, ['Menunggu', 'Ditolak']))
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                <i class="ti ti-trash me-1"></i> Hapus Pengaduan
                            </button>
                            @endif
                        </div>
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

                <!-- Tanggapan dari Admin -->
                @if($pengaduan->tanggapan_admin)
                <div class="card" style="border: 1px solid #43e97b; border-left: 4px solid #43e97b; box-shadow: 0 2px 8px rgba(67, 233, 123, 0.1);">
                    <div class="card-header" style="background: linear-gradient(135deg, rgba(67, 233, 123, 0.1) 0%, rgba(56, 249, 215, 0.1) 100%); border-bottom: 1px solid rgba(67, 233, 123, 0.2);">
                        <div class="d-flex align-items-center justify-content-between">
                            <h5 class="mb-0" style="color: #43e97b;">
                                <i class="ti ti-message-circle me-2"></i>Tanggapan dari Admin
                            </h5>
                            <span class="badge" style="background: #43e97b; color: white;">
                                <i class="ti ti-check me-1"></i> Sudah Ditanggapi
                            </span>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Info Admin -->
                        @if($pengaduan->admin)
                        <div class="d-flex align-items-center mb-4 pb-3" style="border-bottom: 1px solid #eef2f9;">
                            <div class="flex-shrink-0">
                                <div class="avtar avtar-sm bg-light-success" style="width: 40px; height: 40px;">
                                    <i class="ti ti-user-check text-success" style="font-size: 20px;"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-0" style="color: #2d3748;">{{ $pengaduan->admin->name }}</h6>
                                <small class="text-muted">
                                    <i class="ti ti-calendar-event me-1"></i>
                                    {{ $pengaduan->tanggal_ditanggapi->format('d F Y, H:i') }}
                                </small>
                            </div>
                        </div>
                        @endif

                        <!-- Isi Tanggapan -->
                        <div class="mb-4">
                            <p class="mb-0" style="white-space: pre-line; color: #2d3748; line-height: 1.8;">{{ $pengaduan->tanggapan_admin }}</p>
                        </div>

                        <!-- Info Prioritas -->
                        @if($pengaduan->prioritas)
                        <div class="mt-4 pt-3" style="border-top: 1px solid #eef2f9;">
                            <div class="row">
                                <div class="col-md-6">
                                    <small class="text-muted d-block mb-2"><strong>Prioritas Penanganan:</strong></small>
                                    @php
                                        $priorityColor = match($pengaduan->prioritas) {
                                            'Rendah' => '#28a745',
                                            'Sedang' => '#ffc107',
                                            'Tinggi' => '#dc3545',
                                            'Mendesak' => '#dc3545',
                                            default => '#6c757d'
                                        };
                                        $priorityIcon = match($pengaduan->prioritas) {
                                            'Rendah' => 'ti-alert-circle',
                                            'Sedang' => 'ti-alert-triangle',
                                            'Tinggi' => 'ti-alert',
                                            'Mendesak' => 'ti-alert',
                                            default => 'ti-info-circle'
                                        };
                                    @endphp
                                    <span class="badge" style="background: {{ $priorityColor }}; color: white; padding: 6px 12px; font-weight: 700;">
                                        <i class="ti {{ $priorityIcon }} me-1"></i>
                                        {{ $pengaduan->prioritas }}
                                    </span>
                                </div>
                                <div class="col-md-6">
                                    <small class="text-muted d-block mb-2"><strong>Status Saat Ini:</strong></small>
                                    <span class="badge {{ $pengaduan->status_badge }}" style="padding: 6px 12px; font-weight: 700;">
                                        {{ $pengaduan->status }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                @else
                <!-- Card Menunggu Tanggapan -->
                @if(in_array($pengaduan->status, ['Menunggu', 'Diproses']))
                <div class="card" style="border: 1px solid #ffc107; border-left: 4px solid #ffc107; box-shadow: 0 2px 8px rgba(255, 193, 7, 0.1);">
                    <div class="card-header" style="background: linear-gradient(135deg, rgba(255, 193, 7, 0.1) 0%, rgba(255, 179, 0, 0.1) 100%); border-bottom: 1px solid rgba(255, 193, 7, 0.2);">
                        <h5 class="mb-0" style="color: #ff9500;">
                            <i class="ti ti-hourglass-empty me-2"></i>Menunggu Tanggapan Admin
                        </h5>
                    </div>
                    <div class="card-body text-center py-4">
                        <i class="ti ti-clock" style="font-size: 48px; color: #ffc107; opacity: 0.5;"></i>
                        <p class="mt-3 mb-0 text-muted">
                            Pengaduan Anda sedang diproses oleh admin. Kami akan segera memberikan tanggapan.
                        </p>
                    </div>
                </div>
                @endif
                @endif

                <!-- Foto-foto -->
                @if($pengaduan->foto_1 || $pengaduan->foto_2 || $pengaduan->foto_3)
                <div class="card">
                    <div class="card-header">
                        <h5><i class="ti ti-photo me-2"></i>Foto Lampiran</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @if($pengaduan->foto_1)
                            <div class="col-md-4 mb-3">
                                <a href="{{ $pengaduan->foto_1_url }}" target="_blank">
                                    <img src="{{ $pengaduan->foto_1_url }}"
                                         alt="Foto 1"
                                         class="img-fluid rounded border"
                                         style="max-height: 200px; width: 100%; object-fit: cover;">
                                </a>
                                <div class="text-center mt-2">
                                    <a href="{{ $pengaduan->foto_1_url }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="ti ti-eye me-1"></i> Lihat Full
                                    </a>
                                </div>
                            </div>
                            @endif

                            @if($pengaduan->foto_2)
                            <div class="col-md-4 mb-3">
                                <a href="{{ $pengaduan->foto_2_url }}" target="_blank">
                                    <img src="{{ $pengaduan->foto_2_url }}"
                                         alt="Foto 2"
                                         class="img-fluid rounded border"
                                         style="max-height: 200px; width: 100%; object-fit: cover;">
                                </a>
                                <div class="text-center mt-2">
                                    <a href="{{ $pengaduan->foto_2_url }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="ti ti-eye me-1"></i> Lihat Full
                                    </a>
                                </div>
                            </div>
                            @endif

                            @if($pengaduan->foto_3)
                            <div class="col-md-4 mb-3">
                                <a href="{{ $pengaduan->foto_3_url }}" target="_blank">
                                    <img src="{{ $pengaduan->foto_3_url }}"
                                         alt="Foto 3"
                                         class="img-fluid rounded border"
                                         style="max-height: 200px; width: 100%; object-fit: cover;">
                                </a>
                                <div class="text-center mt-2">
                                    <a href="{{ $pengaduan->foto_3_url }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="ti ti-eye me-1"></i> Lihat Full
                                    </a>
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
                            <!-- User Mengirim -->
                            <li class="list-group-item px-0">
                                <div class="d-flex align-items-start">
                                    <div class="flex-shrink-0">
                                        <div class="avtar avtar-s bg-light-primary">
                                            <i class="ti ti-send text-primary"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-0">Pengaduan Dikirim</h6>
                                        <small class="text-muted">{{ $pengaduan->created_at->format('d F Y, H:i') }}</small>
                                    </div>
                                </div>
                            </li>

                            <!-- Ditanggapi Admin -->
                            @if($pengaduan->tanggal_ditanggapi)
                            <li class="list-group-item px-0">
                                <div class="d-flex align-items-start">
                                    <div class="flex-shrink-0">
                                        <div class="avtar avtar-s bg-light-success">
                                            <i class="ti ti-message-circle text-success"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-0">Ditanggapi Admin</h6>
                                        <small class="text-muted">{{ $pengaduan->tanggal_ditanggapi->format('d F Y, H:i') }}</small>
                                        @if($pengaduan->admin)
                                        <br><small class="text-muted">Oleh: <strong>{{ $pengaduan->admin->name }}</strong></small>
                                        @endif
                                    </div>
                                </div>
                            </li>
                            @else
                            <li class="list-group-item px-0">
                                <div class="d-flex align-items-start">
                                    <div class="flex-shrink-0">
                                        <div class="avtar avtar-s bg-light-warning">
                                            <i class="ti ti-hourglass text-warning"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-0">Menunggu Tanggapan</h6>
                                        <small class="text-muted"><em>Pengaduan sedang diproses...</em></small>
                                    </div>
                                </div>
                            </li>
                            @endif

                            <!-- Pengaduan Selesai -->
                            @if($pengaduan->tanggal_selesai)
                            <li class="list-group-item px-0">
                                <div class="d-flex align-items-start">
                                    <div class="flex-shrink-0">
                                        <div class="avtar avtar-s bg-light-success">
                                            <i class="ti ti-circle-check text-success"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-0">Pengaduan Selesai</h6>
                                        <small class="text-muted">{{ $pengaduan->tanggal_selesai->format('d F Y, H:i') }}</small>
                                    </div>
                                </div>
                            </li>
                            @else
                            @if($pengaduan->status === 'Diproses')
                            <li class="list-group-item px-0">
                                <div class="d-flex align-items-start">
                                    <div class="flex-shrink-0">
                                        <div class="avtar avtar-s bg-light-info">
                                            <i class="ti ti-refresh text-info"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-0">Sedang Diproses</h6>
                                        <small class="text-muted"><em>Admin sedang menangani pengaduan Anda...</em></small>
                                    </div>
                                </div>
                            </li>
                            @endif
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    @if(in_array($pengaduan->status, ['Menunggu', 'Ditolak']))
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus pengaduan ini?</p>
                    <div class="alert alert-warning">
                        <strong>{{ $pengaduan->nomor_pengaduan }}</strong><br>
                        {{ $pengaduan->judul }}
                    </div>
                    <p class="text-danger mb-0">
                        <i class="ti ti-alert-triangle me-1"></i>
                        Data yang sudah dihapus tidak dapat dikembalikan!
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form action="{{ route('pengaduan.destroy', $pengaduan->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="ti ti-trash me-1"></i> Ya, Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif
@endsection
