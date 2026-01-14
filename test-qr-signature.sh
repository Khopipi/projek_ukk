#!/bin/bash
# Testing Script untuk QR Digital Signature Feature

echo "╔════════════════════════════════════════════════════════╗"
echo "║  QR Digital Signature - Testing Commands              ║"
echo "╚════════════════════════════════════════════════════════╝"
echo ""

# Colors
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m' # No Color

# Configuration
APP_URL="http://localhost:8000"
ARTISAN="php artisan"

echo -e "${YELLOW}1. Check Library Installation${NC}"
echo "================================"
echo "Running: composer show | grep qr"
composer show | grep qr
echo ""

echo -e "${YELLOW}2. Check Database Columns${NC}"
echo "=========================="
echo "Running: $ARTISAN tinker"
echo "Check these commands in tinker:"
echo ""
echo "$ DB::table('pengajuan_surats')->first();"
echo ""
echo "Press Ctrl+D to exit tinker"
echo ""
$ARTISAN tinker << 'EOF'
$columns = DB::table('pengajuan_surats')->first();
if ($columns) {
    echo "✓ Column check:\n";
    echo "  - signature_token: " . (isset($columns->signature_token) ? "✓ EXISTS" : "✗ MISSING") . "\n";
    echo "  - signature_generated_at: " . (isset($columns->signature_generated_at) ? "✓ EXISTS" : "✗ MISSING") . "\n";
} else {
    echo "✗ Table not found\n";
}
exit;
EOF

echo ""
echo -e "${YELLOW}3. Test Generate Signature Token${NC}"
echo "=================================="
echo "Running: $ARTISAN tinker"
echo ""
$ARTISAN tinker << 'EOF'
$token = App\Helpers\QrCodeGenerator::generateSignatureToken(1, 5);
echo "Generated Token: " . $token . "\n";

$url = App\Helpers\QrCodeGenerator::generateQrUrl($token);
echo "QR URL: " . $url . "\n";

// Test QR code generation
$base64 = App\Helpers\QrCodeGenerator::generateBase64($url);
echo "QR Base64: " . substr($base64, 0, 50) . "...\n";
exit;
EOF

echo ""
echo -e "${YELLOW}4. Test Database Query${NC}"
echo "======================"
echo "Running: $ARTISAN tinker"
echo ""
$ARTISAN tinker << 'EOF'
$pengajuan = App\Models\PengajuanSurat::first();
if ($pengajuan) {
    echo "Found Pengajuan:\n";
    echo "  - ID: " . $pengajuan->id . "\n";
    echo "  - Nomor: " . $pengajuan->nomor_pengajuan . "\n";
    echo "  - Signature Token: " . ($pengajuan->signature_token ?? "NULL") . "\n";
    echo "  - Generated At: " . ($pengajuan->signature_generated_at ?? "NULL") . "\n";
} else {
    echo "No pengajuan found\n";
}
exit;
EOF

echo ""
echo -e "${YELLOW}5. Test Verification Endpoint${NC}"
echo "============================="
echo ""
echo "Method 1: Manual curl test"
echo "Replace {token} with actual token from step 3"
echo ""
echo "curl \"$APP_URL/pengajuan/ttd?p={token}\""
echo ""
echo "Method 2: Test with database token"
echo "Running: $ARTISAN tinker"
echo ""
$ARTISAN tinker << 'EOF'
$pengajuan = App\Models\PengajuanSurat::first();
if ($pengajuan && $pengajuan->signature_token) {
    $url = route('pengajuan.verify-signature', ['p' => $pengajuan->signature_token]);
    echo "Test URL: " . $url . "\n";
    echo "Open in browser or curl:\n";
    echo "curl \"" . $url . "\"\n";
} else {
    echo "No pengajuan with signature token found\n";
}
exit;
EOF

echo ""
echo -e "${YELLOW}6. Test PDF Generation${NC}"
echo "====================="
echo "This requires actual admin access to generate PDF"
echo ""
echo "Steps:"
echo "1. Login as admin"
echo "2. Go to Admin > Verifikasi Pengajuan"
echo "3. Click on any pengajuan"
echo "4. Click 'Generate Surat' button"
echo "5. Check if PDF has QR code in footer"
echo ""

echo ""
echo -e "${GREEN}✓ Testing Complete!${NC}"
echo ""
echo "Next Steps:"
echo "1. Create test pengajuan surat if not exists"
echo "2. Test Generate Surat button in admin panel"
echo "3. Download PDF and verify QR code"
echo "4. Scan QR code and test verification"
echo ""
echo "For more info, see:"
echo "- FITUR_QR_DIGITAL_SIGNATURE.md"
echo "- QR_DIGITAL_SIGNATURE_QUICK_START.md"
echo "- CONTOH_IMPLEMENTASI_QR.md"
