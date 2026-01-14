<?php

require 'vendor/autoload.php';

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

echo "Testing direct QR Code generation\n\n";

// Test 1: Create QR Code
try {
    echo "Creating QRCode...\n";
    $qrCode = new QrCode(
        data: 'Hello World',
        size: 150,
        margin: 10
    );
    echo "✓ QRCode created\n\n";
    
    // Test 2: Create writer
    echo "Creating PngWriter...\n";
    $writer = new PngWriter();
    echo "✓ PngWriter created\n\n";
    
    // Test 3: Write
    echo "Writing PNG...\n";
    $result = $writer->write($qrCode);
    echo "✓ PNG written\n\n";
    
    // Test 4: Get PNG
    echo "Getting PNG data...\n";
    $png = $result->getString();
    echo "✓ PNG data: " . strlen($png) . " bytes\n\n";
    
    // Test 5: Encode to base64
    echo "Encoding to base64...\n";
    $base64 = base64_encode($png);
    echo "✓ Base64 length: " . strlen($base64) . " bytes\n\n";
    
    echo "SUCCESS!\n";
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
    echo "Stack trace:\n";
    echo $e->getTraceAsString() . "\n";
}
