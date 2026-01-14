<?php

require 'vendor/autoload.php';

use Illuminate\Foundation\Application;
use App\Models\PengajuanSurat;

// Bootstrap Laravel
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Get the latest pengajuan
$pengajuan = PengajuanSurat::latest()->first();

$qrUrl = \App\Helpers\QrCodeGenerator::generateQrUrl($pengajuan->signature_token);
$qrPath = \App\Helpers\QrCodeGenerator::generateAndSaveQrCode($qrUrl);

echo "🔍 Path Debugging:\n";
echo "QR Path returned: $qrPath\n";

// Check different path combinations
$pathsToTest = [
    'storage_path(\'app/public\' . $qrPath)' => storage_path('app/public' . $qrPath),
    'public_path($qrPath)' => public_path($qrPath),
    'storage_path(\'app/public/qr_codes\') + filename' => storage_path('app/public/qr_codes') . '/' . basename($qrPath),
];

foreach ($pathsToTest as $desc => $path) {
    $exists = file_exists($path) ? '✓ EXISTS' : '✗ NOT FOUND';
    echo "$desc\n";
    echo "  Path: $path\n";
    echo "  Status: $exists\n";
    if (file_exists($path)) {
        echo "  Size: " . filesize($path) . " bytes\n";
    }
    echo "\n";
}
