@extends('layouts.dashboard')
@section('title', 'Detail Data Kematian')
@section('content')
    <div class="pc-content">
        <!-- Breadcrumb -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.kematian.index') }}">Data Kematian</a></li>
                            <li class="breadcrumb-item" aria-current="page">Detail</li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0"><i class="ti ti-death-icon me-2"></i>Detail Data Kematian</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="row">
            <div class="col-md-8 mx-auto">
                <!-- Data Penduduk -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="card-title">Identitas Penduduk</h5>
                    </div>
                    <div class="card-body">
                        @if($kematian->nama_warga)
                            <div class="alert alert-info">
                                <strong>Nama Warga (Input Bebas):</strong> {{ $kematian->nama_warga }}
                            </div>
                        @elseif($kematian->penduduk)
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-2">
                                        <strong>Nama:</strong><br>
                                        {{ $kematian->penduduk->nama_lengkap }}
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-2">
                                        <strong>NIK:</strong><br>
                                        {{ $kematian->penduduk->nik }}
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-2">
                                        <strong>Tempat, Tanggal Lahir:</strong><br>
                                        {{ $kematian->penduduk->tempat_lahir }}, {{ $kematian->penduduk->tanggal_lahir->format('d M Y') }}
                                    </p>
                                </div>
                                <div class="col-md-6">
                                <p class="mb-0">
                                    <strong>Jenis Kelamin:</strong><br>
                                    {{ $kematian->penduduk->jenis_kelamin }}
                                </p>
                            </div>
                        </div>
                        @else
                            <div class="alert alert-warning">
                                <strong>Catatan:</strong> Data penduduk tidak tersedia (kemungkinan input bebas)
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Data Kematian -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="card-title">Informasi Kematian</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-2">
                                    <strong>Tanggal Kematian:</strong><br>
                                    <span class="badge bg-danger">{{ $kematian->tanggal_kematian->format('d M Y') }}</span>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-2">
                                    <strong>Penyebab Kematian:</strong><br>
                                    {{ $kematian->penyebab_kematian ?? '-' }}
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-2">
                                    <strong>Tempat Kematian:</strong><br>
                                    {{ $kematian->tempat_kematian ?? '-' }}
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-2">
                                    <strong>Lokasi:</strong><br>
                                    {{ $kematian->rs_atau_rumah ?? '-' }}
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-2">
                                    <strong>Usia Saat Meninggal:</strong><br>
                                    {{ $kematian->usia_saat_meninggal ?? '-' }}
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-0">
                                    <strong>Diperiksa Oleh:</strong><br>
                                    {{ $kematian->nama_diperiksa_oleh ?? '-' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Keterangan -->
                @if($kematian->keterangan)
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="card-title">Keterangan</h5>
                    </div>
                    <div class="card-body">
                        {{ $kematian->keterangan }}
                    </div>
                </div>
                @endif

                <!-- Data Input -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="card-title">Data Input</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-0">
                                    <strong>Input Oleh:</strong><br>
                                    <span class="badge bg-light text-dark">{{ $kematian->input_oleh ?? 'Admin' }}</span>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-0">
                                    <strong>Tanggal Input:</strong><br>
                                    {{ $kematian->created_at->format('d M Y H:i') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.kematian.edit', $kematian->id) }}" class="btn btn-warning">
                        <i class="ti ti-pencil me-1"></i>Edit
                    </a>
                    <a href="{{ route('admin.kematian.index') }}" class="btn btn-secondary">
                        <i class="ti ti-arrow-left me-1"></i>Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
