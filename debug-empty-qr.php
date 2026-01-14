<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\PengajuanSurat;
use Illuminate\Support\Facades\Auth;

echo "\n";
echo "╔════════════════════════════════════════════════════════════╗\n";
echo "║            DEBUGGING QR CODE EMPTY ISSUE                  ║\n";
echo "╚════════════════════════════════════════════════════════════╝\n";
echo "\n";

Auth::loginUsingId(1);
$pengajuan = PengajuanSurat::find(1);

// Generate QR
$qrUrl = \App\Helpers\QrCodeGenerator::generateQrUrl($pengajuan->signature_token);
$qrPath = \App\Helpers\QrCodeGenerator::generateAndSaveQrCode($qrUrl);
$qrBase64 = \App\Helpers\QrCodeGenerator::getQrCodeAsBase64($qrPath);

echo "Step 1: Data Check\n";
echo "  signature_token: " . ($pengajuan->signature_token ? 'EXISTS' : 'MISSING') . "\n";
echo "  signature_generated_at: " . ($pengajuan->signature_generated_at ? 'EXISTS' : 'MISSING') . "\n";
echo "  qrPath: " . ($qrPath ? 'EXISTS' : 'MISSING') . "\n";
echo "  qrBase64 length: " . strlen($qrBase64) . " bytes\n";
echo "  qrBase64 valid: " . (strpos($qrBase64, 'data:image') === 0 ? 'YES' : 'NO') . "\n\n";

echo "Step 2: Template Variables\n";
$pengajuanFresh = PengajuanSurat::find($pengajuan->id);

// Test passing ALL variables
$htmlContent = view('pengajuan.surat-template', [
    'pengajuan' => $pengajuanFresh,
    'qrPath' => $qrPath,
    'qrBase64' => $qrBase64
])->render();

echo "  HTML rendered: " . strlen($htmlContent) . " bytes\n";

// Check what's in the HTML
if (strpos($htmlContent, 'data:image/png;base64,') !== false) {
    echo "  ✓ Base64 found in HTML\n";
} else {
    echo "  ✗ Base64 NOT found in HTML\n";
}

if (strpos($htmlContent, 'Scan untuk verifikasi') !== false) {
    echo "  ✓ Scan text found\n";
} else {
    echo "  ✗ Scan text NOT found\n";
}

// Extract the img tag
echo "\nStep 3: Image Tag Check\n";
if (preg_match('/<img[^>]+src="([^"]*)"[^>]*alt="QR Code"[^>]*>/i', $htmlContent, $matches)) {
    $src = $matches[1];
    echo "  Found img tag\n";
    echo "  Src type: " . (strpos($src, 'data:') === 0 ? 'BASE64' : 'PATH') . "\n";
    echo "  Src length: " . strlen($src) . " bytes\n";
    echo "  Src preview: " . substr($src, 0, 80) . "...\n";
} else {
    echo "  ✗ No img tag found with QR Code alt text!\n";
}

echo "\n";
echo "Step 4: Full PDF View Test\n";
$fullPdfHtml = view('pengajuan.pdf', [
    'pengajuan' => $pengajuanFresh,
    'qrPath' => $qrPath,
    'qrBase64' => $qrBase64
])->render();

echo "  PDF HTML: " . strlen($fullPdfHtml) . " bytes\n";
echo "  Has base64: " . (strpos($fullPdfHtml, 'data:image/png;base64,') !== false ? 'YES' : 'NO') . "\n";

// Generate PDF
echo "\nStep 5: Generate PDF\n";
try {
    $pdf = \PDF::loadHTML($fullPdfHtml)->setPaper('a4', 'portrait');
    $pdfContent = $pdf->output();
    
    echo "  ✓ PDF generated: " . strlen($pdfContent) . " bytes\n";
    
    // Save
    $filename = 'debug_qr_' . time() . '.pdf';
    $path = storage_path('app/public/surat_hasil/' . $filename);
    file_put_contents($path, $pdfContent);
    
    echo "  ✓ Saved: " . $filename . "\n";
    echo "  ✓ Download at: /storage/surat_hasil/" . $filename . "\n";
    
} catch (\Exception $e) {
    echo "  ✗ Error: " . $e->getMessage() . "\n";
}

echo "\n";
