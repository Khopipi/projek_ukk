@extends('layouts.app')

@section('title', 'Verifikasi Tanda Tangan Digital')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if($valid && $pengajuan)
                <!-- Valid Signature -->
                <div class="card border-0 shadow-lg" style="max-width: 600px; width: 100%;">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-check-circle"></i> Tanda Tangan Digital Terverifikasi
                        </h5>
                    </div>
                    <div class="card-body p-4">

                        <div class="card mb-3">
                            <div class="card-header bg-light">
                                <h5 class="mb-0">Data Surat</h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-borderless">
                                    <tr>
                                        <th style="width: 200px;">Nomor Surat</th>
                                        <td><strong>{{ $pengajuan->nomor_pengajuan }}</strong></td>
                                    </tr>
                                    <tr>
                                        <th>Jenis Surat</th>
                                        <td>{{ $pengajuan->jenis_surat }}</td>
                                    </tr>
                                    <tr>
                                        <th>Nama Pemohon</th>
                                        <td>{{ $pengajuan->nama_pemohon }}</td>
                                    </tr>
                                    <tr>
                                        <th>NIK</th>
                                        <td>{{ $pengajuan->nik_pemohon }}</td>
                                    </tr>
                                    <tr>
                                        <th>Keperluan</th>
                                        <td>{{ $pengajuan->keperluan }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>
                                            @if($pengajuan->status === 'Selesai')
                                                <span class="badge bg-success">Selesai</span>
                                            @elseif($pengajuan->status === 'Diproses')
                                                <span class="badge bg-primary">Diproses</span>
                                            @elseif($pengajuan->status === 'Ditolak')
                                                <span class="badge bg-danger">Ditolak</span>
                                            @else
                                                <span class="badge bg-warning">{{ $pengajuan->status }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Selesai</th>
                                        <td>
                                            @if($pengajuan->tanggal_selesai)
                                                {{ $pengajuan->tanggal_selesai->format('d F Y H:i') }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Tanda Tangan Digital</th>
                                        <td>
                                            @if($pengajuan->signature_generated_at)
                                                <span class="text-success">
                                                    <i class="fas fa-check-circle"></i> Ditandatangani
                                                </span>
                                                <br>
                                                <small class="text-muted">{{ $pengajuan->signature_generated_at->format('d F Y H:i:s') }}</small>
                                            @else
                                                <span class="text-warning">Belum ditandatangani</span>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="card mb-3 border-0 bg-light">
                            <div class="card-body">
                                <h6 class="card-title">
                                    <i class="fas fa-stamp text-success"></i> Ditandatangani Oleh
                                </h6>
                                <div class="fs-5 fw-bold text-dark">
                                    H. Saiful Imaduddin, SKM., M.Kes
                                </div>
                                <div class="small text-muted">
                                    Kepala Desa Sruni
                                </div>
                                @if($pengajuan && $pengajuan->signature_generated_at)
                                    <div class="small text-muted mt-2">
                                        <i class="fas fa-calendar-alt"></i> 
                                        Tanggal Tanda Tangan: {{ $pengajuan->signature_generated_at->format('d F Y H:i:s') }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> 
                            <strong>Informasi Keamanan:</strong> Surat ini telah ditandatangani secara digital oleh H. Saiful Imaduddin, SKM., M.Kes (Kepala Desa Sruni) dan dapat dipercaya.
                            Setiap surat memiliki token unik yang dapat diverifikasi untuk memastikan keaslian.
                        </div>

                        <div class="text-center mt-4">
                            <a href="{{ route('welcome') }}" class="btn btn-primary">
                                <i class="fas fa-home"></i> Kembali ke Beranda
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <!-- Invalid Signature -->
                <div class="card border-0 shadow-lg" style="max-width: 600px; width: 100%;">
                    <div class="card-header bg-danger text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-times-circle"></i> Tanda Tangan Digital Tidak Valid
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="alert alert-danger mb-3">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </div>

                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i> 
                            <strong>Perhatian:</strong> Surat ini tidak dapat diverifikasi. Hal ini mungkin terjadi karena:
                            <ul class="mt-2">
                                <li>QR Code rusak atau tidak terbaca dengan benar</li>
                                <li>Surat belum ditandatangani oleh Kepala Desa</li>
                                <li>Token signature telah kadaluarsa atau dihapus</li>
                            </ul>
                        </div>

                        <div class="text-center mt-4">
                            <a href="{{ route('welcome') }}" class="btn btn-primary">
                                <i class="fas fa-home"></i> Kembali ke Beranda
                            </a>
                            <a href="{{ route('login') }}" class="btn btn-secondary">
                                <i class="fas fa-sign-in-alt"></i> Login untuk Info Lanjutan
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    .card {
        border-radius: 12px;
    }
    
    .card-header {
        border-radius: 12px 12px 0 0;
        border: none;
        padding: 20px;
        font-weight: 600;
    }
    
    .card-body {
        padding: 30px;
    }
    
    .table th {
        background-color: transparent;
        font-weight: 600;
        color: #667eea;
        border: none;
        padding: 12px 0;
    }
    
    .table td {
        border: none;
        padding: 12px 0;
        border-bottom: 1px solid #e9ecef;
    }
    
    .table tr:last-child td {
        border-bottom: none;
    }
    
    .badge {
        padding: 6px 12px;
        border-radius: 6px;
        font-weight: 500;
        font-size: 0.875rem;
    }
    
    .alert {
        border: none;
        border-radius: 8px;
        border-left: 4px solid;
    }
    
    .alert-success {
        border-left-color: #10b981;
        background-color: #f0fdf4;
        color: #065f46;
    }
    
    .alert-danger {
        border-left-color: #ef4444;
        background-color: #fef2f2;
        color: #7f1d1d;
    }
    
    .alert-warning {
        border-left-color: #f59e0b;
        background-color: #fffbeb;
        color: #78350f;
    }
    
    .alert-info {
        border-left-color: #3b82f6;
        background-color: #eff6ff;
        color: #1e40af;
    }
    
    .bg-light {
        background-color: #f9fafb !important;
        border: 1px solid #e5e7eb;
    }
</style>
@endsection
