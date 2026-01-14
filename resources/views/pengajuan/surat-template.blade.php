<!-- Template Surat Hasil Profesional per Jenis Surat -->

@if($pengajuan->jenis_surat === 'Surat Warisan' || ($pengajuan->data_tambahan['jenis_surat_asli'] ?? '') === 'Surat Warisan')
<!-- SURAT WARISAN -->
<div class="surat">
    <div class="content">
        <div class="header">
            <div class="header-title">PEMERINTAH DESA SRUNI</div>
            <div class="header-subtitle">SURAT KETERANGAN WARISAN</div>
            <div class="nomor">No. {{ $pengajuan->nomor_pengajuan ?? 'Draft' }}</div>
        </div>

        <div style="margin-bottom: 20px; text-align: right; font-size: 11px;">
            <div>Dikeluarkan pada :</div>
            <div style="font-weight: bold; margin-top: 3px;">{{ now()->format('d F Y') }}</div>
        </div>

        <p style="margin-bottom: 15px; font-size: 11px; line-height: 1.8;">
            Berdasarkan permohonan yang telah diajukan, dengan ini kami menerangkan bahwa:
        </p>

        <table style="width: 100%; border-collapse: collapse; margin-bottom: 15px; font-size: 11px;">
            <tr>
                <td style="width: 120px; padding: 5px 0;">Nama</td>
                <td style="padding: 5px 0;">: <strong>{{ $pengajuan->nama_pemohon }}</strong></td>
            </tr>
            <tr>
                <td style="padding: 5px 0;">NIK</td>
                <td style="padding: 5px 0;">: {{ $pengajuan->nik_pemohon }}</td>
            </tr>
            <tr>
                <td style="padding: 5px 0;">Tempat, Tanggal Lahir</td>
                <td style="padding: 5px 0;">: {{ $pengajuan->tempat_lahir_pemohon }}, {{ optional($pengajuan->tanggal_lahir_pemohon)->format('d-m-Y') ?? '-' }}</td>
            </tr>
            <tr>
                <td style="padding: 5px 0;">Jenis Kelamin</td>
                <td style="padding: 5px 0;">: {{ $pengajuan->jenis_kelamin_pemohon }}</td>
            </tr>
            <tr>
                <td style="padding: 5px 0;">Pekerjaan</td>
                <td style="padding: 5px 0;">: {{ $pengajuan->pekerjaan_pemohon }}</td>
            </tr>
            <tr>
                <td style="padding: 5px 0;">Alamat</td>
                <td style="padding: 5px 0;">: {{ $pengajuan->alamat_pemohon }}</td>
            </tr>
        </table>

        <p style="margin-bottom: 10px; font-size: 11px; line-height: 1.8;">
            <strong>Adalah orang yang mempunyai hubungan dengan pewaris atas nama {{ $pengajuan->data_tambahan['nama_almarhum'] ?? '-' }} (telah meninggal), dengan hubungan: <u>{{ $pengajuan->data_tambahan['hubungan_almarhum'] ?? '-' }}</u></strong>
        </p>

        <p style="margin-bottom: 10px; font-size: 11px; line-height: 1.8;">
            <strong>Pewaris tersebut telah meninggal dunia dan meninggalkan warisan yang perlu diatur sesuai dengan ketentuan hukum yang berlaku.</strong>
        </p>

        <p style="margin: 15px 0; font-size: 11px; line-height: 1.8;">
            Adapun ahli waris dari pewaris di atas adalah:
        </p>

        <div style="margin: 15px 0; padding: 10px; border: 1px solid #ccc; font-size: 11px; line-height: 1.8; white-space: pre-wrap;">
            {{ $pengajuan->data_tambahan['daftar_penerima'] ?? '-' }}
        </div>

        <p style="margin: 15px 0; font-size: 11px; line-height: 1.8;">
            Dengan demikian surat keterangan warisan ini diberikan kepada yang bersangkutan untuk keperluan: <strong>{{ $pengajuan->keperluan }}</strong>
        </p>

        <p style="margin: 20px 0; font-size: 11px; line-height: 1.8;">
            Demikian surat keterangan ini dibuat dan diberikan untuk dipergunakan sesuai dengan keperluan.
        </p>
    </div>

    <div class="footer-content">
        <div style="margin-top: 30px; overflow: auto;">
            <div style="float: right; text-align: center; width: 220px;">
                <div style="font-size: 11px; margin-bottom: 5px;">LURAH DESA SRUNI</div>
                @include("pengajuan.components.qr-code-section", ["pengajuan" => $pengajuan])
                <div style="border-top: 1px solid #000; width: 100%; margin: 15px 0 3px 0;"></div>
                <div style="font-weight: bold; margin-top: 3px; font-size: 11px;">(________________________)</div>
            </div>
        </div>
    </div>
