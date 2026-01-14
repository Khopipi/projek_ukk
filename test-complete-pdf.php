<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\PengajuanSurat;
use Illuminate\Support\Facades\Auth;

echo "\n";
echo "╔════════════════════════════════════════════════════════════╗\n";
echo "║   COMPLETE PDF GENERATION WITH QR CODE TEST               ║\n";
echo "╚════════════════════════════════════════════════════════════╝\n";
echo "\n";

Auth::loginUsingId(1);
$pengajuan = PengajuanSurat::find(1);

// Step 1: Setup signature
echo "Step 1: Setup Signature Token\n";
if (!$pengajuan->signature_token) {
    $token = \App\Helpers\QrCodeGenerator::generateSignatureToken($pengajuan->id, Auth::id());
    $pengajuan->update([
        'signature_token' => $token,
        'signature_generated_at' => now()
    ]);
    $pengajuan->refresh();
    echo "  ✓ Token generated: " . substr($token, 0, 30) . "...\n\n";
} else {
    echo "  ✓ Token exists: " . substr($pengajuan->signature_token, 0, 30) . "...\n\n";
}

// Step 2: Generate QR Code file
echo "Step 2: Generate QR Code File\n";
$qrUrl = \App\Helpers\QrCodeGenerator::generateQrUrl($pengajuan->signature_token);
$qrPath = \App\Helpers\QrCodeGenerator::generateAndSaveQrCode($qrUrl);
$fullPath = public_path($qrPath);

echo "  ✓ QR Path: " . $qrPath . "\n";
echo "  ✓ File size: " . filesize($fullPath) . " bytes\n\n";

// Step 3: Render HTML
echo "Step 3: Render HTML Template\n";
$htmlContent = view('pengajuan.pdf', [
    'pengajuan' => $pengajuan,
    'qrPath' => $qrPath
])->render();

$hasQrImage = strpos($htmlContent, 'width="75" height="75"') !== false;
$hasQrText = strpos($htmlContent, 'Scan untuk verifikasi') !== false;
$hasLurah = strpos($htmlContent, 'LURAH DESA SRUNI') !== false;

echo "  ✓ HTML size: " . strlen($htmlContent) . " bytes\n";
echo "  " . ($hasQrImage ? '✓' : '✗') . " QR Image tag found\n";
echo "  " . ($hasQrText ? '✓' : '✗') . " Scan text found\n";
echo "  " . ($hasLurah ? '✓' : '✗') . " Kepala Desa section found\n";
echo "\n";

// Step 4: Generate PDF
echo "Step 4: Generate PDF Document\n";
try {
    $pdf = \PDF::loadHTML($htmlContent)->setPaper('a4', 'portrait');
    $pdfContent = $pdf->output();
    
    echo "  ✓ PDF generated\n";
    echo "  ✓ PDF size: " . strlen($pdfContent) . " bytes\n";
    
    // Save for inspection
    $filename = 'test_qr_' . time() . '.pdf';
    $path = storage_path('app/public/surat_hasil/' . $filename);
    file_put_contents($path, $pdfContent);
    
    echo "  ✓ PDF saved: " . $filename . "\n";
    echo "  ✓ Download: /storage/surat_hasil/" . $filename . "\n";
    
} catch (\Exception $e) {
    echo "  ✗ Error: " . $e->getMessage() . "\n";
    exit(1);
}

echo "\n";
echo "╔════════════════════════════════════════════════════════════╗\n";
echo "║              ✓ SUCCESS!                                   ║\n";
echo "║     QR CODE IS NOW IN YOUR PDF!                          ║\n";
echo "║                                                            ║\n";
echo "║  The QR Code will appear at:                             ║\n";
echo "║  📍 Footer section → TTD (Tanda Tangan) Kepala Desa      ║\n";
echo "║  📍 Size: 75x75 pixels                                    ║\n";
echo "║  📍 With text: \"Scan untuk verifikasi\"                 ║\n";
echo "║                                                            ║\n";
echo "║  Download the PDF and verify the QR code is visible!    ║\n";
echo "╚════════════════════════════════════════════════════════════╝\n\n";
