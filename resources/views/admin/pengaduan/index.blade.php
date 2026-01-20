@extends('layouts.dashboard')
@section('title', 'Verifikasi Pengaduan')
@section('content')
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #5b6ef5 0%, #7685f0 100%);
            --warning-gradient: linear-gradient(135deg, #ffa500 0%, #ff9500 100%);
            --info-gradient: linear-gradient(135deg, #17a2b8 0%, #20c9a6 100%);
            --success-gradient: linear-gradient(135deg, #2dce89 0%, #26c381 100%);
            --danger-gradient: linear-gradient(135deg, #f5365c 0%, #e91e63 100%);
        }

        .stat-card-elegant {
            border: 1px solid #e9ecef;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            transition: all 0.3s ease;
            overflow: hidden;
            position: relative;
            height: 100%;
            background: white;
        }

        .stat-card-elegant:hover {
            transform: translateY(-6px);
            box-shadow: 0 8px 20px rgba(91, 110, 245, 0.1);
            border-color: #5b6ef5;
        }

        .stat-card-elegant.stat-1 { border-left: 4px solid #5b6ef5; }
        .stat-card-elegant.stat-2 { border-left: 4px solid #ffa500; }
        .stat-card-elegant.stat-3 { border-left: 4px solid #17a2b8; }
        .stat-card-elegant.stat-4 { border-left: 4px solid #2dce89; }
        .stat-card-elegant.stat-5 { border-left: 4px solid #f5365c; }

        .stat-icon {
            width: 48px;
            height: 48px;
            background: #f8f9fa;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
        }

        .stat-card-elegant.stat-1 .stat-icon { background: linear-gradient(135deg, #f0f2ff 0%, #e9ebff 100%); color: #5b6ef5; }
        .stat-card-elegant.stat-2 .stat-icon { background: linear-gradient(135deg, #fffbf0 0%, #fff3e0 100%); color: #ff9500; }
        .stat-card-elegant.stat-3 .stat-icon { background: linear-gradient(135deg, #f0f9fb 0%, #e8f7f9 100%); color: #17a2b8; }
        .stat-card-elegant.stat-4 .stat-icon { background: linear-gradient(135deg, #f0fdf4 0%, #e8fbe9 100%); color: #2dce89; }
        .stat-card-elegant.stat-5 .stat-icon { background: linear-gradient(135deg, #fff5f7 0%, #ffe9f0 100%); color: #f5365c; }

        .elegant-card {
            border: 1px solid #e9ecef;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            transition: all 0.3s ease;
            background: white;
        }

        .elegant-card:hover {
            box-shadow: 0 8px 20px rgba(91, 110, 245, 0.08);
        }

        .elegant-card .card-header {
            background: #f8f9fa;
            border-bottom: 1px solid #e9ecef;
            padding: 20px 24px;
        }

        .elegant-card .card-header h5 {
            font-size: 15px;
            font-weight: 700;
            color: #2d3748;
            letter-spacing: 0.3px;
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
            color: white !important;
        }

        .elegant-btn-primary {
            background: var(--primary-gradient);
        }

        .elegant-btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(102, 126, 234, 0.3);
        }

        .filter-form {
            background: linear-gradient(135deg, #f8fbff 0%, #ffffff 100%);
            border-radius: 12px;
            padding: 20px;
            border: 1px solid #eef2f9;
        }

        .filter-form .form-control,
        .filter-form .form-select {
            border-radius: 8px;
            border: 1px solid #eef2f9;
            transition: all 0.3s ease;
            background-color: white;
            color: #2d3748;
        }

        .filter-form .form-control::placeholder {
            color: #718096;
        }

        .filter-form .form-control:focus,
        .filter-form .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        /* Custom Pagination Styling */
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            flex-wrap: nowrap;
            margin: 0;
        }

        .pagination .page-link {
            border: 1px solid #ddd;
            color: #667eea;
            padding: 8px 12px;
            border-radius: 6px;
            transition: all 0.3s ease;
            font-weight: 500;
            min-width: 40px;
            text-align: center;
            white-space: nowrap;
        }

        .pagination .page-link:hover {
            background: #667eea;
            color: white;
            border-color: #667eea;
            transform: translateY(-2px);
        }

        .pagination .page-item.active .page-link {
            background: #667eea;
            border-color: #667eea;
            color: white;
        }

        .pagination .page-item.disabled .page-link {
            color: #ccc;
            cursor: not-allowed;
            opacity: 0.6;
        }

        /* Hide all pagination items except first and last */
        .pagination .page-item {
            display: none !important;
        }

        .pagination .page-item:first-child {
            display: inline-block !important;
        }

        .pagination .page-item:last-child {
            display: inline-block !important;
        }

        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            flex-wrap: nowrap;
        }

        .pagination-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
            gap: 8px;
        }

        .badge-custom {
            border-radius: 6px;
            padding: 6px 12px;
            font-weight: 700;
            font-size: 11px;
            letter-spacing: 0.5px;
        }

        .badge-primary-custom {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .badge-warning-custom {
            background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
            color: white;
        }

        .badge-success-custom {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            color: white;
        }

        .badge-danger-custom {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
        }

        /* Priority Badge Styles */
        .badge-rendah-custom {
            background-color: #28a745 !important;
            color: white !important;
            font-weight: 700;
            padding: 6px 12px;
            border-radius: 6px;
        }

        .badge-sedang-custom {
            background-color: #ffc107 !important;
            color: #333 !important;
            font-weight: 700;
            padding: 6px 12px;
            border-radius: 6px;
        }

        .badge-tinggi-custom {
            background-color: #dc3545 !important;
            color: white !important;
            font-weight: 700;
            padding: 6px 12px;
            border-radius: 6px;
        }

        .badge-mendesak-custom {
            background-color: #dc3545 !important;
            color: white !important;
            font-weight: 700;
            padding: 6px 12px;
            border-radius: 6px;
        }
    </style>

    <div class="pc-content">
        <!-- Breadcrumb -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                            <li class="breadcrumb-item" aria-current="page">Verifikasi Pengaduan</li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0" style="font-size: 24px; font-weight: 800; color: #2d3748;">Verifikasi Pengaduan Warga</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Alert Messages -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" style="border-radius: 12px; border: 1px solid rgba(67, 233, 123, 0.3); background: rgba(67, 233, 123, 0.05);">
                <i class="ti ti-check me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" style="border-radius: 12px; border: 1px solid rgba(245, 87, 108, 0.3); background: rgba(245, 87, 108, 0.05);">
                <i class="ti ti-alert-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-2 col-sm-6 mb-3">
                <div class="card stat-card-elegant stat-1 text-white">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon">
                                <i class="ti ti-bell"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h4 class="text-white mb-0" style="font-weight: 800;">{{ $stats['total'] }}</h4>
                                <p class="mb-0 text-sm" style="font-weight: 600;">Total</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-sm-6 mb-3">
                <div class="card stat-card-elegant stat-2 text-white">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon">
                                <i class="ti ti-clock"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h4 class="text-white mb-0" style="font-weight: 800;">{{ $stats['menunggu'] }}</h4>
                                <p class="mb-0 text-sm" style="font-weight: 600;">Menunggu</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-sm-6 mb-3">
                <div class="card stat-card-elegant stat-3 text-white">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon">
                                <i class="ti ti-refresh"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h4 class="text-white mb-0" style="font-weight: 800;">{{ $stats['diproses'] }}</h4>
                                <p class="mb-0 text-sm" style="font-weight: 600;">Diproses</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-sm-6 mb-3">
                <div class="card stat-card-elegant stat-4 text-white">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon">
                                <i class="ti ti-check"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h4 class="text-white mb-0" style="font-weight: 800;">{{ $stats['selesai'] }}</h4>
                                <p class="mb-0 text-sm" style="font-weight: 600;">Selesai</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-sm-6 mb-3">
                <div class="card stat-card-elegant stat-5 text-white">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon">
                                <i class="ti ti-x"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h4 class="text-white mb-0" style="font-weight: 800;">{{ $stats['ditolak'] }}</h4>
                                <p class="mb-0 text-sm" style="font-weight: 600;">Ditolak</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card elegant-card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-2"><i class="ti ti-message-circle me-2" style="color: #667eea;"></i>Daftar Pengaduan dari Warga</h5>
                                <small class="text-muted">Verifikasi dan tanggapi pengaduan dari warga desa</small>
                            </div>
                            <div>
                                <button type="button" class="elegant-btn elegant-btn-primary" data-bs-toggle="modal" data-bs-target="#helpModal">
                                    <i class="ti ti-help me-1"></i> Panduan
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Filter & Search -->
                        <form method="GET" action="{{ route('admin.pengaduan.index') }}" class="filter-form mb-4">
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <input type="text" name="search" class="form-control" 
                                           placeholder="Cari nomor/judul/lokasi..." value="{{ request('search') }}">
                                </div>
                                <div class="col-md-2">
                                    <select name="kategori" class="form-select">
                                        <option value="">Semua Kategori</option>
                                        <option value="Infrastruktur" {{ request('kategori') == 'Infrastruktur' ? 'selected' : '' }}>Infrastruktur</option>
                                        <option value="Kebersihan" {{ request('kategori') == 'Kebersihan' ? 'selected' : '' }}>Kebersihan</option>
                                        <option value="Keamanan" {{ request('kategori') == 'Keamanan' ? 'selected' : '' }}>Keamanan</option>
                                        <option value="Pelayanan Publik" {{ request('kategori') == 'Pelayanan Publik' ? 'selected' : '' }}>Pelayanan Publik</option>
                                        <option value="Kesehatan" {{ request('kategori') == 'Kesehatan' ? 'selected' : '' }}>Kesehatan</option>
                                        <option value="Pendidikan" {{ request('kategori') == 'Pendidikan' ? 'selected' : '' }}>Pendidikan</option>
                                        <option value="Lainnya" {{ request('kategori') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select name="status" class="form-select">
                                        <option value="">Semua Status</option>
                                        <option value="Menunggu" {{ request('status') == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                                        <option value="Diproses" {{ request('status') == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                                        <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                        <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select name="prioritas" class="form-select">
                                        <option value="">Semua Prioritas</option>
                                        <option value="Mendesak" {{ request('prioritas') == 'Mendesak' ? 'selected' : '' }}>Mendesak</option>
                                        <option value="Tinggi" {{ request('prioritas') == 'Tinggi' ? 'selected' : '' }}>Tinggi</option>
                                        <option value="Sedang" {{ request('prioritas') == 'Sedang' ? 'selected' : '' }}>Sedang</option>
                                        <option value="Rendah" {{ request('prioritas') == 'Rendah' ? 'selected' : '' }}>Rendah</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <button type="submit" class="btn w-100" style="background: var(--primary-gradient); color: white; font-weight: 700; border-radius: 8px;">
                                        <i class="ti ti-search"></i> Filter
                                    </button>
                                </div>
                            </div>
                        </form>

                        <!-- Table -->
                        <div class="table-responsive">
                            <table class="table elegant-table mb-0">
                                <thead>
                                    <tr>
                                        <th width="50">No</th>
                                        <th>Nomor Pengaduan</th>
                                        <th>Kategori</th>
                                        <th>Judul</th>
                                        <th>Pelapor</th>
                                        <th>Tanggal</th>
                                        <th>Prioritas</th>
                                        <th width="120">Status</th>
                                        <th width="200">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($pengaduans as $index => $pengaduan)
                                        <tr>
                                            <td>{{ $pengaduans->firstItem() + $index }}</td>
                                            <td>
                                                <strong style="color: #2d3748;">{{ $pengaduan->nomor_pengaduan }}</strong><br>
                                                <small class="text-muted">{{ $pengaduan->created_at->format('H:i') }}</small>
                                            </td>
                                            <td>
                                                <i class="{{ $pengaduan->kategori_icon }} me-1"></i>
                                                {{ $pengaduan->kategori }}
                                            </td>
                                            <td>{{ Str::limit($pengaduan->judul, 30) }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0">
                                                        <div class="avtar avtar-xs bg-light-primary" style="border-radius: 8px;">
                                                            <i class="ti ti-user f-18"></i>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1 ms-2">
                                                        <h6 class="mb-0" style="color: #2d3748; font-weight: 600;">{{ $pengaduan->user->name }}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $pengaduan->created_at->format('d M Y') }}</td>
                                            <td>
                                                @php
                                                    $badgeClass = match($pengaduan->prioritas) {
                                                        'Rendah' => 'badge-rendah-custom',
                                                        'Sedang' => 'badge-sedang-custom',
                                                        'Tinggi', 'Mendesak' => 'badge-tinggi-custom',
                                                        default => 'badge-sedang-custom'
                                                    };
                                                @endphp
                                                <span class="badge {{ $badgeClass }}">{{ $pengaduan->prioritas_label }}</span>
                                            </td>
                                            <td>
                                                <span class="badge {{ $pengaduan->status_badge }}">
                                                    {{ $pengaduan->status }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('admin.pengaduan.show', $pengaduan->id) }}"
                                                       class="btn btn-sm btn-info"
                                                       title="Lihat Detail">
                                                        <i class="ti ti-eye"></i>
                                                    </a>

                                                    @if($pengaduan->status == 'Menunggu')
                                                    <form action="{{ route('admin.pengaduan.proses', $pengaduan->id) }}"
                                                          method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit"
                                                                class="btn btn-sm btn-warning"
                                                                title="Tandai Sedang Diproses">
                                                            <i class="ti ti-refresh"></i>
                                                        </button>
                                                    </form>
                                                    @endif

                                                    @if(in_array($pengaduan->status, ['Menunggu', 'Diproses']))
                                                    <form action="{{ route('admin.pengaduan.tanggapi', $pengaduan->id) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        <input type="hidden" name="tanggapan_admin" value="Pengaduan ditanggapi">
                                                        <input type="hidden" name="prioritas" value="{{ $pengaduan->prioritas }}">
                                                        <button type="submit"
                                                                class="btn btn-sm btn-success"
                                                                title="Tanggapi">
                                                            <i class="ti ti-message-circle"></i>
                                                        </button>
                                                    </form>
                                                    @endif

                                                    @if($pengaduan->status == 'Diproses')
                                                    <form action="{{ route('admin.pengaduan.selesai', $pengaduan->id) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        <input type="hidden" name="tanggapan_admin" value="Pengaduan diselesaikan">
                                                        <button type="submit"
                                                                class="btn btn-sm btn-success"
                                                                title="Selesaikan">
                                                            <i class="ti ti-check"></i>
                                                        </button>
                                                    </form>
                                                    @endif

                                                    @if(in_array($pengaduan->status, ['Menunggu', 'Diproses']))
                                                    <form action="{{ route('admin.pengaduan.tolak', $pengaduan->id) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        <input type="hidden" name="tanggapan_admin" value="Pengaduan ditolak">
                                                        <button type="submit"
                                                                class="btn btn-sm btn-danger"
                                                                title="Tolak">
                                                            <i class="ti ti-x"></i>
                                                        </button>
                                                    </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>

                                        @empty
                                        <tr>
                                            <td colspan="9" class="text-center py-5">
                                                <i class="ti ti-inbox f-36 text-muted"></i>
                                                <p class="text-muted mt-3 mb-0">Belum ada pengaduan</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if($pengaduans->hasPages())
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <p class="text-muted mb-0">
                                    Menampilkan {{ $pengaduans->firstItem() ?? 0 }} - {{ $pengaduans->lastItem() ?? 0 }} 
                                    dari {{ $pengaduans->total() }} data
                                </p>
                            </div>
                            <div class="col-md-6 text-end">
                                <div class="pagination-wrapper">
                                    {{ $pengaduans->links() }}
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Help Modal -->
    <div class="modal fade" id="helpModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 8px 24px rgba(0,0,0,0.15);">
                <div class="modal-header" style="background: var(--primary-gradient); color: white; border: none;">
                    <h5 class="modal-title" style="font-weight: 800;"><i class="ti ti-help me-2"></i>Panduan Verifikasi Pengaduan</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <h6 class="mb-3" style="font-weight: 800; color: #2d3748;">Langkah-langkah Verifikasi:</h6>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="card elegant-card" style="background: linear-gradient(135deg, rgba(250, 112, 154, 0.1) 0%, rgba(254, 225, 64, 0.1) 100%); border: 1px solid rgba(250, 112, 154, 0.2);">
                                <div class="card-body">
                                    <h6 style="color: #fa709a; font-weight: 800;"><i class="ti ti-refresh me-2"></i>1. Tandai Diproses</h6>
                                    <p class="mb-0 small" style="color: #4a5568;">Klik tombol untuk menandai pengaduan sedang dalam penanganan.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="card elegant-card" style="background: linear-gradient(135deg, rgba(67, 233, 123, 0.1) 0%, rgba(56, 249, 215, 0.1) 100%); border: 1px solid rgba(67, 233, 123, 0.2);">
                                <div class="card-body">
                                    <h6 style="color: #43e97b; font-weight: 800;"><i class="ti ti-message-circle me-2"></i>2. Beri Tanggapan</h6>
                                    <p class="mb-0 small" style="color: #4a5568;">Berikan tanggapan kepada pelapor dan atur prioritas pengaduan.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="card elegant-card" style="background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%); border: 1px solid rgba(102, 126, 234, 0.2);">
                                <div class="card-body">
                                    <h6 style="color: #667eea; font-weight: 800;"><i class="ti ti-check me-2"></i>3. Selesaikan</h6>
                                    <p class="mb-0 small" style="color: #4a5568;">Tandai selesai setelah masalah ditangani dengan laporan penyelesaian.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="card elegant-card" style="background: linear-gradient(135deg, rgba(240, 147, 251, 0.1) 0%, rgba(245, 87, 108, 0.1) 100%); border: 1px solid rgba(240, 147, 251, 0.2);">
                                <div class="card-body">
                                    <h6 style="color: #f093fb; font-weight: 800;"><i class="ti ti-x me-2"></i>4. Tolak</h6>
                                    <p class="mb-0 small" style="color: #4a5568;">Jika pengaduan tidak valid, tolak dengan alasan yang jelas.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid #eef2f9;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 8px;">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts_content')
<script>
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
        
        let styleSheet = document.getElementById('toast-animations');
        if (!styleSheet) {
            styleSheet = document.createElement('style');
            styleSheet.id = 'toast-animations';
            styleSheet.textContent = `
                @keyframes popupIn {
                    0% { opacity: 0; transform: translate(-50%, -50%) scale(0.3); }
                    100% { opacity: 1; transform: translate(-50%, -50%) scale(1); }
                }
                @keyframes bounce {
                    0%, 100% { transform: scale(1); }
                    50% { transform: scale(1.2); }
                }
                @keyframes popupOut {
                    0% { opacity: 1; transform: translate(-50%, -50%) scale(1); }
                    100% { opacity: 0; transform: translate(-50%, -50%) scale(0.3); }
                }
            `;
            document.head.appendChild(styleSheet);
        }
        
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
        const alerts = document.querySelectorAll('.alert-dismissible');
        alerts.forEach(alert => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 5000);
</script>
@endsection
