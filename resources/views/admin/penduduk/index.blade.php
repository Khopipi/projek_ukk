@extends('layouts.dashboard')
@section('title', 'Data Penduduk')
@section('content')
    <div class="pc-content">
        <!-- Breadcrumb -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                            <li class="breadcrumb-item" aria-current="page">Data Penduduk</li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Data Penduduk</h2>
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
                        <h5>Daftar Penduduk</h5>
                        <a href="{{ route('penduduk.create') }}" class="btn btn-primary">
                            <i class="ti ti-plus"></i> Tambah Data
                        </a>
                    </div>
                    <div class="card-body">
                        <!-- Filter & Search -->
                        <form method="GET" action="{{ route('penduduk.index') }}" class="mb-4">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <input type="text" name="search" class="form-control" 
                                           placeholder="Cari NIK/Nama/KK..." value="{{ request('search') }}">
                                </div>
                                <div class="col-md-3">
                                    <select name="jenis_kelamin" class="form-select">
                                        <option value="">Semua Jenis Kelamin</option>
                                        <option value="Laki-laki" {{ request('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="Perempuan" {{ request('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select name="status_perkawinan" class="form-select">
                                        <option value="">Semua Status</option>
                                        <option value="Belum Kawin" {{ request('status_perkawinan') == 'Belum Kawin' ? 'selected' : '' }}>Belum Kawin</option>
                                        <option value="Kawin" {{ request('status_perkawinan') == 'Kawin' ? 'selected' : '' }}>Kawin</option>
                                        <option value="Cerai Hidup" {{ request('status_perkawinan') == 'Cerai Hidup' ? 'selected' : '' }}>Cerai Hidup</option>
                                        <option value="Cerai Mati" {{ request('status_perkawinan') == 'Cerai Mati' ? 'selected' : '' }}>Cerai Mati</option>
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
                                        <th>Foto</th>
                                        <th>NIK</th>
                                        <th>Nama Lengkap</th>
                                        <th>L/P</th>
                                        <th>TTL</th>
                                        <th>Umur</th>
                                        <th>Alamat</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($penduduks as $index => $penduduk)
                                        <tr>
                                            <td>{{ $penduduks->firstItem() + $index }}</td>
                                            <td>
                                                <img src="{{ $penduduk->foto_url }}" 
                                                     alt="Foto" 
                                                     class="img-fluid rounded-circle" 
                                                     style="width: 40px; height: 40px; object-fit: cover;">
                                            </td>
                                            <td>{{ $penduduk->nik }}</td>
                                            <td>{{ $penduduk->nama_lengkap }}</td>
                                            <td>
                                                <span class="badge {{ $penduduk->jenis_kelamin == 'Laki-laki' ? 'bg-primary' : 'bg-danger' }}">
                                                    {{ $penduduk->jenis_kelamin == 'Laki-laki' ? 'L' : 'P' }}
                                                </span>
                                            </td>
                                            <td>{{ $penduduk->tempat_lahir }}, {{ $penduduk->tanggal_lahir->format('d-m-Y') }}</td>
                                            <td>{{ $penduduk->umur }} tahun</td>
                                            <td>RT {{ $penduduk->rt }}/RW {{ $penduduk->rw }}</td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('penduduk.show', $penduduk->id) }}" 
                                                       class="btn btn-sm btn-info" title="Detail">
                                                        <i class="ti ti-eye"></i>
                                                    </a>
                                                    <a href="{{ route('penduduk.edit', $penduduk->id) }}" 
                                                       class="btn btn-sm btn-warning" title="Edit">
                                                        <i class="ti ti-edit"></i>
                                                    </a>
                                                    <form action="{{ route('penduduk.destroy', $penduduk->id) }}" 
                                                          method="POST" 
                                                          onsubmit="return confirm('Yakin ingin menghapus data ini?')" 
                                                          class="d-inline">
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
                                            <td colspan="9" class="text-center">Tidak ada data penduduk</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div>
                                Menampilkan {{ $penduduks->firstItem() ?? 0 }} - {{ $penduduks->lastItem() ?? 0 }} 
                                dari {{ $penduduks->total() }} data
                            </div>
                            <div>
                                {{ $penduduks->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection