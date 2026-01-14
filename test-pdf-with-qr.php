<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\PengajuanSurat;
use Illuminate\Support\Facades\Auth;

echo "🧪 Testing Complete PDF Generation with New QR Code\n";
echo "====================================================\n\n";

// Set auth
Auth::loginUsingId(1);

// Get pengajuan
$pengajuan = PengajuanSurat::find(1);

if (!$pengajuan->signature_token) {
    $token = \App\Helpers\QrCodeGenerator::generateSignatureToken($pengajuan->id, Auth::id());
    $pengajuan->update([
        'signature_token' => $token,
        'signature_generated_at' => now()
    ]);
    $pengajuan->refresh();
}

try {
    // Step 1: Generate QR code file
    echo "Step 1: Generate QR code file\n";
    $qrUrl = \App\Helpers\QrCodeGenerator::generateQrUrl($pengajuan->signature_token);
    $qrPath = \App\Helpers\QrCodeGenerator::generateAndSaveQrCode($qrUrl);
    echo "✓ QR Path: " . $qrPath . "\n\n";

    // Step 2: Render HTML with QR path
    echo "Step 2: Render HTML template\n";
    $pengajuanFresh = PengajuanSurat::find($pengajuan->id);
    $html = view('pengajuan.pdf', ['pengajuan' => $pengajuanFresh, 'qrPath' => $qrPath])->render();
    echo "✓ HTML rendered: " . strlen($html) . " bytes\n\n";

    // Step 3: Generate PDF
    echo "Step 3: Generate PDF\n";
    $pdf = \PDF::loadHTML($html)->setPaper('a4', 'portrait');
    $pdfContent = $pdf->output();
    echo "✓ PDF generated: " . strlen($pdfContent) . " bytes\n\n";

    // Step 4: Save PDF
    echo "Step 4: Save PDF to disk\n";
    $directory = storage_path('app/public/surat_hasil');
    if (!is_dir($directory)) {
        mkdir($directory, 0755, true);
    }
    
    $filename = time() . '_test_new_qr.pdf';
    $diskPath = $directory . DIRECTORY_SEPARATOR . $filename;
    file_put_contents($diskPath, $pdfContent);
    
    if (file_exists($diskPath)) {
        echo "✓ PDF saved: " . $diskPath . "\n";
        echo "✓ File size: " . filesize($diskPath) . " bytes\n\n";
    } else {
        throw new \Exception('Failed to save PDF');
    }

    echo "====================================================\n";
    echo "✅ SUCCESS! PDF with QR code generated successfully!\n";
    echo "====================================================\n\n";
    echo "QR Code Details:\n";
    echo "  Token: " . $pengajuan->signature_token . "\n";
    echo "  Generated At: " . $pengajuan->signature_generated_at . "\n";
    echo "  QR Path: " . $qrPath . "\n";
    echo "  PDF File: " . $filename . "\n";

} catch (\Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
    exit(1);
}
