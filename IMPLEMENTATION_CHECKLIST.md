## ✅ CHECKLIST IMPLEMENTASI QR CODE - FINAL

### 🔧 SETUP & VERIFICATION

- [ ] Run `php artisan storage:link` di terminal untuk membuat symlink
  ```bash
  php artisan storage:link
  ```

- [ ] Verify symlink created:
  ```bash
  # Check if public/storage folder exists
  ls -la public/storage
  # Or on Windows:
  dir public\storage
  ```

- [ ] Check folder permissions:
  ```bash
  chmod -R 755 storage/app/public/qr_codes
  ```

### 🧪 TEST CASES

#### Test 1: Preview HTML
- [ ] Buka browser
- [ ] Login ke admin panel
- [ ] Buka pengajuan surat
- [ ] Klik "Preview Surat"
- [ ] Pastikan QR code muncul sebagai image (bukan placeholder text)
- [ ] QR ada di footer di bawah "LURAH DESA SRUNI"
- [ ] Text "Scan untuk verifikasi" muncul di bawah QR

#### Test 2: Generate PDF
- [ ] Di preview page, klik "Generate Surat"
- [ ] Wait untuk PDF di-generate
- [ ] Download PDF yang dihasilkan
- [ ] Buka PDF (gunakan PDF reader)
- [ ] Pastikan QR code muncul di PDF (bukan placeholder)
- [ ] Check PDF quality dan QR code readability

#### Test 3: Mobile Scanning
- [ ] Dari PDF yang sudah di-download, buka di mobile/tablet
- [ ] Gunakan camera app atau QR scanner
- [ ] Scan QR code
- [ ] Seharusnya membuka verification page: `/pengajuan/ttd?p=...`
- [ ] Verifikasi berhasil tampil dengan data surat

#### Test 4: Email
- [ ] Di pengajuan, klik "Kirim via Email"
- [ ] Email diterima
- [ ] Download PDF dari email
- [ ] Buka PDF
- [ ] QR code muncul
- [ ] Bisa di-scan dari email PDF

#### Test 5: All 8 Letter Types
- [ ] Test dengan Surat Warisan
- [ ] Test dengan Surat Nikah
- [ ] Test dengan Surat Tanah
- [ ] Test dengan Surat Domisili
- [ ] Test dengan Surat Akta Kelahiran
- [ ] Test dengan Surat Akta Kematian
- [ ] Test dengan Surat Keterangan Tidak Mampu
- [ ] Test dengan Default surat

### 🐛 TROUBLESHOOTING

Jika QR code **masih tidak muncul di PDF**:

- [ ] **Check symlink**:
  ```bash
  # Windows
  mklink /D public\storage storage\app\public
  
  # Linux/Mac
  php artisan storage:link
  ```

- [ ] **Check file permissions**:
  ```bash
  ls -la storage/app/public/qr_codes/
  chmod -R 755 storage/app/public
  ```

- [ ] **Check DomPDF logs**:
  - Lihat `storage/logs/laravel.log`
  - Cari error tentang image file

- [ ] **Check browser console** (untuk preview):
  - Buka browser F12 → Console tab
  - Lihat apakah ada error loading image
  - Check Network tab → apakah img src loading correctly

- [ ] **Test langsung dengan PHP**:
  ```bash
  php debug_qr_analysis.php
  php test_qr_final_verification.php
  ```

- [ ] **Check DomPDF configuration**:
  - Edit `config/dompdf.php`
  - Pastikan `'isHtml5ParserEnabled' => true`
  - Pastikan `'isRemoteEnabled' => true`

### 📁 FILES YANG DIMODIFIKASI

- [x] `app/Helpers/QrCodeGenerator.php` - Added 2 new methods
- [x] `resources/views/pengajuan/surat-template.blade.php` - All 8 templates updated
- [ ] `php artisan storage:link` - Need to run this command

### 📊 VALIDATION CHECKLIST

- [ ] QR code file exists: `/storage/app/public/qr_codes/[hash].png`
- [ ] QR code path: `/storage/qr_codes/[hash].png`
- [ ] Helper method works: `QrCodeGenerator::generateImgTag($qrPath)`
- [ ] Template renders img tag with file path
- [ ] PDF contains img tag with file path
- [ ] Browser can load image from path
- [ ] DomPDF can render image from path

### 🎯 EXPECTED RESULTS

✅ **Preview HTML**
- QR code appears as 75x75px image with border
- Text "Scan untuk verifikasi" below QR
- No placeholder "QR Code (belum di-generate)" text

✅ **Generated PDF**
- PDF file created successfully (size > 4000 bytes)
- PDF opens without error
- QR code visible in footer section
- QR code scannable with mobile camera
- Text "Scan untuk verifikasi" below QR in PDF

✅ **Scanning**
- QR scans to URL: `http://domain/pengajuan/ttd?p=...`
- Verification page loads
- Shows surat data with success message
- "Tanda Tangan Digital Terverifikasi" appears

### 💾 BACKUP (Just in case)

Jika ada issue, files yang penting:
- [ ] Backup `app/Helpers/QrCodeGenerator.php`
- [ ] Backup `resources/views/pengajuan/surat-template.blade.php`

### 🔒 SECURITY NOTES

- QR code token format: `{id}|{timestamp}|{user_id}|{hash}`
- Unique per pengajuan dan user
- Can be verified at: `/pengajuan/ttd?p={token}`
- Token stored in database table `pengajuan_surats`

---

## QUICK START COMMAND

```bash
# 1. Create storage link
php artisan storage:link

# 2. Test QR generation
php debug_qr_analysis.php

# 3. Test PDF with QR
php test_qr_final_verification.php

# 4. Clear browser cache
# (Ctrl+Shift+Delete in Chrome/Firefox)

# 5. Open preview page and check
# http://localhost:8000/admin/pengajuan/[id]/preview
```

---

## NOTES

- QR code di-generate sekali per pengajuan (disimpan di database)
- File PNG di-cache di `storage/app/public/qr_codes/`
- Metadata stored: `signature_token`, `signature_generated_at`
- Verifikasi scan: `/pengajuan/ttd?p={token}`

---

✅ **Setelah semua test passed, QR barcode ttd kepala desa siap untuk production!**
