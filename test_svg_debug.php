<?php

require 'vendor/autoload.php';

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\SvgWriter;

echo "[TEST] SVG Generation Debug\n";
echo str_repeat("=", 50) . "\n\n";

try {
    // Create QR Code
    $qrCode = new QrCode(
        data: 'http://127.0.0.1:8000/pengajuan/ttd?p=1|1768269271|1|7d9826f9',
        size: 150,
        margin: 10
    );

    echo "[1] QrCode created\n";
    echo "  Class: " . get_class($qrCode) . "\n\n";

    // Create Writer
    $writer = new SvgWriter();
    echo "[2] SvgWriter created\n";
    echo "  Class: " . get_class($writer) . "\n\n";

    // Write
    $result = $writer->write($qrCode);
    echo "[3] Writer.write() executed\n";
    echo "  Result Class: " . get_class($result) . "\n";
    echo "  Result Type: " . gettype($result) . "\n\n";

    // Check methods
    echo "[4] Available Methods:\n";
    $methods = get_class_methods($result);
    foreach ($methods as $method) {
        if (strpos($method, 'get') !== false || strpos($method, 'string') !== false || strpos($method, 'String') !== false) {
            echo "  - " . $method . "()\n";
        }
    }
    echo "\n";

    // Try getString()
    echo "[5] Calling getString():\n";
    if (method_exists($result, 'getString')) {
        $svg = $result->getString();
        echo "  ✅ Method exists\n";
        echo "  Type: " . gettype($svg) . "\n";
        echo "  Length: " . strlen($svg) . " bytes\n";
        echo "  Preview: " . substr($svg, 0, 100) . "\n";
        if (strlen($svg) > 0) {
            echo "  ✅ SVG Generated Successfully!\n";
            echo "\n[6] SVG Content (first 500 chars):\n";
            echo substr($svg, 0, 500) . "\n";
        } else {
            echo "  ❌ Empty SVG returned\n";
        }
    } else {
        echo "  ❌ Method does NOT exist\n";
        echo "  Available: " . implode(', ', $methods) . "\n";
    }

} catch (\Throwable $e) {
    echo "[ERROR] " . get_class($e) . ": " . $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
}
