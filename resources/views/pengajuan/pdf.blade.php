<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Surat Hasil - {{ $pengajuan->nomor_pengajuan }}</title>
    <style>
        * { margin: 0; padding: 0; }
        body { 
            font-family: 'Calibri', 'Arial', sans-serif; 
            color: #000; 
            font-size: 14px; 
            line-height: 1.5; 
            background: #fff;
        }
        .surat { 
            max-width: 800px; 
            margin: 0 auto; 
            background: #fff; 
            padding: 20px 30px; 
            min-height: 100vh; 
        }
        .content { margin-bottom: 15px; }
        .footer-content { margin-top: 30px; }
        .header { 
            margin-bottom: 15px; 
            border-bottom: 3px solid #000; 
            padding-bottom: 10px; 
            position: relative;
            text-align: center;
        }
        .header-row { 
            position: relative;
            width: 100%; 
            margin-bottom: 8px;
            text-align: center;
        }
        .header-logo { 
            position: absolute;
            left: 0; 
            top: 0;
            width: 70px;
        }
        .header-logo img { 
            width: 60px; 
            height: 60px; 
        }
        .header-text { 
            text-align: center;
        }
        .header-title { 
            font-size: 15px; 
            font-weight: bold; 
            color: #000; 
            margin-bottom: 1px; 
            letter-spacing: 0.5px; 
        }
        .header-subtitle { 
            font-size: 14px; 
            font-weight: bold;
            color: #000; 
            margin-bottom: 2px; 
            letter-spacing: 0.3px; 
        }
        .nomor { 
            font-size: 13px; 
            color: #333; 
            margin-top: 2px; 
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin: 8px 0;
        }
        td {
            padding: 3px 0;
            font-size: 14px;
            line-height: 1.5;
        }
        p {
            margin: 8px 0;
            font-size: 14px;
            line-height: 1.6;
            text-align: justify;
        }
        .signature-section { 
            margin-top: 25px; 
            text-align: right;
        }
        .signature-box { 
            text-align: center; 
            width: 200px;
            margin-left: auto;
            margin-right: 0;
        }
        .signature-line { 
            border-top: 1px solid #000; 
            width: 100%; 
            margin: 35px 0 2px 0; 
        }
        .signature-name { 
            font-weight: bold; 
            margin-top: 3px; 
            font-size: 13px;
        }
        .qr-section {
            text-align: center;
            margin: 8px 0;
        }
        /* Global font size override untuk consistency */
        * { font-size: 14px !important; }
        .header-title { font-size: 15px !important; }
        .header-subtitle { font-size: 14px !important; }
        .nomor { font-size: 13px !important; }
        .signature-name { font-size: 13px !important; }
    </style>
</head>
<body>

