
<li class="pc-item {{ request()->routeIs('pengajuan.*') ? 'active' : '' }}">
    <a href="{{ route('pengajuan.index') }}" class="pc-link">
        <span class="pc-micon"><i class="ti ti-file-text"></i></span>
        <span class="pc-mtext">Pengajuan Surat</span>
    </a>
</li>
<li class="pc-item {{ request()->routeIs('pengaduan.*') ? 'active' : '' }}">
    <a href="{{ route('pengaduan.index') }}" class="pc-link">
        <span class="pc-micon"><i class="ti ti-file-text"></i></span>
        <span class="pc-mtext">Pengaduan</span>
    </a>
</li>


