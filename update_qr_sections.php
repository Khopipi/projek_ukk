<?php
/**
 * Script untuk update surat-template.blade.php
 * Replace 8 QR sections dengan component include
 */

$file = __DIR__ . '/resources/views/pengajuan/surat-template.blade.php';
$content = file_get_contents($file);

// Pattern untuk regex replace
$pattern = '/@if\(\$pengajuan->signature_token && \$pengajuan->signature_generated_at && isset\(\$qrPath\) && !empty\(\$qrPath\)\).*?@endif/s';

$replacement = '@include("pengajuan.components.qr-code-section", ["pengajuan" => $pengajuan, "qrPath" => $qrPath ?? null])';

$newContent = preg_replace($pattern, $replacement, $content);

if ($newContent !== $content) {
    file_put_contents($file, $newContent);
    
    // Count replacements
    $matches = preg_match_all($pattern, $content);
    echo "✓ Updated surat-template.blade.php\n";
    echo "  Replacements: $matches\n";
} else {
    echo "✗ No changes - pattern not found or already updated\n";
}
