<?php
/**
 * DEBUG SCRIPT - QR Code Analysis
 * Menganalisis mengapa QR code tidak muncul
 */

require __DIR__ . '/vendor/autoload.php';

// Initialize Laravel app
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use App\Models\PengajuanSurat;
use App\Helpers\QrCodeGenerator;

echo "\n╔════════════════════════════════════════════════════════════════╗\n";
echo "║           QR CODE PROBLEM ANALYSIS & DEBUGGING                ║\n";
echo "╚════════════════════════════════════════════════════════════════╝\n\n";

// ============================================
// [1] Check database data
// ============================================
echo "[1] DATABASE CHECK\n";
echo str_repeat("-", 60) . "\n";

$pengajuan = PengajuanSurat::whereNotNull('status')->first();

if (!$pengajuan) {
    echo "❌ No pengajuan found in database\n";
    exit(1);
}

echo "✓ Found pengajuan: {$pengajuan->nomor_pengajuan}\n";
echo "  - ID: {$pengajuan->id}\n";
echo "  - Jenis: {$pengajuan->jenis_surat}\n";
echo "  - Status: {$pengajuan->status}\n";
echo "  - signature_token: " . ($pengajuan->signature_token ? "✓ EXISTS" : "❌ NULL") . "\n";
echo "  - signature_generated_at: " . ($pengajuan->signature_generated_at ? "✓ EXISTS" : "❌ NULL") . "\n\n";

// ============================================
// [2] Generate QR code components
// ============================================
echo "[2] QR CODE GENERATION\n";
echo str_repeat("-", 60) . "\n";

// Generate token if not exists
if (!$pengajuan->signature_token) {
    echo "⚠️  No signature token, generating...\n";
    $token = QrCodeGenerator::generateSignatureToken($pengajuan->id, 1);
    $pengajuan->update([
        'signature_token' => $token,
        'signature_generated_at' => now()
    ]);
    echo "✓ Token generated: {$token}\n\n";
} else {
    echo "✓ Token exists: " . substr($pengajuan->signature_token, 0, 30) . "...\n\n";
}

// Generate QR URL
$qrUrl = QrCodeGenerator::generateQrUrl($pengajuan->signature_token);
echo "✓ QR URL: " . $qrUrl . "\n";
echo "  Length: " . strlen($qrUrl) . " chars\n\n";

// Generate QR base64
$qrBase64 = QrCodeGenerator::generateBase64($qrUrl);
echo "✓ QR Base64 generated\n";
echo "  - Starts with: " . substr($qrBase64, 0, 30) . "...\n";
echo "  - Length: " . strlen($qrBase64) . " bytes\n";
echo "  - Valid header: " . (strpos($qrBase64, 'data:image/png;base64,') === 0 ? "✓ YES" : "❌ NO") . "\n\n";

// Generate QR file
$qrPath = QrCodeGenerator::generateAndSaveQrCode($qrUrl);
echo "✓ QR File saved\n";
echo "  - Path: {$qrPath}\n";
echo "  - Full path: " . public_path($qrPath) . "\n";
echo "  - File exists: " . (file_exists(public_path($qrPath)) ? "✓ YES" : "❌ NO") . "\n";
if (file_exists(public_path($qrPath))) {
    echo "  - File size: " . filesize(public_path($qrPath)) . " bytes\n";
}
echo "\n";

// Get base64 from file
$qrBase64FromFile = QrCodeGenerator::getQrCodeAsBase64($qrPath);
echo "✓ QR Base64 from file\n";
echo "  - Length: " . strlen($qrBase64FromFile) . " bytes\n";
echo "  - Valid: " . (strpos($qrBase64FromFile, 'data:image/png;base64,') === 0 ? "✓ YES" : "❌ NO") . "\n\n";

// ============================================
// [3] Template rendering simulation
// ============================================
echo "[3] TEMPLATE RENDERING SIMULATION\n";
echo str_repeat("-", 60) . "\n";

// Pass variables to view exactly like controller does
$pengajuanModel = PengajuanSurat::find($pengajuan->id);

$html = View::make('pengajuan.surat-template', [
    'pengajuan' => $pengajuanModel,
    'qrPath' => $qrPath,
    'qrBase64' => $qrBase64FromFile
])->render();

echo "✓ Template rendered successfully\n";
echo "  - HTML length: " . strlen($html) . " chars\n\n";

// ============================================
// [4] Check for QR code in rendered HTML
// ============================================
echo "[4] QR CODE IN RENDERED HTML\n";
echo str_repeat("-", 60) . "\n";

// Count img tags with QR code
$qrImgCount = preg_match_all('/<img[^>]*alt=["\']QR Code["\'][^>]*>/i', $html, $matches);
echo "Found <img> tags with alt='QR Code': " . $qrImgCount . "\n";

if ($qrImgCount > 0) {
    echo "\nSample img tag:\n";
    $sample = $matches[0][0];
    echo substr($sample, 0, 150) . "...\n";
    
    // Check if src contains base64
    if (preg_match('/src=["\']([^"\']+)["\']/', $sample, $srcMatch)) {
        $srcValue = $srcMatch[1];
        echo "\nSrc value starts with: " . substr($srcValue, 0, 40) . "...\n";
        echo "Is base64: " . (strpos($srcValue, 'data:image') === 0 ? "✓ YES" : "❌ NO") . "\n";
        echo "Is asset path: " . (strpos($srcValue, '/storage') === 0 ? "✓ YES" : "❌ NO") . "\n";
    }
}

