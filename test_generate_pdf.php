<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\PengajuanSurat;

$pengajuan = PengajuanSurat::find(5);
if (!$pengajuan) {
    echo "Pengajuan tidak ditemukan\n";
    exit(1);
}

echo "=== Test Generate PDF ===\n";
echo "Pengajuan ID: " . $pengajuan->id . "\n";
echo "Nomor: " . $pengajuan->nomor_pengajuan . "\n";

// Cek view file
$viewPath = 'resources/views/pengajuan/pdf.blade.php';
if (file_exists($viewPath)) {
    echo "✓ View file exists: " . $viewPath . "\n";
} else {
    echo "✗ View file NOT found: " . $viewPath . "\n";
    exit(1);
}

// Test render HTML
try {
    $html = view('pengajuan.pdf', compact('pengajuan'))->render();
    echo "✓ HTML rendered successfully (" . strlen($html) . " bytes)\n";
} catch (Throwable $e) {
    echo "✗ HTML render failed: " . $e->getMessage() . "\n";
    exit(1);
}

// Test PDF generation
try {
    if (class_exists(\Barryvdh\DomPDF\Facade::class)) {
        echo "✓ Using Barryvdh DomPDF\n";
        $pdf = \PDF::loadHTML($html)->setPaper('a4', 'portrait');
        $pdfContent = $pdf->output();
    } else {
        echo "✓ Using native Dompdf\n";
        $dompdf = new \Dompdf\Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $pdfContent = $dompdf->output();
    }
    echo "✓ PDF generated successfully (" . strlen($pdfContent) . " bytes)\n";
} catch (Throwable $e) {
    echo "✗ PDF generation failed: " . $e->getMessage() . "\n";
    exit(1);
}

// Test file storage
$directory = storage_path('app/public/surat_hasil');
if (!is_dir($directory)) {
    mkdir($directory, 0755, true);
}
echo "✓ Directory exists: " . $directory . "\n";

$filename = time() . '_' . preg_replace('/[^A-Za-z0-9\-_]/', '_', $pengajuan->nomor_pengajuan) . '.pdf';
$filePath = $directory . '/' . $filename;

try {
    file_put_contents($filePath, $pdfContent);
    if (file_exists($filePath)) {
        echo "✓ PDF file saved: " . $filePath . " (" . filesize($filePath) . " bytes)\n";
    } else {
        echo "✗ PDF file was NOT saved\n";
        exit(1);
    }
} catch (Throwable $e) {
    echo "✗ File save failed: " . $e->getMessage() . "\n";
    exit(1);
}

// Test database update
try {
    $pengajuan->update([
        'file_surat_hasil' => $filename,
        'status' => 'Selesai',
        'tanggal_selesai' => now()
    ]);
    echo "✓ Database updated\n";
    echo "  - file_surat_hasil: " . $pengajuan->file_surat_hasil . "\n";
    echo "  - status: " . $pengajuan->status . "\n";
} catch (Throwable $e) {
    echo "✗ Database update failed: " . $e->getMessage() . "\n";
    exit(1);
}

echo "\n✓ All tests passed! PDF generated successfully.\n";
