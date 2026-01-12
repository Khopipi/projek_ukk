@extends('layouts.dashboard')
@section('title', 'Riwayat Download Surat')
@section('content')
    <div class="pc-content">
        <!-- Breadcrumb -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.pengajuan.index') }}">Verifikasi Pengajuan</a></li>
                            <li class="breadcrumb-item" aria-current="page">Riwayat Download</li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Riwayat Download Surat</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center justify-content-between">
                            <h5>Total: {{ $totalDownloads }} kali download</h5>
                            <a href="{{ route('admin.pengajuan.index') }}" class="btn btn-secondary btn-sm">
                                <i class="ti ti-arrow-left me-1"></i> Kembali
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($histories->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Nomor Pengajuan</th>
                                        <th>Jenis Surat</th>
                                        <th>Didownload Oleh</th>
                                        <th>File</th>
                                        <th>IP Address</th>
                                        <th>Waktu Download</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($histories as $history)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <a href="{{ route('admin.pengajuan.show', $history->pengajuan->id) }}" class="text-primary">
                                                {{ $history->pengajuan->nomor_pengajuan }}
                                            </a>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">
                                                {{ $history->pengajuan->data_tambahan['jenis_surat_asli'] ?? $history->pengajuan->jenis_surat }}
                                            </span>
                                        </td>
                                        <td>
                                            <strong>{{ $history->user->name ?? 'Unknown' }}</strong><br>
                                            <small class="text-muted">{{ $history->user->email ?? '-' }}</small>
                                        </td>
                                        <td>
                                            <code>{{ basename($history->filename) }}</code>
                                        </td>
                                        <td>
                                            <code>{{ $history->ip_address ?? '-' }}</code>
                                        </td>
                                        <td>
                                            <small>{{ $history->created_at->format('d M Y H:i:s') }}</small><br>
                                            <small class="text-muted">{{ $history->created_at->diffForHumans() }}</small>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-4">
                            {{ $histories->links() }}
                        </div>
                        @else
                        <div class="alert alert-info text-center">
                            <i class="ti ti-info-circle me-2"></i>
                            Belum ada riwayat download.
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
