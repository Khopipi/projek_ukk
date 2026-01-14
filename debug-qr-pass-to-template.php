<?php

require 'vendor/autoload.php';

use Illuminate\Foundation\Application;
use App\Models\PengajuanSurat;

// Bootstrap Laravel
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

app('auth')->loginUsingId(2);

$pengajuan = PengajuanSurat::latest()->first();

echo "🔍 DEBUG: Checking QR Variables Actually Passed to Template\n";
echo "============================================================\n\n";

// Generate QR
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

echo "[1] QR Variables Before Pass to Template:\n";
echo "    \$qrPath: " . ($qrPath ? "'$qrPath' (length: " . strlen($qrPath) . ")" : "NULL") . "\n";
echo "    \$qrBase64: " . ($qrBase64 ? strlen($qrBase64) . " bytes" : "EMPTY/NULL") . "\n";
echo "    isset(\$qrBase64): " . (isset($qrBase64) ? "TRUE" : "FALSE") . "\n";
echo "    !empty(\$qrBase64): " . (!empty($qrBase64) ? "TRUE" : "FALSE") . "\n";

// Now render include template
echo "\n[2] Render surat-template Include:\n";

$templateVars = [
    'pengajuan' => $pengajuan,
    'qrPath' => $qrPath,
    'qrBase64' => $qrBase64
];

echo "    Variables passed:\n";
foreach ($templateVars as $k => $v) {
    if ($k === 'pengajuan') {
        echo "      - $k: PengajuanSurat object\n";
    } else {
        echo "      - $k: " . ($v ? (is_string($v) ? strlen($v) . " bytes" : $v) : "NULL") . "\n";
    }
}

$html = view('pengajuan.surat-template', $templateVars)->render();

echo "\n[3] Check Output HTML:\n";

// Check if condition passes
if (strpos($html, 'belum di-generate') !== false) {
    echo "    ✗ SHOWING PLACEHOLDER (condition failed)\n";
    echo "    This means: isset(\$qrBase64) && !empty(\$qrBase64) = FALSE\n";
} else {
    echo "    ✓ NOT showing placeholder (condition passed)\n";
}

// Check if img tag with src exists
if (preg_match('/<img[^>]*src="([^"]*)"[^>]*alt="QR Code"/', $html, $m)) {
    $src = $m[1];
    $src_preview = substr($src, 0, 80);
    echo "    ✓ QR img tag found\n";
    echo "    Src: " . $src_preview . (strlen($src) > 80 ? "..." : "") . "\n";
    echo "    Src length: " . strlen($src) . " bytes\n";
    
    if (strpos($src, 'data:image/png;base64,') === 0) {
        echo "    ✓ Source is base64 data URI\n";
    }
} else {
    echo "    ✗ QR img tag NOT found\n";
}

// Check raw base64 in HTML
if (strpos($html, 'data:image/png;base64,iVBORw0KGgo') !== false) {
    echo "    ✓ Base64 PNG found in HTML\n";
} else {
    echo "    ✗ Base64 PNG NOT found in HTML\n";
}

echo "\n[4] Extract QR Code Section:\n";
if (preg_match('/<div style="margin: 8px 0 5px 0; text-align: center;">.*?<\/div>/s', $html, $m)) {
    $section = $m[0];
    // Truncate for display
    $display = substr($section, 0, 300) . (strlen($section) > 300 ? "..." : "");
    echo "    Found section:\n";
    echo "    " . str_replace("\n", "\n    ", $display) . "\n";
}

echo "\n✅ Debug complete\n";
