<?php

require 'vendor/autoload.php';

use Illuminate\Foundation\Application;
use App\Models\PengajuanSurat;

// Bootstrap Laravel
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Get the latest pengajuan
$pengajuan = PengajuanSurat::latest()->first();

if (!$pengajuan) {
    echo "❌ No pengajuan found\n";
    exit(1);
}

echo "📋 Testing sendPdf QR generation...\n";
echo "Pengajuan ID: {$pengajuan->id}\n";
echo "Jenis: {$pengajuan->jenis_surat}\n\n";

// Step 1: Check signature token
echo "[1] Checking Signature Token:\n";
if ($pengajuan->signature_token) {
    echo "    ✓ Token exists: {$pengajuan->signature_token}\n";
} else {
    echo "    ✗ Token missing\n";
}
if ($pengajuan->signature_generated_at) {
    echo "    ✓ Generated at: {$pengajuan->signature_generated_at}\n";
} else {
    echo "    ✗ Not generated\n";
}

// Step 2: Test QR generation
echo "\n[2] Testing QR Code Generation:\n";
$qrUrl = \App\Helpers\QrCodeGenerator::generateQrUrl($pengajuan->signature_token);
echo "    QR URL: $qrUrl\n";

$qrPath = \App\Helpers\QrCodeGenerator::generateAndSaveQrCode($qrUrl);
echo "    QR Path: $qrPath\n";

if (file_exists($qrPath)) {
    $fileSize = filesize($qrPath);
    echo "    ✓ QR File exists: $fileSize bytes\n";
} else {
    echo "    ✗ QR File NOT found\n";
}

// Step 3: Test Base64 conversion
echo "\n[3] Testing Base64 Conversion:\n";
$qrBase64 = \App\Helpers\QrCodeGenerator::getQrCodeAsBase64($qrPath);

if (strpos($qrBase64, 'data:image/png;base64,') === 0) {
    echo "    ✓ Base64 prefix: data:image/png;base64,\n";
    echo "    ✓ Base64 length: " . strlen($qrBase64) . " bytes\n";
    echo "    ✓ First 100 chars: " . substr($qrBase64, 0, 100) . "...\n";
} else {
    echo "    ✗ Invalid base64 format\n";
}

// Step 4: Test HTML rendering
echo "\n[4] Testing HTML Template Rendering:\n";
$html = view('pengajuan.pdf', [
    'pengajuan' => $pengajuan,
    'qrPath' => $qrPath,
    'qrBase64' => $qrBase64
])->render();

echo "    HTML size: " . strlen($html) . " bytes\n";

// Check if base64 is in HTML
if (strpos($html, $qrBase64) !== false) {
    echo "    ✓ Base64 found in HTML\n";
} else {
    echo "    ⚠ Base64 NOT found in HTML (may be in fallback asset path)\n";
}

// Check for img tag
if (preg_match('/<img\s+[^>]*src="([^"]+)"[^>]*alt="QR Code"/', $html, $matches)) {
    echo "    ✓ QR img tag found\n";
    $srcValue = $matches[1];
    if (strpos($srcValue, 'data:image') === 0) {
        echo "    ✓ Using base64 data URI\n";
    } else {
        echo "    ⚠ Using file path: $srcValue\n";
    }
} else {
    echo "    ✗ QR img tag NOT found\n";
}

// Step 5: Test PDF generation
echo "\n[5] Generating PDF:\n";
try {
    if (class_exists(\Barryvdh\DomPDF\Facade::class)) {
        $pdf = \PDF::loadHTML($html)->setPaper('a4', 'portrait');
        $pdfContent = $pdf->output();
        echo "    ✓ PDF generated (Facade): " . strlen($pdfContent) . " bytes\n";
    } else {
        $dompdf = new \Dompdf\Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $pdfContent = $dompdf->output();
        echo "    ✓ PDF generated (Direct): " . strlen($pdfContent) . " bytes\n";
    }
    
    // Save test PDF
    $testPdfPath = storage_path('test_sendpdf_qr_' . time() . '.pdf');
    file_put_contents($testPdfPath, $pdfContent);
    echo "    ✓ PDF saved: $testPdfPath\n";
    
} catch (\Throwable $e) {
    echo "    ✗ PDF generation failed: " . $e->getMessage() . "\n";
}

echo "\n✅ Test complete!\n";