@if($pengajuan->jenis_surat === 'Surat Warisan' || ($pengajuan->data_tambahan['jenis_surat_asli'] ?? '') === 'Surat Warisan')
<!-- SURAT WARISAN -->
<div class="surat">
    <div class="content">
        <div class="header">
            <div class="header-row">
                <div class="header-logo">
                    <img src="{{ $logoBase64 ?? public_path('assets/images/my/logo_Sidoarjo.svg.png') }}" alt="Logo Sidoarjo">
                </div>
                <div class="header-text">
                    <div class="header-title">PEMERINTAH DESA SRUNI</div>
                    <div class="header-subtitle">SURAT KETERANGAN WARISAN</div>
                    <div class="nomor">No. {{ $pengajuan->nomor_pengajuan ?? 'Draft' }}</div>
                </div>
            </div>
        </div>

        <div style="margin-bottom: 20px; text-align: right; font-size: 11px;">
            <div>Dikeluarkan pada :</div>
            <div style="font-weight: bold; margin-top: 3px;">{{ now()->format('d F Y') }}</div>
        </div>

        <p style="margin-bottom: 15px;">
            Berdasarkan permohonan yang telah diajukan, dengan ini kami menerangkan bahwa:
        </p>

        <table style="margin-bottom: 15px;">
            <tr>
                <td style="width: 120px;">Nama</td>
                <td>: <strong>{{ $pengajuan->nama_pemohon }}</strong></td>
            </tr>
            <tr>
                <td>NIK</td>
                <td>: {{ $pengajuan->nik_pemohon }}</td>
            </tr>
            <tr>
                <td>Tempat, Tanggal Lahir</td>
                <td>: {{ $pengajuan->tempat_lahir_pemohon }}, {{ optional($pengajuan->tanggal_lahir_pemohon)->format('d-m-Y') ?? '-' }}</td>
            </tr>
            <tr>
                <td>Jenis Kelamin</td>
                <td>: {{ $pengajuan->jenis_kelamin_pemohon }}</td>
            </tr>
            <tr>
                <td>Pekerjaan</td>
                <td>: {{ $pengajuan->pekerjaan_pemohon }}</td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>: {{ $pengajuan->alamat_pemohon }}</td>
            </tr>
        </table>

        <p style="margin-bottom: 10px;">
            <strong>Adalah orang yang mempunyai hubungan dengan pewaris atas nama {{ $pengajuan->data_tambahan['nama_almarhum'] ?? '-' }} (telah meninggal), dengan hubungan: <u>{{ $pengajuan->data_tambahan['hubungan_almarhum'] ?? '-' }}</u></strong>
        </p>

        <p style="margin-bottom: 10px;">
            <strong>Pewaris tersebut telah meninggal dunia dan meninggalkan warisan yang perlu diatur sesuai dengan ketentuan hukum yang berlaku.</strong>
        </p>

        <p style="margin: 15px 0;">
            Adapun ahli waris dari pewaris di atas adalah:
        </p>

        <div style="margin: 15px 0; padding: 10px; border: 1px solid #ccc;">
            {{ $pengajuan->data_tambahan['daftar_penerima'] ?? '-' }}
        </div>

        <p style="margin: 15px 0;">
            Dengan demikian surat keterangan warisan ini diberikan kepada yang bersangkutan untuk keperluan: <strong>{{ $pengajuan->keperluan }}</strong>
        </p>

        <p style="margin: 20px 0;">
            Demikian surat keterangan ini dibuat dan diberikan untuk dipergunakan sesuai dengan keperluan.
        </p>
    </div>

    <div class="footer-content">
        <div class="signature-section">
            <div class="signature-box">
                <div style="font-size: 11px; margin-bottom: 5px;">LURAH DESA SRUNI</div>
                <div class="qr-section">
                    @include("pengajuan.components.qr-code-section", ["pengajuan" => $pengajuan])
                </div>
                <div class="signature-line"></div>
                <div class="signature-name">(________________________)</div>
            </div>
        </div>
    </div>
</div>

