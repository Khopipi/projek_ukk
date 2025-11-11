@extends('layouts.dashboard')
@section('title', 'Pengajuan Surat')
@section('content')
    <div class="pc-content">
        <!-- Breadcrumb -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                            <li class="breadcrumb-item" aria-current="page">Pengajuan Surat</li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Pengajuan Surat</h2>
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
                                <h3 class="text-white">{{ $pengajuans->where('status', 'Menunggu')->count() }}</h3>
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
                                <h3 class="text-white">{{ $pengajuans->where('status', 'Diproses')->count() }}</h3>
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
                                <h3 class="text-white">{{ $pengajuans->where('status', 'Selesai')->count() }}</h3>
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
                                <h3 class="text-white">{{ $pengajuans->where('status', 'Ditolak')->count() }}</h3>
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
                        <h5>Daftar Pengajuan Surat</h5>
                        <a href="{{ route('pengajuan.create') }}" class="btn btn-primary">
                            <i class="ti ti-plus"></i> Ajukan Surat Baru
                        </a>
                    </div>
                    <div class="card-body">
                        <!-- Filter & Search -->
                        <form method="GET" action="{{ route('pengajuan.index') }}" class="mb-4">
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
                                        <option value="Surat Keterangan Tidak Mampu" {{ request('jenis_surat') == 'Surat Keterangan Tidak Mampu' ? 'selected' : '' }}>Surat Keterangan Tidak Mampu</option>
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

                        <!-- Table -->
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nomor Pengajuan</th>
                                        <th>Jenis Surat</th>
                                        <th>Tanggal Ajuan</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($pengajuans as $index => $pengajuan)
                                        <tr>
                                            <td>{{ $pengajuans->firstItem() + $index }}</td>
                                            <td>
                                                <strong>{{ $pengajuan->nomor_pengajuan }}</strong><br>
                                                <small class="text-muted">{{ $pengajuan->nama_pemohon }}</small>
                                            </td>
                                            <td>
                                                <i class="{{ $pengajuan->jenis_surat_icon }} me-1"></i>
                                                {{ $pengajuan->jenis_surat }}
                                            </td>
                                            <td>{{ $pengajuan->created_at->format('d M Y, H:i') }}</td>
                                            <td>
                                                <span class="badge {{ $pengajuan->status_badge }}">
                                                    {{ $pengajuan->status }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('pengajuan.show', $pengajuan->id) }}" 
                                                       class="btn btn-sm btn-info" 
                                                       title="Detail">
                                                        <i class="ti ti-eye"></i>
                                                    </a>
                                                    
                                                    @if($pengajuan->status == 'Menunggu')
                                                    <a href="{{ route('pengajuan.edit', $pengajuan->id) }}" 
                                                       class="btn btn-sm btn-warning" 
                                                       title="Edit">
                                                        <i class="ti ti-edit"></i>
                                                    </a>
                                                    <form action="{{ route('pengajuan.destroy', $pengajuan->id) }}" 
                                                          method="POST" 
                                                          onsubmit="return confirm('Yakin ingin menghapus pengajuan ini?')" 
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
                                            <td colspan="6" class="text-center py-4">
                                                <i class="ti ti-inbox f-36 text-muted"></i>
                                                <p class="text-muted">Belum ada pengajuan surat</p>
                                                <a href="{{ route('pengajuan.create') }}" class="btn btn-sm btn-primary">
                                                    <i class="ti ti-plus me-1"></i> Ajukan Surat Baru
                                                </a>
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
@endsection