<div class="row">
    <!-- KPI Cards - Statistics -->
    <div class="col-md-6 col-xl-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="avtar avtar-l">
                            <i class="ti ti-users f-28"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="mb-0 text-white">Total Penduduk</h6>
                        <h3 class="mb-0 text-white">
                            {{ \App\Models\Penduduk::count() }}
                            <small class="f-16">Jiwa</small>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="avtar avtar-l">
                            <i class="ti ti-clock f-28"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="mb-0 text-white">Pengajuan Menunggu</h6>
                        <h3 class="mb-0 text-white">
                            {{ \App\Models\PengajuanSurat::where('status', 'Menunggu')->count() }}
                            <small class="f-16">Pengajuan</small>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="avtar avtar-l">
                            <i class="ti ti-check f-28"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="mb-0 text-white">Selesai (Bulan Ini)</h6>
                        <h3 class="mb-0 text-white">
                            {{ \App\Models\PengajuanSurat::where('status', 'Selesai')->whereMonth('tanggal_selesai', now()->month)->count() }}
                            <small class="f-16">Surat</small>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="avtar avtar-l">
                            <i class="ti ti-file-text f-28"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="mb-0 text-white">Total Pengajuan</h6>
                        <h3 class="mb-0 text-white">
                            {{ \App\Models\PengajuanSurat::count() }}
                            <small class="f-16">Surat</small>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5><i class="ti ti-rocket me-2"></i>Aksi Cepat</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-3 col-sm-6">
                        <a href="{{ route('admin.pengajuan.index') }}?status=Menunggu" class="btn btn-outline-warning w-100 d-flex flex-column align-items-center py-3">
                            <i class="ti ti-clock f-36 mb-2"></i>
                            <span>Verifikasi Pengajuan</span>
                            <small class="text-muted">{{ \App\Models\PengajuanSurat::where('status', 'Menunggu')->count() }} menunggu</small>
                        </a>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <a href="{{ route('penduduk.create') }}" class="btn btn-outline-primary w-100 d-flex flex-column align-items-center py-3">
                            <i class="ti ti-user-plus f-36 mb-2"></i>
                            <span>Tambah Penduduk</span>
                            <small class="text-muted">Data baru</small>
                        </a>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <a href="{{ route('admin.pengajuan.index') }}?status=Disetujui" class="btn btn-outline-success w-100 d-flex flex-column align-items-center py-3">
                            <i class="ti ti-upload f-36 mb-2"></i>
                            <span>Upload Surat Hasil</span>
                            <small class="text-muted">{{ \App\Models\PengajuanSurat::where('status', 'Disetujui')->count() }} disetujui</small>
                        </a>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <a href="{{ route('penduduk.index') }}" class="btn btn-outline-info w-100 d-flex flex-column align-items-center py-3">
                            <i class="ti ti-database f-36 mb-2"></i>
                            <span>Lihat Data Penduduk</span>
                            <small class="text-muted">{{ \App\Models\Penduduk::count() }} data</small>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pengajuan Terbaru & Statistik -->
    <div class="col-md-12 col-xl-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5><i class="ti ti-file-check me-2"></i>Pengajuan Surat Terbaru</h5>
                <a href="{{ route('admin.pengajuan.index') }}" class="btn btn-sm btn-primary">
                    Lihat Semua <i class="ti ti-arrow-right ms-1"></i>
                </a>
            </div>
            <div class="card-body">
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
                                <td>{{ $pengajuan->created_at->format('d M Y') }}</td>
                                <td>
                                    <span class="badge {{ $pengajuan->status_badge }}">
                                        {{ $pengajuan->status }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.pengajuan.show', $pengajuan->id) }}" 
                                       class="btn btn-sm btn-info">
                                        <i class="ti ti-eye"></i>
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
    <div class="col-md-12 col-xl-4">
        <div class="card">
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
                            style="width: {{ $total > 0 ? ($count / $total * 100) : 0 }}%;">
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Jenis Surat Populer -->
        <div class="card">
            <div class="card-header">
                <h5><i class="ti ti-star me-2"></i>Jenis Surat Populer</h5>
            </div>
            <div class="card-body">
                @php
                    $populerSurats = \App\Models\PengajuanSurat::select('jenis_surat', \DB::raw('count(*) as total'))
                        ->groupBy('jenis_surat')
                        ->orderBy('total', 'desc')
                        ->take(5)
                        ->get();
                @endphp

                <ul class="list-group list-group-flush">
                    @forelse($populerSurats as $surat)
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span>{{ Str::limit($surat->jenis_surat, 25) }}</span>
                        <span class="badge bg-primary rounded-pill">{{ $surat->total }}</span>
                    </li>
                    @empty
                    <li class="list-group-item text-center text-muted">Belum ada data</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

    <!-- Aktivitas Terbaru -->
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5><i class="ti ti-activity me-2"></i>Aktivitas Terbaru</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach(\App\Models\PengajuanSurat::with('user')->whereNotNull('tanggal_selesai')->latest('tanggal_selesai')->take(4)->get() as $activity)
                    <div class="col-md-6 col-lg-3">
                        <div class="card bg-light-success mb-0">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="avtar avtar-s bg-success">
                                            <i class="ti ti-check"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-0">{{ Str::limit($activity->jenis_surat, 20) }}</h6>
                                        <small class="text-muted">{{ $activity->nama_pemohon }}</small>
                                        <p class="mb-0 text-success small">
                                            <i class="ti ti-clock"></i> {{ $activity->tanggal_selesai->diffForHumans() }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>