@elseif($pengajuan->jenis_surat === 'Surat Nikah' || ($pengajuan->data_tambahan['jenis_surat_asli'] ?? '') === 'Surat Nikah')
<!-- SURAT NIKAH -->
<div class="surat">
    <div class="content">
        <div class="header">
            <div class="header-row">
                <div class="header-logo">
                    <img src="{{ $logoBase64 ?? public_path('assets/images/my/logo_Sidoarjo.svg.png') }}" alt="Logo Sidoarjo">
                </div>
                <div class="header-text">
                    <div class="header-title">PEMERINTAH DESA SRUNI</div>
                    <div class="header-subtitle">SURAT KETERANGAN PENCATATAN PERKAWINAN</div>
                    <div class="nomor">No. {{ $pengajuan->nomor_pengajuan ?? 'Draft' }}</div>
                </div>
            </div>
        </div>

        <div style="margin-bottom: 20px; text-align: right; font-size: 11px;">
            <div>Dikeluarkan pada :</div>
            <div style="font-weight: bold; margin-top: 3px;">{{ now()->format('d F Y') }}</div>
        </div>

        <p style="margin-bottom: 15px;">
            Berdasarkan permohonan yang telah diajukan, dengan ini kami menerangkan bahwa:
        </p>

        <table style="margin-bottom: 15px;">
            <tr>
                <td style="width: 120px;">Nama Lengkap</td>
                <td>: <strong>{{ $pengajuan->nama_pemohon }}</strong></td>
            </tr>
            <tr>
                <td>NIK</td>
                <td>: {{ $pengajuan->nik_pemohon }}</td>
            </tr>
            <tr>
                <td>Tempat, Tanggal Lahir</td>
                <td>: {{ $pengajuan->tempat_lahir_pemohon }}, {{ optional($pengajuan->tanggal_lahir_pemohon)->format('d-m-Y') ?? '-' }}</td>
            </tr>
            <tr>
                <td>Jenis Kelamin</td>
                <td>: {{ $pengajuan->jenis_kelamin_pemohon }}</td>
            </tr>
            <tr>
                <td>Pekerjaan</td>
                <td>: {{ $pengajuan->pekerjaan_pemohon }}</td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>: {{ $pengajuan->alamat_pemohon }}</td>
            </tr>
        </table>

        <p style="margin: 15px 0;">
            <strong>Adalah orang yang telah memasuki jenjang perkawinan dengan rincian sebagai berikut:</strong>
        </p>

        <table style="margin-bottom: 15px;">
            <tr>
                <td style="width: 140px;">Calon Pengantin Pria</td>
                <td>: {{ $pengajuan->data_tambahan['nama_calon_pria'] ?? '-' }}</td>
            </tr>
            <tr>
                <td>Calon Pengantin Wanita</td>
                <td>: {{ $pengajuan->data_tambahan['nama_calon_wanita'] ?? '-' }}</td>
            </tr>
            <tr>
                <td>Tanggal Pernikahan</td>
                <td>: {{ isset($pengajuan->data_tambahan['tanggal_nikah_rencana']) ? \Carbon\Carbon::parse($pengajuan->data_tambahan['tanggal_nikah_rencana'])->format('d F Y') : '-' }}</td>
            </tr>
            <tr>
                <td>Tempat Pernikahan</td>
                <td>: {{ $pengajuan->data_tambahan['tempat_nikah'] ?? '-' }}</td>
            </tr>
        </table>

        <p style="margin: 15px 0;">
            Dengan demikian surat keterangan perkawinan ini diberikan kepada yang bersangkutan untuk keperluan: <strong>{{ $pengajuan->keperluan }}</strong>
        </p>

        <p style="margin: 20px 0;">
            Demikian surat keterangan ini dibuat dan diberikan untuk dipergunakan sesuai dengan keperluan.
        </p>
    </div>

    <div class="footer-content">
        <div class="signature-section">
            <div class="signature-box">
                <div style="font-size: 11px; margin-bottom: 5px;">LURAH DESA SRUNI</div>
                <div class="qr-section">
                    @include("pengajuan.components.qr-code-section", ["pengajuan" => $pengajuan])
                </div>
                <div class="signature-line"></div>
                <div class="signature-name">(________________________)</div>
            </div>
        </div>
    </div>
</div>