</div>

@elseif($pengajuan->jenis_surat === 'Surat Nikah' || ($pengajuan->data_tambahan['jenis_surat_asli'] ?? '') === 'Surat Nikah')
<!-- SURAT NIKAH -->
<div class="surat">
    <div class="content">
        <div class="header">
            <div class="header-title">PEMERINTAH DESA SRUNI</div>
            <div class="header-subtitle">SURAT KETERANGAN PENCATATAN PERKAWINAN</div>
            <div class="nomor">No. {{ $pengajuan->nomor_pengajuan ?? 'Draft' }}</div>
        </div>

        <div style="margin-bottom: 20px; text-align: right; font-size: 11px;">
            <div>Dikeluarkan pada :</div>
            <div style="font-weight: bold; margin-top: 3px;">{{ now()->format('d F Y') }}</div>
        </div>

        <p style="margin-bottom: 15px; font-size: 11px; line-height: 1.8;">
            Berdasarkan permohonan yang telah diajukan, dengan ini kami menerangkan bahwa:
        </p>

        <table style="width: 100%; border-collapse: collapse; margin-bottom: 15px; font-size: 11px;">
            <tr>
                <td style="width: 120px; padding: 5px 0;">Nama Lengkap</td>
                <td style="padding: 5px 0;">: <strong>{{ $pengajuan->nama_pemohon }}</strong></td>
            </tr>
            <tr>
                <td style="padding: 5px 0;">NIK</td>
                <td style="padding: 5px 0;">: {{ $pengajuan->nik_pemohon }}</td>
            </tr>
            <tr>
                <td style="padding: 5px 0;">Tempat, Tanggal Lahir</td>
                <td style="padding: 5px 0;">: {{ $pengajuan->tempat_lahir_pemohon }}, {{ optional($pengajuan->tanggal_lahir_pemohon)->format('d-m-Y') ?? '-' }}</td>
            </tr>
            <tr>
                <td style="padding: 5px 0;">Jenis Kelamin</td>
                <td style="padding: 5px 0;">: {{ $pengajuan->jenis_kelamin_pemohon }}</td>
            </tr>
            <tr>
                <td style="padding: 5px 0;">Pekerjaan</td>
                <td style="padding: 5px 0;">: {{ $pengajuan->pekerjaan_pemohon }}</td>
            </tr>
            <tr>
                <td style="padding: 5px 0;">Alamat</td>
                <td style="padding: 5px 0;">: {{ $pengajuan->alamat_pemohon }}</td>
            </tr>
        </table>

        <p style="margin: 15px 0; font-size: 11px; line-height: 1.8;">
            <strong>Adalah orang yang telah memasuki jenjang perkawinan dengan rincian sebagai berikut:</strong>
        </p>

        <table style="width: 100%; border-collapse: collapse; margin-bottom: 15px; font-size: 11px;">
            <tr>
                <td style="width: 140px; padding: 5px 0;">Calon Pengantin Pria</td>
                <td style="padding: 5px 0;">: {{ $pengajuan->data_tambahan['nama_calon_pria'] ?? '-' }}</td>
            </tr>
            <tr>
                <td style="padding: 5px 0;">Calon Pengantin Wanita</td>
                <td style="padding: 5px 0;">: {{ $pengajuan->data_tambahan['nama_calon_wanita'] ?? '-' }}</td>
            </tr>
            <tr>
                <td style="padding: 5px 0;">Tanggal Pernikahan</td>
                <td style="padding: 5px 0;">: {{ isset($pengajuan->data_tambahan['tanggal_nikah_rencana']) ? \Carbon\Carbon::parse($pengajuan->data_tambahan['tanggal_nikah_rencana'])->format('d F Y') : '-' }}</td>
            </tr>
            <tr>
                <td style="padding: 5px 0;">Tempat Pernikahan</td>
                <td style="padding: 5px 0;">: {{ $pengajuan->data_tambahan['tempat_nikah'] ?? '-' }}</td>
            </tr>
        </table>

        <p style="margin: 15px 0; font-size: 11px; line-height: 1.8;">
            Dengan demikian surat keterangan perkawinan ini diberikan kepada yang bersangkutan untuk keperluan: <strong>{{ $pengajuan->keperluan }}</strong>
        </p>

        <p style="margin: 20px 0; font-size: 11px; line-height: 1.8;">
            Demikian surat keterangan ini dibuat dan diberikan untuk dipergunakan sesuai dengan keperluan.
        </p>
    </div>

    <div class="footer-content">
        <div style="margin-top: 30px; overflow: auto;">
            <div style="float: right; text-align: center; width: 220px;">
                <div style="font-size: 11px; margin-bottom: 5px;">LURAH DESA SRUNI</div>
                @include("pengajuan.components.qr-code-section", ["pengajuan" => $pengajuan])
                <div style="border-top: 1px solid #000; width: 100%; margin: 15px 0 3px 0;"></div>
                <div style="font-weight: bold; margin-top: 3px; font-size: 11px;">(________________________)</div>
            </div>
        </div>
    </div>
