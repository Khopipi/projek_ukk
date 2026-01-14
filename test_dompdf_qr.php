<?php
/**
 * TEST DOMPDF - Cek apakah DomPDF bisa render base64 images
 */

require __DIR__ . '/vendor/autoload.php';

$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\PengajuanSurat;
use App\Helpers\QrCodeGenerator;

echo "╔════════════════════════════════════════════════════════════════╗\n";
echo "║           DOMPDF BASE64 IMAGE TEST                            ║\n";
echo "╚════════════════════════════════════════════════════════════════╝\n\n";

// Get pengajuan with QR
$pengajuan = PengajuanSurat::whereNotNull('signature_token')->first();

if (!$pengajuan) {
    echo "❌ No pengajuan found\n";
    exit;
}

echo "[1] Data\n";
echo "  - Pengajuan: {$pengajuan->nomor_pengajuan}\n";
echo "  - Token: " . substr($pengajuan->signature_token, 0, 30) . "...\n\n";

// Generate QR
$qrUrl = QrCodeGenerator::generateQrUrl($pengajuan->signature_token);
$qrBase64 = QrCodeGenerator::generateBase64($qrUrl);
$qrPath = QrCodeGenerator::generateAndSaveQrCode($qrUrl);

echo "[2] QR Code\n";
echo "  ✓ URL: " . $qrUrl . "\n";
echo "  ✓ Base64: " . strlen($qrBase64) . " bytes\n";
echo "  ✓ Path: " . $qrPath . "\n\n";

// Test 1: Simple base64 image in DomPDF
echo "[3] TEST 1: Simple Base64 Image in DomPDF\n";
echo str_repeat("-", 60) . "\n";

$html1 = <<<'HTML'
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial; margin: 40px; }
        .qr-test { text-align: center; margin: 20px 0; }
        .qr-test img { width: 100px; height: 100px; border: 1px solid #333; }
    </style>
</head>
<body>
    <h1>Test 1: Base64 Image</h1>
    <div class="qr-test">
        <p>Gambar QR Code dibawah:</p>
        <img src="BASE64_DATA_HERE" alt="QR Code">
    </div>
</body>
</html>
HTML;

$html1 = str_replace('BASE64_DATA_HERE', $qrBase64, $html1);

try {
    $pdf = Pdf::loadHTML($html1)->setPaper('a4', 'portrait');
    $pdfContent = $pdf->output();
    file_put_contents(storage_path('app/public/test_base64_1.pdf'), $pdfContent);
    echo "✓ PDF generated: test_base64_1.pdf\n";
    echo "  Size: " . strlen($pdfContent) . " bytes\n";
    echo "  Check if QR appears in PDF\n\n";
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n\n";
}

// Test 2: Asset path image (fallback)
echo "[4] TEST 2: Asset Path Image in DomPDF\n";
echo str_repeat("-", 60) . "\n";

$html2 = <<<HTML
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial; margin: 40px; }
        .qr-test { text-align: center; margin: 20px 0; }
        .qr-test img { width: 100px; height: 100px; border: 1px solid #333; }
    </style>
</head>
<body>
    <h1>Test 2: Asset Path Image</h1>
    <div class="qr-test">
        <p>Gambar QR Code dibawah (via file path):</p>
        <img src="{$qrPath}" alt="QR Code">
    </div>
</body>
</html>
HTML;

try {
    $pdf = Pdf::loadHTML($html2)->setPaper('a4', 'portrait');
    $pdfContent = $pdf->output();
    file_put_contents(storage_path('app/public/test_asset_2.pdf'), $pdfContent);
    echo "✓ PDF generated: test_asset_2.pdf\n";
    echo "  Size: " . strlen($pdfContent) . " bytes\n";
    echo "  Check if QR appears in PDF\n\n";
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n\n";
}

// Test 3: Full path image
echo "[5] TEST 3: Full File Path Image in DomPDF\n";
echo str_repeat("-", 60) . "\n";

$fullPath = public_path($qrPath);
$html3 = <<<HTML
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial; margin: 40px; }
        .qr-test { text-align: center; margin: 20px 0; }
        .qr-test img { width: 100px; height: 100px; border: 1px solid #333; }
    </style>
</head>
<body>
    <h1>Test 3: Full File Path</h1>
    <div class="qr-test">
        <p>Gambar QR Code dibawah (via full path):</p>
        <img src="{$fullPath}" alt="QR Code">
    </div>
</body>
</html>
HTML;

try {
    $pdf = Pdf::loadHTML($html3)->setPaper('a4', 'portrait');
    $pdfContent = $pdf->output();
    file_put_contents(storage_path('app/public/test_fullpath_3.pdf'), $pdfContent);
    echo "✓ PDF generated: test_fullpath_3.pdf\n";
    echo "  Size: " . strlen($pdfContent) . " bytes\n";
    echo "  Check if QR appears in PDF\n\n";
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n\n";
}

// Test 4: Full surat template dengan QR
echo "[6] TEST 4: Full Surat Template\n";
echo str_repeat("-", 60) . "\n";

$html4 = view('pengajuan.pdf', [
    'pengajuan' => $pengajuan,
    'qrPath' => $qrPath,
    'qrBase64' => $qrBase64
])->render();

try {
    $pdf = Pdf::loadHTML($html4)->setPaper('a4', 'portrait');
    $pdfContent = $pdf->output();
    
    $filename = 'test_full_surat_' . time() . '.pdf';
    file_put_contents(storage_path('app/public/' . $filename), $pdfContent);
    
    echo "✓ PDF generated: {$filename}\n";
    echo "  Size: " . strlen($pdfContent) . " bytes\n";
    echo "  Path: storage/app/public/{$filename}\n";
    echo "  Check if QR appears in PDF\n\n";
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n\n";
}

echo "════════════════════════════════════════════════════════════════\n\n";
echo "✓ All test PDFs generated!\n";
echo "\nDownload and check di folder public/storage/\n";
echo "Lihat apakah QR code muncul di PDF atau tidak.\n\n";
