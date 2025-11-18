<li class="pc-item">
    <a href="{{ route('penduduk.index') }}" class="pc-link sidebar-penduduk">
        <span class="pc-micon">
            <i class="ti ti-users"></i>
            <span class="badge-icon">👥</span>
        </span>
        <span class="pc-mtext">Data Penduduk</span>
    </a>
</li>
<li class="pc-item">
    <a href="{{ route('admin.pengajuan.index') }}" class="pc-link sidebar-pengajuan">
        <span class="pc-micon">
            <i class="ti ti-file-check"></i>
            <span class="badge-icon">✅</span>
        </span>
        <span class="pc-mtext">Verifikasi Pengajuan</span>
    </a>
</li>
<li class="pc-item">
    <a href="{{ route('admin.pengaduan.index') }}" class="pc-link sidebar-pengaduan">
        <span class="pc-micon">
            <i class="ti ti-message-circle"></i>
            <span class="badge-icon">💬</span>
        </span>
        <span class="pc-mtext">Verifikasi Pengaduan</span>
    </a>
</li>

<style>
    /* ===== ADMIN SIDEBAR BACKGROUND GRADIENT ===== */
    nav.pc-sidebar,
    .pc-navbar {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
        box-shadow: inset 0 2px 4px rgba(255, 255, 255, 0.1) !important;
    }
    
    /* Default Text Color */
    .pc-navbar .pc-item .pc-link {
        color: #ffffff !important;
        transition: all 0.3s ease !important;
    }
    
    /* ===== PENDUDUK ITEM STYLING ===== */
    .pc-navbar .pc-item.sidebar-penduduk .pc-link {
        border-left: 4px solid transparent !important;
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease !important;
    }
    
    .pc-navbar .pc-item.sidebar-penduduk .pc-link::before {
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
    
    .pc-navbar .pc-item.sidebar-penduduk .pc-link:hover::before {
        left: 0 !important;
    }
    
    .pc-navbar .pc-item.sidebar-penduduk .pc-link:hover {
        background: rgba(255, 255, 255, 0.15) !important;
        border-left-color: #ffffff !important;
        color: #ffffff !important;
        box-shadow: 0 2px 8px rgba(255, 255, 255, 0.25) !important;
        transform: translateX(8px) !important;
    }
    
    .pc-navbar .pc-item.sidebar-penduduk.active .pc-link,
    .pc-navbar .pc-item.sidebar-penduduk .pc-link.active {
        background: rgba(255, 255, 255, 0.2) !important;
        border-left-color: #ffffff !important;
        color: #ffffff !important;
        font-weight: 600 !important;
        box-shadow: 0 3px 12px rgba(255, 255, 255, 0.3) !important;
        transform: translateX(4px) !important;
    }
    
    /* ===== PENGAJUAN ITEM STYLING ===== */
    .pc-navbar .pc-item.sidebar-pengajuan .pc-link {
        border-left: 4px solid transparent !important;
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease !important;
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
    
    .pc-navbar .pc-item.sidebar-pengajuan.active .pc-link,
    .pc-navbar .pc-item.sidebar-pengajuan .pc-link.active {
        background: rgba(255, 255, 255, 0.2) !important;
        border-left-color: #ffffff !important;
        color: #ffffff !important;
        font-weight: 600 !important;
        box-shadow: 0 3px 12px rgba(255, 255, 255, 0.3) !important;
        transform: translateX(4px) !important;
    }
    
    /* ===== PENGADUAN ITEM STYLING ===== */
    .pc-navbar .pc-item.sidebar-pengaduan .pc-link {
        border-left: 4px solid transparent !important;
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease !important;
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
    
    .pc-navbar .pc-item.sidebar-pengaduan.active .pc-link,
    .pc-navbar .pc-item.sidebar-pengaduan .pc-link.active {
        background: rgba(255, 255, 255, 0.2) !important;
        border-left-color: #ffffff !important;
        color: #ffffff !important;
        font-weight: 600 !important;
        box-shadow: 0 3px 12px rgba(255, 255, 255, 0.3) !important;
        transform: translateX(4px) !important;
    }
    
    /* ===== ICON STYLING ===== */
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
    
    .pc-navbar .pc-item .pc-link:hover .pc-micon {
        background: rgba(255, 255, 255, 0.3) !important;
        transform: scale(1.1) !important;
    }
    
    /* ===== BADGE ICON ANIMATION ===== */
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