</div>

@elseif($pengajuan->jenis_surat === 'Surat Tanah' || ($pengajuan->data_tambahan['jenis_surat_asli'] ?? '') === 'Surat Tanah')
<!-- SURAT TANAH -->
<div class="surat">
    <div class="content">
        <div class="header">
            <div class="header-title">PEMERINTAH DESA SRUNI</div>
            <div class="header-subtitle">SURAT KETERANGAN TANAH</div>
            <div class="nomor">No. {{ $pengajuan->nomor_pengajuan ?? 'Draft' }}</div>
        </div>

        <div style="margin-bottom: 20px; text-align: right; font-size: 11px;">
            <div>Dikeluarkan pada :</div>
            <div style="font-weight: bold; margin-top: 3px;">{{ now()->format('d F Y') }}</div>
        </div>

        <p style="margin-bottom: 15px; font-size: 11px; line-height: 1.8;">
            Berdasarkan permohonan yang telah diajukan, dengan ini kami menerangkan bahwa:
        </p>

        <table style="width: 100%; border-collapse: collapse; margin-bottom: 15px; font-size: 11px;">
            <tr>
                <td style="width: 120px; padding: 5px 0;">Nama Pemilik</td>
                <td style="padding: 5px 0;">: <strong>{{ $pengajuan->nama_pemohon }}</strong></td>
            </tr>
            <tr>
                <td style="padding: 5px 0;">NIK</td>
                <td style="padding: 5px 0;">: {{ $pengajuan->nik_pemohon }}</td>
            </tr>
            <tr>
                <td style="padding: 5px 0;">Pekerjaan</td>
                <td style="padding: 5px 0;">: {{ $pengajuan->pekerjaan_pemohon }}</td>
            </tr>
            <tr>
                <td style="padding: 5px 0;">Alamat</td>
                <td style="padding: 5px 0;">: {{ $pengajuan->alamat_pemohon }}</td>
            </tr>
        </table>

        <p style="margin: 15px 0; font-size: 11px; line-height: 1.8;">
            <strong>Adalah orang yang memiliki tanah dengan rincian sebagai berikut:</strong>
        </p>

        <table style="width: 100%; border-collapse: collapse; margin-bottom: 15px; font-size: 11px;">
            <tr>
                <td style="width: 120px; padding: 5px 0;">Alamat Tanah</td>
                <td style="padding: 5px 0;">: {{ $pengajuan->data_tambahan['alamat_tanah'] ?? '-' }}</td>
            </tr>
            <tr>
                <td style="padding: 5px 0;">Luas Tanah</td>
                <td style="padding: 5px 0;">: {{ $pengajuan->data_tambahan['luas_tanah'] ?? '-' }} m²</td>
            </tr>
        </table>

        <p style="margin: 15px 0; font-size: 11px; line-height: 1.8;">
            Dengan demikian surat keterangan tanah ini diberikan kepada yang bersangkutan untuk keperluan: <strong>{{ $pengajuan->keperluan }}</strong>
        </p>

        <p style="margin: 20px 0; font-size: 11px; line-height: 1.8;">
            Demikian surat keterangan ini dibuat dan diberikan untuk dipergunakan sesuai dengan keperluan.
        </p>
    </div>

    <div class="footer-content">
        <div style="margin-top: 30px; overflow: auto;">
            <div style="float: right; text-align: center; width: 220px;">
                <div style="font-size: 11px; margin-bottom: 5px;">LURAH DESA SRUNI</div>
                @include("pengajuan.components.qr-code-section", ["pengajuan" => $pengajuan])
                <div style="border-top: 1px solid #000; width: 100%; margin: 15px 0 3px 0;"></div>
                <div style="font-weight: bold; margin-top: 3px; font-size: 11px;">(________________________)</div>
            </div>
        </div>
    </div>
