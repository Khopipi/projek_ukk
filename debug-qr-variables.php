<?php

require 'vendor/autoload.php';

use Illuminate\Foundation\Application;
use App\Models\PengajuanSurat;

// Bootstrap Laravel
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Simulate Auth
app('auth')->loginUsingId(2);

$pengajuan = PengajuanSurat::latest()->first();

echo "📋 DEBUG: QR Code Variables in Template\n";
echo "========================================\n\n";

// Test values
$qrPath = "/storage/qr_codes/test.png";
$qrBase64 = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAKoAAACq...";

echo "[1] Variable Check:\n";
echo "    \$qrPath = " . ($qrPath ? "'$qrPath'" : "NULL") . "\n";
echo "    \$qrBase64 = " . (strlen($qrBase64) > 0 ? strlen($qrBase64) . " bytes" : "NULL") . "\n";
echo "    isset(\$qrPath) = " . (isset($qrPath) ? "TRUE" : "FALSE") . "\n";
echo "    isset(\$qrBase64) = " . (isset($qrBase64) ? "TRUE" : "FALSE") . "\n";

echo "\n[2] Condition Check (@if):\n";
if ($pengajuan->signature_token && $pengajuan->signature_generated_at && isset($qrPath)) {
    echo "    ✓ Condition TRUE - QR code will show\n";
} else {
    echo "    ✗ Condition FALSE - Placeholder will show\n";
    echo "    signature_token: " . ($pengajuan->signature_token ? "OK" : "MISSING") . "\n";
    echo "    signature_generated_at: " . ($pengajuan->signature_generated_at ? "OK" : "MISSING") . "\n";
    echo "    isset(\$qrPath): " . (isset($qrPath) ? "OK" : "MISSING") . "\n";
}

echo "\n[3] Test Actual Template Rendering:\n";

// Render with actual QR
$pengajuan_fresh = $pengajuan->fresh();
if (!$pengajuan_fresh->signature_token) {
    $token = \App\Helpers\QrCodeGenerator::generateSignatureToken($pengajuan_fresh->id, 2);
    $pengajuan_fresh->update([
        'signature_token' => $token,
        'signature_generated_at' => now()
    ]);
}

$qrUrl = \App\Helpers\QrCodeGenerator::generateQrUrl($pengajuan_fresh->signature_token);
$qrPath_real = \App\Helpers\QrCodeGenerator::generateAndSaveQrCode($qrUrl);
$qrBase64_real = \App\Helpers\QrCodeGenerator::getQrCodeAsBase64($qrPath_real);

echo "    Generated qrPath: $qrPath_real\n";
echo "    Generated qrBase64: " . strlen($qrBase64_real) . " bytes\n";

// Render template include
$html = view('pengajuan.surat-template', [
    'pengajuan' => $pengajuan_fresh,
    'qrPath' => $qrPath_real,
    'qrBase64' => $qrBase64_real
])->render();

echo "\n[4] HTML Check:\n";
if (strpos($html, 'data:image/png;base64,iVBORw0KGgo') !== false) {
    echo "    ✓ Base64 found in HTML\n";
} else {
    echo "    ✗ Base64 NOT found\n";
}

if (preg_match('/<img[^>]*alt="QR Code"/', $html)) {
    echo "    ✓ QR img tag found\n";
    if (preg_match('/<img[^>]*src="([^"]+)"[^>]*alt="QR Code"/', $html, $m)) {
        $src = substr($m[1], 0, 100);
        echo "    Src: " . $src . "...\n";
    }
} else {
    echo "    ✗ QR img tag NOT found\n";
}

if (strpos($html, 'belum di-generate') !== false) {
    echo "    ⚠ Showing placeholder (belum di-generate)\n";
} else {
    echo "    ✓ Not showing placeholder\n";
}

echo "\n✅ Debug complete\n";
