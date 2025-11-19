
<li class="pc-item {{ request()->routeIs('pengajuan.*') ? 'active' : '' }}">
    <a href="{{ route('pengajuan.index') }}" class="pc-link sidebar-pengajuan">
        <span class="pc-micon">
            <i class="ti ti-file-text"></i>
            <span class="badge-icon">📋</span>
        </span>
        <span class="pc-mtext">Pengajuan Surat</span>
    </a>
</li>
<li class="pc-item {{ request()->routeIs('pengaduan.*') ? 'active' : '' }}">
    <a href="{{ route('pengaduan.index') }}" class="pc-link sidebar-pengaduan">
        <span class="pc-micon">
            <i class="ti ti-message-circle"></i>
            <span class="badge-icon">💬</span>
        </span>
        <span class="pc-mtext">Pengaduan</span>
    </a>
</li>

<style>
    /* Sidebar Container Background - WARNA GRADIENT */
    nav.pc-sidebar,
    .pc-navbar {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
    }

    /* Item Default Color */
    .pc-navbar .pc-item .pc-link {
        color: #ffffff !important;
        transition: all 0.3s ease !important;
    }

    /* Sidebar Custom Styling - Pengajuan */
    .pc-navbar .pc-item.sidebar-pengajuan .pc-link {
        border-left: 4px solid transparent !important;
        position: relative;
        overflow: hidden;
    }

    .pc-navbar .pc-item.sidebar-pengajuan .pc-link::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.1);
        transition: left 0.3s ease !important;
        z-index: -1;
    }

    .pc-navbar .pc-item.sidebar-pengajuan .pc-link:hover::before {
        left: 0 !important;
    }

    .pc-navbar .pc-item.sidebar-pengajuan .pc-link:hover {
        background: rgba(255, 255, 255, 0.15) !important;
        border-left-color: #ffffff !important;
        color: #ffffff !important;
        box-shadow: 0 2px 8px rgba(255, 255, 255, 0.25) !important;
        transform: translateX(8px) !important;
    }

    .pc-navbar .pc-item.sidebar-pengajuan.active .pc-link {
        background: rgba(255, 255, 255, 0.2) !important;
        border-left-color: #ffffff !important;
        color: #ffffff !important;
        font-weight: 600 !important;
        box-shadow: 0 3px 12px rgba(255, 255, 255, 0.3) !important;
        transform: translateX(4px) !important;
    }

    /* Sidebar Custom Styling - Pengaduan */
    .pc-navbar .pc-item.sidebar-pengaduan .pc-link {
        border-left: 4px solid transparent !important;
        position: relative;
        overflow: hidden;
    }

    .pc-navbar .pc-item.sidebar-pengaduan .pc-link::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.1);
        transition: left 0.3s ease !important;
        z-index: -1;
    }

    .pc-navbar .pc-item.sidebar-pengaduan .pc-link:hover::before {
        left: 0 !important;
    }

    .pc-navbar .pc-item.sidebar-pengaduan .pc-link:hover {
        background: rgba(255, 255, 255, 0.15) !important;
        border-left-color: #ffffff !important;
        color: #ffffff !important;
        box-shadow: 0 2px 8px rgba(255, 255, 255, 0.25) !important;
        transform: translateX(8px) !important;
    }

    .pc-navbar .pc-item.sidebar-pengaduan.active .pc-link {
        background: rgba(255, 255, 255, 0.2) !important;
        border-left-color: #ffffff !important;
        color: #ffffff !important;
        font-weight: 600 !important;
        box-shadow: 0 3px 12px rgba(255, 255, 255, 0.3) !important;
        transform: translateX(4px) !important;
    }

    /* Icon Styling */
    .pc-micon {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.2) !important;
        border-radius: 8px;
        padding: 4px;
        transition: all 0.3s ease !important;
    }

    .pc-navbar .pc-item.sidebar-pengajuan .pc-link:hover .pc-micon {
        background: rgba(255, 255, 255, 0.3) !important;
        transform: scale(1.1) !important;
    }

    .pc-navbar .pc-item.sidebar-pengaduan .pc-link:hover .pc-micon {
        background: rgba(255, 255, 255, 0.3) !important;
        transform: scale(1.1) !important;
    }

    /* Badge Icon Animation - TERUS BERGERAK */
    .badge-icon {
        position: absolute;
        font-size: 14px;
        margin-left: 8px;
        margin-top: 4px;
        display: inline-block;
        animation: float 3s ease-in-out infinite !important;
    }

    @keyframes float {
        0% {
            transform: translateY(0px) rotate(0deg);
            opacity: 1;
        }
        50% {
            transform: translateY(-8px) rotate(5deg);
            opacity: 1;
        }
        100% {
            transform: translateY(0px) rotate(0deg);
            opacity: 1;
        }
    }

    /* Responsive */
    @media (max-width: 767px) {
        .badge-icon {
            display: none;
        }
    }
</style>