// Check for placeholder
$placeholderCount = substr_count($html, 'QR Code<br/>(belum<br/>di-generate)');
echo "\nPlaceholder occurrences: " . $placeholderCount . "\n";
echo "Expected: 0 (if QR generated correctly)\n";
echo "Status: " . ($placeholderCount > 0 ? "⚠️  ISSUE: Placeholder is showing!" : "✓ OK: No placeholder") . "\n\n";

// ============================================
// [5] Check conditional logic
// ============================================
echo "[5] CONDITIONAL LOGIC CHECK\n";
echo str_repeat("-", 60) . "\n";

$checkToken = $pengajuanModel->signature_token ? "✓ token exists" : "❌ no token";
$checkGenerated = $pengajuanModel->signature_generated_at ? "✓ timestamp exists" : "❌ no timestamp";
$checkBase64 = isset($qrBase64FromFile) && !empty($qrBase64FromFile) ? "✓ base64 not empty" : "❌ base64 empty/null";
$checkPath = isset($qrPath) && !empty($qrPath) ? "✓ path not empty" : "❌ path empty/null";

echo "Token: {$checkToken}\n";
echo "Generated timestamp: {$checkGenerated}\n";
echo "Base64 data: {$checkBase64}\n";
echo "QR Path: {$checkPath}\n\n";

$conditionResult = (
    $pengajuanModel->signature_token && 
    $pengajuanModel->signature_generated_at && 
    ((isset($qrBase64FromFile) && !empty($qrBase64FromFile)) || (isset($qrPath) && !empty($qrPath)))
);

echo "Final condition result: " . ($conditionResult ? "✅ TRUE - should show QR" : "❌ FALSE - shows placeholder") . "\n\n";

// ============================================
// [6] Test PDF rendering
// ============================================
echo "[6] PDF RENDERING TEST\n";
echo str_repeat("-", 60) . "\n";

$pdfHtml = View::make('pengajuan.pdf', [
    'pengajuan' => $pengajuanModel,
    'qrPath' => $qrPath,
    'qrBase64' => $qrBase64FromFile
])->render();

echo "✓ PDF template rendered\n";
echo "  - HTML length: " . strlen($pdfHtml) . " chars\n";

$pdfQrCount = preg_match_all('/<img[^>]*alt=["\']QR Code["\'][^>]*>/i', $pdfHtml, $pdfMatches);
echo "  - QR img tags found: " . $pdfQrCount . "\n";

if ($pdfQrCount > 0) {
    echo "  ✓ QR code should appear in PDF\n";
} else {
    echo "  ❌ QR code will NOT appear in PDF\n";
}
echo "\n";

// ============================================
// [7] Final diagnosis
// ============================================
echo "[7] DIAGNOSIS & SUMMARY\n";
echo str_repeat("=", 60) . "\n\n";

$issues = [];

if (strlen($qrBase64) < 100) {
    $issues[] = "Base64 data too short or empty";
}

if (strlen($qrPath) < 5) {
    $issues[] = "QR file path invalid";
}

if (!file_exists(public_path($qrPath))) {
    $issues[] = "QR file not saved to disk";
}

if ($placeholderCount > 0 && $qrImgCount == 0) {
    $issues[] = "Template showing placeholder instead of QR image";
}

if ($qrImgCount == 0) {
    $issues[] = "No img tag with QR code found in rendered HTML";
}

if (count($issues) === 0) {
    echo "✅ NO ISSUES FOUND!\n";
    echo "All components are working correctly:\n";
    echo "  ✓ QR code generated\n";
    echo "  ✓ Base64 encoded\n";
    echo "  ✓ File saved\n";
    echo "  ✓ Variables passed to template\n";
    echo "  ✓ Template rendering QR image\n";
    echo "  ✓ PDF should display QR\n\n";
    echo "NEXT STEP: Check browser console and network tab for:\n";
    echo "  1. Is img src loading correctly?\n";
    echo "  2. Any CORS or CSP issues?\n";
    echo "  3. Check browser developer tools\n";
} else {
    echo "❌ ISSUES FOUND:\n\n";
    foreach ($issues as $i => $issue) {
        echo "  " . ($i + 1) . ". " . $issue . "\n";
    }
    echo "\n";
    
    echo "RECOMMENDATIONS:\n";
    if (strlen($qrBase64) < 100 || strlen($qrPath) < 5) {
        echo "  - Check QrCodeGenerator helper class\n";
        echo "  - Verify endroid/qr-code library is installed\n";
    }
    if (!file_exists(public_path($qrPath))) {
        echo "  - Check storage/app/public/qr_codes directory permissions\n";
        echo "  - Verify storage:link command was run\n";
    }
    if ($placeholderCount > 0) {
        echo "  - Check template @if condition logic\n";
        echo "  - Verify variables are passed from controller\n";
    }
}

echo "\n" . str_repeat("=", 60) . "\n\n";