</div>

@elseif($pengajuan->jenis_surat === 'Surat Domisili' || ($pengajuan->data_tambahan['jenis_surat_asli'] ?? '') === 'Surat Domisili')
<!-- SURAT DOMISILI -->
<div class="surat">
    <div class="content">
        <div class="header">
            <div class="header-title">PEMERINTAH DESA SRUNI</div>
            <div class="header-subtitle">SURAT KETERANGAN DOMISILI</div>
            <div class="nomor">No. {{ $pengajuan->nomor_pengajuan ?? 'Draft' }}</div>
        </div>

        <div style="margin-bottom: 20px; text-align: right; font-size: 11px;">
            <div>Dikeluarkan pada :</div>
            <div style="font-weight: bold; margin-top: 3px;">{{ now()->format('d F Y') }}</div>
        </div>

        <p style="margin-bottom: 15px; font-size: 11px; line-height: 1.8;">
            Berdasarkan permohonan yang telah diajukan, dengan ini kami menerangkan bahwa:
        </p>

        <table style="width: 100%; border-collapse: collapse; margin-bottom: 15px; font-size: 11px;">
            <tr>
                <td style="width: 120px; padding: 5px 0;">Nama Lengkap</td>
                <td style="padding: 5px 0;">: <strong>{{ $pengajuan->nama_pemohon }}</strong></td>
            </tr>
            <tr>
                <td style="padding: 5px 0;">NIK</td>
                <td style="padding: 5px 0;">: {{ $pengajuan->nik_pemohon }}</td>
            </tr>
            <tr>
                <td style="padding: 5px 0;">Tempat, Tanggal Lahir</td>
                <td style="padding: 5px 0;">: {{ $pengajuan->tempat_lahir_pemohon }}, {{ optional($pengajuan->tanggal_lahir_pemohon)->format('d-m-Y') ?? '-' }}</td>
            </tr>
            <tr>
                <td style="padding: 5px 0;">Pekerjaan</td>
                <td style="padding: 5px 0;">: {{ $pengajuan->pekerjaan_pemohon }}</td>
            </tr>
        </table>

        <p style="margin: 15px 0; font-size: 11px; line-height: 1.8;">
            <strong>Dengan ini kami menerangkan bahwa:</strong>
        </p>

        <p style="margin: 10px 0; font-size: 11px; line-height: 1.8;">
            Seorang warga yang bernama <strong>{{ $pengajuan->nama_pemohon }}</strong> saat ini berdomisili di <strong>{{ $pengajuan->data_tambahan['asal_desa'] ?? '-' }}, {{ $pengajuan->data_tambahan['asal_kota'] ?? '-' }}</strong> dan ingin mengajukan permohonan untuk pindah berdomisili ke <strong>{{ $pengajuan->data_tambahan['tujuan_desa'] ?? '-' }}, {{ $pengajuan->data_tambahan['tujuan_kota'] ?? '-' }}</strong>.
        </p>

        <p style="margin-bottom: 15px; font-size: 11px; line-height: 1.8;">
            <strong>Adalah benar penduduk/berdomisili di:</strong>
        </p>

        <table style="width: 100%; border-collapse: collapse; margin-bottom: 15px; font-size: 11px;">
            <tr>
                <td style="width: 120px; padding: 5px 0;">Alamat Domisili</td>
                <td style="padding: 5px 0;">: {{ $pengajuan->data_tambahan['alamat_domisili'] ?? '-' }}</td>
            </tr>
            <tr>
                <td style="padding: 5px 0;">RT/RW</td>
                <td style="padding: 5px 0;">: {{ $pengajuan->data_tambahan['rt_rw'] ?? '-' }}</td>
            </tr>
        </table>

        <p style="margin: 15px 0; font-size: 11px; line-height: 1.8;">
            Dengan demikian surat keterangan domisili ini diberikan kepada yang bersangkutan untuk keperluan: <strong>{{ $pengajuan->keperluan }}</strong>
        </p>

        <p style="margin: 20px 0; font-size: 11px; line-height: 1.8;">
            Demikian surat keterangan ini dibuat dan diberikan untuk dipergunakan sesuai dengan keperluan.
        </p>
    </div>

    <div class="footer-content">
        <div style="display: flex; justify-content: flex-end; margin-top: 30px;">
            <div style="text-align: center; width: 220px;">
                <div style="font-size: 11px; margin-bottom: 5px;">LURAH DESA SRUNI</div>
                @include("pengajuan.components.qr-code-section", ["pengajuan" => $pengajuan])
                <div style="border-top: 1px solid #000; width: 100%; margin: 15px 0 3px 0;"></div>
                <div style="font-weight: bold; margin-top: 3px; font-size: 11px;">(________________________)</div>
            </div>
        </div>
    </div>
