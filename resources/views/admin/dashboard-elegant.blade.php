<style>
    /* Prevent horizontal scrollbar */
    body, html {
        overflow-x: hidden;
        max-width: 100%;
    }

    .pc-container {
        overflow-x: hidden !important;
    }

    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --danger-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        --info-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        --success-gradient: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        --warning-gradient: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        --secondary-gradient: linear-gradient(135deg, #30cfd0 0%, #330867 100%);
    }

    .stat-card {
        border: none;
        border-radius: 14px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        overflow: hidden;
        position: relative;
        height: 100%;
    }
    
    .stat-card:hover {
        transform: translateY(-12px) scale(1.02);
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.18);
    }
    
    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 5px;
        background: rgba(255, 255, 255, 0.3);
    }
    
    .stat-card-icon {
        width: 80px;
        height: 80px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 36px;
        background: rgba(255, 255, 255, 0.18);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
    }
    
    .stat-card-content h6 {
        font-size: 13px;
        font-weight: 600;
        letter-spacing: 0.6px;
        opacity: 1;
        margin-bottom: 10px;
        text-transform: uppercase;
        color: rgba(255, 255, 255, 0.95);
    }
    
    .stat-card-content h3 {
        font-size: 36px;
        font-weight: 800;
        margin: 0;
        text-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        color: #ffffff;
    }
    
    .stat-card-content small {
        font-size: 11px;
        opacity: 0.95;
        font-weight: 600;
        letter-spacing: 0.4px;
        color: rgba(255, 255, 255, 0.9);
    }

    .stat-card-1 { background: var(--primary-gradient); }
    .stat-card-2 { background: var(--danger-gradient); }
    .stat-card-3 { background: var(--info-gradient); }
    .stat-card-4 { background: var(--success-gradient); }
    .stat-card-5 { background: var(--warning-gradient); }
    .stat-card-6 { background: var(--secondary-gradient); }

    /* Action Cards */
    .action-card {
        border: none;
        border-radius: 14px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        background: linear-gradient(135deg, #f8fbff 0%, #ffffff 100%);
        text-decoration: none;
        color: inherit;
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 32px 20px;
        position: relative;
        overflow: hidden;
    }

    .action-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #667eea, #764ba2);
        transform: scaleX(0);
        transform-origin: left;
        transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .action-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 16px 40px rgba(0, 0, 0, 0.16);
    }

    .action-card:hover::before {
        transform: scaleX(1);
    }

    .action-card:nth-child(1)::before { background: var(--warning-gradient); }
    .action-card:nth-child(2)::before { background: var(--danger-gradient); }
    .action-card:nth-child(3)::before { background: var(--info-gradient); }
    .action-card:nth-child(4)::before { background: var(--success-gradient); }
    .action-card:nth-child(5)::before { background: var(--secondary-gradient); }

    .action-card-icon {
        font-size: 44px;
        margin-bottom: 14px;
        color: #667eea;
        transition: all 0.35s ease;
    }

    .action-card:nth-child(1) .action-card-icon { color: #fa709a; }
    .action-card:nth-child(2) .action-card-icon { color: #f093fb; }
    .action-card:nth-child(3) .action-card-icon { color: #4facfe; }
    .action-card:nth-child(4) .action-card-icon { color: #43e97b; }
    .action-card:nth-child(5) .action-card-icon { color: #30cfd0; }

    .action-card:hover .action-card-icon {
        transform: scale(1.2) rotate(-5deg);
    }

    .action-card span {
        font-size: 15px;
        font-weight: 700;
        text-align: center;
        margin-bottom: 8px;
        color: #1a202c;
    }

    .action-card small {
        font-size: 12px;
        color: #4a5568;
        font-weight: 600;
    }

    /* Elegant Card Styles */
    .elegant-card {
        border: none;
        border-radius: 14px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .elegant-card:hover {
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
    }

    .elegant-card .card-header {
        background: linear-gradient(135deg, #f8fbff 0%, #ffffff 100%);
        border-bottom: 2px solid #eef2f9;
        padding: 24px;
    }

    .elegant-card .card-header h5 {
        font-size: 17px;
        font-weight: 800;
        letter-spacing: 0.5px;
        color: #2d3748;
        margin: 0;
    }

    .elegant-card .table thead th {
        background: #f8fbff;
        border: none;
        color: #4a5568;
        font-weight: 700;
        font-size: 11px;
        letter-spacing: 0.6px;
        text-transform: uppercase;
        padding: 16px 18px;
    }

    .elegant-card .table tbody tr {
        border-bottom: 1px solid #eef2f9;
        transition: all 0.3s ease;
    }

    .elegant-card .table tbody tr:hover {
        background: #f8fbff;
        box-shadow: inset 0 0 0 1px rgba(0, 0, 0, 0.02);
    }

    .elegant-card .table tbody td {
        padding: 16px 18px;
        vertical-align: middle;
        color: #2d3748;
        font-weight: 500;
    }

    .elegant-btn {
        border-radius: 8px;
        padding: 8px 14px;
        font-size: 12px;
        font-weight: 700;
        border: none;
        transition: all 0.3s ease;
        color: white !important;
        text-decoration: none;
    }

    .elegant-btn-primary {
        background: var(--primary-gradient);
    }

    .elegant-btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 16px rgba(102, 126, 234, 0.3);
    }

    /* Progress Bar Style */
    .progress-elegant {
        height: 8px;
        border-radius: 10px;
        background: #eef2f9;
        overflow: hidden;
    }

    .progress-elegant .progress-bar {
        border-radius: 10px;
    }

    /* Badge Styles */
    .badge-custom {
        padding: 6px 12px;
        border-radius: 8px;
        font-weight: 700;
        font-size: 11px;
        letter-spacing: 0.4px;
    }

    /* Section Title */
    .section-title {
        font-size: 20px;
        font-weight: 800;
        letter-spacing: 0.6px;
        color: #2d3748;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
    }

    .section-title i {
        margin-right: 12px;
        width: 32px;
        height: 32px;
        background: var(--primary-gradient);
        color: white;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }

    /* Stat Info Box */
    .stat-info-box {
        text-align: center;
        padding: 20px;
        border-radius: 12px;
        background: linear-gradient(135deg, #f8fbff 0%, #ffffff 100%);
        border: 1px solid #eef2f9;
        transition: all 0.3s ease;
    }

    .stat-info-box:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
    }

    .stat-info-box h5 {
        font-size: 28px;
        font-weight: 800;
        margin-bottom: 8px;
        color: #2d3748;
    }

    .stat-info-box p {
        font-size: 12px;
        font-weight: 600;
        color: #718096;
        margin: 0;
    }

    /* List Group Styling */
    .list-group-item {
        background-color: #ffffff;
        color: #2d3748;
        border-color: #eef2f9;
    }

    .list-group-item span {
        color: #2d3748;
    }

    /* Dashboard Content Padding */
    .dashboard-wrapper {
        padding-left: 35px;
        padding-right: 35px;
        padding-top: 20px;
        padding-bottom: 40px;
    }

    /* Responsive adjustments */
    @media (max-width: 1400px) {
        .dashboard-wrapper {
            padding-left: 20px;
            padding-right: 20px;
        }
    }

    @media (max-width: 992px) {
        .dashboard-wrapper {
            padding-left: 15px;
            padding-right: 15px;
        }
    }
</style>

<div class="row dashboard-wrapper">
    <!-- KPI Cards - Statistics -->
    <div class="col-md-6 col-xl-3 mb-4">
        <div class="card stat-card stat-card-1 text-white h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="stat-card-icon">
                        <i class="ti ti-users"></i>
                    </div>
                    <div class="flex-grow-1 ms-4 stat-card-content">
                        <h6>Total Penduduk</h6>
                        <h3>{{ \App\Models\Penduduk::count() }}</h3>
                        <small>Jiwa</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3 mb-4">
        <div class="card stat-card stat-card-2 text-white h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="stat-card-icon">
                        <i class="ti ti-user-plus"></i>
                    </div>
                    <div class="flex-grow-1 ms-4 stat-card-content">
                        <h6>Penduduk di Input Manual</h6>
                        <h3>{{ \App\Models\Penduduk::whereNull('user_id')->count() }}</h3>
                        <small>Orang</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3 mb-4">
        <div class="card stat-card stat-card-3 text-white h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="stat-card-icon">
                        <i class="ti ti-death-icon"></i>
                    </div>
                    <div class="flex-grow-1 ms-4 stat-card-content">
                        <h6>Penduduk Meninggal</h6>
                        <h3>{{ \App\Models\Kematian::count() }}</h3>
                        <small>Orang</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3 mb-4">
        <div class="card stat-card stat-card-4 text-white h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="stat-card-icon">
                        <i class="ti ti-clock"></i>
                    </div>
                    <div class="flex-grow-1 ms-4 stat-card-content">
                        <h6>Pengajuan Menunggu</h6>
                        <h3>{{ \App\Models\PengajuanSurat::where('status', 'Menunggu')->count() }}</h3>
                        <small>Pengajuan</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3 mb-4">
        <div class="card stat-card stat-card-5 text-white h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="stat-card-icon">
                        <i class="ti ti-check"></i>
                    </div>
                    <div class="flex-grow-1 ms-4 stat-card-content">
                        <h6>Selesai (Bulan Ini)</h6>
                        <h3>{{ \App\Models\PengajuanSurat::where('status', 'Selesai')->whereMonth('tanggal_selesai', now()->month)->count() }}</h3>
                        <small>Surat</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3 mb-4">
        <div class="card stat-card stat-card-6 text-white h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="stat-card-icon">
                        <i class="ti ti-message-circle"></i>
                    </div>
                    <div class="flex-grow-1 ms-4 stat-card-content">
                        <h6>Pengaduan Aktif</h6>
                        <h3>{{ \App\Models\Pengaduan::whereIn('status', ['Menunggu', 'Diproses'])->count() }}</h3>
                        <small>Laporan</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="col-12 mb-4">
        <div class="section-title">
            <i class="ti ti-rocket"></i> Aksi Cepat
        </div>
        <div class="row g-3">
            <div class="col-md-3 col-sm-6">
                <a href="{{ route('admin.pengajuan.index') }}?status=Menunggu" class="action-card">
                    <i class="ti ti-clock action-card-icon"></i>
                    <span>Verifikasi Pengajuan</span>
                    <small>{{ \App\Models\PengajuanSurat::where('status', 'Menunggu')->count() }} menunggu</small>
                </a>
            </div>
            <div class="col-md-3 col-sm-6">
                <a href="{{ route('admin.pengaduan.index') }}?status=Menunggu" class="action-card">
                    <i class="ti ti-message-circle action-card-icon"></i>
                    <span>Tanggapi Pengaduan</span>
                    <small>{{ \App\Models\Pengaduan::where('status', 'Menunggu')->count() }} baru</small>
                </a>
            </div>
            <div class="col-md-3 col-sm-6">
                <a href="{{ route('penduduk.create') }}" class="action-card">
                    <i class="ti ti-user-plus action-card-icon"></i>
                    <span>Tambah Penduduk</span>
                    <small>Data baru</small>
                </a>
            </div>
            <div class="col-md-3 col-sm-6">
                <a href="{{ route('admin.pengajuan.index') }}?status=Disetujui" class="action-card">
                    <i class="ti ti-upload action-card-icon"></i>
                    <span>Upload Surat Hasil</span>
                    <small>{{ \App\Models\PengajuanSurat::where('status', 'Disetujui')->count() }} disetujui</small>
                </a>
            </div>
            <div class="col-md-3 col-sm-6">
                <a href="{{ route('admin.kematian.create') }}" class="action-card">
                    <i class="ti ti-death-icon action-card-icon"></i>
                    <span>Input Data Kematian</span>
                    <small>Total: {{ \App\Models\Kematian::count() }}</small>
                </a>
            </div>
        </div>
    </div>

    <!-- Pengajuan Terbaru & Statistik -->
    <div class="col-md-12 col-xl-8 mb-4">
        <div class="card elegant-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5><i class="ti ti-file-check me-2"></i>Pengajuan Surat Terbaru</h5>
                <a href="{{ route('admin.pengajuan.index') }}" class="elegant-btn elegant-btn-primary">
                    Lihat Semua <i class="ti ti-arrow-right ms-1"></i>
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Nomor</th>
                                <th>Pemohon</th>
                                <th>Jenis Surat</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse(\App\Models\PengajuanSurat::with('user')->latest()->take(5)->get() as $pengajuan)
                            <tr>
                                <td><strong>{{ $pengajuan->nomor_pengajuan }}</strong></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avtar avtar-xs bg-light-primary me-2">
                                            <i class="ti ti-user f-14"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">{{ $pengajuan->nama_pemohon }}</h6>
                                            <small class="text-muted">{{ $pengajuan->user->name }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ Str::limit($pengajuan->jenis_surat, 20) }}</td>
                                <td><small>{{ $pengajuan->created_at->format('d M Y') }}</small></td>
                                <td>
                                    <span class="badge {{ $pengajuan->status_badge }}">
                                        {{ $pengajuan->status }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.pengajuan.show', $pengajuan->id) }}"
                                       class="elegant-btn elegant-btn-primary">
                                        <i class="ti ti-eye"></i> Lihat
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <i class="ti ti-inbox f-36 text-muted"></i>
                                    <p class="text-muted mb-0">Belum ada pengajuan</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Statistik -->
    <div class="col-md-12 col-xl-4 mb-4">
        <div class="card elegant-card">
            <div class="card-header">
                <h5><i class="ti ti-chart-pie me-2"></i>Status Pengajuan</h5>
            </div>
            <div class="card-body">
                @php
                    $statuses = [
                        'Menunggu' => \App\Models\PengajuanSurat::where('status', 'Menunggu')->count(),
                        'Diproses' => \App\Models\PengajuanSurat::where('status', 'Diproses')->count(),
                        'Disetujui' => \App\Models\PengajuanSurat::where('status', 'Disetujui')->count(),
                        'Ditolak' => \App\Models\PengajuanSurat::where('status', 'Ditolak')->count(),
                        'Selesai' => \App\Models\PengajuanSurat::where('status', 'Selesai')->count(),
                    ];
                    $total = array_sum($statuses);
                @endphp

                @foreach($statuses as $status => $count)
                <div class="mb-4">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span style="font-weight: 600; color: #2d3748;">{{ $status }}</span>
                        <span class="badge badge-custom" style="background: var(--primary-gradient); color: white;">{{ $count }}</span>
                    </div>
                    <div class="progress-elegant">
                        <div class="progress-bar
                            @if($status == 'Menunggu') bg-warning
                            @elseif($status == 'Diproses') bg-info
                            @elseif($status == 'Disetujui') bg-success
                            @elseif($status == 'Ditolak') bg-danger
                            @else bg-primary
                            @endif"
                            style="width: {{ $total > 0 ? ($count / $total * 100) : 0 }}%;">
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Jenis Surat Populer -->
        <div class="card elegant-card">
            <div class="card-header">
                <h5><i class="ti ti-star me-2"></i>Jenis Surat Populer</h5>
            </div>
            <div class="card-body">
                @php color: #2d3748;">{{ Str::limit($surat->jenis_surat, 25) }}</span>
                        <span class="badge badge-custom" style="background: var(--info-gradient); color: white;">{{ $surat->total }}</span>
                    </li>
                    @empty
                    <li class="list-group-item text-center" style="color: #a0aec0;
                        ->get();
                @endphp

                <ul class="list-group list-group-flush">
                    @forelse($populerSurats as $surat)
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-3">
                        <span style="font-weight: 600;">{{ Str::limit($surat->jenis_surat, 25) }}</span>
                        <span class="badge badge-custom" style="background: var(--info-gradient); color: white;">{{ $surat->total }}</span>
                    </li>
                    @empty
                    <li class="list-group-item text-center text-muted">Belum ada data</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

    <!-- Pengaduan Terbaru -->
    <div class="col-12 mb-4">
        <div class="card elegant-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5><i class="ti ti-message-circle me-2"></i>Pengaduan Terbaru</h5>
                <a href="{{ route('admin.pengaduan.index') }}" class="elegant-btn elegant-btn-primary">
                    Lihat Semua <i class="ti ti-arrow-right ms-1"></i>
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Nomor</th>
                                <th>Pelapor</th>
                                <th>Kategori</th>
                                <th>Judul</th>
                                <th>Prioritas</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse(\App\Models\Pengaduan::with('user')->latest()->take(5)->get() as $pengaduan)
                            <tr>
                                <td><strong>{{ $pengaduan->nomor_pengaduan }}</strong></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avtar avtar-xs bg-light-danger me-2">
                                            <i class="ti ti-user f-14"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">{{ $pengaduan->user->name }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <i class="{{ $pengaduan->kategori_icon }} me-1"></i>
                                    {{ $pengaduan->kategori }}
                                </td>
                                <td>{{ Str::limit($pengaduan->judul, 30) }}</td>
                                <td>
                                    <span class="badge {{ $pengaduan->prioritas_badge }}">
                                        {{ $pengaduan->prioritas }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge {{ $pengaduan->status_badge }}">
                                        {{ $pengaduan->status }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.pengaduan.show', $pengaduan->id) }}"
                                       class="elegant-btn elegant-btn-primary">
                                        <i class="ti ti-eye"></i> Lihat
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <i class="ti ti-inbox f-36 text-muted"></i>
                                    <p class="text-muted mb-0">Belum ada pengaduan</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Kematian Terbaru -->
    <div class="col-12 mb-4">
        <div class="card elegant-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5><i class="ti ti-death-icon me-2"></i>Penduduk Meninggal (Terbaru)</h5>
                <a href="{{ route('admin.kematian.index') }}" class="elegant-btn elegant-btn-primary">
                    Lihat Semua <i class="ti ti-arrow-right ms-1"></i>
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Penduduk</th>
                                <th>NIK</th>
                                <th>Tanggal Kematian</th>
                                <th>Penyebab</th>
                                <th>Tempat Kematian</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse(\App\Models\Kematian::with('penduduk')->latest()->take(5)->get() as $kematian)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avtar avtar-xs bg-light-danger me-2">
                                            <i class="ti ti-user f-14"></i>
                                        </div>
                                        @if($kematian->nama_warga)
                                            <h6 class="mb-0">{{ $kematian->nama_warga }}</h6>
                                        @elseif($kematian->penduduk)
                                            <h6 class="mb-0">{{ $kematian->penduduk->nama_lengkap }}</h6>
                                        @else
                                            <h6 class="mb-0 text-muted">-</h6>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    @if($kematian->penduduk)
                                        {{ $kematian->penduduk->nik }}
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge badge-custom" style="background: var(--danger-gradient); color: white;">
                                        {{ $kematian->tanggal_kematian->format('d M Y') }}
                                    </span>
                                </td>
                                <td>{{ Str::limit($kematian->penyebab_kematian ?? '-', 25) }}</td>
                                <td>{{ Str::limit($kematian->tempat_kematian ?? '-', 25) }}</td>
                                <td>
                                    <a href="{{ route('admin.kematian.show', $kematian->id) }}"
                                       class="elegant-btn elegant-btn-primary">
                                        <i class="ti ti-eye"></i> Lihat
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <i class="ti ti-inbox f-36 text-muted"></i>
                                    <p class="text-muted mb-0">Belum ada data kematian</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik Penduduk & Detail Penduduk -->
    <div class="col-md-6 mb-4">
        <div class="card elegant-card">
            <div class="card-header">
                <h5><i class="ti ti-chart-bar me-2"></i>Statistik Penduduk</h5>
            </div>
            <div class="card-body">
                @php
                    $totalPenduduk = \App\Models\Penduduk::count();
                    $pendudukInput = \App\Models\Penduduk::whereNull('user_id')->count();
                    $pendudukReg = \App\Models\Penduduk::whereNotNull('user_id')->count();
                    $pendudukMeninggal = \App\Models\Kematian::count();
                    $pendudukHidup = $totalPenduduk - $pendudukMeninggal;
                @endphp

                <div class="mb-4">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span style="font-weight: 600; color: #2d3748;">Total Penduduk</span>
                        <span style="font-weight: 700; font-size: 16px; color: #667eea;">{{ $totalPenduduk }}</span>
                    </div>
                    <div class="progress-elegant">
                        <div class="progress-bar" style="background: var(--primary-gradient); width: 100%;"></div>
                    </div>
                </div>

                <div class="mb-4">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span style="font-weight: 600; color: #2d3748;">Input Manual</span>
                        <span style="font-weight: 700; font-size: 16px; color: #f093fb;">{{ $pendudukInput }}</span>
                    </div>
                    <div class="progress-elegant">
                        <div class="progress-bar" style="background: var(--danger-gradient); width: {{ $totalPenduduk > 0 ? ($pendudukInput / $totalPenduduk * 100) : 0 }}%;"></div>
                    </div>
                </div>

                <div class="mb-4">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span style="font-weight: 600; color: #2d3748;">Registrasi Akun</span>
                        <span style="font-weight: 700; font-size: 16px; color: #43e97b;">{{ $pendudukReg }}</span>
                    </div>
                    <div class="progress-elegant">
                        <div class="progress-bar" style="background: var(--success-gradient); width: {{ $totalPenduduk > 0 ? ($pendudukReg / $totalPenduduk * 100) : 0 }}%;"></div>
                    </div>
                </div>

                <div class="mb-4">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span style="font-weight: 600; color: #2d3748;">Penduduk Hidup</span>
                        <span style="font-weight: 700; font-size: 16px; color: #4facfe;">{{ $pendudukHidup }}</span>
                    </div>
                    <div class="progress-elegant">
                        <div class="progress-bar" style="background: var(--info-gradient); width: {{ $totalPenduduk > 0 ? ($pendudukHidup / $totalPenduduk * 100) : 0 }}%;"></div>
                    </div>
                </div>

                <div class="mb-0">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span style="font-weight: 600; color: #2d3748;">Penduduk Meninggal</span>
                        <span style="font-weight: 700; font-size: 16px; color: #f5576c;">{{ $pendudukMeninggal }}</span>
                    </div>
                    <div class="progress-elegant">
                        <div class="progress-bar" style="background: var(--warning-gradient); width: {{ $totalPenduduk > 0 ? ($pendudukMeninggal / $totalPenduduk * 100) : 0 }}%;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Detail Penduduk -->
    <div class="col-md-6 mb-4">
        <div class="card elegant-card">
            <div class="card-header">
                <h5><i class="ti ti-info-circle me-2"></i>Detail Penduduk</h5>
            </div>
            <div class="card-body">
                @php
                    $totalPenduduk = \App\Models\Penduduk::count();
                    $pendudukInput = \App\Models\Penduduk::whereNull('user_id')->count();
                    $pendudukReg = \App\Models\Penduduk::whereNotNull('user_id')->count();
                    $pendudukMeninggal = \App\Models\Kematian::count();
                @endphp

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="stat-info-box" style="border-color: #eef2f9;">
                            <h5 style="color: #667eea;">{{ $totalPenduduk }}</h5>
                            <p>Total Penduduk</p>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="stat-info-box" style="border-color: #eef2f9;">
                            <h5 style="color: #f093fb;">{{ $pendudukInput }}</h5>
                            <p>Input Manual</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="stat-info-box" style="border-color: #eef2f9;">
                            <h5 style="color: #43e97b;">{{ $pendudukReg }}</h5>
                            <p>Registrasi Akun</p>
                        </div>
                    </div>
                    <div class="col-md-6 mb-0">
                        <div class="stat-info-box" style="border-color: #eef2f9;">
                            <h5 style="color: #f5576c;">{{ $pendudukMeninggal }}</h5>
                            <p>Meninggal</p>
                        </div>
                    </div>
                </div>

                <div class="alert alert-info mt-3 mb-0" style="border-radius: 10px; border: 1px solid rgba(79, 172, 254, 0.3); background: rgba(79, 172, 254, 0.05);">
                    <i class="ti ti-info-circle me-2" style="color: #4facfe;"></i>
                    <strong style="color: #2d3748;">Info:</strong> <span style="color: #718096;">Total = Input Manual + Registrasi Akun</span>
                </div>
            </div>
        </div>
    </div>
</div>
