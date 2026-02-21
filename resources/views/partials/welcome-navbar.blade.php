<div class="pc-welcome-navbar mb-4">
    <style>
        @keyframes wave {
            0% { transform: rotate(0deg); }
            15% { transform: rotate(14deg); }
            30% { transform: rotate(-8deg); }
            40% { transform: rotate(14deg); }
            50% { transform: rotate(-4deg); }
            60% { transform: rotate(10deg); }
            70% { transform: rotate(0deg); }
            100% { transform: rotate(0deg); }
        }

        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.7;
            }
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .welcome-text-animated {
            animation: slideInLeft 0.8s ease-out forwards;
        }

        .welcome-text-animated:nth-child(1) {
            animation-delay: 0.1s;
        }

        .welcome-text-animated:nth-child(2) {
            animation-delay: 0.2s;
        }
    </style>
    <div class="container-fluid">
        <div class="p-4 rounded-3" style="background: linear-gradient(135deg, #0084ff 0%, #00d4ff 50%, #0f3460 100%); box-shadow: 0 15px 50px rgba(0, 132, 255, 0.4);">
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
                                $bg = '#0084ff';
                                if ($gender) {
                                    if (stripos($gender, 'laki') !== false || stripos($gender, 'l') === 0) {
                                        $bg = '#0084ff';
                                    } elseif (stripos($gender, 'perempuan') !== false || stripos($gender, 'p') === 0) {
                                        $bg = '#00d4ff';
                                    }
                                }
                                $size = 140;
                                $svg = "<svg xmlns='http://www.w3.org/2000/svg' width='$size' height='$size' viewBox='0 0 $size $size'>".
                                       "<rect width='100%' height='100%' rx='50%' fill='$bg'/>".
                                       "<text x='50%' y='54%' font-family='Arial, Helvetica, sans-serif' font-size='".($size*0.36)."' fill='#000000' text-anchor='middle' dominant-baseline='middle'>".$initials."</text>".
                                       "</svg>";
                                $avatarUrl = 'data:image/svg+xml;utf8,'.rawurlencode($svg);
                            }
                        @endphp
                        <div class="rounded-circle bg-white d-flex align-items-center justify-content-center" style="width:72px;height:72px;box-shadow:0 8px 25px rgba(0, 212, 255, 0.4);overflow:hidden;border:4px solid #00d4ff;">
                            <img src="{{ $avatarUrl }}" alt="avatar" onerror="this.style.display='none'" style="width:100%;height:100%;object-fit:cover;">
                            <div style="position:absolute;color:#0084ff;font-weight:700;font-size:1.15rem;">{{ $initials }}</div>
                        </div>
                    </div>
                    <div class="text-white">
                        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 6px;">
                            <h2 class="mb-0 fw-bold" style="font-size:1.9rem; color: #ffffff; text-shadow: 0 3px 10px rgba(0,0,0,0.5); letter-spacing: 0.5px;">
                                Selamat Datang, <span style="background: linear-gradient(135deg, #ffeb3b 0%, #ffc107 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">{{ Auth::user()->name }}!</span>
                            </h2>
                            <span style="font-size: 2rem; animation: wave 0.6s ease-in-out infinite;" data-wave="👋">👋</span>
                        </div>
                        <p class="mb-0" style="color: rgba(255,255,255,0.95); text-shadow: 0 2px 5px rgba(0,0,0,0.4); font-size:0.96rem; letter-spacing: 0.3px;">
                            <i class="ti ti-sparkles" style="color: #ffeb3b; margin-right: 6px;"></i>
                            <span style="display: inline-block;">{{ Auth::user()->is_verified ? '✓ Akun Anda terverifikasi' : '⚠ Verifikasi email untuk akses penuh' }} • Lihat ringkasan & mulai ajukan surat</span>
                        </p>
                        <div style="margin-top: 8px; display: flex; gap: 10px; flex-wrap: wrap;">
                            <span class="badge" style="background: rgba(255, 235, 59, 0.25); color: #ffeb3b; border: 1px solid rgba(255, 235, 59, 0.5); font-size: 10px; font-weight: 700; padding: 4px 10px;">
                                <i class="ti ti-files" style="margin-right: 4px;"></i>{{ Auth::user()->pengajuanSurat()->count() }} Pengajuan
                            </span>
                            <span class="badge" style="background: rgba(0, 212, 255, 0.25); color: #00d4ff; border: 1px solid rgba(0, 212, 255, 0.5); font-size: 10px; font-weight: 700; padding: 4px 10px;">
                                <i class="ti ti-message-circle" style="margin-right: 4px;"></i>{{ Auth::user()->pengaduans()->count() }} Pengaduan
                            </span>
                            @if(Auth::user()->pengajuanSurat()->where('status', 'Menunggu')->exists())
                            <span class="badge" style="background: rgba(255, 193, 7, 0.25); color: #ffc107; border: 1px solid rgba(255, 193, 7, 0.5); font-size: 10px; font-weight: 700; padding: 4px 10px; animation: pulse 2s infinite;">
                                <i class="ti ti-clock-hour-4" style="margin-right: 4px;"></i>{{ Auth::user()->pengajuanSurat()->where('status', 'Menunggu')->count() }} Menunggu
                            </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('pengajuan.create') }}" class="btn btn-lg text-dark fw-bold" style="background: linear-gradient(135deg, #00d4ff 0%, #0084ff 100%); border: none; box-shadow: 0 8px 25px rgba(0, 212, 255, 0.5);">
                        <i class="ti ti-plus me-1"></i> AJUKAN SURAT
                    </a>
                    <a href="{{ route('pengaduan.create') }}" class="btn btn-lg text-white fw-bold" style="background: rgba(255, 255, 255, 0.15); border: 2px solid rgba(255,255,255,0.5); backdrop-filter: blur(10px);">
                        <i class="ti ti-message-circle me-1"></i> BUAT PENGADUAN
                    </a>
                    @auth
                        @if (Route::has('profile.show'))
                            <a href="{{ route('profile.show') }}" class="btn btn-lg text-dark fw-bold" style="background: #00d4ff; border: none; padding: 10px 14px; box-shadow: 0 6px 20px rgba(0, 212, 255, 0.4);">
                                <i class="ti ti-user"></i>
                            </a>
                        @endif

                        {{-- Visible logout button (placed next to Profile) --}}
                        <form method="POST" action="{{ route('logout') }}" class="m-0">
                            @csrf
                            <button type="submit" class="btn btn-lg text-white fw-bold" style="background: rgba(255, 68, 68, 0.25); border: 2px solid #ff4444;">
                                <i class="ti ti-power me-1"></i> LOGOUT
                            </button>
                        </form>
                    @else
                        @if (Route::has('login'))
                            <a href="{{ route('login') }}" class="btn btn-lg text-white fw-bold" style="background: rgba(0, 132, 255, 0.25); border: 2px solid #0084ff;">
                                <i class="ti ti-login me-1"></i> LOGIN
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
