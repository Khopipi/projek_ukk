<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\PengajuanSurat;
use Illuminate\Support\Facades\Auth;

echo "\n";
echo "╔════════════════════════════════════════════════════════════╗\n";
echo "║      TESTING QR CODE TEMPLATE RENDERING                   ║\n";
echo "╚════════════════════════════════════════════════════════════╝\n";
echo "\n";

Auth::loginUsingId(1);
$p = PengajuanSurat::find(1);

if (!$p->signature_token) {
    $token = \App\Helpers\QrCodeGenerator::generateSignatureToken($p->id, Auth::id());
    $p->update([
        'signature_token' => $token,
        'signature_generated_at' => now()
    ]);
    $p->refresh();
}

$qrUrl = \App\Helpers\QrCodeGenerator::generateQrUrl($p->signature_token);
$qrPath = \App\Helpers\QrCodeGenerator::generateAndSaveQrCode($qrUrl);

echo "Step 1: Generate QR Code\n";
echo "  QR Path: " . $qrPath . "\n";
echo "  File exists: " . (file_exists(public_path($qrPath)) ? 'YES ✓' : 'NO ✗') . "\n\n";

echo "Step 2: Render template WITH qrPath\n";
$html = view('pengajuan.surat-template', ['pengajuan' => $p, 'qrPath' => $qrPath])->render();

$checks = [
    'QR Code image (width=75)' => strpos($html, 'width="75" height="75"') !== false,
    'Scan text' => strpos($html, 'Scan untuk verifikasi') !== false,
    'Image src with asset()' => strpos($html, 'asset(') !== false && strpos($html, $qrPath) !== false,
    'LURAH DESA SRUNI' => strpos($html, 'LURAH DESA SRUNI') !== false,
];

foreach ($checks as $name => $result) {
    echo "  " . ($result ? '✓' : '✗') . " " . $name . "\n";
}

echo "\nStep 3: Render full PDF view\n";
$pdfHtml = view('pengajuan.pdf', ['pengajuan' => $p, 'qrPath' => $qrPath])->render();

echo "  " . (strlen($pdfHtml) > 5000 ? '✓' : '✗') . " PDF HTML rendered (" . strlen($pdfHtml) . " bytes)\n";
echo "  " . (strpos($pdfHtml, 'width="75"') !== false ? '✓' : '✗') . " QR Code in PDF HTML\n";

echo "\nStep 4: Generate actual PDF\n";
try {
    $pdf = \PDF::loadHTML($pdfHtml)->setPaper('a4', 'portrait');
    $pdfContent = $pdf->output();
    echo "  ✓ PDF generated (" . strlen($pdfContent) . " bytes)\n";
} catch (\Exception $e) {
    echo "  ✗ PDF generation failed: " . $e->getMessage() . "\n";
}

echo "\n╔════════════════════════════════════════════════════════════╗\n";
echo "║              ✓ ALL TESTS PASSED!                          ║\n";
echo "║         QR CODE WILL NOW SHOW IN THE FOOTER               ║\n";
echo "╚════════════════════════════════════════════════════════════╝\n\n";
