@extends('layouts.dashboard')
@section('title', 'Detail & Verifikasi Pengajuan')
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
                            <h2 class="mb-0">Detail & Verifikasi Pengajuan</h2>
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
            <!-- Left Column - Status & Actions -->
            <div class="col-lg-4">
                <!-- Status Card -->
                <div class="card">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <span class="badge {{ $pengajuan->status_badge }} p-3" style="font-size: 1.2rem;">
                                {{ $pengajuan->status }}
                            </span>
                        </div>
                        {{-- Tracking status langkah: Dikirim -> Diproses -> Selesai --}}
                        @php
                            $step = 1;
                            if ($pengajuan->status === 'Diproses') $step = 2;
                            if (in_array($pengajuan->status, ['Disetujui','Selesai'])) $step = 3;
                        @endphp
                        <div class="mb-3">
                            <div style="display:flex;align-items:center;gap:0.5rem;">
                                @php
                                    $ts_dikirim = $pengajuan->data_tambahan['ts_dikirim'] ?? $pengajuan->created_at?->toDateTimeString();
                                    $ts_diproses = $pengajuan->data_tambahan['ts_diproses'] ?? null;
                                    $ts_selesai = $pengajuan->tanggal_selesai?->toDateTimeString() ?? $pengajuan->data_tambahan['ts_selesai'] ?? null;
                                @endphp

                                @foreach(['Dikirim','Diproses','Selesai'] as $i => $label)
                                    @php $idx = $i + 1; $active = $idx <= $step; @endphp
                                    <div style="flex:1;text-align:center;">
                                        <div style="width:44px;height:44px;margin:0 auto;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:600;" class="{{ $active ? 'bg-success text-white' : 'bg-light text-muted' }}">
                                            {{ $idx }}
                                        </div>
                                        <div style="font-size:0.85rem;margin-top:6px;" class="{{ $active ? 'text-success' : 'text-muted' }}">{{ $label }}</div>
                                        <div style="font-size:0.75rem;margin-top:4px;" class="text-muted">
                                            @if($label === 'Dikirim')
                                                {{ $ts_dikirim ? \Carbon\Carbon::parse($ts_dikirim)->format('H:i, d F Y') : '-' }}
                                            @elseif($label === 'Diproses')
                                                {{ $ts_diproses ? \Carbon\Carbon::parse($ts_diproses)->format('H:i, d F Y') : '-' }}
                                            @else
                                                {{ $ts_selesai ? \Carbon\Carbon::parse($ts_selesai)->format('H:i, d F Y') : '-' }}
                                            @endif
                                        </div>
                                    </div>
                                    @if($i < 2)
                                        <div style="width:20px;height:2px;background:{{ $step > $i+1 ? '#28a745' : '#e9ecef' }};align-self:center;margin:0 4px;border-radius:2px;"></div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        
                        <h4 class="mb-1">{{ $pengajuan->nomor_pengajuan }}</h4>
                        <p class="text-muted mb-3">Nomor Pengajuan</p>
                        
                        <div class="text-start mb-3">
                            <p class="mb-2">
                                <i class="{{ $pengajuan->jenis_surat_icon }} me-2 text-primary"></i>
                                <strong>Jenis Surat:</strong><br>
                                <span class="ms-4">{{ $pengajuan->data_tambahan['jenis_surat_asli'] ?? $pengajuan->jenis_surat }}</span>
                            </p>
                            <p class="mb-2">
                                <i class="ti ti-calendar me-2 text-success"></i>
                                <strong>Tanggal Ajuan:</strong><br>
                                <span class="ms-4">{{ optional($pengajuan->created_at)->format('d F Y, H:i') ?? '-' }}</span>
                            </p>
                            
                            @if($pengajuan->admin)
                            <p class="mb-2">
                                <i class="ti ti-user-check me-2 text-info"></i>
                                <strong>Diproses Oleh:</strong><br>
                                <span class="ms-4">{{ $pengajuan->admin->name }}</span>
                            </p>
                            @endif

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
                    </div>
                </div>

                @if($pengajuan->jenis_surat === 'Surat Akta Kematian')
                <div class="card">
                    <div class="card-header">
                        <h5><i class="ti ti-heart-broken me-2"></i>Data Almarhum / Almarhumah</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="text-muted mb-1">Nama</label>
                                <p class="fw-bold">{{ $pengajuan->data_tambahan['nama_almarhum'] ?? '-' }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-muted mb-1">Tempat Lahir</label>
                                <p class="fw-bold">{{ $pengajuan->data_tambahan['tempat_lahir_almarhum'] ?? '-' }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-muted mb-1">Tanggal Lahir</label>
                                <p class="fw-bold">{{ isset($pengajuan->data_tambahan['tanggal_lahir_almarhum']) ? \Carbon\Carbon::parse($pengajuan->data_tambahan['tanggal_lahir_almarhum'])->format('d F Y') : '-' }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-muted mb-1">Dimakamkan di</label>
                                <p class="fw-bold">{{ $pengajuan->data_tambahan['tempat_makam'] ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                @if($pengajuan->jenis_surat === 'Surat Domisili')
                <div class="card">
                    <div class="card-header">
                        <h5><i class="ti ti-file-text me-2"></i>Surat Pengantar RT/RW</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @if($pengajuan->data_tambahan['doc_foto_pengantar_rt'] ?? null)
                            <div class="col-md-6 mb-3">
                                <div class="border rounded p-3 text-center" style="background-color: #f8f9fa;">
                                    <div class="mb-3">
                                        <i class="ti ti-file-pdf" style="font-size: 48px; color: #ef4444;"></i>
                                    </div>
                                    <h6 class="mb-2">Foto Surat Pengantar dari RT</h6>
                                    <div class="d-flex gap-2 justify-content-center">
                                        <a href="{{ asset('storage/' . $pengajuan->data_tambahan['doc_foto_pengantar_rt']) }}" class="btn btn-sm btn-outline-primary" target="_blank">
                                            <i class="ti ti-eye me-1"></i> Lihat
                                        </a>
                                        <a href="{{ asset('storage/' . $pengajuan->data_tambahan['doc_foto_pengantar_rt']) }}" class="btn btn-sm btn-outline-success" download>
                                            <i class="ti ti-download me-1"></i> Download
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endif

                            @if($pengajuan->data_tambahan['doc_foto_pengantar_rw'] ?? null)
                            <div class="col-md-6 mb-3">
                                <div class="border rounded p-3 text-center" style="background-color: #f8f9fa;">
                                    <div class="mb-3">
                                        <i class="ti ti-file-pdf" style="font-size: 48px; color: #ef4444;"></i>
                                    </div>
                                    <h6 class="mb-2">Foto Surat Pengantar dari RW</h6>
                                    <div class="d-flex gap-2 justify-content-center">
                                        <a href="{{ asset('storage/' . $pengajuan->data_tambahan['doc_foto_pengantar_rw']) }}" class="btn btn-sm btn-outline-primary" target="_blank">
                                            <i class="ti ti-eye me-1"></i> Lihat
                                        </a>
                                        <a href="{{ asset('storage/' . $pengajuan->data_tambahan['doc_foto_pengantar_rw']) }}" class="btn btn-sm btn-outline-success" download>
                                            <i class="ti ti-download me-1"></i> Download
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endif

                <!-- Action Buttons -->
                <div class="card">
                    <div class="card-header">
                        <h5>Aksi Verifikasi</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            @if($pengajuan->status == 'Menunggu')
                            <form action="{{ route('admin.pengajuan.proses', $pengajuan->id) }}" method="POST" class="process-form">
                                @csrf
                                <button type="submit" class="btn btn-warning w-100 process-btn">
                                    <span class="btn-text"><i class="ti ti-refresh me-1"></i> Tandai Diproses</span>
                                    <span class="spinner-border spinner-border-sm ms-2 d-none" role="status" aria-hidden="true"></span>
                                </button>
                            </form>
                            @endif

                            @if(in_array($pengajuan->status, ['Menunggu', 'Diproses']))
                            <form action="{{ route('admin.pengajuan.approve', $pengajuan->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="ti ti-check me-1"></i> Setujui Pengajuan
                                </button>
                            </form>
                            
                            <form action="{{ route('admin.pengajuan.reject', $pengajuan->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="catatan_admin" value="Ditolak oleh admin">
                                <button type="submit" class="btn btn-danger w-100">
                                    <i class="ti ti-x me-1"></i> Tolak Pengajuan
                                </button>
                            </form>
                            @endif

                            @if($pengajuan->status == 'Disetujui')
                            <button type="button" class="btn btn-primary w-100 mb-2" data-bs-toggle="modal" data-bs-target="#uploadModal">
                                <i class="ti ti-upload me-1"></i> Upload Surat Hasil
                            </button>
                            @endif

                            @if($pengajuan->status == 'Disetujui')
                            <form action="{{ route('admin.pengajuan.send-pdf', $pengajuan->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success w-100 mb-2">
                                    <i class="ti ti-mail me-1"></i> Kirim Email ke User
                                </button>
                            </form>
                            @endif

                            {{-- Preview Surat & Generate PDF --}}
                            <a href="{{ route('admin.pengajuan.preview-surat', $pengajuan->id) }}" class="btn btn-outline-primary w-100 mb-2">
                                <i class="ti ti-eye me-1"></i> Preview Surat
                            </a>

                            @if($pengajuan->file_surat_hasil)
                            <form action="{{ route('admin.pengajuan.delete-surat', $pengajuan->id) }}" method="POST" onsubmit="return confirmDelete(event)">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger w-100 delete-btn" onclick="this.disabled = true; this.querySelector('.btn-text')?.classList.add('d-none'); this.querySelector('.spinner-border')?.classList.remove('d-none');">
                                    <span class="btn-text"><i class="ti ti-trash me-1"></i> Hapus File Surat</span>
                                    <span class="spinner-border spinner-border-sm ms-2 d-none" role="status" aria-hidden="true"></span>
                                </button>
                            </form>
                            @endif

                            <hr>
                            
                            <a href="{{ route('admin.pengajuan.index') }}" class="btn btn-secondary w-100">
                                <i class="ti ti-arrow-left me-1"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Info Pemohon (Akun) -->
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
                        <p class="mb-0"><strong>Bergabung:</strong> {{ optional($pengajuan->user->created_at)->format('d M Y') ?? '-' }}</p>
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
                                <label class="mb-1" style="color: #808080;">Nama Lengkap</label>
                                <p class="fw-bold">{{ $pengajuan->nama_pemohon }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="mb-1" style="color: #808080;">NIK</label>
                                <p class="fw-bold">{{ $pengajuan->nik_pemohon }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="mb-1" style="color: #808080;">Tempat, Tanggal Lahir</label>
                                <p class="fw-bold">{{ $pengajuan->tempat_lahir_pemohon }}, {{ optional($pengajuan->tanggal_lahir_pemohon)->format('d F Y') ?? '-' }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="mb-1" style="color: #808080;">Jenis Kelamin</label>
                                <p class="fw-bold">{{ $pengajuan->jenis_kelamin_pemohon }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="mb-1" style="color: #808080;">Pekerjaan</label>
                                <p class="fw-bold">{{ $pengajuan->pekerjaan_pemohon }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="mb-1" style="color: #808080;">No. Telepon</label>
                                <p class="fw-bold">{{ $pengajuan->no_telepon_pemohon }}</p>
                            </div>
                            <div class="col-md-12 mb-0">
                                <label class="mb-1" style="color: #808080;">Alamat</label>
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
                            <!-- Base Documents (KTP & KK) - Shown only for types that use them -->
                            @if(in_array($pengajuan->jenis_surat, ['Surat Tanah', 'Surat Domisili']))
                            <div class="col-md-6 mb-3">
                                <label class="mb-2" style="color: #808080;">
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
                                <label class="mb-2" style="color: #808080;">
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
                            @endif

                            <!-- Special Documents for specific surat types -->
                            @php
                                $specialDocs = $pengajuan->getSpecialDocuments();
                            @endphp
                            
                            @if(count($specialDocs) > 0)
                            <div class="col-md-12">
                                <hr>
                                <h6 class="mb-3" style="color: #808080;">Dokumen Khusus untuk {{ $pengajuan->data_tambahan['jenis_surat_asli'] ?? $pengajuan->jenis_surat }}</h6>
                            </div>
                            
                            @foreach($specialDocs as $fieldName => $doc)
                            <div class="col-lg-4 col-md-6 mb-3">
                                <label class="mb-2" style="color: #808080;">
                                    <i class="ti ti-file me-1"></i> {{ $doc['label'] }}
                                </label>
                                <div>
                                    <a href="{{ $doc['url'] }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="ti ti-eye me-1"></i> Lihat
                                    </a>
                                    <a href="{{ $doc['url'] }}" download class="btn btn-sm btn-outline-success">
                                        <i class="ti ti-download me-1"></i> Download
                                    </a>
                                </div>
                            </div>
                            @endforeach
                            @endif

                            <!-- Optional Supporting Documents -->
                            @if($pengajuan->file_pendukung_1_url || $pengajuan->file_pendukung_2_url || $pengajuan->file_pendukung_3_url)
                            <div class="col-md-12">
                                <hr>
                                <h6 class="mb-3" style="color: #808080;">Dokumen Pendukung Tambahan</h6>
                            </div>
                            
                            @if($pengajuan->file_pendukung_1_url)
                            <div class="col-md-4 mb-3">
                                <label class="mb-2" style="color: #808080;">
                                    <i class="ti ti-file me-1"></i> Dokumen Pendukung 1
                                </label>
                                <div>
                                    <a href="{{ $pengajuan->file_pendukung_1_url }}" target="_blank" class="btn btn-sm btn-outline-info">
                                        <i class="ti ti-eye me-1"></i> Lihat
                                    </a>
                                    <a href="{{ $pengajuan->file_pendukung_1_url }}" download class="btn btn-sm btn-outline-success">
                                        <i class="ti ti-download me-1"></i> Download
                                    </a>
                                </div>
                            </div>
                            @endif

                            @if($pengajuan->file_pendukung_2_url)
                            <div class="col-md-4 mb-3">
                                <label class="mb-2" style="color: #808080;">
                                    <i class="ti ti-file me-1"></i> Dokumen Pendukung 2
                                </label>
                                <div>
                                    <a href="{{ $pengajuan->file_pendukung_2_url }}" target="_blank" class="btn btn-sm btn-outline-info">
                                        <i class="ti ti-eye me-1"></i> Lihat
                                    </a>
                                    <a href="{{ $pengajuan->file_pendukung_2_url }}" download class="btn btn-sm btn-outline-success">
                                        <i class="ti ti-download me-1"></i> Download
                                    </a>
                                </div>
                            </div>
                            @endif

                            @if($pengajuan->file_pendukung_3_url)
                            <div class="col-md-4 mb-3">
                                <label class="mb-2" style="color: #808080;">
                                    <i class="ti ti-file me-1"></i> Dokumen Pendukung 3
                                </label>
                                <div>
                                    <a href="{{ $pengajuan->file_pendukung_3_url }}" target="_blank" class="btn btn-sm btn-outline-info">
                                        <i class="ti ti-eye me-1"></i> Lihat
                                    </a>
                                    <a href="{{ $pengajuan->file_pendukung_3_url }}" download class="btn btn-sm btn-outline-success">
                                        <i class="ti ti-download me-1"></i> Download
                                    </a>
                                </div>
                            </div>
                            @endif
                            @endif

                            @if(count($specialDocs) == 0 && !$pengajuan->file_pendukung_1_url && !$pengajuan->file_pendukung_2_url && !$pengajuan->file_pendukung_3_url)
                            <div class="col-md-12">
                                <p class="text-muted text-center">Tidak ada dokumen yang diupload</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
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
                        <button type="submit" class="btn btn-primary submit-btn">
                            <span class="btn-text"><i class="ti ti-upload me-1"></i> Upload</span>
                            <span class="spinner-border spinner-border-sm ms-2 d-none" role="status" aria-hidden="true"></span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts_content')
<script>
    // Confirmation modal dengan popup custom
    function confirmDelete(event) {
        event.preventDefault();
        const form = event.target;
        
        // Tampilkan popup konfirmasi
        const existingModal = document.getElementById('custom-confirm-modal');
        if (existingModal) existingModal.remove();
        
        const backdrop = document.createElement('div');
        backdrop.id = 'custom-confirm-modal';
        backdrop.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 99998;
            animation: fadeIn 0.3s ease-out;
        `;
        
        const modal = document.createElement('div');
        modal.style.cssText = `
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            max-width: 400px;
            width: 90%;
            text-align: center;
            animation: popupIn 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        `;
        
        modal.innerHTML = `
            <div style="font-size: 48px; margin-bottom: 20px;">⚠️</div>
            <h3 style="color: #2d3748; font-size: 20px; font-weight: 700; margin: 0 0 12px 0;">Hapus File Surat?</h3>
            <p style="color: #718096; margin: 0 0 30px 0; line-height: 1.5;">Anda yakin ingin menghapus file surat hasil ini? Tindakan ini tidak dapat dibatalkan.</p>
            <div style="display: flex; gap: 12px;">
                <button id="cancelBtn" type="button" style="flex: 1; padding: 10px; border: 1px solid #ccc; background: white; color: #2d3748; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.3s ease;">
                    Batal
                </button>
                <button id="confirmBtn" type="button" style="flex: 1; padding: 10px; border: none; background: #ef4444; color: white; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.3s ease;">
                    Ya, Hapus
                </button>
            </div>
        `;
        
        backdrop.appendChild(modal);
        document.body.appendChild(backdrop);
        
        // Add animations if not exists
        let styleSheet = document.getElementById('confirm-animations');
        if (!styleSheet) {
            styleSheet = document.createElement('style');
            styleSheet.id = 'confirm-animations';
            styleSheet.textContent = `
                @keyframes fadeIn {
                    from { opacity: 0; }
                    to { opacity: 1; }
                }
                @keyframes popupIn {
                    0% { opacity: 0; transform: scale(0.3); }
                    100% { opacity: 1; transform: scale(1); }
                }
                @keyframes popupOut {
                    0% { opacity: 1; transform: scale(1); }
                    100% { opacity: 0; transform: scale(0.3); }
                }
            `;
            document.head.appendChild(styleSheet);
        }
        
        const cancelBtn = document.getElementById('cancelBtn');
        const confirmBtn = document.getElementById('confirmBtn');
        
        cancelBtn.addEventListener('click', function() {
            backdrop.style.opacity = '0';
            setTimeout(() => backdrop.remove(), 300);
        });
        
        confirmBtn.addEventListener('click', function() {
            backdrop.remove();
            form.submit();
        });
        
        return false;
    }

    // Create beautiful modern popup
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
        
        // Add animations if not exists
        let styleSheet = document.getElementById('toast-animations');
        if (!styleSheet) {
            styleSheet = document.createElement('style');
            styleSheet.id = 'toast-animations';
            styleSheet.textContent = `
                @keyframes popupIn {
                    0% {
                        opacity: 0;
                        transform: translate(-50%, -50%) scale(0.3);
                    }
                    100% {
                        opacity: 1;
                        transform: translate(-50%, -50%) scale(1);
                    }
                }
                @keyframes bounce {
                    0%, 100% { transform: scale(1); }
                    50% { transform: scale(1.2); }
                }
                @keyframes popupOut {
                    0% {
                        opacity: 1;
                        transform: translate(-50%, -50%) scale(1);
                    }
                    100% {
                        opacity: 0;
                        transform: translate(-50%, -50%) scale(0.3);
                    }
                }
            `;
            document.head.appendChild(styleSheet);
        }
        
        // Auto remove
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
                
                const submitBtn = this.querySelector('button[type="submit"]');
                let message = 'Memproses Data...';
                let icon = '⏳';
                
                if (submitBtn) {
                    const btnText = submitBtn.textContent.trim();
                    if (btnText.includes('Setuju')) {
                        message = '✓ Pengajuan Disetujui!';
                        icon = '✓';
                    } else if (btnText.includes('Tolak')) {
                        message = '✗ Pengajuan Ditolak!';
                        icon = '✗';
                    } else if (btnText.includes('Diproses')) {
                        message = '⏳ Pengajuan Sedang Diproses...';
                        icon = '⏳';
                    } else if (btnText.includes('Tanggapi')) {
                        message = '📝 Tanggapan Diproses...';
                        icon = '📝';
                    } else if (btnText.includes('Selesai')) {
                        message = '✓ Pengaduan Diselesaikan!';
                        icon = '✓';
                    } else if (btnText.includes('Hapus')) {
                        message = '🗑️ Data Dihapus!';
                        icon = '🗑️';
                    } else if (btnText.includes('Upload')) {
                        message = '📤 File Terupload!';
                        icon = '📤';
                    } else if (btnText.includes('Kirim')) {
                        message = '✉️ Email Terkirim!';
                        icon = '✉️';
                    }
                    
                    // Tampilkan spinner dan sembunyikan teks
                    const btnText_el = submitBtn.querySelector('.btn-text');
                    const spinner = submitBtn.querySelector('.spinner-border');
                    if (btnText_el && spinner) {
                        btnText_el.classList.add('d-none');
                        spinner.classList.remove('d-none');
                    }
                    
                    submitBtn.disabled = true;
                }
                
                showCustomToast(message, icon);
            });
        });
    });

    // Auto-hide alerts
    setTimeout(function() {
        if (typeof bootstrap === 'undefined') return;
        const alerts = document.querySelectorAll('.alert-dismissible');
        alerts.forEach(alert => {
            try {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            } catch (e) {}
        });
    }, 5000);
</script>
</script>
@endsection