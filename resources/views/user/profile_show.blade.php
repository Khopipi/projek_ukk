@extends('layouts.dashboard')
@section('title', 'Profil Saya')
@section('content')
<div class="pc-content">
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item" aria-current="page">Profil Saya</li>
                    </ul>
                </div>
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h2 class="mb-0">Profil Saya</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Data Registrasi</h5>
                    <a href="{{ route('user.profile.edit') }}" class="btn btn-sm btn-primary">Ubah Profil</a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label class="fw-bold">NIK</label>
                            <div class="border rounded p-2">{{ $user->nik ?? '-' }}</div>
                        </div>

                        <div class="col-12 mb-3">
                            <label class="fw-bold">Nomor KK</label>
                            <div class="border rounded p-2">{{ $user->no_kk ?? '-' }}</div>
                        </div>

                        <div class="col-12 mb-3">
                            <label class="fw-bold">Nama Lengkap</label>
                            <div class="border rounded p-2">{{ $user->name ?? '-' }}</div>
                        </div>

                        <div class="col-12 mb-3">
                            <label class="fw-bold">Tempat, Tanggal Lahir</label>
                            <div class="border rounded p-2">{{ $user->tempat_lahir ?? '-' }}, {{ optional($user->tanggal_lahir)->format('d M Y') ?? '-' }}</div>
                        </div>

                        <div class="col-12 mb-3">
                            <label class="fw-bold">Jenis Kelamin</label>
                            <div class="border rounded p-2">{{ $user->jenis_kelamin ?? '-' }}</div>
                        </div>

                        <div class="col-12 mb-3">
                            <label class="fw-bold">Pekerjaan</label>
                            <div class="border rounded p-2">{{ $user->pekerjaan ?? '-' }}</div>
                        </div>

                        <div class="col-12 mb-3">
                            <label class="fw-bold">No. Telepon</label>
                            <div class="border rounded p-2">{{ $user->no_telepon ?? '-' }}</div>
                        </div>

                        <div class="col-12 mb-3">
                            <label class="fw-bold">Alamat Lengkap</label>
                            <div class="border rounded p-2">{{ $user->alamat_lengkap ?? $user->alamat ?? '-' }}</div>
                        </div>

                        <div class="col-12 mb-3">
                            <label class="fw-bold">Desa</label>
                            <div class="border rounded p-2">{{ $user->desa ?? '-' }}</div>
                        </div>

                        <div class="col-12 mb-3">
                            <label class="fw-bold">Kecamatan</label>
                            <div class="border rounded p-2">{{ $user->kecamatan ?? '-' }}</div>
                        </div>

                        <div class="col-12 mb-3">
                            <label class="fw-bold">Kabupaten / Provinsi</label>
                            <div class="border rounded p-2">{{ $user->kabupaten ?? '-' }} / {{ $user->provinsi ?? '-' }}</div>
                        </div>

                        <div class="col-12 mb-3">
                            <label class="fw-bold">Agama</label>
                            <div class="border rounded p-2">{{ $user->agama ?? '-' }}</div>
                        </div>

                        <div class="col-12 mb-3">
                            <label class="fw-bold">Status Perkawinan</label>
                            <div class="border rounded p-2">{{ $user->status_perkawinan ?? '-' }}</div>
                        </div>

                        <div class="col-12 mb-3">
                            <label class="fw-bold">Pendidikan Terakhir</label>
                            <div class="border rounded p-2">{{ $user->pendidikan_terakhir ?? '-' }}</div>
                        </div>

                        <div class="col-12 mb-3">
                            <label class="fw-bold">Email</label>
                            <div class="border rounded p-2">{{ $user->email ?? '-' }}</div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