@elseif($pengajuan->jenis_surat === 'Surat Tanah' || ($pengajuan->data_tambahan['jenis_surat_asli'] ?? '') === 'Surat Tanah')
<!-- SURAT TANAH -->
<div class="surat">
    <div class="content">
        <div class="header">
            <div class="header-row">
                <div class="header-logo">
                    <img src="{{ $logoBase64 ?? public_path('assets/images/my/logo_Sidoarjo.svg.png') }}" alt="Logo Sidoarjo">
                </div>
                <div class="header-text">
                    <div class="header-title">PEMERINTAH DESA SRUNI</div>
                    <div class="header-subtitle">SURAT KEPEMILIKAN TANAH</div>
                    <div class="nomor">No. {{ $pengajuan->nomor_pengajuan ?? 'Draft' }}</div>
                </div>
            </div>
        </div>

        <div style="margin-bottom: 20px; text-align: right; font-size: 11px;">
            <div>Dikeluarkan pada :</div>
            <div style="font-weight: bold; margin-top: 3px;">{{ now()->format('d F Y') }}</div>
        </div>

        <p style="margin-bottom: 15px;">
            Berdasarkan permohonan yang telah diajukan, dengan ini kami menerangkan bahwa:
        </p>

        <table style="margin-bottom: 15px;">
            <tr>
                <td style="width: 120px;">Nama Pemilik</td>
                <td>: <strong>{{ $pengajuan->nama_pemohon }}</strong></td>
            </tr>
            <tr>
                <td>NIK</td>
                <td>: {{ $pengajuan->nik_pemohon }}</td>
            </tr>
            <tr>
                <td>Pekerjaan</td>
                <td>: {{ $pengajuan->pekerjaan_pemohon }}</td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>: {{ $pengajuan->alamat_pemohon }}</td>
            </tr>
        </table>

        <p style="margin: 15px 0;">
            <strong>Adalah orang yang memiliki tanah dengan rincian sebagai berikut:</strong>
        </p>

        <table style="margin-bottom: 15px;">
            <tr>
                <td style="width: 120px;">Alamat Tanah</td>
                <td>: {{ $pengajuan->data_tambahan['alamat_tanah'] ?? '-' }}</td>
            </tr>
            <tr>
                <td>Luas Tanah</td>
                <td>: {{ $pengajuan->data_tambahan['luas_tanah'] ?? '-' }} m²</td>
            </tr>
        </table>

        <p style="margin: 15px 0;">
            Dengan demikian surat keterangan tanah ini diberikan kepada yang bersangkutan untuk keperluan: <strong>{{ $pengajuan->keperluan }}</strong>
        </p>

        <p style="margin: 20px 0;">
            Demikian surat keterangan ini dibuat dan diberikan untuk dipergunakan sesuai dengan keperluan.
        </p>
    </div>

    <div class="footer-content">
        <div class="signature-section">
            <div class="signature-box">
                <div style="font-size: 11px; margin-bottom: 5px;">LURAH DESA SRUNI</div>
                <div class="qr-section">
                    @include("pengajuan.components.qr-code-section", ["pengajuan" => $pengajuan])
                </div>
                <div class="signature-line"></div>
                <div class="signature-name">(________________________)</div>
            </div>
        </div>
    </div>
</div>

