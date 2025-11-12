<div class="row">
    <!-- Welcome Card -->
    <div class="col-12">
        <div class="card bg-gradient" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <div class="card-body text-white">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h2 class="text-white mb-2">
                            <i class="ti ti-hand-rock me-2"></i>Selamat Datang, {{ Auth::user()->name }}!
                        </h2>
                        <p class="text-white-50 mb-3 lead">
                            Ini adalah dashboard Anda untuk mengelola pengajuan surat dan pengaduan.
                        </p>

                        @if (!Auth::user()->is_verified)
                        <div class="alert alert-warning mb-0">
                            <div class="d-flex align-items-center">
                                <i class="ti ti-alert-triangle fs-4 me-2"></i>
                                <div class="flex-grow-1">
                                    <strong>Email belum diverifikasi!</strong>
                                    <p class="mb-0">Verifikasi email untuk mengakses semua fitur.</p>
                                </div>
                                <a href="{{ route('verify.form') }}" class="btn btn-warning btn-sm ms-2">
                                    Verifikasi Sekarang
                                </a>
                            </div>
                        </div>
                        @else
                        <a href="{{ route('pengajuan.create') }}" class="btn btn-light me-2">
                            <i class="ti ti-plus me-1"></i> Ajukan Surat Baru
                        </a>
                        <a href="{{ route('pengaduan.create') }}" class="btn btn-outline-light">
                            <i class="ti ti-message-circle me-1"></i> Buat Pengaduan
                        </a>
                        @endif
                    </div>
                    <div class="col-md-4 text-center d-none d-md-block">
                        <i class="ti ti-home-2 opacity-25" style="font-size: 10rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="col-md-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="avtar avtar-l bg-light-warning">
                            <i class="ti ti-clock f-24 text-warning"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="mb-0 text-muted">Pengajuan Menunggu</h6>
                        <h3 class="mb-0">
                            {{ Auth::user()->pengajuanSurat()->where('status', 'Menunggu')->count() }}
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="avtar avtar-l bg-light-info">
                            <i class="ti ti-refresh f-24 text-info"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="mb-0 text-muted">Sedang Diproses</h6>
                        <h3 class="mb-0">
                            {{ Auth::user()->pengajuanSurat()->where('status', 'Diproses')->count() }}
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="avtar avtar-l bg-light-success">
                            <i class="ti ti-check f-24 text-success"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="mb-0 text-muted">Selesai</h6>
                        <h3 class="mb-0">
                            {{ Auth::user()->pengajuanSurat()->where('status', 'Selesai')->count() }}
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="avtar avtar-l bg-light-primary">
                            <i class="ti ti-file-text f-24 text-primary"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="mb-0 text-muted">Total Pengajuan</h6>
                        <h3 class="mb-0">
                            {{ Auth::user()->pengajuanSurat()->count() }}
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pengajuan Surat Saya -->
    <div class="col-md-12 col-xl-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5><i class="ti ti-file-text me-2"></i>Riwayat Pengajuan Surat</h5>
                <a href="{{ route('pengajuan.index') }}" class="btn btn-sm btn-primary">
                    Lihat Semua <i class="ti ti-arrow-right ms-1"></i>
                </a>
            </div>
            <div class="card-body">
                @if(Auth::user()->is_verified)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Nomor</th>
                                    <th>Jenis Surat</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse(Auth::user()->pengajuanSurat()->latest()->take(5)->get() as $pengajuan)
                                <tr>
                                    <td>
                                        <strong>{{ $pengajuan->nomor_pengajuan }}</strong><br>
                                        <small class="text-muted">{{ $pengajuan->created_at->format('H:i') }}</small>
                                    </td>
                                    <td>
                                        <i class="{{ $pengajuan->jenis_surat_icon }} me-1 text-primary"></i>
                                        {{ Str::limit($pengajuan->jenis_surat, 25) }}
                                    </td>
                                    <td>{{ $pengajuan->created_at->format('d M Y') }}</td>
                                    <td>
                                        <span class="badge {{ $pengajuan->status_badge }}">
                                            {{ $pengajuan->status }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('pengajuan.show', $pengajuan->id) }}"
                                           class="btn btn-sm btn-info">
                                            <i class="ti ti-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">
                                        <i class="ti ti-inbox f-36 text-muted"></i>
                                        <p class="text-muted mb-2">Belum ada pengajuan surat</p>
                                        <a href="{{ route('pengajuan.create') }}" class="btn btn-sm btn-primary">
                                            <i class="ti ti-plus me-1"></i> Ajukan Surat Pertama
                                        </a>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="ti ti-alert-triangle f-48 text-warning mb-3"></i>
                        <h5>Email Belum Diverifikasi</h5>
                        <p class="text-muted mb-3">Silakan verifikasi email Anda untuk mengajukan surat</p>
                        <a href="{{ route('verify.form') }}" class="btn btn-warning">
                            <i class="ti ti-shield-check me-1"></i> Verifikasi Email
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Riwayat Pengaduan & Charts -->
    <div class="col-md-12 col-xl-4">
        <!-- Status Progress -->
        <div class="card">
            <div class="card-header">
                <h5><i class="ti ti-chart-donut me-2"></i>Status Pengajuan</h5>
            </div>
            <div class="card-body">
                @php
                    $userStatuses = [
                        'Menunggu' => Auth::user()->pengajuanSurat()->where('status', 'Menunggu')->count(),
                        'Diproses' => Auth::user()->pengajuanSurat()->where('status', 'Diproses')->count(),
                        'Disetujui' => Auth::user()->pengajuanSurat()->where('status', 'Disetujui')->count(),
                        'Ditolak' => Auth::user()->pengajuanSurat()->where('status', 'Ditolak')->count(),
                        'Selesai' => Auth::user()->pengajuanSurat()->where('status', 'Selesai')->count(),
                    ];
                    $userTotal = array_sum($userStatuses);
                @endphp

                @if($userTotal > 0)
                    @foreach($userStatuses as $status => $count)
                    @if($count > 0)
                    <div class="mb-3">
                        <div class="d-flex align-items-center justify-content-between mb-1">
                            <span>{{ $status }}</span>
                            <span class="fw-bold">{{ $count }}</span>
                        </div>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar
                                @if($status == 'Menunggu') bg-warning
                                @elseif($status == 'Diproses') bg-info
                                @elseif($status == 'Disetujui') bg-success
                                @elseif($status == 'Ditolak') bg-danger
                                @else bg-primary
                                @endif"
                                style="width: {{ ($count / $userTotal * 100) }}%;">
                            </div>
                        </div>
                    </div>
                    @endif
                    @endforeach
                @else
                    <div class="text-center text-muted py-3">
                        <i class="ti ti-inbox f-36 mb-2"></i>
                        <p class="mb-0">Belum ada data</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Panduan Cepat -->
        <div class="card">
            <div class="card-header">
                <h5><i class="ti ti-help me-2"></i>Panduan Cepat</h5>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    <a href="{{ route('pengajuan.create') }}" class="list-group-item list-group-item-action px-0">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="avtar avtar-s bg-light-primary">
                                    <i class="ti ti-plus text-primary"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-0">Ajukan Surat Baru</h6>
                                <small class="text-muted">Buat pengajuan surat desa</small>
                            </div>
                            <i class="ti ti-chevron-right"></i>
                        </div>
                    </a>
                    <a href="{{ route('pengajuan.index') }}" class="list-group-item list-group-item-action px-0">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="avtar avtar-s bg-light-info">
                                    <i class="ti ti-file-text text-info"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-0">Lihat Pengajuan Saya</h6>
                                <small class="text-muted">Tracking status pengajuan</small>
                            </div>
                            <i class="ti ti-chevron-right"></i>
                        </div>
                    </a>
                    <a href="{{ route('pengaduan.index') }}" class="list-group-item list-group-item-action px-0">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="avtar avtar-s bg-light-warning">
                                    <i class="ti ti-message-circle text-warning"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-0">Pengaduan Saya</h6>
                                <small class="text-muted">Lapor masalah desa</small>
                            </div>
                            <i class="ti ti-chevron-right"></i>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Riwayat Pengaduan -->
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5><i class="ti ti-message-circle me-2"></i>Riwayat Pengaduan</h5>
                <a href="{{ route('pengaduan.index') }}" class="btn btn-sm btn-primary">
                    Lihat Semua <i class="ti ti-arrow-right ms-1"></i>
                </a>
            </div>
            <div class="card-body">
                <div class="row">
                    @forelse(Auth::user()->pengaduans()->latest()->take(4)->get() as $pengaduan)
                    <div class="col-md-6 col-lg-3">
                        <div class="card bg-light-{{ $pengaduan->status == 'Selesai' ? 'success' : ($pengaduan->status == 'Ditolak' ? 'danger' : 'warning') }} mb-md-0">
                            <div class="card-body">
                                <div class="d-flex align-items-start">
                                    <div class="flex-shrink-0">
                                        <div class="avtar avtar-s bg-{{ $pengaduan->status == 'Selesai' ? 'success' : ($pengaduan->status == 'Ditolak' ? 'danger' : 'warning') }}">
                                            <i class="ti ti-{{ $pengaduan->status == 'Selesai' ? 'check' : ($pengaduan->status == 'Ditolak' ? 'x' : 'clock') }}"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="text-{{ $pengaduan->status == 'Selesai' ? 'success' : ($pengaduan->status == 'Ditolak' ? 'danger' : 'warning') }}">
                                            {{ Str::limit($pengaduan->judul, 30) }}
                                        </h6>
                                        <p class="mb-0 small">
                                            <span class="badge {{ $pengaduan->status_badge }}">{{ $pengaduan->status }}</span><br>
                                            <i class="ti ti-clock"></i> {{ $pengaduan->created_at->diffForHumans() }}
                                        </p>
                                        <a href="{{ route('pengaduan.show', $pengaduan->id) }}" class="btn btn-sm btn-outline-{{ $pengaduan->status == 'Selesai' ? 'success' : ($pengaduan->status == 'Ditolak' ? 'danger' : 'warning') }} mt-2">
                                            Lihat Detail
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12 text-center py-4">
                        <i class="ti ti-inbox f-36 text-muted"></i>
                        <p class="text-muted mb-2">Belum ada pengaduan</p>
                        <a href="{{ route('pengaduan.create') }}" class="btn btn-sm btn-primary">
                            <i class="ti ti-plus me-1"></i> Buat Pengaduan
                        </a>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Info Penting -->
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5><i class="ti ti-info-circle me-2"></i>Informasi Penting</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card bg-light-primary mb-md-0">
                            <div class="card-body">
                                <div class="d-flex align-items-start">
                                    <div class="flex-shrink-0">
                                        <div class="avtar avtar-s bg-primary">
                                            <i class="ti ti-clock"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="text-primary">Waktu Proses</h6>
                                        <p class="mb-0 small">Pengajuan surat diproses maksimal 3-5 hari kerja</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-light-success mb-md-0">
                            <div class="card-body">
                                <div class="d-flex align-items-start">
                                    <div class="flex-shrink-0">
                                        <div class="avtar avtar-s bg-success">
                                            <i class="ti ti-file-check"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="text-success">Dokumen Lengkap</h6>
                                        <p class="mb-0 small">Pastikan KTP, KK, dan dokumen pendukung valid</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-light-warning mb-0">
                            <div class="card-body">
                                <div class="d-flex align-items-start">
                                    <div class="flex-shrink-0">
                                        <div class="avtar avtar-s bg-warning">
                                            <i class="ti ti-bell"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="text-warning">Notifikasi</h6>
                                        <p class="mb-0 small">Cek email untuk update status pengajuan Anda</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
