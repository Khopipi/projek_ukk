<?php

require 'vendor/autoload.php';

use Illuminate\Foundation\Application;
use App\Models\PengajuanSurat;

// Bootstrap Laravel
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

app('auth')->loginUsingId(2);

$pengajuan = PengajuanSurat::latest()->first();

echo "🔍 DETAILED DEBUG: Why QR Not Showing\n";
echo "=====================================\n\n";

// Step 1: Check database values
echo "[1] Database Values:\n";
echo "    signature_token: " . ($pengajuan->signature_token ? "✓ EXISTS" : "✗ MISSING") . "\n";
echo "    signature_generated_at: " . ($pengajuan->signature_generated_at ? "✓ EXISTS" : "✗ MISSING") . "\n";

// Step 2: Check if QR generation happens
echo "\n[2] Generate QR Code:\n";

if (!$pengajuan->signature_token) {
    $token = \App\Helpers\QrCodeGenerator::generateSignatureToken($pengajuan->id, 2);
    $pengajuan->update([
        'signature_token' => $token,
        'signature_generated_at' => now()
    ]);
    echo "    Generated new token\n";
}

$qrUrl = \App\Helpers\QrCodeGenerator::generateQrUrl($pengajuan->signature_token);
echo "    QR URL: $qrUrl\n";

$qrPath = \App\Helpers\QrCodeGenerator::generateAndSaveQrCode($qrUrl);
echo "    QR Path: $qrPath\n";

if (file_exists(public_path($qrPath))) {
    $filesize = filesize(public_path($qrPath));
    echo "    File exists: ✓ ($filesize bytes)\n";
} else {
    echo "    File exists: ✗ NOT FOUND\n";
    echo "    Tried path: " . public_path($qrPath) . "\n";
}

$qrBase64 = \App\Helpers\QrCodeGenerator::getQrCodeAsBase64($qrPath);
echo "    Base64 generated: " . (strlen($qrBase64) > 0 ? "✓ (" . strlen($qrBase64) . " bytes)" : "✗ EMPTY") . "\n";

if (strlen($qrBase64) > 0) {
    echo "    Base64 starts with: " . substr($qrBase64, 0, 50) . "\n";
}

// Step 3: Check what actually goes to template
echo "\n[3] Template Variables Check:\n";

$variables = [
    'pengajuan' => $pengajuan,
    'qrPath' => $qrPath,
    'qrBase64' => $qrBase64
];

echo "    qrPath: " . ($qrPath ? "✓ " . $qrPath : "✗ EMPTY") . "\n";
echo "    qrBase64: " . ($qrBase64 ? "✓ " . strlen($qrBase64) . " bytes" : "✗ EMPTY") . "\n";

// Step 4: Render template and check HTML
echo "\n[4] Render Template and Check HTML:\n";

$html = view('pengajuan.surat-template', $variables)->render();

// Look for img tags
if (preg_match_all('/<img[^>]*src="([^"]*)"[^>]*alt="QR Code"/', $html, $matches)) {
    echo "    Found " . count($matches[0]) . " QR img tag(s)\n";
    
    foreach ($matches[1] as $i => $src) {
        echo "\n    Img #" . ($i + 1) . ":\n";
        
        if (strlen($src) === 0) {
            echo "      ✗ SRC IS EMPTY!\n";
        } else if (strpos($src, 'data:image') === 0) {
            echo "      Type: Base64 Data URI\n";
            echo "      Length: " . strlen($src) . " bytes\n";
            echo "      Starts: " . substr($src, 0, 60) . "...\n";
            
            // Validate base64
            $base64_part = str_replace('data:image/png;base64,', '', $src);
            if (base64_decode($base64_part, true) !== false) {
                echo "      ✓ Base64 is VALID\n";
            } else {
                echo "      ✗ Base64 is INVALID\n";
            }
        } else if (strpos($src, 'storage/') !== false || strpos($src, '/storage/') !== false) {
            echo "      Type: File Path\n";
            echo "      Path: $src\n";
            
            // Check if file accessible
            if (strpos($src, 'http') === 0) {
                echo "      ⚠ Full URL (might not work in PDF)\n";
            }
        } else {
            echo "      Type: Other\n";
            echo "      Value: " . substr($src, 0, 100) . "...\n";
        }
    }
} else {
    echo "    ✗ No QR img tag found!\n";
}

// Step 5: Check condition in HTML
echo "\n[5] Condition Check in HTML:\n";

if (strpos($html, 'belum di-generate') !== false) {
    echo "    ✗ Showing PLACEHOLDER\n";
    echo "    This means the @if condition FAILED\n";
    echo "    Either qrBase64 empty OR qrPath empty\n";
} else {
    echo "    ✓ NOT showing placeholder\n";
    echo "    Condition passed\n";
}

// Step 6: Test actual preview-surat view
echo "\n[6] Test Preview Surat View (Full Flow):\n";

$preview_html = view('admin.pengajuan.preview-surat', $variables)->render();

if (preg_match('/<img[^>]*alt="QR Code"[^>]*src="([^"]*)"/', $preview_html, $m)) {
    echo "    QR img src: " . substr($m[1], 0, 80) . "...\n";
} else {
    echo "    ✗ No QR img tag in preview\n";
}

echo "\n✅ Debug complete\n";
