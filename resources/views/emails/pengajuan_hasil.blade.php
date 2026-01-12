<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Surat Hasil Pengajuan</title>
    <style>
        body { font-family: Calibri, Arial, sans-serif; color: #333; line-height: 1.6; }
        .email-container { max-width: 600px; margin: 0 auto; }
        .header { background-color: #f0f0f0; padding: 20px; text-align: center; border-bottom: 3px solid #007bff; }
        .header h1 { margin: 0; font-size: 18px; color: #333; }
        .header p { margin: 5px 0 0 0; color: #666; font-size: 14px; }
        .content { padding: 20px; }
        .info-box { background-color: #f9f9f9; border-left: 4px solid #007bff; padding: 15px; margin: 15px 0; }
        .info-box strong { color: #007bff; }
        .footer { background-color: #f0f0f0; padding: 15px; text-align: center; font-size: 12px; color: #999; border-top: 1px solid #ddd; }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>Surat Hasil Pengajuan</h1>
            <p>Nomor: {{ $pengajuan->nomor_pengajuan }}</p>
        </div>

        <div class="content">
            <p>Yth. <strong>{{ $pengajuan->nama_pemohon }}</strong>,</p>

            <p>Dengan hormat, kami informasikan bahwa permohonan Anda telah selesai diproses.</p>

            <div class="info-box">
                <strong>Detail Pengajuan:</strong>
                <ul style="margin: 10px 0; padding-left: 20px;">
                    <li><strong>Nomor Pengajuan:</strong> {{ $pengajuan->nomor_pengajuan }}</li>
                    <li><strong>Jenis Surat:</strong> {{ $pengajuan->data_tambahan['jenis_surat_asli'] ?? $pengajuan->jenis_surat }}</li>
                    <li><strong>Status:</strong> {{ $pengajuan->status }}</li>
                    <li><strong>Tanggal Selesai:</strong> {{ optional($pengajuan->tanggal_selesai)->format('d F Y') ?? '-' }}</li>
                </ul>
            </div>

            <p>File <strong>{{ $pengajuan->data_tambahan['jenis_surat_asli'] ?? $pengajuan->jenis_surat }}</strong> telah kami lampirkan dalam email ini sebagai dokumen PDF.</p>

            <p style="margin-top: 20px;">Anda dapat mengunduh file surat hasil dari portal layanan kami dengan menggunakan nomor pengajuan di atas.</p>

            <p style="margin-top: 20px;">Jika ada pertanyaan atau memerlukan bantuan lebih lanjut, silakan hubungi:</p>
            <ul style="margin: 10px 0; padding-left: 20px;">
                <li>Email: admin@desa-kelurahan.id</li>
                <li>Telepon: (0xxx) xxxxx</li>
            </ul>

            <p style="margin-top: 20px;">Terima kasih telah menggunakan layanan kami.</p>

            <p style="margin-top: 25px;">Salam hormat,<br><strong>Pemerintah Desa / Kelurahan</strong></p>
        </div>

        <div class="footer">
            <p style="margin: 0;">Email ini dikirim otomatis oleh sistem, mohon tidak membalas email ini.</p>
            <p style="margin: 5px 0 0 0;">© Pemerintah Desa / Kelurahan - Sistem Layanan Surat</p>
        </div>
    </div>
</body>
</html>
