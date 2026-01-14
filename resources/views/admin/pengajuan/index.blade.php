@extends('layouts.dashboard')
@section('title', 'Verifikasi Pengajuan Surat')
@section('content')
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --warning-gradient: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
            --info-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --success-gradient: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            --danger-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }

        .stat-card-elegant {
            border: none;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
            position: relative;
            height: 100%;
        }

        .stat-card-elegant:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.15);
        }

        .stat-card-elegant.stat-1 { background: var(--primary-gradient); }
        .stat-card-elegant.stat-2 { background: var(--warning-gradient); }
        .stat-card-elegant.stat-3 { background: var(--info-gradient); }
        .stat-card-elegant.stat-4 { background: var(--success-gradient); }
        .stat-card-elegant.stat-5 { background: var(--danger-gradient); }

        .stat-icon {
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }

        .elegant-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }

        .elegant-card:hover {
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.12);
        }

        .elegant-card .card-header {
            background: linear-gradient(135deg, #f8fbff 0%, #ffffff 100%);
            border-bottom: 2px solid #eef2f9;
            padding: 24px;
        }

        .elegant-card .card-header h5 {
            font-size: 16px;
            font-weight: 800;
            color: #2d3748;
            letter-spacing: 0.5px;
        }

        .elegant-table {
            border-collapse: collapse;
        }

        .elegant-table thead th {
            background: #f8fbff;
            color: #e0e7ff;
            font-weight: 700;
            font-size: 11px;
            letter-spacing: 0.6px;
            text-transform: uppercase;
            padding: 16px;
            border: none;
        }

        .elegant-table tbody tr {
            border-bottom: 1px solid #eef2f9;
            transition: all 0.3s ease;
        }

        .elegant-table tbody tr:hover {
            background: #f8fbff;
            box-shadow: inset 0 0 0 1px rgba(0, 0, 0, 0.02);
        }

        .elegant-table tbody td {
            padding: 16px;
            color: #e0e7ff;
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
        }

        .filter-form .form-control:focus,
        .filter-form .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
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
                            <li class="breadcrumb-item" aria-current="page">Verifikasi Pengajuan</li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Verifikasi Pengajuan Surat</h2>
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

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-2 col-sm-6">
                <div class="card bg-secondary text-white">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <i class="ti ti-files f-28"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h4 class="text-white mb-0">{{ $stats['total'] }}</h4>
                                <p class="mb-0 text-sm">Total</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-sm-6">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <i class="ti ti-clock f-28"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h4 class="text-white mb-0">{{ $stats['menunggu'] }}</h4>
                                <p class="mb-0 text-sm">Menunggu</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-sm-6">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <i class="ti ti-refresh f-28"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h4 class="text-white mb-0">{{ $stats['diproses'] }}</h4>
                                <p class="mb-0 text-sm">Diproses</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-sm-6">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <i class="ti ti-check f-28"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h4 class="text-white mb-0">{{ $stats['disetujui'] }}</h4>
                                <p class="mb-0 text-sm">Disetujui</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-sm-6">
                <div class="card bg-danger text-white">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <i class="ti ti-x f-28"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h4 class="text-white mb-0">{{ $stats['ditolak'] }}</h4>
                                <p class="mb-0 text-sm">Ditolak</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-sm-6">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <i class="ti ti-circle-check f-28"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h4 class="text-white mb-0">{{ $stats['selesai'] }}</h4>
                                <p class="mb-0 text-sm">Selesai</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-0">
                                    <i class="ti ti-file-check me-2"></i>Daftar Pengajuan Surat dari Warga
                                </h5>
                                <small class="text-muted">Verifikasi dan proses pengajuan surat dari warga desa</small>
                            </div>
                            <div>
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#helpModal">
                                    <i class="ti ti-help me-1"></i> Panduan Verifikasi
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Filter & Search -->
                        <form method="GET" action="{{ route('admin.pengajuan.index') }}" class="mb-4">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <input type="text" name="search" class="form-control" 
                                           placeholder="Cari nomor/nama/NIK..." value="{{ request('search') }}">
                                </div>
                                <div class="col-md-3">
                                    <select name="jenis_surat" class="form-select">
                                        <option value="">Semua Jenis Surat</option>
                                        <option value="Surat Nikah" {{ request('jenis_surat') == 'Surat Nikah' ? 'selected' : '' }}>Surat Nikah</option>
                                        <option value="Pembuatan KTP" {{ request('jenis_surat') == 'Pembuatan KTP' ? 'selected' : '' }}>Pembuatan KTP</option>
                                        <option value="Surat Tanah" {{ request('jenis_surat') == 'Surat Tanah' ? 'selected' : '' }}>Surat Tanah</option>
                                        <option value="Surat Warisan" {{ request('jenis_surat') == 'Surat Warisan' ? 'selected' : '' }}>Surat Warisan</option>
                                        <option value="Surat Domisili" {{ request('jenis_surat') == 'Surat Domisili' ? 'selected' : '' }}>Surat Domisili</option>
                                        <option value="Surat Kelahiran" {{ request('jenis_surat') == 'Surat Kelahiran' ? 'selected' : '' }}>Surat Kelahiran</option>
                                        <option value="Surat Keterangan Tidak Mampu" {{ request('jenis_surat') == 'Surat Keterangan Tidak Mampu' ? 'selected' : '' }}>SKTM</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select name="status" class="form-select">
                                        <option value="">Semua Status</option>
                                        <option value="Menunggu" {{ request('status') == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                                        <option value="Diproses" {{ request('status') == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                                        <option value="Disetujui" {{ request('status') == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                                        <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                                        <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="ti ti-search"></i> Filter
                                    </button>
                                </div>
                            </div>
                        </form>

                        <!-- Bulk Actions (untuk status Menunggu) -->
                        @if($pengajuans->where('status', 'Menunggu')->count() > 0)
                        <div class="alert alert-info mb-3">
                            <div class="d-flex align-items-center">
                                <i class="ti ti-info-circle me-2"></i>
                                <span>Pilih pengajuan untuk melakukan aksi massal</span>
                            </div>
                        </div>
                        @endif

                        <!-- Table -->
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th width="50">No</th>
                                        <th>Nomor Pengajuan</th>
                                        <th>Pemohon</th>
                                        <th>Jenis Surat</th>
                                        <th>Tanggal</th>
                                        <th width="120">Status</th>
                                        <th width="200">Aksi Verifikasi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($pengajuans as $index => $pengajuan)
                                        <tr>
                                            <td>{{ $pengajuans->firstItem() + $index }}</td>
                                            <td>
                                                <strong>{{ $pengajuan->nomor_pengajuan }}</strong><br>
                                                <small class="text-muted">{{ $pengajuan->created_at->format('H:i') }}</small>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0">
                                                        <div class="avtar avtar-xs bg-light-primary">
                                                            <i class="ti ti-user f-18"></i>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1 ms-2">
                                                        <h6 class="mb-0">{{ $pengajuan->nama_pemohon }}</h6>
                                                        <small class="text-muted">{{ $pengajuan->user->name }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <i class="{{ $pengajuan->jenis_surat_icon }} me-1 text-primary"></i>
                                                {{ $pengajuan->jenis_surat }}
                                            </td>
                                            <td>{{ $pengajuan->created_at->format('d M Y') }}</td>
                                            <td>
                                                <span class="badge {{ $pengajuan->status_badge }}">
                                                    {{ $pengajuan->status }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('admin.pengajuan.show', $pengajuan->id) }}" 
                                                       class="btn btn-sm btn-info"
                                                       title="Lihat Detail & Verifikasi">
                                                        <i class="ti ti-eye"></i>
                                                    </a>
                                                    
                                                    @if($pengajuan->status == 'Menunggu')
                                                    <form action="{{ route('admin.pengajuan.proses', $pengajuan->id) }}" 
                                                          method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" 
                                                                class="btn btn-sm btn-warning"
                                                                title="Tandai Sedang Diproses"
                                                                onclick="return confirm('Tandai pengajuan ini sedang diproses?')">
                                                            <i class="ti ti-refresh"></i>
                                                        </button>
                                                    </form>
                                                    @endif
                                                    
                                                    @if(in_array($pengajuan->status, ['Menunggu', 'Diproses']))
                                                    <button type="button" 
                                                            class="btn btn-sm btn-success"
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#approveModal{{ $pengajuan->id }}"
                                                            title="Setujui">
                                                        <i class="ti ti-check"></i>
                                                    </button>
                                                    
                                                    <button type="button" 
                                                            class="btn btn-sm btn-danger"
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#rejectModal{{ $pengajuan->id }}"
                                                            title="Tolak">
                                                        <i class="ti ti-x"></i>
                                                    </button>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Approve Modal -->
                                        <div class="modal fade" id="approveModal{{ $pengajuan->id }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <form action="{{ route('admin.pengajuan.approve', $pengajuan->id) }}" method="POST">
                                                    @csrf
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-success text-white">
                                                            <h5 class="modal-title">Setujui Pengajuan</h5>
                                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="alert alert-info">
                                                                <strong>{{ $pengajuan->nomor_pengajuan }}</strong><br>
                                                                {{ $pengajuan->jenis_surat }}<br>
                                                                Pemohon: {{ $pengajuan->nama_pemohon }}
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Catatan (Opsional)</label>
                                                                <textarea name="catatan_admin" class="form-control" rows="3" 
                                                                          placeholder="Berikan catatan jika diperlukan..."></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-success">
                                                                <i class="ti ti-check me-1"></i> Ya, Setujui
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                        <!-- Reject Modal -->
                                        <div class="modal fade" id="rejectModal{{ $pengajuan->id }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <form action="{{ route('admin.pengajuan.reject', $pengajuan->id) }}" method="POST">
                                                    @csrf
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-danger text-white">
                                                            <h5 class="modal-title">Tolak Pengajuan</h5>
                                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="alert alert-warning">
                                                                <strong>{{ $pengajuan->nomor_pengajuan }}</strong><br>
                                                                {{ $pengajuan->jenis_surat }}<br>
                                                                Pemohon: {{ $pengajuan->nama_pemohon }}
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Alasan Penolakan <span class="text-danger">*</span></label>
                                                                <textarea name="catatan_admin" class="form-control" rows="4" required
                                                                          placeholder="Jelaskan alasan penolakan..."></textarea>
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

                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-5">
                                                <i class="ti ti-inbox f-36 text-muted"></i>
                                                <p class="text-muted mb-0 mt-2">Tidak ada pengajuan surat yang perlu diverifikasi</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if($pengajuans->hasPages())
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div>
                                Menampilkan {{ $pengajuans->firstItem() ?? 0 }} - {{ $pengajuans->lastItem() ?? 0 }} 
                                dari {{ $pengajuans->total() }} data
                            </div>
                            <div>
                                {{ $pengajuans->links() }}
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
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="ti ti-help me-2"></i>Panduan Verifikasi Pengajuan</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <h6 class="mb-3">Langkah-langkah Verifikasi:</h6>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="card bg-light-warning">
                                <div class="card-body">
                                    <h6 class="text-warning"><i class="ti ti-refresh me-2"></i>1. Tandai Diproses</h6>
                                    <p class="mb-0 small">Klik tombol kuning untuk menandai pengajuan sedang dalam proses verifikasi.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="card bg-light-info">
                                <div class="card-body">
                                    <h6 class="text-info"><i class="ti ti-eye me-2"></i>2. Lihat Detail</h6>
                                    <p class="mb-0 small">Klik tombol biru untuk melihat detail lengkap pengajuan dan dokumen pendukung.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="card bg-light-success">
                                <div class="card-body">
                                    <h6 class="text-success"><i class="ti ti-check me-2"></i>3. Setujui</h6>
                                    <p class="mb-0 small">Klik tombol hijau jika dokumen lengkap dan valid. Bisa tambahkan catatan.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="card bg-light-danger">
                                <div class="card-body">
                                    <h6 class="text-danger"><i class="ti ti-x me-2"></i>4. Tolak</h6>
                                    <p class="mb-0 small">Klik tombol merah jika ada masalah. <strong>WAJIB</strong> isi alasan penolakan.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card bg-light-primary">
                                <div class="card-body">
                                    <h6 class="text-primary"><i class="ti ti-upload me-2"></i>5. Upload Surat Hasil</h6>
                                    <p class="mb-0 small">Setelah disetujui, masuk ke halaman detail untuk upload surat hasil (PDF).</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="alert alert-warning mt-3 mb-0">
                        <strong><i class="ti ti-alert-triangle me-2"></i>Penting:</strong>
                        <ul class="mb-0 mt-2">
                            <li>Pastikan semua dokumen pendukung sudah diperiksa dengan teliti</li>
                            <li>Verifikasi kebenaran data pemohon (NIK, KK, dll)</li>
                            <li>Jika menolak, jelaskan alasan dengan detail agar pemohon bisa memperbaiki</li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts_content')
<script>
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