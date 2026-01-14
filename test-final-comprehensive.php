<?php

require 'vendor/autoload.php';

use Illuminate\Foundation\Application;
use App\Models\PengajuanSurat;

// Bootstrap Laravel
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$pengajuan = PengajuanSurat::latest()->first();

echo "🎯 Final QR Code Test - All Methods\n";
echo "===================================\n\n";

// Ensure QR exists
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

echo "[1] QR Data:\n";
echo "    Path: $qrPath\n";
echo "    Base64: " . strlen($qrBase64) . " bytes\n";

// Test 1: Preview Surat
echo "\n[2] Preview Surat (Admin Panel):\n";
$html_preview = view('admin.pengajuan.preview-surat', [
    'pengajuan' => $pengajuan,
    'qrPath' => $qrPath,
    'qrBase64' => $qrBase64
])->render();

if (strpos($html_preview, $qrBase64) !== false && strpos($html_preview, 'belum di-generate') === false) {
    echo "    ✓ QR code embedded in preview\n";
    echo "    ✓ No placeholder text\n";
} else {
    echo "    ✗ QR code issue\n";
}

// Test 2: PDF view template
echo "\n[3] PDF Template:\n";
$html_pdf = view('pengajuan.pdf', [
    'pengajuan' => $pengajuan,
    'qrPath' => $qrPath,
    'qrBase64' => $qrBase64
])->render();

if (strpos($html_pdf, $qrBase64) !== false) {
    echo "    ✓ QR base64 embedded in PDF HTML\n";
} else {
    echo "    ✗ QR base64 NOT in PDF HTML\n";
}

// Test 3: Generate PDF
echo "\n[4] PDF Generation:\n";
try {
    $pdf = \PDF::loadHTML($html_pdf)->setPaper('a4', 'portrait');
    $pdfContent = $pdf->output();
    
    $filename = 'test_final_qr_' . time() . '.pdf';
    $filepath = storage_path($filename);
    file_put_contents($filepath, $pdfContent);
    
    echo "    ✓ PDF generated: " . strlen($pdfContent) . " bytes\n";
    echo "    ✓ Saved: $filename\n";
    echo "    ✓ Download: file:///C:\\Users\\Lenovo\\projek_ukk\\storage\\$filename\n";
} catch (\Throwable $e) {
    echo "    ✗ Error: " . $e->getMessage() . "\n";
}

echo "\n✅ All tests complete!\n";
echo "\n📋 What to do next:\n";
echo "1. Refresh admin panel (F5)\n";
echo "2. Go to Verifikasi Pengajuan → Preview Surat\n";
echo "3. QR code should now appear!\n";
echo "4. Download/Send PDF to see QR in PDF\n";
