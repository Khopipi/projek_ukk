<?php
/**
 * TEST - QR Code Complete Flow
 * Verify QR muncul di preview dan PDF
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
echo "║        QR CODE COMPLETE FLOW TEST - VERIFY PLACEHOLDER GONE    ║\n";
echo "╚════════════════════════════════════════════════════════════════╝\n\n";

// Get pengajuan
$pengajuan = PengajuanSurat::whereNotNull('status')->first();

if (!$pengajuan) {
    echo "❌ No pengajuan found\n";
    exit;
}

echo "[1] Prepare Test Data\n";
echo str_repeat("-", 60) . "\n";
echo "  Pengajuan: {$pengajuan->nomor_pengajuan}\n";
echo "  Current Token: " . (empty($pengajuan->signature_token) ? "❌ EMPTY" : "✓ EXISTS") . "\n\n";

// Simulate controller flow (previewSurat)
echo "[2] Simulate Controller - previewSurat()\n";
echo str_repeat("-", 60) . "\n";

if (!$pengajuan->signature_token) {
    $signatureToken = QrCodeGenerator::generateSignatureToken($pengajuan->id, Auth::id() ?? 1);
    $pengajuan->update([
        'signature_token' => $signatureToken,
        'signature_generated_at' => now()
    ]);
    echo "  ✓ Token generated and saved\n";
} else {
    echo "  ✓ Token already exists\n";
}

$qrUrl = QrCodeGenerator::generateQrUrl($pengajuan->signature_token);
$qrPath = QrCodeGenerator::generateAndSaveQrCode($qrUrl);
$qrBase64 = QrCodeGenerator::getQrCodeAsBase64($qrPath);

echo "  ✓ QR Path: $qrPath\n";
echo "  ✓ File exists: " . (file_exists(public_path($qrPath)) ? "YES" : "NO") . "\n";
echo "  ✓ QR Base64 length: " . strlen($qrBase64) . " bytes\n\n";

// Test component rendering
echo "[3] Test Component Rendering\n";
echo str_repeat("-", 60) . "\n";

// Set view path
View::addLocation(resource_path('views'));

try {
    $componentHtml = view('pengajuan.components.qr-code-section', [
        'pengajuan' => $pengajuan,
        'qrPath' => $qrPath
    ])->render();
    
    echo "  ✓ Component rendered successfully\n";
    
    // Check if placeholder exists
    if (strpos($componentHtml, 'belum di-generate') !== false) {
        echo "  ❌ PLACEHOLDER FOUND! Component still showing placeholder\n";
    } else {
        echo "  ✓ NO PLACEHOLDER - Component has actual QR\n";
    }
    
    // Check if img tag exists
    if (strpos($componentHtml, '<img') !== false) {
        echo "  ✓ IMG tag found - QR will display\n";
    }
    
    echo "  ✓ HTML length: " . strlen($componentHtml) . " bytes\n\n";
} catch (\Exception $e) {
    echo "  ❌ Component error: " . $e->getMessage() . "\n\n";
}

// Test full template rendering
echo "[4] Test Full Template Rendering\n";
echo str_repeat("-", 60) . "\n";

try {
    $templateHtml = view('pengajuan.surat-template', [
        'pengajuan' => $pengajuan,
        'qrPath' => $qrPath,
        'qrBase64' => $qrBase64
    ])->render();
    
    echo "  ✓ Template rendered successfully\n";
    
    // Count QR images in template
    $qrCount = substr_count($templateHtml, '<img') - substr_count($templateHtml, '<!-- skip -->');
    echo "  ✓ QR images in template: $qrCount\n";
    
    // Check if placeholder exists
    if (strpos($templateHtml, 'belum di-generate') !== false) {
        echo "  ❌ PLACEHOLDER FOUND in template!\n";
    } else {
        echo "  ✓ NO PLACEHOLDER in template\n";
    }
    
    echo "  ✓ HTML length: " . strlen($templateHtml) . " bytes\n\n";
} catch (\Exception $e) {
    echo "  ❌ Template error: " . $e->getMessage() . "\n\n";
}

// Test PDF generation
echo "[5] Test PDF Generation\n";
echo str_repeat("-", 60) . "\n";

try {
    $pengajuanFresh = PengajuanSurat::find($pengajuan->id);
    $html = view('pengajuan.pdf', [
        'pengajuan' => $pengajuanFresh,
        'qrPath' => $qrPath,
        'qrBase64' => $qrBase64
    ])->render();
    
    if (class_exists(\Barryvdh\DomPDF\Facade::class)) {
        $pdf = \PDF::loadHTML($html)->setPaper('a4', 'portrait');
        $pdfContent = $pdf->output();
        echo "  ✓ PDF generated successfully\n";
        echo "  ✓ PDF size: " . strlen($pdfContent) . " bytes\n";
        
        // Check if QR is in PDF HTML
        if (strpos($html, 'belum di-generate') !== false) {
            echo "  ❌ PLACEHOLDER FOUND in PDF HTML!\n";
        } else {
            echo "  ✓ NO PLACEHOLDER in PDF HTML\n";
        }
    } else {
        echo "  ⚠️  DomPDF not available\n";
    }
    echo "\n";
} catch (\Exception $e) {
    echo "  ❌ PDF error: " . $e->getMessage() . "\n\n";
}

echo "════════════════════════════════════════════════════════════════\n";
echo "✅ QR CODE COMPLETE FLOW TEST DONE\n";
echo "\nExpected Result:\n";
echo "  ✓ All components render without placeholder\n";
echo "  ✓ QR code muncul as actual image (not placeholder)\n";
echo "  ✓ Works in template, PDF, and all views\n";
echo "════════════════════════════════════════════════════════════════\n\n";