</div>

@elseif($pengajuan->jenis_surat === 'Surat Akta Kelahiran' || ($pengajuan->data_tambahan['jenis_surat_asli'] ?? '') === 'Surat Akta Kelahiran')
<!-- SURAT AKTA KELAHIRAN -->
<div class="surat">
    <div class="content">
        <div class="header">
            <div class="header-title">PEMERINTAH DESA SRUNI/div>
            <div class="header-subtitle">SURAT KETERANGAN KELAHIRAN</div>
            <div class="nomor">No. {{ $pengajuan->nomor_pengajuan ?? 'Draft' }}</div>
        </div>

        <div style="margin-bottom: 20px; text-align: right; font-size: 11px;">
            <div>Dikeluarkan pada :</div>
            <div style="font-weight: bold; margin-top: 3px;">{{ now()->format('d F Y') }}</div>
        </div>

        <p style="margin-bottom: 15px; font-size: 11px; line-height: 1.8;">
            Berdasarkan permohonan yang telah diajukan, dengan ini kami menerangkan bahwa:
        </p>

        <p style="margin: 15px 0; font-size: 11px; line-height: 1.8;">
            <strong>Orang Tua:</strong>
        </p>

        <table style="width: 100%; border-collapse: collapse; margin-bottom: 15px; font-size: 11px;">
            <tr>
                <td style="width: 120px; padding: 5px 0;">Nama Ayah</td>
                <td style="padding: 5px 0;">: {{ $pengajuan->data_tambahan['nama_ayah'] ?? '-' }}</td>
            </tr>
            <tr>
                <td style="padding: 5px 0;">Nama Ibu</td>
                <td style="padding: 5px 0;">: {{ $pengajuan->data_tambahan['nama_ibu'] ?? '-' }}</td>
            </tr>
        </table>

        <p style="margin: 15px 0; font-size: 11px; line-height: 1.8;">
            <strong>Telah melahirkan seorang anak dengan rincian:</strong>
        </p>

        <table style="width: 100%; border-collapse: collapse; margin-bottom: 15px; font-size: 11px;">
            <tr>
                <td style="width: 120px; padding: 5px 0;">Nama Bayi</td>
                <td style="padding: 5px 0;">: {{ $pengajuan->data_tambahan['nama_bayi'] ?? '-' }}</td>
            </tr>
            <tr>
                <td style="padding: 5px 0;">Tanggal Lahir</td>
                <td style="padding: 5px 0;">: {{ isset($pengajuan->data_tambahan['tanggal_lahir_bayi']) ? \Carbon\Carbon::parse($pengajuan->data_tambahan['tanggal_lahir_bayi'])->format('d F Y') : '-' }}</td>
            </tr>
            <tr>
                <td style="padding: 5px 0;">Tempat Lahir</td>
                <td style="padding: 5px 0;">: {{ $pengajuan->data_tambahan['tempat_lahir_bayi'] ?? '-' }}</td>
            </tr>
            <tr>
                <td style="padding: 5px 0;">Jenis Kelamin</td>
                <td style="padding: 5px 0;">: {{ $pengajuan->data_tambahan['jenis_kelamin_bayi'] ?? '-' }}</td>
            </tr>
        </table>

        <p style="margin: 15px 0; font-size: 11px; line-height: 1.8;">
            Dengan demikian surat keterangan kelahiran ini diberikan kepada yang bersangkutan untuk keperluan: <strong>{{ $pengajuan->keperluan }}</strong>
        </p>

        <p style="margin: 20px 0; font-size: 11px; line-height: 1.8;">
            Demikian surat keterangan ini dibuat dan diberikan untuk dipergunakan sesuai dengan keperluan.
        </p>
    </div>

    <div class="footer-content">
        <div style="margin-top: 30px; overflow: auto;">
            <div style="float: right; text-align: center; width: 220px;">
                <div style="font-size: 11px; margin-bottom: 5px;">LURAH DESA SRUNI,</div>
                @include("pengajuan.components.qr-code-section", ["pengajuan" => $pengajuan])
                <div style="border-top: 1px solid #000; width: 100%; margin: 15px 0 3px 0;"></div>
                <div style="font-weight: bold; margin-top: 3px; font-size: 11px;">(________________________)</div>
            </div>
        </div>
    </div>
