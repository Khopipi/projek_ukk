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

    /* ===== ADMIN SIDEBAR STYLING - MATCH USER THEME ===== */
    /* These will be overridden by dashboard.blade.php but kept here for clarity */
    
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
        color: #e0e7ff !important;
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
        color: #ffffff !important;
        background: rgba(0, 132, 255, 0.25) !important;
        box-shadow: 0 4px 16px rgba(0, 132, 255, 0.3) !important;
        transform: translateX(10px) !important;
        padding-left: 30px !important;
    }

    .pc-navbar .pc-item .pc-link.active,
    .pc-navbar .pc-item.active .pc-link {
        background: linear-gradient(135deg, #0084ff 0%, #00d4ff 100%) !important;
        color: #000 !important;
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
        color: inherit !important;
    }

    /* ===== BADGE ICON ANIMATION ===== */
    .badge-icon {
        position: absolute !important;
        font-size: 16px !important;
        margin-left: 28px !important;
        margin-top: -8px !important;
        display: inline-block !important;
        animation: float-elegant 2.5s ease-in-out infinite !important;
    }

    .pc-navbar .pc-item .pc-link.active .badge-icon,
    .pc-navbar .pc-item.active .pc-link .badge-icon {
        animation: float-active 2.5s ease-in-out infinite !important;
    }

    @keyframes float-elegant {
        0% {
            transform: translateY(0px) rotate(0deg) scale(1);
            opacity: 0.7;
        }
        50% {
            transform: translateY(-6px) rotate(-3deg) scale(1.1);
            opacity: 1;
        }
        100% {
            transform: translateY(0px) rotate(0deg) scale(1);
            opacity: 0.7;
        }
    }

    @keyframes float-active {
        0% {
            transform: translateY(0px) rotate(0deg) scale(1.1);
            opacity: 1;
        }
        50% {
            transform: translateY(-8px) rotate(5deg) scale(1.2);
            opacity: 1;
        }
        100% {
            transform: translateY(0px) rotate(0deg) scale(1.1);
            opacity: 1;
        }
    }

    /* ===== SIDEBAR SPECIFIC ANIMATIONS ===== */
    .sidebar-penduduk .badge-icon { animation-delay: 0s; }
    .sidebar-pengajuan .badge-icon { animation-delay: 0.3s; }
    .sidebar-pengaduan .badge-icon { animation-delay: 0.6s; }
    .sidebar-kematian .badge-icon { animation-delay: 0.9s; }

    /* ===== SEPARATOR LINE ===== */
    .pc-navbar::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 1px;
        background: rgba(0, 132, 255, 0.1);
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 767px) {
        .pc-navbar .pc-item .pc-link {
            padding: 12px 18px !important;
            font-size: 13px !important;
        }

        .pc-micon {
            min-width: auto !important;
            min-height: auto !important;
        }

        .badge-icon {
            display: none !important;
        }
    }
</style>

<li class="pc-item">
    <a href="{{ route('penduduk.index') }}" class="pc-link sidebar-penduduk">
        <span class="pc-micon">
            <i class="ti ti-users"></i>
        </span>
        <span class="pc-mtext">Data Penduduk</span>
        <span class="badge-icon">👥</span>
    </a>
</li>
<li class="pc-item">
    <a href="{{ route('admin.pengajuan.index') }}" class="pc-link sidebar-pengajuan">
        <span class="pc-micon">
            <i class="ti ti-file-check"></i>
        </span>
        <span class="pc-mtext">Verifikasi Pengajuan</span>
        <span class="badge-icon">✅</span>
    </a>
</li>
<li class="pc-item">
    <a href="{{ route('admin.pengaduan.index') }}" class="pc-link sidebar-pengaduan">
        <span class="pc-micon">
            <i class="ti ti-message-circle"></i>
        </span>
        <span class="pc-mtext">Verifikasi Pengaduan</span>
        <span class="badge-icon">💬</span>
    </a>
</li>
<li class="pc-item">
    <a href="{{ route('admin.kematian.index') }}" class="pc-link sidebar-kematian">
        <span class="pc-micon">
            <i class="ti ti-death-icon"></i>
        </span>
        <span class="pc-mtext">Data Kematian</span>
        <span class="badge-icon">⚰️</span>
    </a>
</li>
