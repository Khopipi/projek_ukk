@extends('layouts.dashboard')
@section('title', 'Verifikasi Pengaduan')
@section('content')
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
                            <h2 class="mb-0">Verifikasi Pengaduan Warga</h2>
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
                                <h4 class="text-white mb-0">{{ $stats['selesai'] }}</h4>
                                <p class="mb-0 text-sm">Selesai</p>
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
        </div>

        <!-- Main Content -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-0">
                                    <i class="ti ti-message-circle me-2"></i>Daftar Pengaduan dari Warga
                                </h5>
                                <small class="text-muted">Verifikasi dan tanggapi pengaduan dari warga desa</small>
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
                        <form method="GET" action="{{ route('admin.pengaduan.index') }}" class="mb-4">
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
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="ti ti-search"></i> Filter
                                    </button>
                                </div>
                            </div>
                        </form>

                        <!-- Table -->
                        <div class="table-responsive">
                            <table class="table table-hover">
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
                                                <strong>{{ $pengaduan->nomor_pengaduan }}</strong><br>
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
                                                        <div class="avtar avtar-xs bg-light-primary">
                                                            <i class="ti ti-user f-18"></i>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1 ms-2">
                                                        <h6 class="mb-0">{{ $pengaduan->user->name }}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $pengaduan->created_at->format('d M Y') }}</td>
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
                                                                title="Tandai Sedang Diproses"
                                                                onclick="return confirm('Tandai pengaduan ini sedang diproses?')">
                                                            <i class="ti ti-refresh"></i>
                                                        </button>
                                                    </form>
                                                    @endif

                                                    @if(in_array($pengaduan->status, ['Menunggu', 'Diproses']))
                                                    <button type="button"
                                                            class="btn btn-sm btn-success"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#tanggapiModal{{ $pengaduan->id }}"
                                                            title="Tanggapi">
                                                        <i class="ti ti-message-circle"></i>
                                                    </button>
                                                    @endif

                                                    @if($pengaduan->status == 'Diproses')
                                                    <button type="button"
                                                            class="btn btn-sm btn-primary"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#selesaiModal{{ $pengaduan->id }}"
                                                            title="Selesaikan">
                                                        <i class="ti ti-check"></i>
                                                    </button>
                                                    @endif

                                                    @if(in_array($pengaduan->status, ['Menunggu', 'Diproses']))
                                                    <button type="button"
                                                            class="btn btn-sm btn-danger"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#tolakModal{{ $pengaduan->id }}"
                                                            title="Tolak">
                                                        <i class="ti ti-x"></i>
                                                    </button>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Tanggapi Modal -->
                                        <div class="modal fade" id="tanggapiModal{{ $pengaduan->id }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <form action="{{ route('admin.pengaduan.tanggapi', $pengaduan->id) }}" method="POST">
                                                    @csrf
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-success text-white">
                                                            <h5 class="modal-title">Tanggapi Pengaduan</h5>
                                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="alert alert-info">
                                                                <strong>{{ $pengaduan->nomor_pengaduan }}</strong><br>
                                                                {{ $pengaduan->judul }}<br>
                                                                Pelapor: {{ $pengaduan->user->name }}
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
                                                                <textarea name="tanggapan_admin" class="form-control" rows="4" required
                                                                          placeholder="Berikan tanggapan...">{{ $pengaduan->tanggapan_admin }}</textarea>
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

                                        <!-- Selesai Modal -->
                                        @if($pengaduan->status == 'Diproses')
                                        <div class="modal fade" id="selesaiModal{{ $pengaduan->id }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <form action="{{ route('admin.pengaduan.selesai', $pengaduan->id) }}" method="POST">
                                                    @csrf
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-primary text-white">
                                                            <h5 class="modal-title">Selesaikan Pengaduan</h5>
                                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="alert alert-success">
                                                                <strong>{{ $pengaduan->nomor_pengaduan }}</strong><br>
                                                                {{ $pengaduan->judul }}
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Laporan Penyelesaian <span class="text-danger">*</span></label>
                                                                <textarea name="tanggapan_admin" class="form-control" rows="4" required
                                                                          placeholder="Jelaskan hasil penyelesaian pengaduan..."></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-primary">
                                                                <i class="ti ti-check me-1"></i> Selesaikan
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        @endif

                                        <!-- Tolak Modal -->
                                        <div class="modal fade" id="tolakModal{{ $pengaduan->id }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <form action="{{ route('admin.pengaduan.tolak', $pengaduan->id) }}" method="POST">
                                                    @csrf
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-danger text-white">
                                                            <h5 class="modal-title">Tolak Pengaduan</h5>
                                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="alert alert-warning">
                                                                <strong>{{ $pengaduan->nomor_pengaduan }}</strong><br>
                                                                {{ $pengaduan->judul }}
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Alasan Penolakan <span class="text-danger">*</span></label>
                                                                <textarea name="tanggapan_admin" class="form-control" rows="4" required
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
                                            <td colspan="9" class="text-center py-5">
                                                <i class="ti ti-inbox f-36 text-muted"></i>
                                                <p class="text-muted mb-0 mt-2">Tidak ada pengaduan</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if($pengaduans->hasPages())
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div>
                                Menampilkan {{ $pengaduans->firstItem() ?? 0 }} - {{ $pengaduans->lastItem() ?? 0 }}
                                dari {{ $pengaduans->total() }} data
                            </div>
                            <div>
                                {{ $pengaduans->links() }}
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
                    <h5 class="modal-title"><i class="ti ti-help me-2"></i>Panduan Verifikasi Pengaduan</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <h6 class="mb-3">Langkah-langkah Verifikasi:</h6>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="card bg-light-warning">
                                <div class="card-body">
                                    <h6 class="text-warning"><i class="ti ti-refresh me-2"></i>1. Tandai Diproses</h6>
                                    <p class="mb-0 small">Klik tombol kuning untuk menandai pengaduan sedang dalam penanganan.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="card bg-light-success">
                                <div class="card-body">
                                    <h6 class="text-success"><i class="ti ti-message-circle me-2"></i>2. Beri Tanggapan</h6>
                                    <p class="mb-0 small">Berikan tanggapan kepada pelapor dan atur prioritas pengaduan.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="card bg-light-primary">
                                <div class="card-body">
                                    <h6 class="text-primary"><i class="ti ti-check me-2"></i>3. Selesaikan</h6>
                                    <p class="mb-0 small">Tandai selesai setelah masalah ditangani dengan laporan penyelesaian.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="card bg-light-danger">
                                <div class="card-body">
                                    <h6 class="text-danger"><i class="ti ti-x me-2"></i>4. Tolak</h6>
                                    <p class="mb-0 small">Jika pengaduan tidak valid, tolak dengan alasan yang jelas.</p>
                                </div>
                            </div>
                        </div>
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
