
<!-- LAYANAN UTAMA -->
<li class="pc-item-divider mt-2 mb-2">
    <span style="font-size: 12px; font-weight: 700; letter-spacing: 1px; color: #5fa3f0; text-transform: uppercase; padding: 0 15px; display: block;">
        <i class="ti ti-layout me-2"></i>Layanan Utama
    </span>
</li>

<li class="pc-item {{ request()->routeIs('pengajuan.*') ? 'active' : '' }}">
    <a href="{{ route('pengajuan.index') }}" class="pc-link sidebar-pengajuan">
        <span class="pc-micon">
            <i class="ti ti-file-text"></i>
        </span>
        <span class="pc-mtext">Pengajuan Surat</span>
    </a>
</li>

<li class="pc-item {{ request()->routeIs('pengaduan.*') ? 'active' : '' }}">
    <a href="{{ route('pengaduan.index') }}" class="pc-link sidebar-pengaduan">
        <span class="pc-micon">
            <i class="ti ti-message-circle"></i>
        </span>
        <span class="pc-mtext">Pengaduan</span>
    </a>
</li>

<!-- AKUN & PENGATURAN -->
<li class="pc-item-divider mt-3 mb-2">
    <span style="font-size: 12px; font-weight: 700; letter-spacing: 1px; color: #5fa3f0; text-transform: uppercase; padding: 0 15px; display: block;">
        <i class="ti ti-settings me-2"></i>Akun
    </span>
</li>

<li class="pc-item {{ request()->routeIs('user.profile.*') ? 'active' : '' }}">
    <a href="{{ route('user.profile.show') }}" class="pc-link sidebar-profile">
        <span class="pc-micon">
            <i class="ti ti-user"></i>
        </span>
        <span class="pc-mtext">Profil Saya</span>
    </a>
</li>

<style>
    /* ===== USER SIDEBAR MATCH DARK THEME ===== */
    
    /* Sidebar divider section */
    .pc-item-divider {
        list-style: none;
        position: relative;
        margin: 0 !important;
        padding: 0 !important;
    }
    
    .pc-item-divider::after {
        content: '';
        display: block;
        height: 1px;
        background: linear-gradient(90deg, transparent 0%, #5fa3f0 20%, #5fa3f0 80%, transparent 100%);
        margin: 8px 15px 0 15px;
    }
    
    .pc-item-divider span {
        display: flex !important;
        align-items: center;
        transition: all 0.3s ease;
    }
    
    .pc-item-divider span i {
        margin-right: 8px !important;
    }
</style>