</div>

@elseif($pengajuan->jenis_surat === 'Surat Akta Kematian' || ($pengajuan->data_tambahan['jenis_surat_asli'] ?? '') === 'Surat Akta Kematian')
<!-- SURAT AKTA KEMATIAN -->
<div class="surat">
    <div class="content">
        <div class="header">
            <div class="header-title">PEMERINTAH DESA SRUNI</div>
            <div class="header-subtitle">SURAT KETERANGAN KEMATIAN</div>
            <div class="nomor">No. {{ $pengajuan->nomor_pengajuan ?? 'Draft' }}</div>
        </div>

        <div style="margin-bottom: 20px; text-align: right; font-size: 11px;">
            <div>Dikeluarkan pada :</div>
            <div style="font-weight: bold; margin-top: 3px;">{{ now()->format('d F Y') }}</div>
        </div>

        <p style="margin-bottom: 15px; font-size: 11px; line-height: 1.8;">
            Berdasarkan permohonan yang telah diajukan, dengan ini kami menerangkan bahwa:
        </p>

        <p style="margin: 15px 0; font-size: 11px; line-height: 1.8;">
            <strong>Data Almarhum / Almarhumah:</strong>
        </p>

        <table style="width: 100%; border-collapse: collapse; margin-bottom: 15px; font-size: 11px;">
            <tr>
                <td style="width: 120px; padding: 5px 0;">Nama Almarhum</td>
                <td style="padding: 5px 0;">: <strong>{{ $pengajuan->data_tambahan['nama_almarhum'] ?? '-' }}</strong></td>
            </tr>
            <tr>
                <td style="padding: 5px 0;">Tempat, Tanggal Lahir</td>
                <td style="padding: 5px 0;">: {{ $pengajuan->data_tambahan['tempat_lahir_almarhum'] ?? '-' }}, {{ isset($pengajuan->data_tambahan['tanggal_lahir_almarhum']) ? \Carbon\Carbon::parse($pengajuan->data_tambahan['tanggal_lahir_almarhum'])->format('d-m-Y') : '-' }}</td>
            </tr>
            <tr>
                <td style="padding: 5px 0;">Dimakamkan di</td>
                <td style="padding: 5px 0;">: {{ $pengajuan->data_tambahan['tempat_makam'] ?? '-' }}</td>
            </tr>
        </table>

        <p style="margin: 15px 0; font-size: 11px; line-height: 1.8;">
            <strong>Pelapor Kematian:</strong>
        </p>

        <table style="width: 100%; border-collapse: collapse; margin-bottom: 15px; font-size: 11px;">
            <tr>
                <td style="width: 120px; padding: 5px 0;">Nama Pelapor</td>
                <td style="padding: 5px 0;">: {{ $pengajuan->nama_pemohon }}</td>
            </tr>
            <tr>
                <td style="padding: 5px 0;">NIK</td>
                <td style="padding: 5px 0;">: {{ $pengajuan->nik_pemohon }}</td>
            </tr>
            <tr>
                <td style="padding: 5px 0;">Hubungan dengan Almarhum</td>
                <td style="padding: 5px 0;">: -</td>
            </tr>
        </table>

        <p style="margin: 15px 0; font-size: 11px; line-height: 1.8;">
            Dengan demikian surat keterangan kematian ini diberikan kepada yang bersangkutan untuk keperluan: <strong>{{ $pengajuan->keperluan }}</strong>
        </p>

        <p style="margin: 20px 0; font-size: 11px; line-height: 1.8;">
            Demikian surat keterangan ini dibuat dan diberikan untuk dipergunakan sesuai dengan keperluan.
        </p>
    </div>

    <div class="footer-content">
        <div style="display: flex; justify-content: flex-end; margin-top: 30px;">
            <div style="text-align: center; width: 220px;">
                <div style="font-size: 11px; margin-bottom: 5px;">LURAH DESA SRUNI,</div>
                @include("pengajuan.components.qr-code-section", ["pengajuan" => $pengajuan])
                <div style="border-top: 1px solid #000; width: 100%; margin: 15px 0 3px 0;"></div>
                <div style="font-weight: bold; margin-top: 3px; font-size: 11px;">(________________________)</div>
            </div>
        </div>
    </div>
