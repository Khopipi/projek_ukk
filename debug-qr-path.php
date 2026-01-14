<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\PengajuanSurat;
use Illuminate\Support\Facades\Auth;

echo "Debug QR Path di Template\n";
echo "==========================\n\n";

Auth::loginUsingId(1);
$pengajuan = PengajuanSurat::find(1);

if (!$pengajuan->signature_token) {
    $token = \App\Helpers\QrCodeGenerator::generateSignatureToken($pengajuan->id, Auth::id());
    $pengajuan->update([
        'signature_token' => $token,
        'signature_generated_at' => now()
    ]);
    $pengajuan->refresh();
}

// Generate QR
$qrUrl = \App\Helpers\QrCodeGenerator::generateQrUrl($pengajuan->signature_token);
$qrPath = \App\Helpers\QrCodeGenerator::generateAndSaveQrCode($qrUrl);

echo "1. QR Path: " . $qrPath . "\n";
echo "2. Asset path: " . asset($qrPath) . "\n\n";

// Render template WITH qrPath
echo "3. Rendering template WITH qrPath variable:\n";
$htmlWithQr = view('pengajuan.surat-template', [
    'pengajuan' => $pengajuan,
    'qrPath' => $qrPath
])->render();

if (strpos($htmlWithQr, '<img src=') !== false) {
    echo "   ✓ Found <img tag\n";
    // Extract the img tag
    if (preg_match('/<img[^>]+src="([^"]*)"[^>]*>/i', $htmlWithQr, $matches)) {
        echo "   ✓ Image src: " . substr($matches[1], 0, 60) . "...\n";
    }
} else {
    echo "   ✗ NO <img tag found!\n";
}

if (strpos($htmlWithQr, 'asset(') !== false) {
    echo "   ✓ Found asset() reference\n";
} else {
    echo "   ✗ NO asset() reference!\n";
}

echo "\n4. Rendering template WITHOUT qrPath variable:\n";
$htmlWithoutQr = view('pengajuan.surat-template', [
    'pengajuan' => $pengajuan
    // qrPath NOT passed
])->render();

if (strpos($htmlWithoutQr, '<img src=') !== false) {
    echo "   Found <img tag (unexpected!)\n";
} else {
    echo "   ✓ NO <img tag (expected - qrPath not passed)\n";
}

echo "\n5. Check PDF view:\n";
$pdfView = view('pengajuan.pdf', ['pengajuan' => $pengajuan, 'qrPath' => $qrPath])->render();
if (strpos($pdfView, 'asset(' . $qrPath . ')') !== false || strpos($pdfView, $qrPath) !== false) {
    echo "   ✓ qrPath found in PDF view\n";
} else {
    echo "   ✗ qrPath NOT found in PDF view\n";
}

echo "\n6. Check @if condition in template:\n";
echo "   signature_token: " . ($pengajuan->signature_token ? 'YES' : 'NO') . "\n";
echo "   signature_generated_at: " . ($pengajuan->signature_generated_at ? 'YES' : 'NO') . "\n";
echo "   qrPath passed: " . (!empty($qrPath) ? 'YES' : 'NO') . "\n";
