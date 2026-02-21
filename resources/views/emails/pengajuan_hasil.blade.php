<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi Surat Hasil</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 30px 20px;
            text-align: center;
            color: white;
        }
        .header h1 {
            font-size: 24px;
            margin-bottom: 5px;
        }
        .header p {
            font-size: 14px;
            opacity: 0.9;
        }
        .content {
            padding: 30px 20px;
        }
        .greeting {
            font-size: 16px;
            margin-bottom: 20px;
            color: #333;
        }
        .greeting strong {
            color: #667eea;
        }
        .message-box {
            background-color: #f8f9fa;
            border-left: 4px solid #667eea;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .message-box h3 {
            color: #667eea;
            font-size: 16px;
            margin-bottom: 10px;
        }
        .message-box p {
            font-size: 14px;
            line-height: 1.8;
            color: #555;
        }
        .details {
            background-color: #f0f0f0;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            font-size: 14px;
            border-bottom: 1px solid #ddd;
        }
        .detail-row:last-child {
            border-bottom: none;
        }
        .detail-label {
            font-weight: 600;
            color: #333;
            width: 40%;
        }
        .detail-value {
            color: #666;
            text-align: right;
            width: 60%;
        }
        .info-box {
            background-color: #e7f3ff;
            border-left: 4px solid #2196F3;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .info-box p {
            font-size: 13px;
            color: #1565c0;
            line-height: 1.6;
        }
        .warning-box {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .warning-box p {
            font-size: 13px;
            color: #856404;
            line-height: 1.6;
        }
        .cta-section {
            text-align: center;
            margin: 25px 0;
        }
        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            padding: 12px 30px;
            border-radius: 4px;
            font-weight: 600;
            font-size: 14px;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            border-top: 1px solid #e0e0e0;
            font-size: 12px;
            color: #666;
        }
        .footer p {
            margin: 5px 0;
        }
        .success-badge {
            display: inline-block;
            background-color: #28a745;
            color: white;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 15px;
        }
        .surat-type {
            display: inline-block;
            background-color: #e3f2fd;
            color: #1976d2;
            padding: 8px 16px;
            border-radius: 4px;
            font-weight: 600;
            font-size: 14px;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>✓ Surat Telah Diproses</h1>
            <p>Desa Sruni - Sistem Administrasi Online</p>
        </div>

        <!-- Content -->
        <div class="content">
            <!-- Greeting -->
            <div class="greeting">
                Kepada Yth. <strong>{{ $pengajuan->nama_pemohon }}</strong>,
            </div>

            <!-- Success Badge -->
            <div style="text-align: center;">
                <span class="success-badge">✓ BERHASIL DIPROSES</span>
            </div>

            <!-- Message Box -->
            <div class="message-box">
                <h3>📄 Jenis Surat: <span class="surat-type">{{ $pengajuan->jenis_surat }}</span></h3>
                <p>
                    @if($pengajuan->jenis_surat === 'Surat Warisan')
                        Surat Keterangan Warisan Anda telah berhasil diproses dan telah siap untuk digunakan. 
                        Dokumen ini membuktikan hubungan keluarga dan pembagian warisan sesuai dengan ketentuan hukum yang berlaku.
                    @elseif($pengajuan->jenis_surat === 'Surat Nikah')
                        Surat Keterangan Perkawinan Anda telah berhasil diproses dan telah siap untuk digunakan. 
                        Dokumen ini membuktikan status perkawinan Anda sesuai dengan data yang tercatat.
                    @elseif($pengajuan->jenis_surat === 'Surat Tanah')
                        Surat Keterangan Tanah Anda telah berhasil diproses dan telah siap untuk digunakan. 
                        Dokumen ini membuktikan kepemilikan tanah sesuai dengan data yang tercatat di desa.
                    @elseif($pengajuan->jenis_surat === 'Surat Domisili')
                        Surat Keterangan Domisili Anda telah berhasil diproses dan telah siap untuk digunakan. 
                        Dokumen ini membuktikan tempat tinggal Anda sesuai dengan data yang tercatat.
                    @elseif($pengajuan->jenis_surat === 'Surat Keterangan Kelahiran')
                        Surat Keterangan Kelahiran telah berhasil diproses dan telah siap untuk digunakan. 
                        Dokumen ini membuktikan data kelahiran sesuai dengan catatan yang tercatat di desa.
                    @elseif($pengajuan->jenis_surat === 'Surat Akta Kematian')
                        Surat Akta Kematian telah berhasil diproses dan telah siap untuk digunakan. 
                        Dokumen ini merupakan bukti resmi atas pelaporan kematian di desa.
                    @elseif($pengajuan->jenis_surat === 'Surat Keterangan Tidak Mampu')
                        Surat Keterangan Tidak Mampu Anda telah berhasil diproses dan telah siap untuk digunakan. 
                        Dokumen ini membuktikan status ekonomi Anda untuk keperluan tertentu.
                    @else
                        Surat Anda telah berhasil diproses dan telah siap untuk digunakan.
                    @endif
                </p>
            </div>

            <!-- Details -->
            <div class="details">
                <div class="detail-row">
                    <span class="detail-label">Nomor Pengajuan:</span>
                    <span class="detail-value"><strong>{{ $pengajuan->nomor_pengajuan }}</strong></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Tanggal Pengajuan:</span>
                    <span class="detail-value">{{ $pengajuan->created_at->format('d F Y') }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Tanggal Selesai:</span>
                    <span class="detail-value">{{ now()->format('d F Y') }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Keperluan:</span>
                    <span class="detail-value">{{ $pengajuan->keperluan }}</span>
                </div>
            </div>

            <!-- Info Box -->
            <div class="info-box">
                <p>
                    <strong>📎 File Surat Terlampir</strong><br>
                    Surat dalam format PDF telah terlampir pada email ini. Silakan download dan simpan dengan baik untuk keperluan Anda.
                </p>
            </div>

            <!-- Warning Box -->
            <div class="warning-box">
                <p>
                    <strong>⚠️ Penting</strong><br>
                    Surat ini diterbitkan berdasarkan data administrasi yang tercatat di sistem. Pastikan data pribadi Anda sudah benar. 
                    Jika ada kesalahan, segera hubungi kantor desa untuk perbaikan.
                </p>
            </div>

            <!-- Call to Action -->
            <div class="cta-section">
                <p style="margin-bottom: 15px; color: #666; font-size: 14px;">
                    Butuh bantuan? Silakan kunjungi website kami atau hubungi kantor desa
                </p>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p><strong>Desa Sruni</strong></p>
            <p>Sistem Administrasi Online Desa</p>
            <p style="margin-top: 10px; color: #999; font-size: 11px;">
                Email ini dikirim secara otomatis. Jangan balas email ini langsung.
            </p>
        </div>
    </div>
</body>
</html>
