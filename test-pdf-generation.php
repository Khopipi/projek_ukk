<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\PengajuanSurat;
use Illuminate\Support\Facades\Auth;

echo "Testing PDF Generation\n";
echo "======================\n\n";

// Get the first pengajuan (ID=1 which we already generated token for)
$pengajuan = PengajuanSurat::find(1);

if (!$pengajuan) {
    echo "ERROR: Pengajuan ID 1 not found!\n";
    exit(1);
}

echo "Testing with Pengajuan:\n";
echo "ID: " . $pengajuan->id . "\n";
echo "Jenis Surat: " . $pengajuan->jenis_surat . "\n";
echo "Signature Token: " . ($pengajuan->signature_token ?? 'NULL') . "\n\n";

// Set auth to simulate admin user
Auth::loginUsingId(1);

try {
    echo "Step 1: Generate signature token (if needed)...\n";
    if (!$pengajuan->signature_token) {
        $token = \App\Helpers\QrCodeGenerator::generateSignatureToken($pengajuan->id, Auth::id());
        $pengajuan->update([
            'signature_token' => $token,
            'signature_generated_at' => now()
        ]);
        $pengajuan->refresh();
        echo "✓ Token generated: " . $pengajuan->signature_token . "\n\n";
    } else {
        echo "✓ Token already exists: " . $pengajuan->signature_token . "\n\n";
    }
    
    echo "Step 2: Render HTML template...\n";
    $pengajuanFresh = PengajuanSurat::find($pengajuan->id);
    $html = view('pengajuan.pdf', ['pengajuan' => $pengajuanFresh])->render();
    
    if (strlen($html) > 100) {
        echo "✓ HTML rendered (" . strlen($html) . " bytes)\n\n";
    } else {
        echo "✗ HTML render failed (too short)\n";
        exit(1);
    }
    
    echo "Step 3: Generate PDF...\n";
    $pdf = \PDF::loadHTML($html)->setPaper('a4', 'portrait');
    $pdfContent = $pdf->output();
    
    if (strlen($pdfContent) > 100) {
        echo "✓ PDF generated (" . strlen($pdfContent) . " bytes)\n\n";
    } else {
        echo "✗ PDF generation failed (too short)\n";
        exit(1);
    }
    
    echo "Step 4: Save PDF to disk...\n";
    $filename = time() . '_test.pdf';
    $directory = storage_path('app/public/surat_hasil');
    if (!is_dir($directory)) {
        mkdir($directory, 0755, true);
    }
    
    $diskPath = $directory . DIRECTORY_SEPARATOR . $filename;
    file_put_contents($diskPath, $pdfContent);
    
    if (file_exists($diskPath)) {
        echo "✓ PDF saved to: " . $diskPath . "\n";
        echo "✓ File size: " . filesize($diskPath) . " bytes\n\n";
    } else {
        echo "✗ Failed to save PDF\n";
        exit(1);
    }
    
    echo "======================\n";
    echo "✓ SUCCESS! PDF generation works!\n";
    
} catch (\Throwable $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
    echo "\nStack trace:\n";
    echo $e->getTraceAsString() . "\n";
    exit(1);
}
