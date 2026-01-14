<?php
use App\Helpers\QrCodeGenerator;

$hasQr = false;
$qrData = null;

try {
    if (empty($pengajuan->signature_token)) {
        $pengajuan->update([
            'signature_token' => QrCodeGenerator::generateSignatureToken(
                $pengajuan->id,
                auth()->id() ?? 1
            )
        ]);
    }

    if (!empty($pengajuan->signature_token)) {
        $qrUrl = QrCodeGenerator::generateQrUrl($pengajuan->signature_token);
        $qrData = QrCodeGenerator::generateSvgBase64($qrUrl);
        $hasQr = !empty($qrData);
    }
} catch (\Throwable $e) {
    logger()->error('QR SVG SECTION ERROR', ['msg' => $e->getMessage()]);
}
?>

@if($hasQr)
    <div style="text-align:center;margin:8px 0;">
        <img src="{{ $qrData }}" width="75" height="75" alt="QR Code">
    </div>
    <div style="font-size:8px;text-align:center;">
        Scan untuk verifikasi
    </div>
@else
    <div style="width:75px;height:75px;margin:8px auto;border:1px dashed #ccc;
        display:flex;align-items:center;justify-content:center;font-size:8px;color:#999;">
        QR Code belum tersedia
    </div>
@endif
