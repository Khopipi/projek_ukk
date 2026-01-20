<?php
require 'vendor/autoload.php';

// Load Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Pengaduan;
use Illuminate\Support\Facades\DB;

echo "=== PRIORITY DEBUG TEST ===\n\n";

// Check all pengaduans and their priority values
$pengaduans = Pengaduan::orderBy('created_at', 'desc')->take(10)->get();

echo "Latest 10 Pengaduans:\n";
echo str_repeat("-", 80) . "\n";
echo sprintf("%-5s | %-15s | %-10s | %-20s | %-20s\n", "ID", "Nomor", "Prioritas", "Label", "Status");
echo str_repeat("-", 80) . "\n";

foreach ($pengaduans as $p) {
    printf("%-5d | %-15s | %-10s | %-20s | %-20s\n", 
        $p->id, 
        $p->nomor_pengaduan,
        $p->prioritas,
        $p->prioritas_label,
        $p->status
    );
}

echo "\n=== DISTINCT PRIORITAS VALUES IN DB ===\n";
$distinctPrioritas = DB::table('pengaduans')->distinct('prioritas')->pluck('prioritas');
echo "Distinct prioritas values: " . $distinctPrioritas->implode(', ') . "\n";

echo "\n=== COUNT BY PRIORITAS ===\n";
$countByPrioritas = DB::table('pengaduans')->groupBy('prioritas')->selectRaw('prioritas, COUNT(*) as total')->get();
foreach ($countByPrioritas as $row) {
    echo sprintf("%s: %d records\n", $row->prioritas, $row->total);
}

echo "\n=== FORM FIELD VALIDATION ===\n";
echo "Controller expects: Rendah, Sedang, Tinggi\n";
echo "Form sends: Rendah (Biasa), Sedang (Mendesak), Tinggi (Sangat Mendesak)\n";

echo "\n✅ Debug complete!\n";
