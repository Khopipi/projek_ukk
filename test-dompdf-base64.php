<?php

require 'vendor/autoload.php';

use Illuminate\Foundation\Application;
use App\Models\PengajuanSurat;

// Bootstrap Laravel
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$pengajuan = PengajuanSurat::latest()->first();

echo "🧪 Testing DomPDF with Base64 Images\n";
echo "====================================\n\n";

// Generate fresh QR
if (!$pengajuan->signature_token) {
    $token = \App\Helpers\QrCodeGenerator::generateSignatureToken($pengajuan->id, 2);
    $pengajuan->update([
        'signature_token' => $token,
        'signature_generated_at' => now()
    ]);
}

$qrUrl = \App\Helpers\QrCodeGenerator::generateQrUrl($pengajuan->signature_token);
$qrPath = \App\Helpers\QrCodeGenerator::generateAndSaveQrCode($qrUrl);
$qrBase64 = \App\Helpers\QrCodeGenerator::getQrCodeAsBase64($qrPath);

echo "[1] QR Code Generated:\n";
echo "    Path: $qrPath\n";
echo "    Base64: " . strlen($qrBase64) . " bytes\n";

// Test 1: Simple HTML with base64
echo "\n[2] Test 1: Simple HTML with base64 img tag\n";
$html1 = <<<HTML
<!DOCTYPE html>
<html>
<body>
<h1>QR Code Test</h1>
<img src="$qrBase64" width="200" height="200" alt="QR Test">
</body>
</html>
HTML;

try {
    $pdf1 = \PDF::loadHTML($html1)->setPaper('a4', 'portrait');
    $content1 = $pdf1->output();
    file_put_contents(storage_path('test_qr_base64_1.pdf'), $content1);
    echo "    ✓ PDF generated: " . strlen($content1) . " bytes\n";
    echo "    Saved: test_qr_base64_1.pdf\n";
} catch (\Throwable $e) {
    echo "    ✗ Error: " . $e->getMessage() . "\n";
}

// Test 2: With explicit data: prefix
echo "\n[3] Test 2: With explicit data: prefix in img\n";
$html2 = <<<HTML
<!DOCTYPE html>
<html>
<body>
<h1>QR Code Test</h1>
<img src="$qrBase64" style="width:200px;height:200px;" alt="QR Test">
</body>
</html>
HTML;

try {
    $pdf2 = \PDF::loadHTML($html2)->setPaper('a4', 'portrait');
    $content2 = $pdf2->output();
    file_put_contents(storage_path('test_qr_base64_2.pdf'), $content2);
    echo "    ✓ PDF generated: " . strlen($content2) . " bytes\n";
    echo "    Saved: test_qr_base64_2.pdf\n";
} catch (\Throwable $e) {
    echo "    ✗ Error: " . $e->getMessage() . "\n";
}

// Test 3: Using background-image CSS
echo "\n[4] Test 3: Using background-image CSS\n";
$htmlBg = <<<HTML
<!DOCTYPE html>
<html>
<body>
<h1>QR Code Test</h1>
<div style="width:200px;height:200px;background-image:url($qrBase64);background-size:contain;border:1px solid black;"></div>
</body>
</html>
HTML;

try {
    $pdf3 = \PDF::loadHTML($htmlBg)->setPaper('a4', 'portrait');
    $content3 = $pdf3->output();
    file_put_contents(storage_path('test_qr_base64_3.pdf'), $content3);
    echo "    ✓ PDF generated: " . strlen($content3) . " bytes\n";
    echo "    Saved: test_qr_base64_3.pdf\n";
} catch (\Throwable $e) {
    echo "    ✗ Error: " . $e->getMessage() . "\n";
}

// Test 4: Using public path file reference
echo "\n[5] Test 4: Using public path file reference\n";
$publicPath = str_replace('/storage/', 'storage/', $qrPath);
$htmlFile = <<<HTML
<!DOCTYPE html>
<html>
<body>
<h1>QR Code Test</h1>
<img src="$publicPath" width="200" height="200" alt="QR Test">
</body>
</html>
HTML;

try {
    $pdf4 = \PDF::loadHTML($htmlFile)->setPaper('a4', 'portrait');
    $content4 = $pdf4->output();
    file_put_contents(storage_path('test_qr_file.pdf'), $content4);
    echo "    ✓ PDF generated: " . strlen($content4) . " bytes\n";
    echo "    Saved: test_qr_file.pdf\n";
} catch (\Throwable $e) {
    echo "    ✗ Error: " . $e->getMessage() . "\n";
}

echo "\n✅ Tests complete! Check which method works best.\n";
