<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\PengajuanSurat;

echo "Checking if QR Code is in the rendered HTML\n";
echo "============================================\n\n";

$pengajuan = PengajuanSurat::find(1);
$pengajuanFresh = PengajuanSurat::find(1);
$html = view('pengajuan.pdf', ['pengajuan' => $pengajuanFresh])->render();

echo "Pengajuan signature_token: " . ($pengajuan->signature_token ?? 'NULL') . "\n";
echo "Pengajuan signature_generated_at: " . ($pengajuan->signature_generated_at ?? 'NULL') . "\n\n";

// Check if HTML contains base64 image
if (strpos($html, 'data:image/png;base64,') !== false) {
    echo "✓ QR Code (as base64 image) found in HTML!\n\n";
    
    // Count occurrences
    $count = substr_count($html, 'data:image/png;base64,');
    echo "Number of QR codes found: " . $count . "\n\n";
} else {
    echo "✗ QR Code NOT found in HTML\n\n";
    
    // Check what's in the signature area
    if (strpos($html, 'Scan untuk verifikasi') !== false) {
        echo "Found 'Scan untuk verifikasi' text but no QR code image\n";
        echo "This means the @if condition passed but generateBase64() returned empty\n\n";
    } else {
        echo "No QR code section found at all\n\n";
    }
}

// Show a sample of the HTML around the QR code area
$pos = strpos($html, 'Scan untuk verifikasi');
if ($pos !== false) {
    echo "HTML snippet around QR code area:\n";
    echo "================================\n";
    echo substr($html, max(0, $pos - 200), 400) . "\n";
}
