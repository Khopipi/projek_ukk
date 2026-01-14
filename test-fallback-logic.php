<?php

require 'vendor/autoload.php';

use Illuminate\Foundation\Application;
use App\Models\PengajuanSurat;

// Bootstrap Laravel
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$pengajuan = PengajuanSurat::latest()->first();

echo "🔄 Test Fallback Logic (Path Only)\n";
echo "===================================\n\n";

// Generate QR
if (!$pengajuan->signature_token) {
    $token = \App\Helpers\QrCodeGenerator::generateSignatureToken($pengajuan->id, 2);
    $pengajuan->update([
        'signature_token' => $token,
        'signature_generated_at' => now()
    ]);
}

$qrUrl = \App\Helpers\QrCodeGenerator::generateQrUrl($pengajuan->signature_token);
$qrPath = \App\Helpers\QrCodeGenerator::generateAndSaveQrCode($qrUrl);

echo "[1] Test dengan qrPath saja (tanpa qrBase64):\n";

// Render dengan hanya qrPath
$html = view('pengajuan.surat-template', [
    'pengajuan' => $pengajuan,
    'qrPath' => $qrPath,
    // qrBase64 tidak di-pass, atau kosong
    'qrBase64' => null
])->render();

if (strpos($html, 'belum di-generate') !== false) {
    echo "    ✗ SHOWING PLACEHOLDER\n";
} else {
    echo "    ✓ NOT showing placeholder\n";
}

if (preg_match('/<img[^>]*alt="QR Code"/', $html)) {
    echo "    ✓ QR img tag found\n";
    
    // Extract src
    if (preg_match('/<img[^>]*src="([^"]+)"/', $html, $m)) {
        $src = $m[1];
        if (strpos($src, 'storage/qr_codes') !== false) {
            echo "    ✓ Using file path: " . substr($src, 0, 60) . "...\n";
        } else if (strpos($src, 'data:image') === 0) {
            echo "    ⚠ Using base64 (unexpected)\n";
        } else {
            echo "    Src: $src\n";
        }
    }
} else {
    echo "    ✗ QR img tag NOT found\n";
}

echo "\n[2] Test dengan qrBase64:\n";

$qrBase64 = \App\Helpers\QrCodeGenerator::getQrCodeAsBase64($qrPath);

$html2 = view('pengajuan.surat-template', [
    'pengajuan' => $pengajuan,
    'qrPath' => $qrPath,
    'qrBase64' => $qrBase64
])->render();

if (strpos($html2, 'belum di-generate') !== false) {
    echo "    ✗ SHOWING PLACEHOLDER\n";
} else {
    echo "    ✓ NOT showing placeholder\n";
}

if (preg_match('/<img[^>]*src="(data:image[^"]*)"/', $html2, $m)) {
    echo "    ✓ Using base64 data URI\n";
    echo "    Length: " . strlen($m[1]) . " bytes\n";
}

echo "\n✅ Fallback test complete\n";
