<?php
// Debug script to check pengajuan records

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\PengajuanSurat;
use App\Models\User;

echo "=== Users in Database ===\n";
$users = User::all();
foreach ($users as $u) {
    echo "ID: {$u->id}, Name: {$u->name}, Email: {$u->email}, Role: {$u->role}\n";
}

echo "\n=== Pengajuan Records ===\n";
$pengajuan = PengajuanSurat::where('file_ktp', 'like', '%1764040350%')->first();

if ($pengajuan) {
    echo "Found Pengajuan:\n";
    echo "ID: {$pengajuan->id}\n";
    echo "User ID: {$pengajuan->user_id}\n";
    echo "File KTP: {$pengajuan->file_ktp}\n";
    echo "File KK: {$pengajuan->file_kk}\n";
    echo "Status: {$pengajuan->status}\n";
    echo "User Role: {$pengajuan->user->role}\n";
} else {
    echo "Pengajuan not found with file 1764040350\n";
    echo "\nAll pengajuan records:\n";
    $all = PengajuanSurat::all();
    foreach ($all as $p) {
        echo "ID: {$p->id}, User: {$p->user_id}, File KTP: {$p->file_ktp}\n";
    }
}
?>
