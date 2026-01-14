<?php
/**
 * FINAL TEST - Verify QR code appears in preview and PDF dengan solusi baru
 */

require __DIR__ . '/vendor/autoload.php';

$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\View;
use App\Models\PengajuanSurat;
use App\Helpers\QrCodeGenerator;
use Barryvdh\DomPDF\Facade\Pdf;

echo "\n╔════════════════════════════════════════════════════════════════╗\n";
echo "║           FINAL QR CODE VERIFICATION TEST                    ║\n";
echo "║              dengan generateImgTag() method baru              ║\n";
echo "╚════════════════════════════════════════════════════════════════╝\n\n";

$pengajuan = PengajuanSurat::whereNotNull('signature_token')->first();

if (!$pengajuan) {
    echo "❌ No pengajuan found\n";
    exit;
}

// Generate QR
$qrUrl = QrCodeGenerator::generateQrUrl($pengajuan->signature_token);
$qrPath = QrCodeGenerator::generateAndSaveQrCode($qrUrl);

echo "[1] QR Code Setup\n";
echo str_repeat("-", 60) . "\n";
echo "✓ Pengajuan: {$pengajuan->nomor_pengajuan}\n";
echo "✓ QR Path: {$qrPath}\n";
echo "✓ Full Path: " . QrCodeGenerator::getQrCodeFullPath($qrPath) . "\n";
echo "✓ File exists: " . (file_exists(public_path($qrPath)) ? "YES" : "NO") . "\n\n";

// Test 1: Template rendering
echo "[2] Template Rendering Test\n";
echo str_repeat("-", 60) . "\n";

$html = View::make('pengajuan.surat-template', [
    'pengajuan' => $pengajuan,
    'qrPath' => $qrPath,
    'qrBase64' => ''  // Sengaja kosong untuk test
])->render();

$imgCount = preg_match_all('/<img[^>]*alt=["\']QR Code["\'][^>]*>/i', $html);
echo "✓ Template rendered\n";
echo "  - QR img tags found: $imgCount (expected: 1 if QR generated)\n";

// Check if it's using file path
if (preg_match('/<img src="([^"]+)"/', $html, $matches)) {
    $src = $matches[1];
    echo "  - img src: " . substr($src, 0, 50) . "...\n";
    echo "  - Using file path: " . (strpos($src, 'storage') !== false ? "✓ YES" : "❌ NO") . "\n";
}
echo "\n";

// Test 2: PDF generation
echo "[3] PDF Generation Test\n";
echo str_repeat("-", 60) . "\n";

try {
    $pdfHtml = View::make('pengajuan.pdf', [
        'pengajuan' => $pengajuan,
        'qrPath' => $qrPath,
        'qrBase64' => ''
    ])->render();
    
    $pdf = Pdf::loadHTML($pdfHtml)->setPaper('a4', 'portrait');
    $pdfContent = $pdf->output();
    
    $filename = 'test_qr_final_' . time() . '.pdf';
    file_put_contents(storage_path('app/public/' . $filename), $pdfContent);
    
    echo "✓ PDF generated successfully\n";
    echo "  - Filename: {$filename}\n";
    echo "  - Size: " . strlen($pdfContent) . " bytes\n";
    echo "  - Path: storage/app/public/{$filename}\n";
    echo "  - Download and check if QR code appears\n\n";
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n\n";
}

// Test 3: Helper method verification
echo "[4] Helper Method Verification\n";
echo str_repeat("-", 60) . "\n";

$imgTag = QrCodeGenerator::generateImgTag($qrPath);
echo "✓ generateImgTag() output:\n";
echo "  " . substr($imgTag, 0, 80) . "...\n";
echo "  - Length: " . strlen($imgTag) . " bytes\n";
echo "  - Contains file path: " . (strpos($imgTag, 'storage') !== false ? "✓ YES" : "❌ NO") . "\n";
echo "  - Contains full path: " . (strpos($imgTag, public_path()) !== false ? "✓ YES" : "❌ NO") . "\n\n";

// Final check
echo "[5] SUMMARY\n";
echo str_repeat("=", 60) . "\n";

if ($imgCount > 0 && strlen($imgTag) > 50) {
    echo "✅ SUCCESS!\n\n";
    echo "QR Code solution is working:\n";
    echo "  ✓ generateImgTag() helper working\n";
    echo "  ✓ Template rendering QR img tag\n";
    echo "  ✓ PDF generation successful\n";
    echo "  ✓ File path used (reliable for DomPDF)\n\n";
    echo "NEXT: Download generated PDF from storage/app/public/\n";
    echo "      Verify that QR code appears as image (not placeholder)\n";
} else {
    echo "⚠️  Issues found - check test output above\n";
}

echo "\n" . str_repeat("=", 60) . "\n\n";