</div>

@elseif($pengajuan->jenis_surat === 'Surat Keterangan Tidak Mampu' || ($pengajuan->data_tambahan['jenis_surat_asli'] ?? '') === 'Surat Keterangan Tidak Mampu')
<!-- SURAT KETERANGAN TIDAK MAMPU -->
<div class="surat">
    <div class="content">
        <div class="header">
            <div class="header-title">PEMERINTAH DESA SRUNI</div>
            <div class="header-subtitle">SURAT KETERANGAN TIDAK MAMPU (SKTM)</div>
            <div class="nomor">No. {{ $pengajuan->nomor_pengajuan ?? 'Draft' }}</div>
        </div>

        <div style="margin-bottom: 20px; text-align: right; font-size: 11px;">
            <div>Dikeluarkan pada :</div>
            <div style="font-weight: bold; margin-top: 3px;">{{ now()->format('d F Y') }}</div>
        </div>

        <p style="margin-bottom: 15px; font-size: 11px; line-height: 1.8;">
            Berdasarkan permohonan yang telah diajukan, dengan ini kami menerangkan bahwa:
        </p>

        <table style="width: 100%; border-collapse: collapse; margin-bottom: 15px; font-size: 11px;">
            <tr>
                <td style="width: 120px; padding: 5px 0;">Nama Lengkap</td>
                <td style="padding: 5px 0;">: <strong>{{ $pengajuan->nama_pemohon }}</strong></td>
            </tr>
            <tr>
                <td style="padding: 5px 0;">NIK</td>
                <td style="padding: 5px 0;">: {{ $pengajuan->nik_pemohon }}</td>
            </tr>
            <tr>
                <td style="padding: 5px 0;">Tempat, Tanggal Lahir</td>
                <td style="padding: 5px 0;">: {{ $pengajuan->tempat_lahir_pemohon }}, {{ optional($pengajuan->tanggal_lahir_pemohon)->format('d-m-Y') ?? '-' }}</td>
            </tr>
            <tr>
                <td style="padding: 5px 0;">Pekerjaan</td>
                <td style="padding: 5px 0;">: {{ $pengajuan->pekerjaan_pemohon }}</td>
            </tr>
            <tr>
                <td style="padding: 5px 0;">Alamat</td>
                <td style="padding: 5px 0;">: {{ $pengajuan->alamat_pemohon }}</td>
            </tr>
        </table>

        <p style="margin: 15px 0; font-size: 11px; line-height: 1.8;">
            <strong>Adalah penduduk kami yang benar-benar tidak mampu dari segi ekonomi.</strong>
        </p>

        <p style="margin: 15px 0; font-size: 11px; line-height: 1.8;">
            Surat keterangan ini dibuat sebagai bukti ketidakmampuan untuk keperluan: <strong>{{ $pengajuan->keperluan }}</strong>
        </p>

        <p style="margin: 20px 0; font-size: 11px; line-height: 1.8;">
            Demikian surat keterangan ini dibuat dan diberikan untuk dipergunakan sesuai dengan keperluan yang ditunjuk.
        </p>
    </div>

    <div class="footer-content">
        <div style="margin-top: 30px; overflow: auto;">
            <div style="float: right; text-align: center; width: 220px;">
                <div style="font-size: 11px; margin-bottom: 5px;">LURAH DESA SRUNI,</div>
                @include("pengajuan.components.qr-code-section", ["pengajuan" => $pengajuan])
                <div style="border-top: 1px solid #000; width: 100%; margin: 15px 0 3px 0;"></div>
                <div style="font-weight: bold; margin-top: 3px; font-size: 11px;">(________________________)</div>
            </div>
        </div>
    </div>
