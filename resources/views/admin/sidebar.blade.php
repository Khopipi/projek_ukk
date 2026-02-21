<style>
    :root {
        --primary: #0084ff;
        --primary-dark: #0066cc;
        --secondary: #00d4ff;
        --accent: #ff006e;
        --success: #00d084;
        --warning: #ffb800;
        --danger: #ff4444;
    }

    /* ===== SIDEBAR ITEMS WRAPPER ===== */
    .pc-navbar ul {
        padding: 12px 0 !important;
    }

    /* ===== COMMON LINK STYLING ===== */
    .pc-navbar .pc-item {
        margin: 12px 8px !important;
        border-radius: 16px !important;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1) !important;
        position: relative;
    }

    .pc-navbar .pc-item::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        width: 5px;
        height: 0;
        background: linear-gradient(180deg, #00d4ff, #0084ff);
        transition: height 0.3s ease !important;
        z-index: 1;
    }

    .pc-navbar .pc-item:hover::before {
        height: 100%;
    }

    .pc-navbar .pc-item .pc-link {
        transition: all 0.3s ease !important;
        border-radius: 14px !important;
        padding: 16px 20px !important;
        position: relative;
        overflow: visible;
        font-weight: 600 !important;
        font-size: 14px !important;
        letter-spacing: 0.3px !important;
        display: flex !important;
        align-items: center !important;
    }

    .pc-navbar .pc-item .pc-link:hover {
        background: rgba(0, 132, 255, 0.25) !important;
        box-shadow: 0 4px 16px rgba(0, 132, 255, 0.3) !important;
        transform: translateX(10px) !important;
        padding-left: 30px !important;
    }

    .pc-navbar .pc-item .pc-link.active,
    .pc-navbar .pc-item.active .pc-link {
        background: linear-gradient(135deg, #0084ff 0%, #00d4ff 100%) !important;
        font-weight: 700 !important;
        box-shadow: 0 10px 30px rgba(0, 212, 255, 0.5) !important;
        transform: none !important;
        border-left: none !important;
    }

    /* ===== ICON STYLING ===== */
    .pc-micon {
        position: relative !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        font-size: 20px !important;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
        margin-right: 14px !important;
    }

    .pc-navbar .pc-item .pc-link:hover .pc-micon {
        transform: scale(1.1) !important;
    }

    .pc-navbar .pc-item .pc-link.active .pc-micon,
    .pc-navbar .pc-item.active .pc-link .pc-micon {
        transform: scale(1.15) !important;
    }

    /* ===== TEXT STYLING ===== */
    .pc-mtext {
        font-weight: 600 !important;
        letter-spacing: 0.3px !important;
        font-size: 14px !important;
    }



    /* ===== RESPONSIVE ===== */
    @media (max-width: 767px) {
        .pc-navbar .pc-item .pc-link {
            padding: 12px 18px !important;
            font-size: 13px !important;
        }

        .badge-icon {
            display: none !important;
        }
    }

    /* =====================================================
       ✅ DARK FONT OVERRIDE (TANPA MENGUBAH YANG LAIN)
       ===================================================== */
    .pc-navbar .pc-item .pc-link {
        color: #1f2937 !important;
    }

    .pc-navbar .pc-item .pc-link .pc-mtext {
        color: #1f2937 !important;
    }

    .pc-navbar .pc-item .pc-link:hover {
        color: #111827 !important;
    }

    .pc-navbar .pc-item .pc-link.active,
    .pc-navbar .pc-item.active .pc-link {
        color: #0f172a !important;
    }

    .pc-navbar .pc-item .pc-link.active .pc-mtext,
    .pc-navbar .pc-item.active .pc-link .pc-mtext {
        color: #0f172a !important;
    }

    /* =====================================================
       🔔 NOTIFICATION BADGE STYLING
       ===================================================== */
    .badge-notification {
        position: absolute !important;
        right: 12px !important;
        top: 50% !important;
        transform: translateY(-50%) !important;
        background: linear-gradient(135deg, #ff4444 0%, #ff1744 100%) !important;
        color: white !important;
        border-radius: 50% !important;
        min-width: 28px !important;
        height: 28px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        font-weight: 800 !important;
        font-size: 11px !important;
        box-shadow: 0 4px 12px rgba(255, 17, 68, 0.4) !important;
        animation: pulse-badge 2s ease-in-out infinite !important;
        z-index: 10 !important;
    }

    .pc-navbar .pc-item:hover .badge-notification {
        animation: pulse-badge-active 0.6s ease-in-out infinite !important;
        box-shadow: 0 6px 16px rgba(255, 17, 68, 0.6) !important;
    }

    @keyframes pulse-badge {
        0%, 100% {
            transform: translateY(-50%) scale(1);
            opacity: 1;
        }
        50% {
            transform: translateY(-50%) scale(1.1);
            opacity: 0.9;
        }
    }

    @keyframes pulse-badge-active {
        0%, 100% {
            transform: translateY(-50%) scale(1.15);
            opacity: 1;
        }
        50% {
            transform: translateY(-50%) scale(1.25);
            opacity: 0.95;
        }
    }

    .pc-navbar .pc-item .pc-link.active .badge-notification,
    .pc-navbar .pc-item.active .pc-link .badge-notification {
        background: linear-gradient(135deg, #fff200 0%, #ffb300 100%) !important;
        color: #000 !important;
        box-shadow: 0 4px 16px rgba(255, 179, 0, 0.6) !important;
    }
</style>


<li class="pc-item">
    <a href="{{ route('admin.pengajuan.index') }}" class="pc-link sidebar-pengajuan" style="position: relative;">
        <span class="pc-micon"><i class="ti ti-file-check"></i></span>
        <span class="pc-mtext">Verifikasi Pengajuan</span>
        @php
            $pengajuanMenunggu = \App\Models\PengajuanSurat::where('status', 'Menunggu')->count();
        @endphp
        @if($pengajuanMenunggu > 0)
            <span class="badge-notification" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: linear-gradient(135deg, #ff4444 0%, #ff1744 100%); color: white; border-radius: 50%; min-width: 28px; height: 28px; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 11px; box-shadow: 0 4px 12px rgba(255, 17, 68, 0.4); z-index: 10;">{{ $pengajuanMenunggu }}</span>
        @endif
    </a>
</li>

<li class="pc-item">
    <a href="{{ route('admin.pengaduan.index') }}" class="pc-link sidebar-pengaduan" style="position: relative;">
        <span class="pc-micon"><i class="ti ti-message-circle"></i></span>
        <span class="pc-mtext">Verifikasi Pengaduan</span>
        @php
            $pengaduanMenunggu = \App\Models\Pengaduan::where('status', 'Menunggu')->count();
        @endphp
        @if($pengaduanMenunggu > 0)
            <span class="badge-notification" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: linear-gradient(135deg, #ff4444 0%, #ff1744 100%); color: white; border-radius: 50%; min-width: 28px; height: 28px; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 11px; box-shadow: 0 4px 12px rgba(255, 17, 68, 0.4); z-index: 10;">{{ $pengaduanMenunggu }}</span>
        @endif
    </a>
</li>


<li class="pc-item">
    <a href="{{ route('penduduk.index') }}" class="pc-link sidebar-penduduk">
        <span class="pc-micon"><i class="ti ti-users"></i></span>
        <span class="pc-mtext">pendataan Penduduk</span>
    </a>
</li>

<li class="pc-item">
    <a href="{{ route('admin.kematian.index') }}" class="pc-link sidebar-kematian">
        <span class="pc-micon"><i class="ti ti-coffin"></i></span>
        <span class="pc-mtext">pendataan Kematian</span>
    </a>
</li>
