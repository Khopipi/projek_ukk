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
                            <li class="breadcrumb-item"><a href="{{ route('admin.pengajuan.index') }}">Verifikasi Pengajuan</a></li>
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
            <!-- Left Column - Info & Actions -->
            <div class="col-lg-4">
                <!-- Status Card -->
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
                            
                            @if($pengajuan->admin)
                            <p class="mb-2">
                                <i class="ti ti-user-check me-2 text-info"></i>
                                <strong>Diproses Oleh:</strong><br>
                                <span class="ms-4">{{ $pengajuan->admin->name }}</span>
                            </p>
                            @endif
                        </div>

                        @if($pengajuan->catatan_admin)
                        <div class="alert alert-info text-start">
                            <strong><i class="ti ti-message-circle me-1"></i> Catatan Admin:</strong>
                            <p class="mb-0 mt-2">{{ $pengajuan->catatan_admin }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="card">
                    <div class="card-header">
                        <h5>Aksi</h5>
                    </div>
                    <div class="card-body">
                        @if($pengajuan->status == 'Menunggu')
                        <form action="{{ route('admin.pengajuan.proses', $pengajuan->id) }}" method="POST" class="mb-2">
                            @csrf
                            <button type="submit" class="btn btn-info w-100">
                                <i class="ti ti-refresh me-1"></i> Proses Pengajuan
                            </button>
                        </form>
                        @endif

                        @if(in_array($pengajuan->status, ['Menunggu', 'Diproses']))
                        <button type="button" class="btn btn-success w-100 mb-2" data-bs-toggle="modal" data-bs-target="#approveModal">
                            <i class="ti ti-check me-1"></i> Setujui
                        </button>
                        
                        <button type="button" class="btn btn-danger w-100 mb-2" data-bs-toggle="modal" data-bs-target="#rejectModal">
                            <i class="ti ti-x me-1"></i> Tolak
                        </button>
                        @endif

                        @if($pengajuan->status == 'Disetujui')
                        <button type="button" class="btn btn-primary w-100 mb-2" data-bs-toggle="modal" data-bs-target="#uploadModal">
                            <i class="ti ti-upload me-1"></i> Upload Surat Hasil
                        </button>
                        @endif

                        @if($pengajuan->file_surat_hasil)
                        <a href="{{ $pengajuan->file_surat_hasil_url }}" target="_blank" class="btn btn-success w-100 mb-2">
                            <i class="ti ti-download me-1"></i> Lihat Surat Hasil
                        </a>
                        
                        <form action="{{ route('admin.pengajuan.delete-surat', $pengajuan->id) }}" method="POST" onsubmit="return confirm('Yakin hapus file surat?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger w-100 mb-2">
                                <i class="ti ti-trash me-1"></i> Hapus File Surat
                            </button>
                        </form>
                        @endif

                        <hr>
                        
                        <a href="{{ route('admin.pengajuan.index') }}" class="btn btn-secondary w-100">
                            <i class="ti ti-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                </div>

                <!-- Info Pemohon -->
                <div class="card">
                    <div class="card-header">
                        <h5>Info Akun Pemohon</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="flex-shrink-0">
                                <div class="avtar avtar-l bg-light-primary">
                                    <i class="ti ti-user f-24"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-0">{{ $pengajuan->user->name }}</h6>
                                <small class="text-muted">{{ $pengajuan->user->email }}</small>
                            </div>
                        </div>
                        <p class="mb-1"><strong>Role:</strong> {{ ucfirst($pengajuan->user->role) }}</p>
                        <p class="mb-0"><strong>Bergabung:</strong> {{ $pengajuan->user->created_at->format('d M Y') }}</p>
                    </div>
                </div>
            </div>

            <!-- Right Column - Details -->
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
                                    <a href="{{ $pengajuan->file_ktp_url }}" download class="btn btn-sm btn-outline-success">
                                        <i class="ti ti-download me-1"></i> Download
                                    </a>
                                </div>
                                @else
                                <p class="text-muted mb-0">Tidak ada file</p>
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
                                    <a href="{{ $pengajuan->file_kk_url }}" download class="btn btn-sm btn-outline-success">
                                        <i class="ti ti-download me-1"></i> Download
                                    </a>
                                </div>
                                @else
                                <p class="text-muted mb-0">Tidak ada file</p>
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

    <!-- Approve Modal -->
    <div class="modal fade" id="approveModal" tabindex="-1">
        <div class="modal-dialog">
            <form action="{{ route('admin.pengajuan.approve', $pengajuan->id) }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title">Setujui Pengajuan</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p>Apakah Anda yakin ingin menyetujui pengajuan ini?</p>
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
    <div class="modal fade" id="rejectModal" tabindex="-1">
        <div class="modal-dialog">
            <form action="{{ route('admin.pengajuan.reject', $pengajuan->id) }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title">Tolak Pengajuan</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p>Apakah Anda yakin ingin menolak pengajuan ini?</p>
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

    <!-- Upload Surat Modal -->
    <div class="modal fade" id="uploadModal" tabindex="-1">
        <div class="modal-dialog">
            <form action="{{ route('admin.pengajuan.upload-surat', $pengajuan->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Upload Surat Hasil</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-info">
                            <i class="ti ti-info-circle me-1"></i>
                            Upload file surat hasil dalam format PDF (max 5MB)
                        </div>
                        <div class="form-group">
                            <label class="form-label">File Surat Hasil (PDF) <span class="text-danger">*</span></label>
                            <input type="file" name="file_surat_hasil" class="form-control" accept=".pdf" required>
                            <small class="text-muted">Format: PDF | Max: 5MB</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-upload me-1"></i> Upload
                        </button>
                    </div>
                </div>
            </form>
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