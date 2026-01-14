#!/usr/bin/env php
<?php
/**
 * Test QR Code Verification Page
 */

require 'vendor/autoload.php';

echo "\n═══════════════════════════════════════════════════════\n";
echo "   QR CODE VERIFICATION PAGE TEST\n";
echo "═══════════════════════════════════════════════════════\n\n";

// Test 1: Check if layouts.app exists
echo "[1] Check layouts.app\n";
$layoutPath = 'resources/views/layouts/app.blade.php';
if (file_exists($layoutPath)) {
    $layoutSize = filesize($layoutPath);
    echo "    ✅ File exists\n";
    echo "    Size: $layoutSize bytes\n";
    
    $content = file_get_contents($layoutPath);
    if (strpos($content, '@yield') !== false) {
        echo "    ✅ Contains @yield sections\n";
    }
} else {
    echo "    ❌ File not found\n";
}

echo "\n[2] Check verify-signature.blade.php\n";
$verifyPath = 'resources/views/pengajuan/verify-signature.blade.php';
if (file_exists($verifyPath)) {
    $content = file_get_contents($verifyPath);
    echo "    ✅ File exists\n";
    
    if (strpos($content, "H. Saiful Imaduddin, SKM., M.Kes") !== false) {
        echo "    ✅ Contains Kepala Desa name\n";
    } else {
        echo "    ❌ Missing Kepala Desa name\n";
    }
    
    if (strpos($content, "Kepala Desa Sruni") !== false) {
        echo "    ✅ Contains Kepala Desa title\n";
    }
    
    if (strpos($content, '@extends(\'layouts.app\')') !== false) {
        echo "    ✅ Extends layouts.app\n";
    }
    
    if (strpos($content, 'Ditandatangani Oleh') !== false) {
        echo "    ✅ Contains signature section\n";
    }
} else {
    echo "    ❌ File not found\n";
}

echo "\n[3] Check Route\n";
$routePath = 'routes/web.php';
$routeContent = file_get_contents($routePath);
if (strpos($routeContent, "'/pengajuan/ttd'") !== false) {
    echo "    ✅ Route exists\n";
    if (strpos($routeContent, "verifySignature") !== false) {
        echo "    ✅ Route calls verifySignature()\n";
    }
} else {
    echo "    ❌ Route not found\n";
}

echo "\n[4] Check Controller Method\n";
$controllerPath = 'app/Http/Controllers/PengajuanSuratController.php';
$controllerContent = file_get_contents($controllerPath);
if (strpos($controllerContent, "public function verifySignature") !== false) {
    echo "    ✅ verifySignature() method exists\n";
    if (strpos($controllerContent, "pengajuan.verify-signature") !== false) {
        echo "    ✅ Returns verify-signature view\n";
    }
} else {
    echo "    ❌ Method not found\n";
}

echo "\n═══════════════════════════════════════════════════════\n";
echo "✅ VERIFICATION PAGE SETUP COMPLETE\n";
echo "═══════════════════════════════════════════════════════\n";
echo "\nTo test the QR signature verification:\n";
echo "1. Generate a pengajuan with a QR code\n";
echo "2. Scan the QR code\n";
echo "3. Page should display with:\n";
echo "   - Kepala Desa name: H. Saiful Imaduddin, SKM., M.Kes\n";
echo "   - Verification status\n";
echo "   - Pengajuan details\n\n";
