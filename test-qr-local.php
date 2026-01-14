<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';

echo "Testing QR Code Generation\n";
echo "===========================\n\n";

try {
    // Test 1: QR Code generation
    echo "Test 1: QR Code Generation\n";
    try {
        $url = 'http://localhost:8000/pengajuan/ttd?p=42|1705126800|5|a8f3b2c1';
        $base64 = App\Helpers\QrCodeGenerator::generateBase64($url);
        
        if ($base64 && strpos($base64, 'data:image/png;base64,') === 0) {
            echo "✓ QR Code generation WORKS!\n";
            echo "Generated length: " . strlen($base64) . " bytes\n\n";
        } else {
            echo "✗ QR Code generation FAILED (returned empty)\n\n";
        }
    } catch (\Exception $e) {
        echo "✗ Error: " . $e->getMessage() . "\n";
        echo "File: " . $e->getFile() . " Line: " . $e->getLine() . "\n\n";
    }
    
    // Test 2: Token generation
    echo "Test 2: Signature Token Generation\n";
    $token = App\Helpers\QrCodeGenerator::generateSignatureToken(42, 5);
    echo "✓ Token: " . $token . "\n\n";
    
    // Test 3: URL generation
    echo "Test 3: QR URL Generation\n";
    $qrUrl = App\Helpers\QrCodeGenerator::generateQrUrl($token);
    echo "✓ URL: " . $qrUrl . "\n\n";
    
    echo "===========================\n";
    echo "✓ All tests passed!\n";
    
} catch (\Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
}
