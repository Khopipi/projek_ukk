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
                                @php
                                    $bgClass = match($pengaduan->prioritas) {
                                        'Rendah' => 'bg-success',
                                        'Sedang' => 'bg-warning',
                                        'Tinggi', 'Mendesak' => 'bg-danger',
                                        default => 'bg-secondary'
                                    };
                                    $textColor = in_array($pengaduan->prioritas, ['Sedang']) ? 'color: #333;' : '';
                                @endphp
                                <span class="badge {{ $bgClass }} p-2" style="font-size: 0.9rem; width: 100%; display: inline-block; {{ $textColor }}">
                                    @if($pengaduan->prioritas == 'Rendah')
                                        <i class="ti ti-alert-circle me-1"></i>
                                    @elseif($pengaduan->prioritas == 'Sedang')
                                        <i class="ti ti-alert-triangle me-1"></i>
                                    @else
                                        <i class="ti ti-alert me-1"></i>
                                    @endif
                                    Prioritas: {{ $pengaduan->prioritas_label }}
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
                                <button type="submit" class="btn btn-warning w-100">
                                    <i class="ti ti-refresh me-1"></i> Tandai Diproses
                                </button>
                            </form>
                            @endif

                            @if(in_array($pengaduan->status, ['Menunggu', 'Diproses']))
                            <form action="{{ route('admin.pengaduan.tanggapi', $pengaduan->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="tanggapan_admin" value="Pengaduan ditanggapi">
                                <input type="hidden" name="prioritas" value="{{ $pengaduan->prioritas }}">
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="ti ti-message-circle me-1"></i> Beri Tanggapan
                                </button>
                            </form>
                            @endif

                            @if($pengaduan->status == 'Diproses')
                            <form action="{{ route('admin.pengaduan.selesai', $pengaduan->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="tanggapan_admin" value="Pengaduan diselesaikan">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="ti ti-check me-1"></i> Selesaikan Pengaduan
                                </button>
                            </form>
                            @endif

                            @if(in_array($pengaduan->status, ['Menunggu', 'Diproses']))
                            <form action="{{ route('admin.pengaduan.tolak', $pengaduan->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="tanggapan_admin" value="Pengaduan ditolak">
                                <button type="submit" class="btn btn-danger w-100">
                                    <i class="ti ti-x me-1"></i> Tolak Pengaduan
                                </button>
                            </form>
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
                            @if($pengaduan->foto_1)
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
                                    <a href="{{ route('pengaduan.download', $pengaduan->foto_1) }}"
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

                            @if($pengaduan->foto_2)
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
                                    <a href="{{ route('pengaduan.download', $pengaduan->foto_2) }}"
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

                            @if($pengaduan->foto_3)
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
                                    <a href="{{ route('pengaduan.download', $pengaduan->foto_3) }}"
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
                <a href="{{ route('pengaduan.download', $pengaduan->foto_1) }}"
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
                <a href="{{ route('pengaduan.download', $pengaduan->foto_2) }}"
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
                <a href="{{ route('pengaduan.download', $pengaduan->foto_3) }}"
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
    // Create beautiful modern popup
    function showCustomToast(message, icon = '✓') {
        const existing = document.getElementById('custom-toast-popup');
        if (existing) existing.remove();
        
        const popup = document.createElement('div');
        popup.id = 'custom-toast-popup';
        
        let bgColor = '#3b82f6';
        if (message.includes('Disetujui') || message.includes('Diselesaikan')) bgColor = '#10b981';
        else if (message.includes('Ditolak')) bgColor = '#ef4444';
        else if (message.includes('Dihapus')) bgColor = '#f59e0b';
        
        popup.style.cssText = `
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 40px 50px;
            border-radius: 15px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            z-index: 99999;
            text-align: center;
            min-width: 350px;
            animation: popupIn 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
        `;
        
        popup.innerHTML = `
            <div style="font-size: 60px; margin-bottom: 20px; animation: bounce 0.6s ease-out;">${icon}</div>
            <h3 style="color: #2d3748; font-size: 22px; font-weight: 700; margin: 0 0 30px 0;">${message}</h3>
            <div style="width: 50px; height: 5px; background: linear-gradient(90deg, ${bgColor} 0%, ${bgColor} 100%); margin: 0 auto; border-radius: 3px;"></div>
        `;
        
        document.body.appendChild(popup);
        
        // Add animations if not exists
        let styleSheet = document.getElementById('toast-animations');
        if (!styleSheet) {
            styleSheet = document.createElement('style');
            styleSheet.id = 'toast-animations';
            styleSheet.textContent = `
                @keyframes popupIn {
                    0% {
                        opacity: 0;
                        transform: translate(-50%, -50%) scale(0.3);
                    }
                    100% {
                        opacity: 1;
                        transform: translate(-50%, -50%) scale(1);
                    }
                }
                @keyframes bounce {
                    0%, 100% { transform: scale(1); }
                    50% { transform: scale(1.2); }
                }
                @keyframes popupOut {
                    0% {
                        opacity: 1;
                        transform: translate(-50%, -50%) scale(1);
                    }
                    100% {
                        opacity: 0;
                        transform: translate(-50%, -50%) scale(0.3);
                    }
                }
            `;
            document.head.appendChild(styleSheet);
        }
        
        // Auto remove
        setTimeout(() => {
            popup.style.animation = 'popupOut 0.4s cubic-bezier(0.34, 1.56, 0.64, 1)';
            setTimeout(() => popup.remove(), 400);
        }, 2500);
    }

    document.addEventListener('DOMContentLoaded', function() {
        const forms = document.querySelectorAll('form');
        
        forms.forEach(form => {
            form.addEventListener('submit', function(e) {
                if (this.dataset.submitted === 'true') {
                    e.preventDefault();
                    return;
                }
                
                this.dataset.submitted = 'true';
                
                const submitBtn = document.activeElement;
                let message = 'Memproses Data...';
                let icon = '⏳';
                
                if (submitBtn && submitBtn.type === 'submit') {
                    const btnText = submitBtn.textContent.trim();
                    if (btnText.includes('Setuju')) {
                        message = '✓ Pengajuan Disetujui!';
                        icon = '✓';
                    } else if (btnText.includes('Tolak')) {
                        message = '✗ Pengajuan Ditolak!';
                        icon = '✗';
                    } else if (btnText.includes('Tanggapi')) {
                        message = '📝 Tanggapan Diproses...';
                        icon = '📝';
                    } else if (btnText.includes('Selesai')) {
                        message = '✓ Pengaduan Diselesaikan!';
                        icon = '✓';
                    } else if (btnText.includes('Hapus')) {
                        message = '🗑️ Data Dihapus!';
                        icon = '🗑️';
                    }
                }
                
                showCustomToast(message, icon);
                
                const buttons = this.querySelectorAll('button[type="submit"]');
                buttons.forEach(btn => btn.disabled = true);
            });
        });
    });

    // Auto-hide alerts
    setTimeout(function() {
        if (typeof bootstrap === 'undefined') return;
        const alerts = document.querySelectorAll('.alert-dismissible');
        alerts.forEach(alert => {
            try {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            } catch (e) {}
        });
    }, 5000);
</script>
</script>
@endsection
