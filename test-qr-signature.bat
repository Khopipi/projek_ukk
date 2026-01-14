@echo off
REM Testing Script untuk QR Digital Signature Feature (Windows)

setlocal enabledelayedexpansion

title QR Digital Signature - Testing Commands

cls
echo.
echo ╔════════════════════════════════════════════════════════╗
echo ║  QR Digital Signature - Testing Commands              ║
echo ║  (Windows Batch)                                      ║
echo ╚════════════════════════════════════════════════════════╝
echo.

REM Configuration
set APP_URL=http://localhost:8000
set ARTISAN=php artisan

echo.
echo 1. Check Library Installation
echo ================================
echo Running: composer show ^| findstr qr
composer show | findstr qr
pause

cls
echo.
echo 2. Check Migration Status
echo ==========================
echo Running: %ARTISAN% migrate:status
call %ARTISAN% migrate:status
pause

cls
echo.
echo 3. Check Database Structure
echo ============================
echo.
echo Open this command in browser to check database:
echo URL: %APP_URL%/admin/database (if admin dashboard has this)
echo.
echo Or run MySQL query:
echo.
echo   SELECT COLUMN_NAME, COLUMN_TYPE 
echo   FROM INFORMATION_SCHEMA.COLUMNS 
echo   WHERE TABLE_NAME='pengajuan_surats' 
echo   AND COLUMN_NAME LIKE '%%signature%%';
echo.
pause

cls
echo.
echo 4. Test PHP Helper Class
echo =========================
echo Running: %ARTISAN% tinker
echo.
echo Copy-paste these commands:
echo.
echo   $token = App\Helpers\QrCodeGenerator::generateSignatureToken(1, 5);
echo   echo $token;
echo.
echo   $url = App\Helpers\QrCodeGenerator::generateQrUrl($token);
echo   echo $url;
echo.
echo   $base64 = App\Helpers\QrCodeGenerator::generateBase64($url);
echo   echo substr($base64, 0, 50);
echo.
echo Then press Ctrl+D to exit
echo.
call %ARTISAN% tinker
pause

cls
echo.
echo 5. Test Database Query
echo ======================
echo Running: %ARTISAN% tinker
echo.
echo Copy-paste these commands:
echo.
echo   $pengajuan = App\Models\PengajuanSurat::first();
echo   if ($pengajuan) {
echo     echo "ID: " . $pengajuan->id;
echo     echo "Token: " . $pengajuan->signature_token;
echo   }
echo.
call %ARTISAN% tinker
pause

cls
echo.
echo 6. Test Routes
echo ===============
echo Running: %ARTISAN% route:list
echo.
call %ARTISAN% route:list | findstr ttd
echo.
pause

cls
echo.
echo 7. Manual Testing Steps
echo =======================
echo.
echo Step 1: Test Generate Signature Token
echo   Open: %APP_URL%/admin/pengajuan
echo   Click any pengajuan
echo   Click "Generate Surat" button
echo.
echo Step 2: Check Generated PDF
echo   Download the PDF
echo   Check if QR code appears in footer
echo.
echo Step 3: Test Verification
echo   Scan QR code with smartphone camera
echo   Should open verification page
echo   Or manually open: %APP_URL%/pengajuan/ttd?p={token}
echo.
echo Step 4: Check Database
echo   Open MySQL client or phpMyAdmin
echo   Query: SELECT * FROM pengajuan_surats WHERE signature_token IS NOT NULL
echo   Check columns: signature_token, signature_generated_at
echo.
pause

cls
echo.
echo 8. Troubleshooting
echo ==================
echo.
echo If QR Code not appearing in PDF:
echo - Run: %ARTISAN% migrate
echo - Check: composer show ^| findstr qr
echo - View logs: storage/logs/laravel.log
echo.
echo If Verification URL not working:
echo - Check: %ARTISAN% route:list ^| findstr ttd
echo - Test: curl "%APP_URL%/pengajuan/ttd?p=test"
echo.
echo If Database column missing:
echo - Run: %ARTISAN% migrate:fresh (WARNING: resets all data)
echo - Or run: %ARTISAN% migrate --step
echo.
pause

cls
echo.
echo 9. Quick Reference
echo ===================
echo.
echo Route untuk Verifikasi:
echo   %APP_URL%/pengajuan/ttd?p={signature_token}
echo.
echo Admin Generate Surat:
echo   %APP_URL%/admin/pengajuan/{id}/generate-surat
echo.
echo Download Surat:
echo   %APP_URL%/admin/pengajuan/{id}/download-pdf
echo.
pause

cls
echo.
echo ╔════════════════════════════════════════════════════════╗
echo ║  Testing Complete!                                    ║
echo ╚════════════════════════════════════════════════════════╝
echo.
echo Dokumentasi:
echo - FITUR_QR_DIGITAL_SIGNATURE.md
echo - QR_DIGITAL_SIGNATURE_QUICK_START.md
echo - CONTOH_IMPLEMENTASI_QR.md
echo.
pause
