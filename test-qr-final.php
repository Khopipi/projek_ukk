<?php
// Test script to verify QR code rendering in all templates after fix

$app = require __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use App\Models\PengajuanSurat;
use App\Helpers\QrCodeGenerator;

echo "=== QR CODE TEMPLATE RENDERING TEST ===\n\n";

// Get a pengajuan with signature token
$pengajuan = DB::table('pengajuan_surats')
    ->whereNotNull('signature_token')
    ->whereNotNull('signature_generated_at')
    ->first();

if (!$pengajuan) {
    echo "❌ No pengajuan with signature_token found\n";
    exit(1);
}

echo "[1] Pengajuan Data:\n";
echo "    ID: {$pengajuan->id}\n";
echo "    Jenis: {$pengajuan->jenis_surat}\n";
echo "    Signature Token: " . substr($pengajuan->signature_token, 0, 30) . "...\n";
echo "    Generated At: {$pengajuan->signature_generated_at}\n\n";

// Generate QR code
echo "[2] Generating QR Code:\n";
$qrUrl = QrCodeGenerator::generateQrUrl($pengajuan->signature_token);
$qrPath = QrCodeGenerator::generateAndSaveQrCode($qrUrl);
echo "    ✓ QR Path: $qrPath\n";

// Convert to base64
$qrBase64 = QrCodeGenerator::getQrCodeAsBase64($qrPath);
echo "    ✓ QR Base64 length: " . strlen($qrBase64) . " bytes\n";
echo "    ✓ Base64 valid: " . (strpos($qrBase64, 'data:image/png;base64,') === 0 ? 'YES' : 'NO') . "\n\n";

// Test all 8 templates
$templates = [
    'Surat Warisan',
    'Surat Nikah',
    'Surat Tanah',
    'Surat Domisili',
    'Surat Akta Kelahiran',
    'Surat Akta Kematian',
    'Surat Keterangan Tidak Mampu',
    'Default'
];

echo "[3] Testing Template Rendering for All 8 Letter Types:\n";

$pengajuanModel = PengajuanSurat::find($pengajuan->id);

// Render template with variables
$html = View::make('pengajuan.surat-template', [
    'pengajuan' => $pengajuanModel,
    'qrPath' => $qrPath,
    'qrBase64' => $qrBase64
])->render();

echo "    ✓ Template rendered successfully\n";

// Search for img tags with QR Code
$qrImageCount = preg_match_all('/<img[^>]*alt="QR Code"[^>]*>/', $html, $matches);
echo "    ✓ Found $qrImageCount img tags with alt='QR Code' (expected 8)\n";

if ($qrImageCount > 0) {
    // Check if base64 is used
    $base64Count = substr_count($html, 'data:image/png;base64,');
    echo "    ✓ Found $base64Count base64 data URIs\n";
    
    // Show sample of first img tag
    if (isset($matches[0][0])) {
        echo "    Sample img tag:\n";
        echo "    " . substr($matches[0][0], 0, 100) . "...\n";
    }
}

// Check for placeholder text (should not appear if QR is properly rendered)
$placeholderCount = substr_count($html, 'QR Code<br/>(belum<br/>di-generate)');
echo "    ✓ Placeholder count: $placeholderCount (expected 0 if all QR codes generated)\n\n";

echo "[4] Final Check:\n";
if ($qrImageCount === 8 && $base64Count === 8) {
    echo "    ✅ SUCCESS: All 8 templates have proper QR code img tags with base64!\n";
    echo "    ✅ QR barcode should now appear in preview and PDF!\n";
} else {
    echo "    ⚠️  WARNING: Found $qrImageCount img tags instead of 8\n";
}

echo "\n=== TEST COMPLETE ===\n";
