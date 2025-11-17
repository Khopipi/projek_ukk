<div class="pc-welcome-navbar mb-4">
    <div class="container-fluid">
        <div class="p-4 rounded-3" style="background: linear-gradient(90deg, #6a11cb 0%, #2575fc 100%);">
            <div class="d-flex flex-column flex-md-row align-items-center justify-content-between gap-3">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <div class="rounded-circle bg-white d-flex align-items-center justify-content-center" style="width:64px;height:64px;">
                            <i class="ti ti-user f-28 text-primary"></i>
                        </div>
                    </div>
                    <div class="text-white">
                        <h2 class="mb-0 fw-bold" style="font-size:1.6rem; color: #ffffff; text-shadow: 0 2px 6px rgba(0,0,0,0.45);">Selamat Datang, {{ Auth::user()->name }}!</h2>
                        <p class="mb-0" style="color: rgba(255,255,255,0.95); text-shadow: 0 1px 3px rgba(0,0,0,0.35);">Lihat ringkasan terbaru dan aksi cepat untuk memulai.</p>
                    </div>
                </div>

                <div class="d-flex align-items-center">
                    <a href="{{ route('pengajuan.create') }}" class="btn btn-lg btn-light text-primary me-2 shadow-sm">
                        <i class="ti ti-plus me-1"></i> Ajukan Surat
                    </a>
                    <a href="{{ route('pengaduan.create') }}" class="btn btn-lg btn-outline-light text-white me-2" style="border-color: rgba(255,255,255,0.35);">
                        <i class="ti ti-message-circle me-1"></i> Buat Pengaduan
                    </a>
                    @if (Route::has('profile.show'))
                        <a href="{{ route('profile.show') }}" class="btn btn-lg btn-white bg-white text-primary" style="padding:10px 14px;">
                            <i class="ti ti-user"></i>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
