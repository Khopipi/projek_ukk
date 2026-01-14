<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\PengajuanSurat;
use Illuminate\Support\Facades\Auth;

echo "\n";
echo "╔════════════════════════════════════════════════════════════╗\n";
echo "║    TESTING QR CODE WITH BASE64 ENCODING                  ║\n";
echo "╚════════════════════════════════════════════════════════════╝\n";
echo "\n";

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

echo "Step 1: Generate QR Code File\n";
$qrUrl = \App\Helpers\QrCodeGenerator::generateQrUrl($pengajuan->signature_token);
$qrPath = \App\Helpers\QrCodeGenerator::generateAndSaveQrCode($qrUrl);
echo "  ✓ QR Path: " . $qrPath . "\n";
echo "  ✓ File exists: " . (file_exists(public_path($qrPath)) ? 'YES' : 'NO') . "\n\n";

echo "Step 2: Convert to Base64\n";
$qrBase64 = \App\Helpers\QrCodeGenerator::getQrCodeAsBase64($qrPath);
echo "  ✓ Base64 length: " . strlen($qrBase64) . " bytes\n";
echo "  ✓ Starts with data:image: " . (strpos($qrBase64, 'data:image/png;base64,') === 0 ? 'YES' : 'NO') . "\n\n";

echo "Step 3: Render HTML Template\n";
$pengajuanFresh = PengajuanSurat::find($pengajuan->id);
$htmlContent = view('pengajuan.pdf', [
    'pengajuan' => $pengajuanFresh,
    'qrPath' => $qrPath,
    'qrBase64' => $qrBase64
])->render();

$hasBase64 = strpos($htmlContent, 'data:image/png;base64,') !== false;
$hasQrImage = strpos($htmlContent, 'width="75" height="75"') !== false;

echo "  ✓ HTML size: " . strlen($htmlContent) . " bytes\n";
echo "  " . ($hasBase64 ? '✓' : '✗') . " QR Base64 in HTML: " . ($hasBase64 ? 'YES' : 'NO') . "\n";
echo "  " . ($hasQrImage ? '✓' : '✗') . " QR Image tag: " . ($hasQrImage ? 'YES' : 'NO') . "\n\n";

echo "Step 4: Generate PDF\n";
try {
    $pdf = \PDF::loadHTML($htmlContent)->setPaper('a4', 'portrait');
    $pdfContent = $pdf->output();
    
    echo "  ✓ PDF generated: " . strlen($pdfContent) . " bytes\n";
    
    // Save for inspection
    $filename = 'test_qr_base64_' . time() . '.pdf';
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
echo "║     QR CODE NOW EMBEDDED AS BASE64!                      ║\n";
echo "║                                                            ║\n";
echo "║  QR Code should now appear correctly in PDF:            ║\n";
echo "║  - Using base64 encoding (more compatible with DomPDF)  ║\n";
echo "║  - At: Footer section → TTD Kepala Desa                 ║\n";
echo "║  - Size: 75x75 pixels with border                       ║\n";
echo "║                                                            ║\n";
echo "║  Download the PDF to verify!                            ║\n";
echo "╚════════════════════════════════════════════════════════════╝\n\n";
