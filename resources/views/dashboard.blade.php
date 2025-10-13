@extends('layouts.dashboard')
@section('title', 'Dashboard Page')

@section('content')
    <div class="row">
    <!-- KPI Cards -->
    <div class="col-md-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <h6 class="mb-2 f-w-400 text-muted">Total Pengajuan</h6>
                <h4 class="mb-3" id="kpi-total-submissions">12,430
                    <span class="badge bg-light-primary border border-primary"><i class="ti ti-trending-up"></i> 8.2%</span>
                </h4>
                <p class="mb-0 text-muted text-sm">Pengajuan surat dari warga (bulan berjalan)</p>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <h6 class="mb-2 f-w-400 text-muted">Pengajuan Menunggu</h6>
                <h4 class="mb-3" id="kpi-pending-submissions">420
                    <span class="badge bg-light-warning border border-warning"><i class="ti ti-clock"></i> 3.1%</span>
                </h4>
                <p class="mb-0 text-muted text-sm">Belum diverifikasi petugas desa</p>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <h6 class="mb-2 f-w-400 text-muted">Total Pengaduan</h6>
                <h4 class="mb-3" id="kpi-total-complaints">1,230
                    <span class="badge bg-light-danger border border-danger"><i class="ti ti-alert-circle"></i> 12%</span>
                </h4>
                <p class="mb-0 text-muted text-sm">Masalah yang dilaporkan warga</p>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <h6 class="mb-2 f-w-400 text-muted">Pengaduan Terselesai</h6>
                <h4 class="mb-3" id="kpi-resolved-complaints">980
                    <span class="badge bg-light-success border border-success"><i class="ti ti-check"></i> 79.7%</span>
                </h4>
                <p class="mb-0 text-muted text-sm">Kondisi terlaporkan yang sudah ditangani</p>
            </div>
        </div>
    </div>

    <!-- Charts: Submissions & Complaints -->
    <div class="col-md-12 col-xl-8">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h5 class="mb-0">Tren Pengajuan & Pengaduan</h5>
            <ul class="nav nav-pills justify-content-end mb-0" id="chart-tab-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="chart-tab-month" data-bs-toggle="pill"
                        data-bs-target="#chart-tab-month-pane" type="button" role="tab" aria-controls="chart-tab-month-pane"
                        aria-selected="true">Bulan</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="chart-tab-week" data-bs-toggle="pill"
                        data-bs-target="#chart-tab-week-pane" type="button" role="tab"
                        aria-controls="chart-tab-week-pane" aria-selected="false">Minggu</button>
                </li>
            </ul>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="tab-content" id="chart-tab-tabContent">
                    <div class="tab-pane show active" id="chart-tab-month-pane" role="tabpanel">
                        <div id="chart-submissions-month" style="height:300px;"></div>
                    </div>
                    <div class="tab-pane" id="chart-tab-week-pane" role="tabpanel">
                        <div id="chart-submissions-week" style="height:300px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Income / Activity Overview -->
    <div class="col-md-12 col-xl-4">
        <h5 class="mb-3">Aktivitas Mingguan</h5>
        <div class="card">
            <div class="card-body">
                <h6 class="mb-2 f-w-400 text-muted">Permohonan & Tindak Lanjut</h6>
                <h3 class="mb-3" id="weekly-activity-count">1,345</h3>
                <div id="chart-week-activity" style="height:160px;"></div>
            </div>
        </div>
    </div>

    <!-- Recent Submissions Table -->
    <div class="col-md-12 col-xl-8">
        <h5 class="mb-3">Pengajuan Terbaru</h5>
        <div class="card tbl-card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-borderless mb-0">
                        <thead>
                            <tr>
                                <th>NO. TRACK</th>
                                <th>JENIS SURAT</th>
                                <th>NAMA PENGAJU</th>
                                <th>STATUS</th>
                                <th class="text-end">TANGGAL</th>
                            </tr>
                        </thead>
                        <tbody id="recent-submissions-body">
                            <!-- contoh baris (ganti dengan loop backend) -->
                            <tr>
                                <td><a href="#" class="text-muted">SUB-20250929-001</a></td>
                                <td>Surat Keterangan Domisili</td>
                                <td>Ahmad Sudirman</td>
                                <td><span class="badge bg-light-warning border border-warning">Menunggu</span></td>
                                <td class="text-end">2025-09-29</td>
                            </tr>
                            <tr>
                                <td><a href="#" class="text-muted">SUB-20250929-002</a></td>
                                <td>Pencatatan Kelahiran</td>
                                <td>Siti Nurhaliza</td>
                                <td><span class="badge bg-light-success border border-success">Selesai</span></td>
                                <td class="text-end">2025-09-28</td>
                            </tr>
                            <!-- end contoh -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Complaints -->
    <div class="col-md-12 col-xl-4">
        <h5 class="mb-3">Pengaduan Terbaru</h5>
        <div class="card">
            <div class="list-group list-group-flush" id="recent-complaints-list">
                <a href="#" class="list-group-item list-group-item-action d-flex align-items-center justify-content-between">
                    <div class="d-flex">
                        <div class="flex-shrink-0">
                            <div class="avtar avtar-s rounded-circle text-danger bg-light-danger"><i class="ti ti-flag f-18"></i></div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1">Jalan Rusak - RT 05</h6>
                            <p class="mb-0 text-muted small">Laporan oleh: Suyanto — 2 jam lalu</p>
                        </div>
                    </div>
                    <div class="flex-shrink-0 text-end">
                        <span class="badge bg-light-warning border border-warning">Diprioritaskan</span>
                    </div>
                </a>

                <!-- contoh lain -->
                <a href="#" class="list-group-item list-group-item-action d-flex align-items-center justify-content-between">
                    <div class="d-flex">
                        <div class="flex-shrink-0">
                            <div class="avtar avtar-s rounded-circle text-primary bg-light-primary"><i class="ti ti-bell f-18"></i></div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1">Izin Hajatan - RT 02</h6>
                            <p class="mb-0 text-muted small">Laporan oleh: Rian — 1 hari lalu</p>
                        </div>
                    </div>
                    <div class="flex-shrink-0 text-end">
                        <span class="badge bg-light-success border border-success">Selesai</span>
                    </div>
                </a>
            </div>

            <div class="card-body px-2">
                <div id="chart-complaints-status" style="height:160px;"></div>
            </div>
        </div>
    </div>

    <!-- Sales / Transaction area repurposed to "Layanan Statistik" -->
    <div class="col-md-12 col-xl-8">
        <h5 class="mb-3">Statistik Layanan</h5>
        <div class="card">
            <div class="card-body">
                <h6 class="mb-2 f-w-400 text-muted">Jenis Pengajuan Populer (Minggu Ini)</h6>
                <div id="chart-popular-docs" style="height:260px;"></div>
            </div>
        </div>
    </div>

    <div class="col-md-12 col-xl-4">
        <h5 class="mb-3">Riwayat Tindakan</h5>
        <div class="card">
            <div class="list-group list-group-flush">
                <a href="#" class="list-group-item list-group-item-action">
                    <div class="d-flex">
                        <div class="flex-shrink-0">
                            <div class="avtar avtar-s rounded-circle text-success bg-light-success"><i class="ti ti-check f-18"></i></div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1">Surat Domisili diterbitkan</h6>
                            <p class="mb-0 text-muted">Hari ini, 09:30</p>
                        </div>
                    </div>
                </a>
                <a href="#" class="list-group-item list-group-item-action">
                    <div class="d-flex">
                        <div class="flex-shrink-0">
                            <div class="avtar avtar-s rounded-circle text-primary bg-light-primary"><i class="ti ti-inbox f-18"></i></div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1">Permohonan SKTM diterima</h6>
                            <p class="mb-0 text-muted">Kemarin, 15:12</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

        @if (auth()->user()->role == 'admin')
            @include('admin.dashboard')
        @else
            @include('user.dashboard')
        @endif

    </div>
@endsection