@elseif($pengajuan->jenis_surat === 'Surat Domisili' || ($pengajuan->data_tambahan['jenis_surat_asli'] ?? '') === 'Surat Domisili')
<!-- SURAT DOMISILI -->
<div class="surat">
    <div class="content">
        <div class="header">
            <div class="header-row">
                <div class="header-logo">
                    <img src="{{ $logoBase64 ?? public_path('assets/images/my/logo_Sidoarjo.svg.png') }}" alt="Logo Sidoarjo">
                </div>
                <div class="header-text">
                    <div class="header-title">PEMERINTAH DESA SRUNI</div>
                    <div class="header-subtitle">SURAT KETERANGAN DOMISILI</div>
                    <div class="nomor">No. {{ $pengajuan->nomor_pengajuan ?? 'Draft' }}</div>
                </div>
            </div>
        </div>

        <div style="margin-bottom: 20px; text-align: right; font-size: 11px;">
            <div>Dikeluarkan pada :</div>
            <div style="font-weight: bold; margin-top: 3px;">{{ now()->format('d F Y') }}</div>
        </div>

        <p style="margin-bottom: 15px;">
            Berdasarkan permohonan yang telah diajukan, dengan ini kami menerangkan bahwa:
        </p>

        <table style="margin-bottom: 15px;">
            <tr>
                <td style="width: 120px;">Nama Lengkap</td>
                <td>: <strong>{{ $pengajuan->nama_pemohon }}</strong></td>
            </tr>
            <tr>
                <td>NIK</td>
                <td>: {{ $pengajuan->nik_pemohon }}</td>
            </tr>
            <tr>
                <td>Tempat, Tanggal Lahir</td>
                <td>: {{ $pengajuan->tempat_lahir_pemohon }}, {{ optional($pengajuan->tanggal_lahir_pemohon)->format('d-m-Y') ?? '-' }}</td>
            </tr>
            <tr>
                <td>Pekerjaan</td>
                <td>: {{ $pengajuan->pekerjaan_pemohon }}</td>
            </tr>
        </table>

        <p style="margin: 15px 0;">
            <strong>Dengan ini kami menerangkan bahwa:</strong>
        </p>

        <p style="margin: 10px 0;">
            Seorang warga yang bernama <strong>{{ $pengajuan->nama_pemohon }}</strong> saat ini berdomisili di <strong>{{ $pengajuan->data_tambahan['asal_desa'] ?? '-' }}, {{ $pengajuan->data_tambahan['asal_kota'] ?? '-' }}</strong> dan ingin mengajukan permohonan untuk pindah berdomisili ke <strong>{{ $pengajuan->data_tambahan['tujuan_desa'] ?? '-' }}, {{ $pengajuan->data_tambahan['tujuan_kota'] ?? '-' }}</strong>.
        </p>

        <p style="margin-bottom: 15px;">
            <strong>Adalah benar penduduk/berdomisili di:</strong>
        </p>

        <table style="margin-bottom: 15px;">
            <tr>
                <td style="width: 120px;">Alamat Domisili</td>
                <td>: {{ $pengajuan->data_tambahan['alamat_domisili'] ?? '-' }}</td>
            </tr>
            <tr>
                <td>RT/RW</td>
                <td>: {{ $pengajuan->data_tambahan['rt_rw'] ?? '-' }}</td>
            </tr>
        </table>

        <p style="margin: 15px 0;">
            Dengan demikian surat keterangan domisili ini diberikan kepada yang bersangkutan untuk keperluan: <strong>{{ $pengajuan->keperluan }}</strong>
        </p>

        <p style="margin: 20px 0;">
            Demikian surat keterangan ini dibuat dan diberikan untuk dipergunakan sesuai dengan keperluan.
        </p>
    </div>

    <div class="footer-content">
        <div class="signature-section">
            <div class="signature-box">
                <div style="font-size: 11px; margin-bottom: 5px;">LURAH DESA SRUNI</div>
                <div class="qr-section">
                    @include("pengajuan.components.qr-code-section", ["pengajuan" => $pengajuan])
                </div>
                <div class="signature-line"></div>
                <div class="signature-name">(________________________)</div>
            </div>
        </div>
    </div>
</div>

