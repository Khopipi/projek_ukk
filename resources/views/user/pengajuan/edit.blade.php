@extends('layouts.dashboard')
@section('title', 'Detail Pengajuan Surat')
@section('content')
    <div class="pc-content">
        <!-- Breadcrumb -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('pengajuan.index') }}">Pengajuan Surat</a></li>
                            <li class="breadcrumb-item" aria-current="page">Detail</li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Detail Pengajuan Surat</h2>
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

        <div class="row">
            <!-- Status & Info Pengajuan -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <span class="badge {{ $pengajuan->status_badge }} p-3" style="font-size: 1.2rem;">
                                {{ $pengajuan->status }}
                            </span>
                        </div>
                        
                        <h4 class="mb-1">{{ $pengajuan->nomor_pengajuan }}</h4>
                        <p class="text-muted mb-3">Nomor Pengajuan</p>
                        
                        <div class="text-start mb-3">
                            <p class="mb-2">
                                <i class="{{ $pengajuan->jenis_surat_icon }} me-2 text-primary"></i>
                                <strong>Jenis Surat:</strong><br>
                                <span class="ms-4">{{ $pengajuan->jenis_surat }}</span>
                            </p>
                            <p class="mb-2">
                                <i class="ti ti-calendar me-2 text-success"></i>
                                <strong>Tanggal Ajuan:</strong><br>
                                <span class="ms-4">{{ $pengajuan->created_at->format('d F Y, H:i') }}</span>
                            </p>
                            
                            @if($pengajuan->tanggal_disetujui)
                            <p class="mb-2">
                                <i class="ti ti-check me-2 text-success"></i>
                                <strong>Disetujui:</strong><br>
                                <span class="ms-4">{{ $pengajuan->tanggal_disetujui->format('d F Y, H:i') }}</span>
                            </p>
                            @endif
                            
                            @if($pengajuan->tanggal_ditolak)
                            <p class="mb-2">
                                <i class="ti ti-x me-2 text-danger"></i>
                                <strong>Ditolak:</strong><br>
                                <span class="ms-4">{{ $pengajuan->tanggal_ditolak->format('d F Y, H:i') }}</span>
                            </p>
                            @endif
                            
                            @if($pengajuan->tanggal_selesai)
                            <p class="mb-0">
                                <i class="ti ti-circle-check me-2 text-primary"></i>
                                <strong>Selesai:</strong><br>
                                <span class="ms-4">{{ $pengajuan->tanggal_selesai->format('d F Y, H:i') }}</span>
                            </p>
                            @endif
                        </div>

                        @if($pengajuan->catatan_admin)
                        <div class="alert alert-info text-start mt-3">
                            <strong><i class="ti ti-message-circle me-1"></i> Catatan Admin:</strong>
                            <p class="mb-0 mt-2">{{ $pengajuan->catatan_admin }}</p>
                        </div>
                        @endif

                        @if($pengajuan->file_surat_hasil)
                        <div class="mt-3">
                            <a href="{{ $pengajuan->file_surat_hasil_url }}" target="_blank" class="btn btn-success w-100">
                                <i class="ti ti-download me-1"></i> Download Surat Hasil
                            </a>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="card">
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('pengajuan.index') }}" class="btn btn-secondary">
                                <i class="ti ti-arrow-left me-1"></i> Kembali
                            </a>
                            
                            @if($pengajuan->status == 'Menunggu')
                            <a href="{{ route('pengajuan.edit', $pengajuan->id) }}" class="btn btn-warning">
                                <i class="ti ti-edit me-1"></i> Edit Pengajuan
                            </a>
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                <i class="ti ti-trash me-1"></i> Batalkan Pengajuan
                            </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detail Data -->
            <div class="col-lg-8">
                <!-- Keperluan -->
                <div class="card">
                    <div class="card-header">
                        <h5><i class="ti ti-info-circle me-2"></i>Keperluan</h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-0">{{ $pengajuan->keperluan }}</p>
                    </div>
                </div>

                <!-- Data Pemohon -->
                <div class="card">
                    <div class="card-header">
                        <h5><i class="ti ti-user me-2"></i>Data Pemohon</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="text-muted mb-1">Nama Lengkap</label>
                                <p class="fw-bold">{{ $pengajuan->nama_pemohon }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-muted mb-1">NIK</label>
                                <p class="fw-bold">{{ $pengajuan->nik_pemohon }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-muted mb-1">Tempat, Tanggal Lahir</label>
                                <p class="fw-bold">{{ $pengajuan->tempat_lahir_pemohon }}, {{ $pengajuan->tanggal_lahir_pemohon->format('d F Y') }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-muted mb-1">Jenis Kelamin</label>
                                <p class="fw-bold">{{ $pengajuan->jenis_kelamin_pemohon }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-muted mb-1">Pekerjaan</label>
                                <p class="fw-bold">{{ $pengajuan->pekerjaan_pemohon }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-muted mb-1">No. Telepon</label>
                                <p class="fw-bold">{{ $pengajuan->no_telepon_pemohon }}</p>
                            </div>
                            <div class="col-md-12 mb-0">
                                <label class="text-muted mb-1">Alamat</label>
                                <p class="fw-bold mb-0">{{ $pengajuan->alamat_pemohon }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dokumen Upload -->
                <div class="card">
                    <div class="card-header">
                        <h5><i class="ti ti-file-upload me-2"></i>Dokumen Pendukung</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="text-muted mb-2">
                                    <i class="ti ti-id me-1"></i> Foto/Scan KTP
                                </label>
                                @if($pengajuan->file_ktp)
                                <div>
                                    <a href="{{ $pengajuan->file_ktp_url }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="ti ti-eye me-1"></i> Lihat Dokumen
                                    </a>
                                </div>
                                @else
                                <p class="text-muted mb-0">-</p>
                                @endif
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="text-muted mb-2">
                                    <i class="ti ti-users me-1"></i> Foto/Scan KK
                                </label>
                                @if($pengajuan->file_kk)
                                <div>
                                    <a href="{{ $pengajuan->file_kk_url }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="ti ti-eye me-1"></i> Lihat Dokumen
                                    </a>
                                </div>
                                @else
                                <p class="text-muted mb-0">-</p>
                                @endif
                            </div>

                            @for($i = 1; $i <= 3; $i++)
                                @php
                                    $field = "file_pendukung_{$i}";
                                @endphp
                                @if($pengajuan->$field)
                                <div class="col-md-4 mb-3">
                                    <label class="text-muted mb-2">
                                        <i class="ti ti-file me-1"></i> Dokumen Pendukung {{ $i }}
                                    </label>
                                    <div>
                                        <a href="{{ asset('storage/pengajuan/' . $pengajuan->$field) }}" target="_blank" class="btn btn-sm btn-outline-info">
                                            <i class="ti ti-eye me-1"></i> Lihat
                                        </a>
                                    </div>
                                </div>
                                @endif
                            @endfor
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    @if($pengajuan->status == 'Menunggu')
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Pembatalan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin membatalkan pengajuan surat ini?</p>
                    <div class="alert alert-warning">
                        <strong>{{ $pengajuan->nomor_pengajuan }}</strong><br>
                        {{ $pengajuan->jenis_surat }}
                    </div>
                    <p class="text-danger mb-0">
                        <i class="ti ti-alert-triangle me-1"></i>
                        Data yang sudah dibatalkan tidak dapat dikembalikan!
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                    <form action="{{ route('pengajuan.destroy', $pengajuan->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="ti ti-trash me-1"></i> Ya, Batalkan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif
@endsection