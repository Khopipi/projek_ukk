@extends('layouts.dashboard')
@section('title', 'Buat Pengaduan Baru')
@section('content')
    <div class="pc-content">
        <!-- Breadcrumb -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('pengaduan.index') }}">Pengaduan</a></li>
                            <li class="breadcrumb-item" aria-current="page">Buat Pengaduan</li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Buat Pengaduan Baru</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="row">
            <div class="col-sm-12">
                <form action="{{ route('pengaduan.store') }}" method="POST" enctype="multipart/form-data" id="formPengaduan">
                    @csrf

                    <div class="card">
                        <div class="card-header">
                            <h5><i class="ti ti-alert-triangle me-2"></i>Informasi Pengaduan</h5>
                        </div>
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <strong>Terdapat kesalahan:</strong>
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Kategori Pengaduan <span class="text-danger">*</span></label>
                                        <select name="kategori" class="form-select @error('kategori') is-invalid @enderror" required>
                                            <option value="">-- Pilih Kategori --</option>
                                            @foreach($kategoris as $kategori)
                                                <option value="{{ $kategori }}" {{ old('kategori') == $kategori ? 'selected' : '' }}>
                                                    {{ $kategori }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('kategori')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Lokasi Kejadian</label>
                                        <input type="text" name="lokasi" class="form-control @error('lokasi') is-invalid @enderror"
                                               value="{{ old('lokasi') }}" placeholder="Contoh: Jl. Mangga RT 02/RW 03">
                                        @error('lokasi')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">Judul Pengaduan <span class="text-danger">*</span></label>
                                        <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror"
                                               value="{{ old('judul') }}" required placeholder="Ringkasan singkat pengaduan Anda">
                                        @error('judul')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">Isi Pengaduan <span class="text-danger">*</span></label>
                                        <textarea name="isi_pengaduan" class="form-control @error('isi_pengaduan') is-invalid @enderror"
                                                  rows="5" required placeholder="Jelaskan secara detail pengaduan Anda...">{{ old('isi_pengaduan') }}</textarea>
                                        @error('isi_pengaduan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Upload Foto -->
                    <div class="card">
                        <div class="card-header">
                            <h5><i class="ti ti-photo me-2"></i>Lampiran Foto (Opsional)</h5>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-info">
                                <i class="ti ti-info-circle me-2"></i>
                                <strong>Informasi:</strong> Upload foto pendukung untuk memperkuat pengaduan Anda.
                                File harus berformat JPG, JPEG, atau PNG dengan ukuran maksimal 2MB per file.
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Foto 1</label>
                                        <input type="file" name="foto_1" class="form-control @error('foto_1') is-invalid @enderror"
                                               accept="image/jpeg,image/png,image/jpg">
                                        <small class="text-muted">Format: JPG, PNG | Max: 2MB</small>
                                        @error('foto_1')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <a href="{{ route('pengaduan.index') }}" class="btn btn-secondary">
                                <i class="ti ti-x"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-send"></i> Kirim Pengaduan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts_content')
<script>
    // Disable submit button after form submission
    document.getElementById('formPengaduan').addEventListener('submit', function() {
        const submitBtn = this.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Mengirim...';
    });
</script>
@endsection
