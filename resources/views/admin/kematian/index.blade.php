@extends('layouts.dashboard')
@section('title', 'Data Kematian Penduduk')
@section('content')
    <div class="pc-content">
        <!-- Breadcrumb -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                            <li class="breadcrumb-item" aria-current="page">Data Kematian</li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0"><i class="ti ti-death-icon me-2"></i>Data Kematian Penduduk</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="row">
            <div class="col-sm-12">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5>Daftar Data Kematian</h5>
                        <a href="{{ route('admin.kematian.create') }}" class="btn btn-primary">
                            <i class="ti ti-plus"></i> Tambah Data Kematian
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Penduduk</th>
                                        <th>NIK</th>
                                        <th>Tanggal Kematian</th>
                                        <th>Penyebab</th>
                                        <th>Tempat Kematian</th>
                                        <th>Input Oleh</th>
                                        <th>Tanggal Input</th>
                                        <th class="w-1">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($kematians as $key => $kematian)
                                    <tr>
                                        <td>{{ $kematians->firstItem() + $key }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-grow-1">
                                                    @if($kematian->nama_warga)
                                                        <h6 class="mb-0">{{ $kematian->nama_warga }}</h6>
                                                        <small class="text-muted">(Input Bebas)</small>
                                                    @elseif($kematian->penduduk)
                                                        <h6 class="mb-0">{{ $kematian->penduduk->nama_lengkap }}</h6>
                                                    @else
                                                        <h6 class="mb-0 text-muted">-</h6>
                                                    @endif
                                                </div>
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
                                            <span class="badge bg-danger">
                                                {{ $kematian->tanggal_kematian->format('d M Y') }}
                                            </span>
                                        </td>
                                        <td>{{ $kematian->penyebab_kematian ?? '-' }}</td>
                                        <td>{{ $kematian->tempat_kematian ?? '-' }}</td>
                                        <td>
                                            <span class="badge bg-light text-dark">{{ $kematian->input_oleh ?? 'Admin' }}</span>
                                        </td>
                                        <td>{{ $kematian->created_at->format('d M Y H:i') }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.kematian.show', $kematian->id) }}" 
                                                   class="btn btn-sm btn-info" title="Lihat">
                                                    <i class="ti ti-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.kematian.edit', $kematian->id) }}" 
                                                   class="btn btn-sm btn-warning" title="Edit">
                                                    <i class="ti ti-pencil"></i>
                                                </a>
                                                <form action="{{ route('admin.kematian.destroy', $kematian->id) }}" 
                                                      method="POST" class="d-inline" 
                                                      onsubmit="return confirm('Yakin ingin menghapus?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                        <i class="ti ti-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="9" class="text-center py-4">
                                            <i class="ti ti-inbox text-muted" style="font-size: 2rem;"></i>
                                            <p class="text-muted mt-2">Belum ada data kematian</p>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        @if($kematians->hasPages())
                        <div class="d-flex justify-content-end mt-3">
                            {{ $kematians->links() }}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
