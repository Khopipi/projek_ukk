<?php

require 'vendor/autoload.php';

use Illuminate\Foundation\Application;
use App\Models\PengajuanSurat;

// Bootstrap Laravel
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Simulate authenticated user
app('auth')->loginUsingId(2);

$pengajuan = PengajuanSurat::latest()->first();

echo "🧪 Simulate Controller previewSurat()\n";
echo "====================================\n\n";

// EXACT SAME CODE AS CONTROLLER
if (!$pengajuan->signature_token) {
    $signatureToken = \App\Helpers\QrCodeGenerator::generateSignatureToken($pengajuan->id, auth()->id());
    $pengajuan->update([
        'signature_token' => $signatureToken,
        'signature_generated_at' => now()
    ]);
    echo "Generated new token\n";
}

// Generate QR code untuk preview
$qrPath = null;
$qrBase64 = null;
if ($pengajuan->signature_token && $pengajuan->signature_generated_at) {
    $qrUrl = \App\Helpers\QrCodeGenerator::generateQrUrl($pengajuan->signature_token);
    $qrPath = \App\Helpers\QrCodeGenerator::generateAndSaveQrCode($qrUrl);
    $qrBase64 = \App\Helpers\QrCodeGenerator::getQrCodeAsBase64($qrPath);
}

echo "[1] QR Variables Before View:\n";
echo "    \$qrPath: " . ($qrPath ? "✓ $qrPath" : "✗ NULL") . "\n";
echo "    \$qrBase64: " . ($qrBase64 ? "✓ " . strlen($qrBase64) . " bytes" : "✗ NULL") . "\n";

// Now render with compact - same as controller
$html = view('admin.pengajuan.preview-surat', compact('pengajuan', 'qrPath', 'qrBase64'))->render();

echo "\n[2] Check HTML Output:\n";

// Find all img tags
if (preg_match_all('/<img[^>]*alt="QR Code"[^>]*src="([^"]*)"/', $html, $m)) {
    echo "    ✓ Found QR img tag!\n";
    $src = $m[1][0];
    
    echo "    Source type: ";
    if (strpos($src, 'data:image') === 0) {
        echo "Base64 Data URI\n";
        echo "    Length: " . strlen($src) . " bytes\n";
    } else if (strpos($src, 'storage') !== false) {
        echo "File Path\n";
        echo "    Path: $src\n";
    } else if (strlen($src) === 0) {
        echo "EMPTY!\n";
    } else {
        echo "Other: " . substr($src, 0, 50) . "\n";
    }
} else {
    echo "    ✗ NO QR img tag found!\n";
    
    // Check if showing placeholder
    if (strpos($html, 'belum di-generate') !== false) {
        echo "    Showing placeholder instead\n";
    }
    
    // Try to find any img tags
    if (preg_match_all('/<img[^>]*/', $html, $imgs)) {
        echo "\n    Found other img tags:\n";
        foreach (array_slice($imgs[0], 0, 3) as $img) {
            echo "      " . substr($img, 0, 80) . "...\n";
        }
    }
}

// Also check surat-template directly
echo "\n[3] Direct surat-template render:\n";
$direct_html = view('pengajuan.surat-template', compact('pengajuan', 'qrPath', 'qrBase64'))->render();

if (preg_match('/<img[^>]*alt="QR Code"[^>]*src="([^"]*)"/', $direct_html, $m)) {
    echo "    ✓ QR img tag found\n";
    echo "    Type: " . (strpos($m[1], 'data:') === 0 ? "Base64" : "Path") . "\n";
} else {
    echo "    ✗ QR img tag NOT found\n";
}

echo "\n✅ Simulation complete\n";
