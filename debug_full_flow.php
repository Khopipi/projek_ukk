<?php
/**
 * COMPREHENSIVE QR DEBUG
 * Simulate exact flow dari controller ke template
 */

require __DIR__ . '/vendor/autoload.php';

$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\PengajuanSurat;
use App\Helpers\QrCodeGenerator;

echo "\n╔════════════════════════════════════════════════════════════════╗\n";
echo "║           DEBUG - QR FLOW SIMULATION                           ║\n";
echo "╚════════════════════════════════════════════════════════════════╝\n\n";

// Get pengajuan
$pengajuan = PengajuanSurat::whereNotNull('status')->first();

if (!$pengajuan) {
    echo "❌ No pengajuan found\n";
    exit;
}

echo "[1] Starting State\n";
echo str_repeat("-", 60) . "\n";
echo "  Pengajuan ID: {$pengajuan->id}\n";
echo "  Pengajuan Nomor: {$pengajuan->nomor_pengajuan}\n";
echo "  Token Current: " . (empty($pengajuan->signature_token) ? "❌ EMPTY" : "✓ " . substr($pengajuan->signature_token, 0, 20) . "...") . "\n";
echo "  Generated At: " . (empty($pengajuan->signature_generated_at) ? "❌ NULL" : "✓ " . $pengajuan->signature_generated_at) . "\n\n";

echo "[2] Simulate Controller: previewSurat()\n";
echo str_repeat("-", 60) . "\n";

// Generate QR code jika belum ada signature token
if (!$pengajuan->signature_token) {
    echo "  Token is empty, generating...\n";
    $signatureToken = QrCodeGenerator::generateSignatureToken($pengajuan->id, Auth::id() ?? 1);
    $pengajuan->update([
        'signature_token' => $signatureToken,
        'signature_generated_at' => now()
    ]);
    echo "  ✓ Token generated and saved\n";
} else {
    echo "  ✓ Token already exists\n";
}

// Generate QR code untuk preview
$qrPath = null;
$qrBase64 = null;
if ($pengajuan->signature_token && $pengajuan->signature_generated_at) {
    echo "  Generating QR code...\n";
    $qrUrl = QrCodeGenerator::generateQrUrl($pengajuan->signature_token);
    echo "    QR URL: $qrUrl\n";
    
    $qrPath = QrCodeGenerator::generateAndSaveQrCode($qrUrl);
    echo "    QR Path: $qrPath\n";
    echo "    File exists: " . (file_exists(public_path($qrPath)) ? "✓ YES" : "❌ NO") . "\n";
    
    $qrBase64 = QrCodeGenerator::getQrCodeAsBase64($qrPath);
    echo "    Base64 length: " . strlen($qrBase64) . " bytes\n";
}

echo "\n  Variables ready:\n";
echo "  - pengajuan: ✓\n";
echo "  - qrPath: " . ($qrPath ? "✓ $qrPath" : "❌ null") . "\n";
echo "  - qrBase64: " . ($qrBase64 ? "✓ " . strlen($qrBase64) . " bytes" : "❌ null") . "\n\n";

echo "[3] Render preview-surat with template\n";
echo str_repeat("-", 60) . "\n";

View::addLocation(resource_path('views'));

try {
    // This simulates what preview-surat.blade.php does
    $html = view('pengajuan.surat-template', [
        'pengajuan' => $pengajuan,
        'qrPath' => $qrPath ?? null,
        'qrBase64' => $qrBase64 ?? null
    ])->render();
    
    echo "  ✓ Template rendered\n";
    echo "  - HTML length: " . strlen($html) . " bytes\n";
    
    // Check for QR
    if (strpos($html, 'belum di-generate') !== false) {
        echo "  ❌ PLACEHOLDER FOUND\n\n";
        
        // Find where placeholder is
        preg_match('/belum di-generate.*?<\/div>/s', $html, $match);
        if ($match) {
            echo "  Placeholder context:\n";
            echo "  " . substr($match[0], 0, 200) . "...\n\n";
        }
    } else {
        echo "  ✓ NO PLACEHOLDER\n";
    }
    
    // Check for QR img
    if (preg_match('/<img[^>]*qr_codes[^>]*>/i', $html, $match)) {
        echo "  ✓ QR Image found:\n";
        echo "    " . htmlspecialchars($match[0]) . "\n\n";
    } else {
        echo "  ❌ NO QR IMAGE FOUND\n\n";
    }
    
} catch (\Exception $e) {
    echo "  ❌ Template error: " . $e->getMessage() . "\n";
    echo "    " . $e->getFile() . ":" . $e->getLine() . "\n\n";
}

echo "[4] Test Component Directly\n";
echo str_repeat("-", 60) . "\n";

try {
    $componentHtml = view('pengajuan.components.qr-code-section', [
        'pengajuan' => $pengajuan,
        'qrPath' => $qrPath
    ])->render();
    
    echo "  Component rendered: " . strlen($componentHtml) . " bytes\n";
    
    if (strpos($componentHtml, 'img src') !== false) {
        echo "  ✓ IMG tag found\n";
        preg_match('/<img[^>]*>/', $componentHtml, $match);
        if ($match) {
            echo "    " . htmlspecialchars($match[0]) . "\n";
        }
    } else {
        echo "  ❌ No IMG tag\n";
    }
    
    if (strpos($componentHtml, 'belum di-generate') !== false) {
        echo "  ❌ Placeholder in component\n";
    } else {
        echo "  ✓ No placeholder in component\n";
    }
    
} catch (\Exception $e) {
    echo "  ❌ Component error: " . $e->getMessage() . "\n";
}

echo "\n════════════════════════════════════════════════════════════════\n";
echo "CONCLUSION:\n";
echo "════════════════════════════════════════════════════════════════\n\n";
