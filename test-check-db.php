<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\PengajuanSurat;
use Illuminate\Support\Facades\DB;

echo "Checking database...\n\n";

// Check if there are any pengajuan records
$count = PengajuanSurat::count();
echo "Total pengajuan records: " . $count . "\n\n";

if ($count > 0) {
    $pengajuan = PengajuanSurat::first();
    echo "First pengajuan:\n";
    echo "ID: " . $pengajuan->id . "\n";
    echo "Status: " . $pengajuan->status . "\n";
    echo "Signature Token: " . ($pengajuan->signature_token ?? 'NULL') . "\n";
    echo "Signature Generated At: " . ($pengajuan->signature_generated_at ?? 'NULL') . "\n\n";
    
    // If no token, generate one
    if (!$pengajuan->signature_token) {
        echo "Generating signature token...\n";
        $token = \App\Helpers\QrCodeGenerator::generateSignatureToken($pengajuan->id, 1);
        $pengajuan->update([
            'signature_token' => $token,
            'signature_generated_at' => now(),
        ]);
        echo "✓ Token generated: " . $token . "\n";
    } else {
        echo "Token already exists: " . $pengajuan->signature_token . "\n";
    }
} else {
    echo "No pengajuan records found. Please create one first.\n";
}
