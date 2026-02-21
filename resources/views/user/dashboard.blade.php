@include('partials.welcome-navbar')

<style>
    /* Prevent horizontal scrollbar */
    body, html {
        overflow-x: hidden;
        max-width: 100%;
    }

    .pc-container {
        overflow-x: hidden !important;
    }

    /* Responsive padding */
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

    :root {
        --primary-gradient: linear-gradient(135deg, #5b6ef5 0%, #7685f0 100%);
        --danger-gradient: linear-gradient(135deg, #f5365c 0%, #e91e63 100%);
        --info-gradient: linear-gradient(135deg, #17a2b8 0%, #20c9a6 100%);
        --success-gradient: linear-gradient(135deg, #2dce89 0%, #26c381 100%);
        --warning-gradient: linear-gradient(135deg, #ffa500 0%, #ff9500 100%);
        --secondary-gradient: linear-gradient(135deg, #6c757d 0%, #495057 100%);
    }

    .dashboard-card {
        border-radius: 12px !important;
        transition: all 0.3s ease;
        border: 1px solid #e9ecef;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        background: white;
    }

    .dashboard-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 8px 20px rgba(91, 110, 245, 0.1);
        border-color: #5b6ef5;
    }

    .stat-card {
        background: white;
        border-radius: 12px;
        border: 1px solid #e9ecef;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 8px 20px rgba(91, 110, 245, 0.1);
        border-color: #5b6ef5;
    }

    .stat-card-1 { border-left: 4px solid #5b6ef5; }
    .stat-card-2 { border-left: 4px solid #f5365c; }
    .stat-card-3 { border-left: 4px solid #17a2b8; }
    .stat-card-4 { border-left: 4px solid #2dce89; }

    .icon-box {
        width: 60px;
        height: 60px;
        border-radius: 10px;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 28px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
    }

    .stat-card-1 .icon-box { background: linear-gradient(135deg, #f0f2ff 0%, #e9ebff 100%); color: #5b6ef5; }
    .stat-card-2 .icon-box { background: linear-gradient(135deg, #fff5f7 0%, #ffe9f0 100%); color: #f5365c; }
    .stat-card-3 .icon-box { background: linear-gradient(135deg, #f0f9fb 0%, #e8f7f9 100%); color: #17a2b8; }
    .stat-card-4 .icon-box { background: linear-gradient(135deg, #f0fdf4 0%, #e8fbe9 100%); color: #2dce89; }

    .small-icon-box {
        width: 44px;
        height: 44px;
        border-radius: 8px;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 20px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
    }

    .elegant-table {
        border-collapse: collapse;
    }

    .elegant-table thead th {
        background: #f8f9fa;
        color: #495057;
        font-weight: 700;
        font-size: 11px;
        letter-spacing: 0.3px;
        text-transform: none;
        padding: 14px 16px;
        border: 1px solid #dee2e6;
    }

    .elegant-table tbody tr {
        border-bottom: 1px solid #e9ecef;
        transition: all 0.2s ease;
    }

    .elegant-table tbody tr:hover {
        background: #f8f9fa;
        box-shadow: inset 0 0 0 1px rgba(91, 110, 245, 0.05);
    }

    .elegant-table tbody td {
        padding: 14px 16px;
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
        color: white;
        text-decoration: none;
    }

    .elegant-btn-primary {
        background: var(--primary-gradient);
    }

    .elegant-btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 16px rgba(102, 126, 234, 0.3);
        color: white;
    }

    .progress-elegant {
        height: 8px;
        border-radius: 10px;
        background: #eef2f9;
        overflow: hidden;
    }

    .progress-elegant .progress-bar {
        border-radius: 10px;
    }

    .badge-custom {
        padding: 6px 12px;
        border-radius: 8px;
        font-weight: 700;
        font-size: 11px;
        letter-spacing: 0.4px;
    }

    .card-header-elegant {
        background: linear-gradient(135deg, #f8fbff 0%, #ffffff 100%);
        border-bottom: 2px solid #eef2f9;
        padding: 24px;
    }

    .section-title {
        font-size: 18px;
        font-weight: 800;
        letter-spacing: 0.5px;
        color: #2d3748;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
    }

    .section-title i {
        margin-right: 10px;
        width: 28px;
        height: 28px;
        background: var(--primary-gradient);
        color: white;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
    }

    .info-card {
        border-radius: 12px;
        padding: 20px;
        background: linear-gradient(135deg, #f8fbff 0%, #ffffff 100%);
        border: 1px solid #eef2f9;
        transition: all 0.3s ease;
    }

    .info-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
    }

    .stat-value {
        font-size: 32px;
        font-weight: 800;
        color: #2d3748;
    }

    .stat-label {
        font-size: 13px;
        font-weight: 600;
        color: #718096;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }
</style>


<div class="row g-4">

    <!-- WARNING: EMAIL NOT VERIFIED -->
    @if (session('warning'))
    <div class="col-12 mb-4" id="warningContainer">
        <div class="alert alert-warning alert-dismissible fade show" role="alert" style="border-radius: 12px; border-left: 4px solid #ffc107; background: linear-gradient(135deg, rgba(255, 193, 7, 0.08) 0%, rgba(255, 193, 7, 0.04) 100%); border: 1px solid rgba(255, 193, 7, 0.2);">
            <div class="d-flex align-items-start">
                <div style="width: 50px; height: 50px; background: var(--warning-gradient); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: white; font-size: 24px; flex-shrink: 0; margin-top: 0;">
                    <i class="ti ti-alert-triangle"></i>
                </div>
                <div class="ms-3 flex-grow-1">
                    <h6 class="mb-1" style="color: #856404; font-weight: 800;">⚠ Email Belum Diverifikasi</h6>
                    <p class="mb-2" style="color: #856404; font-size: 14px;">
                        {{ session('warning') }}
                    </p>
                    <a href="{{ route('verify.form') }}" class="btn btn-sm" style="background: var(--warning-gradient); color: white; border: none; font-weight: 600;">
                        <i class="ti ti-shield-check me-1"></i> Verifikasi Email Sekarang
                    </a>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
    @endif

    <!-- NOTIFIKASI PENGAJUAN/PENGADUAN SELESAI -->
    @php
        // Ambil notifikasi yang sudah di-close dari session
        $closedNotifications = session()->get('closed_notifications', []);
        
        // Ambil pengajuan selesai yang belum di-close
        $pengajuanSelesai = Auth::user()->pengajuanSurat()
            ->where('status', 'Selesai')
            ->latest()
            ->take(3)
            ->get()
            ->filter(function($p) use ($closedNotifications) {
                return !in_array('pengajuan_' . $p->id, $closedNotifications);
            });
        
        // Ambil pengaduan selesai yang belum di-close
        $pengaduanSelesai = Auth::user()->pengaduans()
            ->where('status', 'Selesai')
            ->latest()
            ->take(3)
            ->get()
            ->filter(function($pd) use ($closedNotifications) {
                return !in_array('pengaduan_' . $pd->id, $closedNotifications);
            });
    @endphp

    @if($pengajuanSelesai->count() > 0 || $pengaduanSelesai->count() > 0)
    <div class="col-12 mb-4" id="notificationContainer">
        @foreach($pengajuanSelesai as $p)
        <div class="alert alert-success alert-dismissible fade show mb-3" role="alert" data-notification-id="pengajuan_{{ $p->id }}" style="border-radius: 12px; border-left: 4px solid #2dce89; background: linear-gradient(135deg, rgba(45, 206, 137, 0.08) 0%, rgba(45, 206, 137, 0.04) 100%); border: 1px solid rgba(45, 206, 137, 0.2);">
            <div class="d-flex align-items-center">
                <div style="width: 50px; height: 50px; background: var(--success-gradient); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: white; font-size: 24px; flex-shrink: 0;">
                    <i class="ti ti-check"></i>
                </div>
                <div class="ms-3 flex-grow-1">
                    <h6 class="mb-1" style="color: #1e7e34; font-weight: 800;">✓ Pengajuan Surat {{ $p->jenis_surat }} Selesai!</h6>
                    <p class="mb-0" style="color: #2d5f2d; font-size: 14px;">
                        Pengajuan Anda dengan nomor <strong>{{ $p->nomor_pengajuan }}</strong> telah selesai diproses. 
                        <a href="{{ route('pengajuan.show', $p->id) }}" style="color: #1e7e34; text-decoration: none; font-weight: 600;">Lihat detail →</a>
                    </p>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endforeach

        @foreach($pengaduanSelesai as $pd)
        <div class="alert alert-success alert-dismissible fade show mb-3" role="alert" data-notification-id="pengaduan_{{ $pd->id }}" style="border-radius: 12px; border-left: 4px solid #2dce89; background: linear-gradient(135deg, rgba(45, 206, 137, 0.08) 0%, rgba(45, 206, 137, 0.04) 100%); border: 1px solid rgba(45, 206, 137, 0.2);">
            <div class="d-flex align-items-center">
                <div style="width: 50px; height: 50px; background: var(--success-gradient); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: white; font-size: 24px; flex-shrink: 0;">
                    <i class="ti ti-message-circle-check"></i>
                </div>
                <div class="ms-3 flex-grow-1">
                    <h6 class="mb-1" style="color: #1e7e34; font-weight: 800;">✓ Pengaduan Anda Selesai Ditanggapi!</h6>
                    <p class="mb-0" style="color: #2d5f2d; font-size: 14px;">
                        Pengaduan "<strong>{{ Str::limit($pd->judul, 40) }}</strong>" telah selesai ditanggapi oleh admin. 
                        <a href="{{ route('pengaduan.show', $pd->id) }}" style="color: #1e7e34; text-decoration: none; font-weight: 600;">Lihat tanggapan →</a>
                    </p>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endforeach
    </div>
    @endif

    <script>
        // Handle notification close dengan session storage
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('[data-notification-id]');
            
            alerts.forEach(alert => {
                const closeBtn = alert.querySelector('.btn-close');
                const notificationId = alert.getAttribute('data-notification-id');
                
                closeBtn.addEventListener('click', function() {
                    // Simpan ke localStorage untuk persistent storage
                    const closedNotifications = JSON.parse(localStorage.getItem('closed_notifications') || '[]');
                    if (!closedNotifications.includes(notificationId)) {
                        closedNotifications.push(notificationId);
                        localStorage.setItem('closed_notifications', JSON.stringify(closedNotifications));
                    }
                    
                    // Kirim ke server untuk disimpan di session
                    fetch('{{ route("notification.close") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            notification_id: notificationId
                        })
                    }).catch(error => console.log('Notification closed locally'));
                });
            });
        });
    </script>
    @php
        $stats = [
            [
                'label' => 'Menunggu',
                'value' => Auth::user()->pengajuanSurat()->where('status','Menunggu')->count(),
                'color' => 'warning',
                'gradient' => 'var(--warning-gradient)',
                'icon'  => 'clock'
            ],
            [
                'label' => 'Diproses',
                'value' => Auth::user()->pengajuanSurat()->where('status','Diproses')->count(),
                'color' => 'info',
                'gradient' => 'var(--info-gradient)',
                'icon'  => 'refresh'
            ],
            [
                'label' => 'Selesai',
                'value' => Auth::user()->pengajuanSurat()->where('status','Selesai')->count(),
                'color' => 'success',
                'gradient' => 'var(--success-gradient)',
                'icon'  => 'check'
            ],
            [
                'label' => 'Total Pengajuan',
                'value' => Auth::user()->pengajuanSurat()->count(),
                'color' => 'primary',
                'gradient' => 'var(--primary-gradient)',
                'icon'  => 'file-text'
            ],
        ];
    @endphp

    @foreach($stats as $s)
    <div class="col-md-6 col-xl-3">
        <div class="card stat-card stat-card-{{ $loop->iteration }}">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="icon-box" style="background: {{ $s['gradient'] }}; color: white;">
                        <i class="ti ti-{{ $s['icon'] }}"></i>
                    </div>
                    <div class="ms-4">
                        <p class="stat-label mb-1">{{ $s['label'] }}</p>
                        <h3 class="stat-value mb-0">{{ $s['value'] }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    <!-- RIWAYAT PENGAJUAN SURAT -->
    <div class="col-xl-8 mb-4">
        <div class="card dashboard-card">
            <div class="card-header card-header-elegant d-flex justify-content-between align-items-center">
                <h5 class="mb-0" style="font-size: 16px; font-weight: 800; color: #2d3748;"><i class="ti ti-file-text me-2" style="color: #667eea;"></i>Riwayat Pengajuan Surat</h5>
                <a href="{{ route('pengajuan.index') }}" class="elegant-btn elegant-btn-primary">
                    Lihat Semua <i class="ti ti-arrow-right ms-1"></i>
                </a>
            </div>

            <div class="card-body p-0">
                @if(Auth::user()->is_verified)
                    <div class="table-responsive">
                        <table class="table align-middle mb-0 elegant-table">
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
                                @forelse(Auth::user()->pengajuanSurat()->latest()->take(5)->get() as $p)
                                    <tr>
                                        <td>
                                            <strong style="color: #2d3748;">{{ $p->nomor_pengajuan }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $p->created_at->format('H:i') }}</small>
                                        </td>
                                        <td>
                                            <i class="{{ $p->jenis_surat_icon }} text-primary me-2"></i>
                                            {{ Str::limit($p->jenis_surat, 25) }}
                                        </td>
                                        <td><small>{{ $p->created_at->format('d M Y') }}</small></td>
                                        <td>
                                            <span class="badge {{ $p->status_badge }}">{{ $p->status }}</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('pengajuan.show', $p->id) }}" class="elegant-btn elegant-btn-primary">
                                                <i class="ti ti-eye"></i> Lihat
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5">
                                            <i class="ti ti-inbox f-36 text-muted"></i>
                                            <p class="text-muted mt-3">Belum ada pengajuan surat</p>
                                            <a href="{{ route('pengajuan.create') }}" class="elegant-btn elegant-btn-primary mt-3">
                                                <i class="ti ti-plus me-1"></i> Ajukan Surat
                                            </a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="ti ti-alert-triangle f-48 text-warning"></i>
                        <h5 class="mt-3 fw-bold" style="color: #2d3748;">Email Belum Diverifikasi</h5>
                        <p class="text-muted">Verifikasi email Anda untuk mengajukan surat</p>
                        <a href="{{ route('verify.form') }}" class="elegant-btn" style="background: var(--warning-gradient);">
                            <i class="ti ti-shield-check me-1"></i> Verifikasi Email
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- STATUS CHART -->
    <div class="col-xl-4 mb-4">
        <div class="card dashboard-card">
            <div class="card-header card-header-elegant">
                <h5 class="mb-0" style="font-size: 16px; font-weight: 800; color: #2d3748;"><i class="ti ti-chart-donut me-2" style="color: #667eea;"></i>Status Pengajuan</h5>
            </div>

            <div class="card-body">
                @php
                    $userStatuses = [
                        'Menunggu' => Auth::user()->pengajuanSurat()->where('status','Menunggu')->count(),
                        'Diproses' => Auth::user()->pengajuanSurat()->where('status','Diproses')->count(),
                        'Disetujui' => Auth::user()->pengajuanSurat()->where('status','Disetujui')->count(),
                        'Ditolak'   => Auth::user()->pengajuanSurat()->where('status','Ditolak')->count(),
                        'Selesai'   => Auth::user()->pengajuanSurat()->where('status','Selesai')->count(),
                    ];
                    $total = array_sum($userStatuses);
                @endphp

                @if($total > 0)
                    @foreach($userStatuses as $label => $count)
                        @if($count > 0)
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span style="font-weight: 600; color: #2d3748;">{{ $label }}</span>
                                <span class="badge badge-custom" style="background: var(--primary-gradient); color: white;">{{ $count }}</span>
                            </div>
                            <div class="progress-elegant">
                                <div class="progress-bar
                                    @if($label=='Menunggu') bg-warning
                                    @elseif($label=='Diproses') bg-info
                                    @elseif($label=='Disetujui') bg-success
                                    @elseif($label=='Ditolak') bg-danger
                                    @else bg-primary
                                    @endif"
                                    style="width: {{ ($count / $total * 100) }}%">
                                </div>
                            </div>
                        </div>
                        @endif
                    @endforeach
                @else
                    <div class="text-center text-muted py-5">
                        <i class="ti ti-inbox f-36"></i>
                        <p class="mt-3">Belum ada data</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- RIWAYAT PENGADUAN -->
    <div class="col-12 mb-4">
        <div class="card dashboard-card">
            <div class="card-header card-header-elegant d-flex justify-content-between align-items-center">
                <h5 class="mb-0" style="font-size: 16px; font-weight: 800; color: #2d3748;"><i class="ti ti-message-circle me-2" style="color: #667eea;"></i>Riwayat Pengaduan</h5>
                <a href="{{ route('pengaduan.index') }}" class="elegant-btn elegant-btn-primary">
                    Lihat Semua <i class="ti ti-arrow-right ms-1"></i>
                </a>
            </div>

            <div class="card-body">
                <div class="row g-3">

                    @forelse(Auth::user()->pengaduans()->latest()->take(4)->get() as $pd)
                    <div class="col-md-6 col-lg-3">
                        <div class="card dashboard-card" style="background: linear-gradient(135deg, #f8fbff 0%, #ffffff 100%); border: 2px solid {{ $pd->prioritas_color ?? '#eef2f9' }};">
                            <div class="card-body">
                                <div class="d-flex align-items-start">
                                    <div class="small-icon-box" style="background: {{ $pd->prioritas_color ?? 'var(--primary-gradient)' }}; color: white;">
                                        <i class="ti ti-{{ $pd->status_icon }}"></i>
                                    </div>
                                    <div class="ms-3">
                                        <h6 class="fw-bold" style="color: #2d3748; font-size: 14px; line-height: 1.3;">
                                            {{ Str::limit($pd->judul, 30) }}
                                        </h6>
                                        <p class="mb-2 small">
                                            <span class="badge {{ $pd->status_badge }}" style="font-size: 10px;">{{ $pd->status }}</span><br>
                                            <small style="color: #a0aec0;"><i class="ti ti-clock"></i> {{ $pd->created_at->diffForHumans() }}</small>
                                        </p>
                                        <a href="{{ route('pengaduan.show',$pd->id) }}"
                                           class="elegant-btn elegant-btn-primary mt-2" style="font-size: 11px;">
                                            Lihat Detail
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12 text-center py-5">
                        <i class="ti ti-inbox f-36 text-muted"></i>
                        <p class="text-muted mt-3">Belum ada pengaduan</p>
                        <a href="{{ route('pengaduan.create') }}" class="elegant-btn elegant-btn-primary mt-3">
                            <i class="ti ti-plus me-1"></i> Buat Pengaduan
                        </a>
                    </div>
                    @endforelse

                </div>
            </div>
        </div>
    </div>

    <!-- INFO PENTING -->
    <div class="col-12 mb-4">
        <div class="section-title">
            <i class="ti ti-info-circle"></i> Informasi Penting
        </div>
        <div class="row g-3">

            @php
                $infos = [
                    [
                        'color'=>'primary',
                        'gradient' => 'var(--primary-gradient)',
                        'icon'=>'clock',
                        'title'=>'Waktu Proses',
                        'text'=>'waktu proses 1-2 hari kerja'
                    ],
                    [
                        'color'=>'success',
                        'gradient' => 'var(--success-gradient)',
                        'icon'=>'file-check',
                        'title'=>'Dokumen Lengkap',
                        'text'=>'Pastikan KTP, KK & dokumen pendukung valid'
                    ],
                    [
                        'color'=>'warning',
                        'gradient' => 'var(--warning-gradient)',
                        'icon'=>'bell',
                        'title'=>'Notifikasi',
                        'text'=>'Cek email untuk update status pengajuan'
                    ],
                ];
            @endphp

            @foreach($infos as $info)
            <div class="col-md-4">
                <div class="info-card">
                    <div class="d-flex align-items-start">
                        <div class="small-icon-box" style="background: {{ $info['gradient'] }}; color: white; flex-shrink: 0;">
                            <i class="ti ti-{{ $info['icon'] }}"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="fw-bold" style="color: #2d3748; margin-bottom: 8px;">{{ $info['title'] }}</h6>
                            <p class="text-muted small mb-0" style="font-size: 13px; line-height: 1.5;">{{ $info['text'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
    </div>

</div>
