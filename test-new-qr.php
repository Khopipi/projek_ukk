<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\PengajuanSurat;
use Illuminate\Support\Facades\Auth;

echo "Testing Updated QR Code Implementation\n";
echo "======================================\n\n";

// Set auth
Auth::loginUsingId(1);

// Get pengajuan
$pengajuan = PengajuanSurat::find(1);

if (!$pengajuan) {
    echo "ERROR: Pengajuan not found\n";
    exit(1);
}

echo "Step 1: Check signature token\n";
echo "Token: " . ($pengajuan->signature_token ?? 'NONE') . "\n\n";

if (!$pengajuan->signature_token) {
    echo "Step 2: Generate signature token\n";
    $token = \App\Helpers\QrCodeGenerator::generateSignatureToken($pengajuan->id, Auth::id());
    $pengajuan->update([
        'signature_token' => $token,
        'signature_generated_at' => now()
    ]);
    $pengajuan->refresh();
    echo "✓ Token generated: " . $pengajuan->signature_token . "\n\n";
}

echo "Step 3: Generate QR Code file\n";
$qrUrl = \App\Helpers\QrCodeGenerator::generateQrUrl($pengajuan->signature_token);
echo "QR URL: " . $qrUrl . "\n";

$qrPath = \App\Helpers\QrCodeGenerator::generateAndSaveQrCode($qrUrl);
echo "✓ QR Path: " . $qrPath . "\n";

if (!$qrPath) {
    echo "ERROR: QR path is empty\n";
    exit(1);
}

// Check if file exists
$filename = basename($qrPath);
$fullPath = public_path($qrPath);
echo "Full path: " . $fullPath . "\n";
echo "File exists: " . (file_exists($fullPath) ? 'YES' : 'NO') . "\n\n";

echo "Step 4: Render HTML with QR path\n";
$pengajuanFresh = PengajuanSurat::find($pengajuan->id);
$html = view('pengajuan.pdf', ['pengajuan' => $pengajuanFresh, 'qrPath' => $qrPath])->render();

// Check for QR code image in HTML
if (strpos($html, 'asset(' . $qrPath . ')') !== false) {
    echo "✓ QR Path found in HTML\n";
} elseif (strpos($html, $qrPath) !== false) {
    echo "✓ QR Path found in HTML\n";
} else {
    echo "⚠ QR Path might not be properly rendered\n";
    // Check for the img tag
    if (strpos($html, '<img src=') !== false) {
        echo "But found img tag\n";
    }
}

echo "HTML size: " . strlen($html) . " bytes\n\n";

echo "Step 5: Generate PDF\n";
try {
    $pdf = \PDF::loadHTML($html)->setPaper('a4', 'portrait');
    $pdfContent = $pdf->output();
    
    echo "✓ PDF Generated: " . strlen($pdfContent) . " bytes\n\n";
    
    echo "======================================\n";
    echo "✓ SUCCESS! New implementation works!\n";
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    exit(1);
}
