<?php
/**
 * DEBUG - Show actual HTML rendered by component
 */

require __DIR__ . '/vendor/autoload.php';

$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\View;
use App\Models\PengajuanSurat;
use App\Helpers\QrCodeGenerator;

$pengajuan = PengajuanSurat::whereNotNull('status')->first();

if (!$pengajuan) {
    echo "No pengajuan found\n";
    exit;
}

// Generate QR
$qrUrl = QrCodeGenerator::generateQrUrl($pengajuan->signature_token);
$qrPath = QrCodeGenerator::generateAndSaveQrCode($qrUrl);

View::addLocation(resource_path('views'));

// Render component
$componentHtml = view('pengajuan.components.qr-code-section', [
    'pengajuan' => $pengajuan,
    'qrPath' => $qrPath
])->render();

echo "COMPONENT HTML OUTPUT:\n";
echo str_repeat("=", 70) . "\n";
echo $componentHtml;
echo "\n" . str_repeat("=", 70) . "\n";
