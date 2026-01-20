@extends('layouts.dashboard')
@section('title', 'Pengaduan Saya')
@section('content')
    <style>
        .user-table {
            border-collapse: collapse;
        }

        .user-table thead th {
            background: #f8fbff;
            color: #e0e7ff;
            font-weight: 700;
            font-size: 11px;
            letter-spacing: 0.6px;
            text-transform: uppercase;
            padding: 16px;
            border: none;
        }

        .user-table tbody tr {
            border-bottom: 1px solid #eef2f9;
            transition: all 0.3s ease;
        }

        .user-table tbody tr:hover {
            background: #f8fbff;
            box-shadow: inset 0 0 0 1px rgba(0, 0, 0, 0.02);
        }

        .user-table tbody td {
            padding: 16px;
            color: #ffffff;
            font-weight: 500;
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
                            <li class="breadcrumb-item" aria-current="page">Pengaduan</li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Pengaduan Saya</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Alert Messages -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="ti ti-check me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="ti ti-alert-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Statistik Cards -->
        <div class="row mb-4">
            <div class="col-md-3 col-sm-6">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <i class="ti ti-clock f-36"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h3 class="text-white">{{ $pengaduans->where('status', 'Menunggu')->count() }}</h3>
                                <p class="mb-0">Menunggu</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <i class="ti ti-refresh f-36"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h3 class="text-white">{{ $pengaduans->where('status', 'Diproses')->count() }}</h3>
                                <p class="mb-0">Diproses</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <i class="ti ti-check f-36"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h3 class="text-white">{{ $pengaduans->where('status', 'Selesai')->count() }}</h3>
                                <p class="mb-0">Selesai</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card bg-danger text-white">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <i class="ti ti-x f-36"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h3 class="text-white">{{ $pengaduans->where('status', 'Ditolak')->count() }}</h3>
                                <p class="mb-0">Ditolak</p>
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
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5>Daftar Pengaduan</h5>
                        <a href="{{ route('pengaduan.create') }}" class="btn btn-primary">
                            <i class="ti ti-plus"></i> Buat Pengaduan Baru
                        </a>
                    </div>
                    <div class="card-body">
                        <!-- Filter & Search -->
                        <form method="GET" action="{{ route('pengaduan.index') }}" class="mb-4">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <input type="text" name="search" class="form-control" 
                                           placeholder="Cari nomor/judul/lokasi..." value="{{ request('search') }}">
                                </div>
                                <div class="col-md-3">
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
                                <div class="col-md-3">
                                    <select name="status" class="form-select">
                                        <option value="">Semua Status</option>
                                        <option value="Menunggu" {{ request('status') == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                                        <option value="Diproses" {{ request('status') == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                                        <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                        <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="ti ti-search"></i> Filter
                                    </button>
                                </div>
                            </div>
                        </form>

                        <!-- Table -->
                        <div class="table-responsive">
                            <table class="table user-table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nomor Pengaduan</th>
                                        <th>Kategori</th>
                                        <th>Judul</th>
                                        <th>Lokasi</th>
                                        <th>Tanggal</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($pengaduans as $index => $pengaduan)
                                        <tr>
                                            <td>{{ $pengaduans->firstItem() + $index }}</td>
                                            <td>
                                                <strong>{{ $pengaduan->nomor_pengaduan }}</strong>
                                            </td>
                                            <td>
                                                <i class="{{ $pengaduan->kategori_icon }} me-1"></i>
                                                {{ $pengaduan->kategori }}
                                            </td>
                                            <td>{{ Str::limit($pengaduan->judul, 30) }}</td>
                                            <td>{{ $pengaduan->lokasi ?? '-' }}</td>
                                            <td>{{ $pengaduan->created_at->format('d M Y, H:i') }}</td>
                                            <td>
                                                <span class="badge {{ $pengaduan->status_badge }}">
                                                    {{ $pengaduan->status }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('pengaduan.show', $pengaduan->id) }}" 
                                                       class="btn btn-sm btn-info" 
                                                       title="Detail">
                                                        <i class="ti ti-eye"></i>
                                                    </a>
                                                    
                                                    @if(in_array($pengaduan->status, ['Menunggu', 'Ditolak']))
                                                    <form action="{{ route('pengaduan.destroy', $pengaduan->id) }}" 
                                                          method="POST" 
                                                          class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                            <i class="ti ti-trash"></i>
                                                        </button>
                                                    </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center py-4">
                                                <i class="ti ti-inbox f-36 text-muted"></i>
                                                <p class="text-muted">Belum ada pengaduan</p>
                                                <a href="{{ route('pengaduan.create') }}" class="btn btn-sm btn-primary">
                                                    <i class="ti ti-plus me-1"></i> Buat Pengaduan Baru
                                                </a>
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
@endsection

@section('scripts_content')
<script>
    // Show toast notification
    function showCustomToast(message, icon = '✓') {
        const existing = document.getElementById('custom-toast-popup');
        if (existing) existing.remove();
        
        const popup = document.createElement('div');
        popup.id = 'custom-toast-popup';
        
        let bgColor = '#3b82f6';
        if (message.includes('Selesai') || message.includes('berhasil')) bgColor = '#10b981';
        else if (message.includes('Dihapus') || message.includes('Hapus')) bgColor = '#ef4444';
        
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
                    if (btnText.includes('Hapus')) {
                        message = '🗑️ Pengaduan Dihapus!';
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