@elseif($pengajuan->jenis_surat === 'Surat Keterangan Kelahiran' || ($pengajuan->data_tambahan['jenis_surat_asli'] ?? '') === 'Surat Keterangan Kelahiran')
<!-- SURAT KELAHIRAN -->
<div class="surat">
    <div class="content">
        <div class="header">
            <div class="header-row">
                <div class="header-logo">
                    <img src="{{ $logoBase64 ?? public_path('assets/images/my/logo_Sidoarjo.svg.png') }}" alt="Logo Sidoarjo">
                </div>
                <div class="header-text">
                    <div class="header-title">PEMERINTAH DESA SRUNI</div>
                    <div class="header-subtitle">SURAT KETERANGAN KELAHIRAN</div>
                    <div class="nomor">No. {{ $pengajuan->nomor_pengajuan ?? 'Draft' }}</div>
                </div>
            </div>
        </div>

        <div style="margin-bottom: 20px; text-align: right; font-size: 11px;">
            <div>Dikeluarkan pada :</div>
            <div style="font-weight: bold; margin-top: 3px;">{{ now()->format('d F Y') }}</div>
        </div>

        <p style="margin-bottom: 15px;">
            Berdasarkan permohonan yang telah diajukan, dengan ini kami menerangkan bahwa:
        </p>

        <p style="margin: 15px 0;">
            <strong>Orang Tua:</strong>
        </p>

        <table style="margin-bottom: 15px;">
            <tr>
                <td style="width: 120px;">Nama Ayah</td>
                <td>: {{ $pengajuan->data_tambahan['nama_ayah'] ?? '-' }}</td>
            </tr>
            <tr>
                <td>Nama Ibu</td>
                <td>: {{ $pengajuan->data_tambahan['nama_ibu'] ?? '-' }}</td>
            </tr>
        </table>

        <p style="margin: 15px 0;">
            <strong>Telah melahirkan seorang anak dengan rincian:</strong>
        </p>

        <table style="margin-bottom: 15px;">
            <tr>
                <td style="width: 120px;">Nama Bayi</td>
                <td>: {{ $pengajuan->data_tambahan['nama_bayi'] ?? '-' }}</td>
            </tr>
            <tr>
                <td>Tanggal Lahir</td>
                <td>: {{ isset($pengajuan->data_tambahan['tanggal_lahir_bayi']) ? \Carbon\Carbon::parse($pengajuan->data_tambahan['tanggal_lahir_bayi'])->format('d F Y') : '-' }}</td>
            </tr>
            <tr>
                <td>Tempat Lahir</td>
                <td>: {{ $pengajuan->data_tambahan['tempat_lahir_bayi'] ?? '-' }}</td>
            </tr>
            <tr>
                <td>Jenis Kelamin</td>
                <td>: {{ $pengajuan->data_tambahan['jenis_kelamin_bayi'] ?? '-' }}</td>
            </tr>
        </table>

        <p style="margin: 15px 0;">
            Dengan demikian surat keterangan kelahiran ini diberikan kepada yang bersangkutan untuk keperluan: <strong>{{ $pengajuan->keperluan }}</strong>
        </p>

        <p style="margin: 20px 0;">
            Demikian surat keterangan ini dibuat dan diberikan untuk dipergunakan sesuai dengan keperluan.
        </p>
    </div>

    <div class="footer-content">
        <div class="signature-section">
            <div class="signature-box">
                <div style="font-size: 11px; margin-bottom: 5px;">LURAH DESA SRUNI,</div>
                <div class="qr-section">
                    @include("pengajuan.components.qr-code-section", ["pengajuan" => $pengajuan])
                </div>
                <div class="signature-line"></div>
                <div class="signature-name">(________________________)</div>
            </div>
        </div>
    </div>
</div>

