<?php

require 'vendor/autoload.php';

use Illuminate\Foundation\Application;
use App\Models\PengajuanSurat;

// Bootstrap Laravel
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Get the latest pengajuan
$pengajuan = PengajuanSurat::latest()->first();

// Generate everything fresh
$qrUrl = \App\Helpers\QrCodeGenerator::generateQrUrl($pengajuan->signature_token);
$qrPath = \App\Helpers\QrCodeGenerator::generateAndSaveQrCode($qrUrl);
$qrBase64 = \App\Helpers\QrCodeGenerator::getQrCodeAsBase64($qrPath);

// Generate HTML
$html = view('pengajuan.pdf', [
    'pengajuan' => $pengajuan,
    'qrPath' => $qrPath,
    'qrBase64' => $qrBase64
])->render();

echo "✅ HTML Generated\n";
echo "QR Base64 Present: " . (strpos($html, 'data:image/png;base64,iVBORw0KGgo') !== false ? 'YES' : 'NO') . "\n";
echo "Base64 Length in HTML: " . strlen($qrBase64) . " bytes\n";

// Find the img tag
if (preg_match('/<img[^>]*src="(data:image[^"]+)"[^>]*alt="QR Code"/', $html, $matches)) {
    $imgSrc = $matches[1];
    echo "\n✓ QR img src found!\n";
    echo "  Src length: " . strlen($imgSrc) . " bytes\n";
    echo "  Starts with: " . substr($imgSrc, 0, 50) . "...\n";
    
    // Extract just the base64 part
    $base64Part = str_replace('data:image/png;base64,', '', $imgSrc);
    echo "  Base64 part length: " . strlen($base64Part) . " bytes\n";
    
    // Try to decode first 100 bytes to verify it's valid PNG
    $decodedStart = base64_decode(substr($base64Part, 0, 100));
    if (strpos($decodedStart, 'PNG') !== false) {
        echo "  ✓ Valid PNG signature detected!\n";
    } else {
        echo "  ⚠ PNG signature not detected\n";
    }
} else {
    echo "\n✗ QR img src NOT found in expected format\n";
}

// Generate PDF
echo "\n📄 Generating PDF...\n";
try {
    $pdf = \PDF::loadHTML($html)->setPaper('a4', 'portrait');
    $pdfContent = $pdf->output();
    
    $pdfPath = storage_path('test_pdf_final_' . time() . '.pdf');
    file_put_contents($pdfPath, $pdfContent);
    
    echo "✓ PDF Generated: " . strlen($pdfContent) . " bytes\n";
    echo "  Saved to: $pdfPath\n";
    echo "  Download: file:///$pdfPath\n";
} catch (\Throwable $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
}
