<div class="pc-welcome-navbar mb-4">
    <div class="container-fluid">
        <div class="p-4 rounded-3" style="background: linear-gradient(90deg, #6a11cb 0%, #2575fc 100%);">
            <div class="d-flex flex-column flex-md-row align-items-center justify-content-between gap-3">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        {{-- Avatar with circular frame and subtle border/shadow --}}
                        @php
                            // Build avatar url: prefer uploaded avatar, otherwise generate SVG placeholder by gender
                            $avatarUrl = Auth::user()->avatar ?? null;
                            $initials = collect(explode(' ', trim(Auth::user()->name)))->map(function($p){return strtoupper(substr($p,0,1));})->take(2)->join('');
                            if (!$avatarUrl) {
                                $gender = Auth::user()->jenis_kelamin ?? null;
                                $bg = '#6a11cb';
                                if ($gender) {
                                    if (stripos($gender, 'laki') !== false || stripos($gender, 'l') === 0) {
                                        $bg = '#2575fc';
                                    } elseif (stripos($gender, 'perempuan') !== false || stripos($gender, 'p') === 0) {
                                        $bg = '#ff6b81';
                                    }
                                }
                                $size = 140;
                                $svg = "<svg xmlns='http://www.w3.org/2000/svg' width='$size' height='$size' viewBox='0 0 $size $size'>".
                                       "<rect width='100%' height='100%' rx='50%' fill='$bg'/>".
                                       "<text x='50%' y='54%' font-family='Arial, Helvetica, sans-serif' font-size='".($size*0.36)."' fill='#ffffff' text-anchor='middle' dominant-baseline='middle'>".$initials."</text>".
                                       "</svg>";
                                $avatarUrl = 'data:image/svg+xml;utf8,'.rawurlencode($svg);
                            }
                        @endphp
                        <div class="rounded-circle bg-white d-flex align-items-center justify-content-center" style="width:72px;height:72px;box-shadow:0 6px 18px rgba(0,0,0,0.18);overflow:hidden;border:3px solid rgba(255,255,255,0.12);">
                            <img src="{{ $avatarUrl }}" alt="avatar" onerror="this.style.display='none'" style="width:100%;height:100%;object-fit:cover;">
                            <div style="position:absolute;color:#3b82f6;font-weight:700;font-size:1.15rem;">{{ $initials }}</div>
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
                    @auth
                        @if (Route::has('profile.show'))
                            <a href="{{ route('profile.show') }}" class="btn btn-lg btn-white bg-white text-primary me-2" style="padding:10px 14px;">
                                <i class="ti ti-user"></i>
                            </a>
                        @endif

                        {{-- Visible logout button (placed next to Profile) --}}
                        <form method="POST" action="{{ route('logout') }}" class="m-0">
                            @csrf
                            <button type="submit" class="btn btn-lg btn-outline-light text-white" style="border-color: rgba(255,255,255,0.35);">
                                <i class="ti ti-power me-1"></i> Logout
                            </button>
                        </form>
                    @else
                        @if (Route::has('login'))
                            <a href="{{ route('login') }}" class="btn btn-lg btn-outline-light text-white me-2" style="border-color: rgba(255,255,255,0.35);">
                                <i class="ti ti-login me-1"></i> Login
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
