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
                    <a href="{{ route('pengajuan.create') }}" class="btn btn-lg btn-light text-primary me-2 shadow-sm" style="box-shadow:0 6px 14px rgba(102,126,234,0.18);">
                        <i class="ti ti-plus me-1"></i> Ajukan Surat
                    </a>
                    <a href="{{ route('pengaduan.create') }}" class="btn btn-lg btn-outline-light text-white me-2" style="border-color: rgba(255,255,255,0.35);">
                        <i class="ti ti-message-circle me-1"></i> Buat Pengaduan
                    </a>
                    @if (Route::has('profile.show'))
                        {{-- Avatar button with dropdown for profile actions --}}
                        <div class="dropdown">
                            <button class="btn btn-lg btn-white bg-white d-flex align-items-center shadow-sm" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="padding:6px 10px;border-radius:10px;">
                                <img src="{{ $avatarUrl }}" alt="avatar" onerror="this.style.display='none'" class="rounded-circle me-2" style="width:36px;height:36px;object-fit:cover;">
                                <div class="text-start">
                                    <div style="font-weight:700;color:#0b5ed7;">{{ Str::limit(Auth::user()->name,18) }}</div>
                                    <small class="text-muted">{{ ucfirst(Auth::user()->role) }}</small>
                                </div>
                                <i class="ti ti-chevron-down ms-3 text-muted"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="profileDropdown">
                                <li><a class="dropdown-item" href="{{ route('profile.show') }}"><i class="ti ti-user me-2"></i> Profil Saya</a></li>
                                @if(Route::has('user.biodata') && Auth::user()->role === 'admin')
                                    <li><a class="dropdown-item" href="{{ route('user.biodata') }}"><i class="ti ti-file-text me-2"></i> Edit Biodata</a></li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger"><i class="ti ti-logout me-2"></i> Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