</div>

@else
<!-- DEFAULT - SURAT UMUM -->
<div class="surat">
    <div class="content">
        <div class="header">
            <div class="header-title">PEMERINTAH DESA SRUNI</div>
            <div class="header-subtitle">SURAT HASIL PENGAJUAN</div>
            <div class="nomor">No. {{ $pengajuan->nomor_pengajuan ?? 'Draft' }}</div>
        </div>

        <div style="margin-bottom: 20px; text-align: right; font-size: 11px;">
            <div>Dikeluarkan pada :</div>
            <div style="font-weight: bold; margin-top: 3px;">{{ now()->format('d F Y') }}</div>
        </div>

        <p style="margin-bottom: 15px; font-size: 11px; line-height: 1.8;">
            Berdasarkan permohonan yang telah diajukan, dengan ini kami menerangkan bahwa:
        </p>

        <table style="width: 100%; border-collapse: collapse; margin-bottom: 15px; font-size: 11px;">
            <tr>
                <td style="width: 120px; padding: 5px 0;">Nama</td>
                <td style="padding: 5px 0;">: <strong>{{ $pengajuan->nama_pemohon }}</strong></td>
            </tr>
            <tr>
                <td style="padding: 5px 0;">NIK</td>
                <td style="padding: 5px 0;">: {{ $pengajuan->nik_pemohon }}</td>
            </tr>
            <tr>
                <td style="padding: 5px 0;">Tempat, Tanggal Lahir</td>
                <td style="padding: 5px 0;">: {{ $pengajuan->tempat_lahir_pemohon }}, {{ optional($pengajuan->tanggal_lahir_pemohon)->format('d-m-Y') ?? '-' }}</td>
            </tr>
            <tr>
                <td style="padding: 5px 0;">Pekerjaan</td>
                <td style="padding: 5px 0;">: {{ $pengajuan->pekerjaan_pemohon }}</td>
            </tr>
            <tr>
                <td style="padding: 5px 0;">Alamat</td>
                <td style="padding: 5px 0;">: {{ $pengajuan->alamat_pemohon }}</td>
            </tr>
        </table>

        <p style="margin: 15px 0; font-size: 11px; line-height: 1.8;">
            Dengan demikian surat keterangan ini diberikan kepada yang bersangkutan untuk keperluan: <strong>{{ $pengajuan->keperluan }}</strong>
        </p>

        <p style="margin: 20px 0; font-size: 11px; line-height: 1.8;">
            Demikian surat keterangan ini dibuat dan diberikan untuk dipergunakan sesuai dengan keperluan.
        </p>
    </div>

    <div class="footer-content">
        <div style="margin-top: 30px; overflow: auto;">
            <div style="float: right; text-align: center; width: 220px;">
                <div style="font-size: 11px; margin-bottom: 5px;">LURAH DESA SRUNI,</div>
                @include("pengajuan.components.qr-code-section", ["pengajuan" => $pengajuan])
                <div style="border-top: 1px solid #000; width: 100%; margin: 15px 0 3px 0;"></div>
                <div style="font-weight: bold; margin-top: 3px; font-size: 11px;">(________________________)</div>
            </div>
        </div>
    </div>
</div>
@endif












