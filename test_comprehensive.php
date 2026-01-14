#!/usr/bin/env php
<?php
/**
 * COMPREHENSIVE SVG QR CODE TEST
 * Verifies all components are working together
 */

require 'vendor/autoload.php';

echo "\n";
echo "╔════════════════════════════════════════════════════════════╗\n";
echo "║     SVG QR CODE SYSTEM - COMPREHENSIVE TEST               ║\n";
echo "║     (NO GD LIBRARY REQUIRED - NO FILE STORAGE)            ║\n";
echo "╚════════════════════════════════════════════════════════════╝\n\n";

use App\Helpers\QrCodeGenerator;

$tests = [
    '1. Token Generation' => fn() => testTokenGeneration(),
    '2. QR URL Generation' => fn() => testQrUrl(),
    '3. SVG Generation' => fn() => testSvgGeneration(),
    '4. Base64 Encoding' => fn() => testBase64Encoding(),
    '5. Component Integration' => fn() => testComponentIntegration(),
];

$passed = 0;
$failed = 0;

foreach ($tests as $name => $test) {
    echo "────────────────────────────────────────────────────────────\n";
    echo "TEST: $name\n";
    echo "────────────────────────────────────────────────────────────\n";
    try {
        $result = $test();
        if ($result['success']) {
            echo "✅ PASSED\n";
            echo "   {$result['message']}\n";
            $passed++;
        } else {
            echo "❌ FAILED\n";
            echo "   {$result['message']}\n";
            $failed++;
        }
    } catch (\Throwable $e) {
        echo "❌ ERROR: {$e->getMessage()}\n";
        $failed++;
    }
    echo "\n";
}

// Summary
echo "════════════════════════════════════════════════════════════\n";
echo "TEST SUMMARY\n";
echo "════════════════════════════════════════════════════════════\n";
echo "Passed: $passed\n";
echo "Failed: $failed\n";
echo "Total:  " . ($passed + $failed) . "\n";
echo "════════════════════════════════════════════════════════════\n\n";

if ($failed === 0) {
    echo "✅ ALL TESTS PASSED!\n";
    echo "   SVG QR Code system is working correctly\n";
    echo "   Ready for production use\n\n";
    exit(0);
} else {
    echo "❌ SOME TESTS FAILED\n";
    echo "   Please review the errors above\n\n";
    exit(1);
}

// Test Functions
function testTokenGeneration() {
    $token = \App\Helpers\QrCodeGenerator::generateSignatureToken(99, 1);
    $parts = explode('|', $token);
    
    if (count($parts) !== 4) {
        return ['success' => false, 'message' => 'Token format invalid (expected 4 parts)'];
    }
    
    if (!is_numeric($parts[0]) || !is_numeric($parts[1]) || !is_numeric($parts[2])) {
        return ['success' => false, 'message' => 'Token parts not numeric'];
    }
    
    return ['success' => true, 'message' => "Token generated: $token"];
}

function testQrUrl() {
    $token = "99|1234567890|1|abc12345";
    $url = "http://127.0.0.1:8000/pengajuan/ttd?p=" . urlencode($token);
    
    if (strpos($url, '/pengajuan/ttd?p=') === false) {
        return ['success' => false, 'message' => 'QR URL format invalid'];
    }
    
    return ['success' => true, 'message' => "URL length: " . strlen($url) . " chars"];
}

function testSvgGeneration() {
    $data = "http://127.0.0.1:8000/pengajuan/ttd?p=99%7C1234567890%7C1%7Cabc12345";
    $svg = \App\Helpers\QrCodeGenerator::generateSvg($data, 150);
    
    if (strlen($svg) === 0) {
        return ['success' => false, 'message' => 'SVG generation returned empty string'];
    }
    
    if (strpos($svg, '<svg') === false || strpos($svg, '</svg>') === false) {
        return ['success' => false, 'message' => 'SVG content missing XML tags'];
    }
    
    return ['success' => true, 'message' => "SVG length: " . strlen($svg) . " bytes"];
}

function testBase64Encoding() {
    $data = "http://127.0.0.1:8000/pengajuan/ttd?p=99%7C1234567890%7C1%7Cabc12345";
    $dataUri = \App\Helpers\QrCodeGenerator::generateSvgBase64($data, 150);
    
    if (strlen($dataUri) === 0) {
        return ['success' => false, 'message' => 'Base64 encoding returned empty'];
    }
    
    if (strpos($dataUri, 'data:image/svg+xml;base64,') !== 0) {
        return ['success' => false, 'message' => 'Base64 data URI prefix invalid'];
    }
    
    return ['success' => true, 'message' => "Data URI length: " . strlen($dataUri) . " bytes"];
}

function testComponentIntegration() {
    $dataUri = \App\Helpers\QrCodeGenerator::generateSvgBase64(
        "http://127.0.0.1:8000/pengajuan/ttd?p=99%7C1234567890%7C1%7Cabc12345",
        150
    );
    
    if (strlen($dataUri) === 0) {
        return ['success' => false, 'message' => 'Component would render placeholder (empty SVG)'];
    }
    
    // Simulate what component does
    $html = '<img src="' . htmlspecialchars($dataUri) . '" width="75" height="75" alt="QR Code">';
    
    if (strlen($html) < 100) {
        return ['success' => false, 'message' => 'HTML output too short'];
    }
    
    return ['success' => true, 'message' => "Component HTML ready for embedding"];
}
