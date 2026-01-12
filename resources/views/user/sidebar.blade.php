
@php $pengajuanActive = request()->routeIs('pengajuan.*'); @endphp
<li class="pc-item {{ $pengajuanActive ? 'active' : '' }}">
    <a class="pc-link sidebar-pengajuan" data-bs-toggle="collapse" href="#pengajuanMenu" role="button" aria-expanded="{{ $pengajuanActive ? 'true' : 'false' }}" aria-controls="pengajuanMenu" style="display: flex !important; align-items: center !important; justify-content: space-between !important; white-space: nowrap !important;">
        <span style="display: flex !important; align-items: center !important; gap: 12px !important;">
            <span class="pc-micon">
                <i class="ti ti-file-text"></i>
            </span>
            <span class="pc-mtext" style="white-space: normal !important;">Pengajuan Surat</span>
        </span>
        <i class="ti ti-chevron-down" style="flex-shrink: 0; margin-left: 8px;"></i>
    </a>

    <div class="collapse {{ $pengajuanActive ? 'show' : '' }}" id="pengajuanMenu">
        @php
            $jenisList = [
                'Surat Nikah',
                'Surat Tanah',
                'Surat Warisan',
                'Surat Domisili',
                'Surat Akta Kelahiran',
                'Surat Keterangan Tidak Mampu',
                'Surat Akta Kematian'
            ];
        @endphp
        <ul class="list-unstyled ps-3 mb-2">
            <li class="mb-1">
                <a href="{{ route('pengajuan.index') }}" class="pc-sublink d-block text-decoration-none">
                    <i class="ti ti-list-check me-1"></i> Daftar Pengajuan
                </a>
            </li>
            @foreach($jenisList as $jenis)
                <li class="mb-1">
                    <a href="{{ route('pengajuan.create', ['jenis_surat' => $jenis]) }}" class="pc-sublink d-block text-decoration-none">
                        <i class="ti ti-file-plus me-1"></i> {{ $jenis }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</li>
<li class="pc-item {{ request()->routeIs('pengaduan.*') ? 'active' : '' }}">
    <a href="{{ route('pengaduan.index') }}" class="pc-link sidebar-pengaduan">
        <span class="pc-micon">
            <i class="ti ti-message-circle"></i>
        </span>
        <span class="pc-mtext">Pengaduan</span>
    </a>
</li>

<style>
    /* ===== USER SIDEBAR MATCH DARK THEME ===== */
    /* Styling will be handled by dashboard.blade.php */

    /* Collapsible header styling */
    .pc-navbar .pc-item .pc-link .ti-chevron-down {
        opacity: 0.85;
        transition: transform 0.3s ease !important;
    }

    .pc-navbar .pc-item[aria-expanded="true"] .pc-link .ti-chevron-down,
    .pc-navbar .pc-item .pc-link[aria-expanded="true"] .ti-chevron-down {
        transform: rotate(180deg);
    }

    /* Submenu links (accessible) */
    .pc-sublink {
        color: #d0d7ff !important;
        display: block;
        padding: 10px 14px;
        border-radius: 10px;
        font-size: 0.95rem;
        transition: all 0.3s ease !important;
        position: relative;
        padding-left: 28px !important;
    }

    .pc-sublink::before {
        content: '→';
        position: absolute;
        left: 12px;
        color: #00d4ff;
        font-weight: bold;
    }

    .pc-sublink i {
        color: #e0e7ff;
        opacity: 0.95;
    }

    .pc-sublink:hover,
    .pc-sublink:focus {
        background: rgba(0, 212, 255, 0.2) !important;
        color: #ffffff !important;
        text-decoration: none !important;
        outline: none !important;
        transform: translateX(5px) !important;
    }

    /* Active / selected submenu */
    .pc-sublink.active,
    .pc-sublink[aria-current='true'] {
        background: rgba(0, 132, 255, 0.25) !important;
        color: #ffffff !important;
        font-weight: 600;
    }

    /* Collapse container styling */
    .collapse {
        background: rgba(0, 132, 255, 0.15) !important;
        border-left: 4px solid #00d4ff !important;
        border-radius: 12px !important;
        margin: 12px 8px !important;
        padding-left: 15px !important;
        backdrop-filter: blur(10px);
    }
</style>