@elseif($pengajuan->jenis_surat === 'Surat Akta Kematian' || ($pengajuan->data_tambahan['jenis_surat_asli'] ?? '') === 'Surat Akta Kematian')
<!-- SURAT AKTA KEMATIAN -->
<div class="surat">
    <div class="content">
        <div class="header">
            <div class="header-row">
                <div class="header-logo">
                    <img src="{{ $logoBase64 ?? public_path('assets/images/my/logo_Sidoarjo.svg.png') }}" alt="Logo Sidoarjo">
                </div>
                <div class="header-text">
                    <div class="header-title">PEMERINTAH DESA SRUNI</div>
                    <div class="header-subtitle">SURAT AKTA KEMATIAN</div>
                    <div class="nomor">No. {{ $pengajuan->nomor_pengajuan ?? 'Draft' }}</div>
                </div>
            </div>
        </div>

        <div style="margin-bottom: 20px; text-align: right; font-size: 11px;">
            <div>Dikeluarkan pada :</div>
            <div style="font-weight: bold; margin-top: 3px;">{{ now()->format('d F Y') }}</div>
        </div>

        <p style="margin-bottom: 15px;">
            Berdasarkan permohonan yang telah diajukan, dengan ini kami menerangkan bahwa:
        </p>

        <p style="margin: 15px 0;">
            <strong>Data Almarhum / Almarhumah:</strong>
        </p>

        <table style="margin-bottom: 15px;">
            <tr>
                <td style="width: 120px;">Nama Almarhum</td>
                <td>: <strong>{{ $pengajuan->data_tambahan['nama_almarhum'] ?? '-' }}</strong></td>
            </tr>
            <tr>
                <td>Tempat, Tanggal Lahir</td>
                <td>: {{ $pengajuan->data_tambahan['tempat_lahir_almarhum'] ?? '-' }}, {{ isset($pengajuan->data_tambahan['tanggal_lahir_almarhum']) ? \Carbon\Carbon::parse($pengajuan->data_tambahan['tanggal_lahir_almarhum'])->format('d-m-Y') : '-' }}</td>
            </tr>
            <tr>
                <td>Dimakamkan di</td>
                <td>: {{ $pengajuan->data_tambahan['tempat_makam'] ?? '-' }}</td>
            </tr>
        </table>

        <p style="margin: 15px 0;">
            <strong>Pelapor Kematian:</strong>
        </p>

        <table style="margin-bottom: 15px;">
            <tr>
                <td style="width: 120px;">Nama Pelapor</td>
                <td>: {{ $pengajuan->nama_pemohon }}</td>
            </tr>
            <tr>
                <td>NIK</td>
                <td>: {{ $pengajuan->nik_pemohon }}</td>
            </tr>
            <tr>
                <td>Hubungan dengan Almarhum</td>
                <td>: -</td>
            </tr>
        </table>

        <p style="margin: 15px 0;">
            Dengan demikian surat keterangan kematian ini diberikan kepada yang bersangkutan untuk keperluan: <strong>{{ $pengajuan->keperluan }}</strong>
        </p>

        <p style="margin: 20px 0;">
            Demikian surat keterangan ini dibuat dan diberikan untuk dipergunakan sesuai dengan keperluan.
        </p>
    </div>

    <div class="footer-content">
        <div class="signature-section">
            <div class="signature-box">
                <div style="font-size: 11px; margin-bottom: 5px;">LURAH DESA SRUNI,</div>
                <div class="qr-section">
                    @include("pengajuan.components.qr-code-section", ["pengajuan" => $pengajuan])
                </div>
                <div class="signature-line"></div>
                <div class="signature-name">(________________________)</div>
            </div>
        </div>
    </div>
</div>

@elseif($pengajuan->jenis_surat === 'Surat Keterangan Tidak Mampu' || ($pengajuan->data_tambahan['jenis_surat_asli'] ?? '') === 'Surat Keterangan Tidak Mampu')
<!-- SURAT KETERANGAN TIDAK MAMPU -->
<div class="surat">
    <div class="content">
        <div class="header">
            <div class="header-row">
                <div class="header-logo">
                    <img src="{{ $logoBase64 ?? public_path('assets/images/my/logo_Sidoarjo.svg.png') }}" alt="Logo Sidoarjo">
                </div>
                <div class="header-text">
                    <div class="header-title">PEMERINTAH DESA SRUNI</div>
                    <div class="header-subtitle">SURAT KETERANGAN TIDAK MAMPU</div>
                    <div class="nomor">No. {{ $pengajuan->nomor_pengajuan ?? 'Draft' }}</div>
                </div>
            </div>
        </div>

        <div style="margin-bottom: 20px; text-align: right; font-size: 11px;">
            <div>Dikeluarkan pada :</div>
            <div style="font-weight: bold; margin-top: 3px;">{{ now()->format('d F Y') }}</div>
        </div>

        <p style="margin-bottom: 15px;">
            Berdasarkan permohonan yang telah diajukan, dengan ini kami menerangkan bahwa:
        </p>

        <table style="margin-bottom: 15px;">
            <tr>
                <td style="width: 120px;">Nama Lengkap</td>
                <td>: <strong>{{ $pengajuan->nama_pemohon }}</strong></td>
            </tr>
            <tr>
                <td>NIK</td>
                <td>: {{ $pengajuan->nik_pemohon }}</td>
            </tr>
            <tr>
                <td>Tempat, Tanggal Lahir</td>
                <td>: {{ $pengajuan->tempat_lahir_pemohon }}, {{ optional($pengajuan->tanggal_lahir_pemohon)->format('d-m-Y') ?? '-' }}</td>
            </tr>
            <tr>
                <td>Pekerjaan</td>
                <td>: {{ $pengajuan->pekerjaan_pemohon }}</td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>: {{ $pengajuan->alamat_pemohon }}</td>
            </tr>
        </table>

        <p style="margin: 15px 0;">
            <strong>Adalah penduduk kami yang benar-benar tidak mampu dari segi ekonomi.</strong>
        </p>

        <p style="margin: 15px 0;">
            Surat keterangan ini dibuat sebagai bukti ketidakmampuan untuk keperluan: <strong>{{ $pengajuan->keperluan }}</strong>
        </p>

        <p style="margin: 20px 0;">
            Demikian surat keterangan ini dibuat dan diberikan untuk dipergunakan sesuai dengan keperluan yang ditunjuk.
        </p>
    </div>

    <div class="footer-content">
        <div class="signature-section">
            <div class="signature-box">
                <div style="font-size: 11px; margin-bottom: 5px;">LURAH DESA SRUNI,</div>
                <div class="qr-section">
                    @include("pengajuan.components.qr-code-section", ["pengajuan" => $pengajuan])
                </div>
                <div class="signature-line"></div>
                <div class="signature-name">(________________________)</div>
            </div>
        </div>
    </div>
