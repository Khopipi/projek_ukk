<?php

require 'vendor/autoload.php';

use Illuminate\Foundation\Application;
use App\Models\PengajuanSurat;

// Bootstrap Laravel
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Simulate Auth
app('auth')->loginUsingId(2);

// Get the latest pengajuan
$pengajuan = PengajuanSurat::latest()->first();

echo "🧪 Testing QR Display in Preview Surat\n";
echo "======================================\n\n";

// Simulate previewSurat flow
echo "[1] Testing previewSurat() controller method:\n";

// Step 1: Check/generate signature token
if (!$pengajuan->signature_token) {
    $signatureToken = \App\Helpers\QrCodeGenerator::generateSignatureToken($pengajuan->id, 2);
    $pengajuan->update([
        'signature_token' => $signatureToken,
        'signature_generated_at' => now()
    ]);
    echo "    ✓ Generated new signature token\n";
} else {
    echo "    ✓ Signature token already exists: {$pengajuan->signature_token}\n";
}

// Step 2: Generate QR
$qrUrl = \App\Helpers\QrCodeGenerator::generateQrUrl($pengajuan->signature_token);
$qrPath = \App\Helpers\QrCodeGenerator::generateAndSaveQrCode($qrUrl);
$qrBase64 = \App\Helpers\QrCodeGenerator::getQrCodeAsBase64($qrPath);

echo "    ✓ QR Path: $qrPath\n";
echo "    ✓ QR Base64 Length: " . strlen($qrBase64) . " bytes\n";

// Step 3: Render view with qrPath and qrBase64
echo "\n[2] Rendering preview-surat view:\n";
$html = view('admin.pengajuan.preview-surat', compact('pengajuan', 'qrPath', 'qrBase64'))->render();

echo "    ✓ HTML rendered: " . strlen($html) . " bytes\n";

// Step 4: Check if QR code is in HTML
if (strpos($html, 'data:image/png;base64,iVBORw0KGgo') !== false) {
    echo "    ✓ Base64 QR code FOUND in HTML!\n";
} else {
    echo "    ⚠ Base64 QR code not found\n";
}

// Check for img tag
if (preg_match('/<img[^>]*alt="QR Code"/', $html)) {
    echo "    ✓ QR img tag found\n";
} else {
    echo "    ⚠ QR img tag not found\n";
}

// Check for placeholder text
if (strpos($html, 'belum di-generate') !== false) {
    echo "    ⚠ Still showing placeholder text (should not happen)\n";
} else {
    echo "    ✓ No placeholder text (good!)\n";
}

echo "\n✅ Preview Surat QR Display Test Complete!\n";
echo "\nNow you should see QR code in admin preview! 🎯\n";