</div>

@else
<!-- DEFAULT - SURAT UMUM -->
<div class="surat">
    <div class="content">
        <div class="header">
            <div class="header-row">
                <div class="header-logo">
                    <img src="{{ $logoBase64 ?? public_path('assets/images/my/logo_Sidoarjo.svg.png') }}" alt="Logo Sidoarjo">
                </div>
                <div class="header-text">
                    <div class="header-title">PEMERINTAH DESA SRUNI</div>
                    <div class="header-subtitle">SURAT HASIL PENGAJUAN</div>
                    <div class="nomor">No. {{ $pengajuan->nomor_pengajuan ?? 'Draft' }}</div>
                </div>
            </div>
        </div>

        <div style="margin-bottom: 20px; text-align: right; font-size: 11px;">
            <div>Dikeluarkan pada :</div>
            <div style="font-weight: bold; margin-top: 3px;">{{ now()->format('d F Y') }}</div>
        </div>

        <p style="margin-bottom: 15px;">
            Berdasarkan permohonan yang telah diajukan, dengan ini kami menerangkan bahwa:
        </p>

        <table style="margin-bottom: 15px;">
            <tr>
                <td style="width: 120px;">Nama</td>
                <td>: <strong>{{ $pengajuan->nama_pemohon }}</strong></td>
            </tr>
            <tr>
                <td>NIK</td>
                <td>: {{ $pengajuan->nik_pemohon }}</td>
            </tr>
            <tr>
                <td>Tempat, Tanggal Lahir</td>
                <td>: {{ $pengajuan->tempat_lahir_pemohon }}, {{ optional($pengajuan->tanggal_lahir_pemohon)->format('d-m-Y') ?? '-' }}</td>
            </tr>
            <tr>
                <td>Pekerjaan</td>
                <td>: {{ $pengajuan->pekerjaan_pemohon }}</td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>: {{ $pengajuan->alamat_pemohon }}</td>
            </tr>
        </table>

        <p style="margin: 15px 0;">
            Dengan demikian surat keterangan ini diberikan kepada yang bersangkutan untuk keperluan: <strong>{{ $pengajuan->keperluan }}</strong>
        </p>

        <p style="margin: 20px 0;">
            Demikian surat keterangan ini dibuat dan diberikan untuk dipergunakan sesuai dengan keperluan.
        </p>
    </div>

    <div class="footer-content">
        <div class="signature-section">
            <div class="signature-box">
                <div style="font-size: 11px; margin-bottom: 5px;">LURAH DESA SRUNI,</div>
                <div class="qr-section">
                    @include("pengajuan.components.qr-code-section", ["pengajuan" => $pengajuan])
                </div>
                <div class="signature-line"></div>
                <div class="signature-name">(________________________)</div>
            </div>
        </div>
    </div>
</div>
@endif

</body>
</html>
