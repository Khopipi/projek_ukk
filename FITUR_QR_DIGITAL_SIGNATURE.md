# Implementasi QR Code Digital Signature untuk Tanda Tangan Kepala Desa

## Ringkasan
Fitur ini menambahkan **QR Code Digital Signature** pada setiap surat yang di-generate. QR code ini berisi token unik yang dapat di-scan oleh warga untuk memverifikasi keaslian surat dan tanda tangan digital kepala desa.

## Fitur Utama

### 1. **QR Code Dinamis**
- Setiap surat memiliki QR code unik yang berbeda-beda
- QR code di-generate secara otomatis saat admin menjalankan "Generate Surat"
- Format QR code: `{pengajuan_id}|{timestamp}|{user_id}|{random_hash}`

### 2. **Verifikasi Digital**
- Warga dapat scan QR code menggunakan smartphone untuk memverifikasi keaslian surat
- Halaman verifikasi menampilkan informasi lengkap surat dan status tanda tangan digital
- Endpoint publik yang dapat diakses tanpa login

### 3. **Tracking dan Audit**
- Setiap pengajuan surat menyimpan:
  - `signature_token`: Token unik untuk QR code
  - `signature_generated_at`: Waktu tanda tangan digital dibuat

## Komponen Teknis

### Library
```bash
composer require endroid/qr-code
```

### Database Migration
File: `database/migrations/2026_01_13_000000_add_signature_token_to_pengajuan_surats_table.php`

Kolom baru di tabel `pengajuan_surats`:
- `signature_token` (string, unique, nullable)
- `signature_generated_at` (timestamp, nullable)

### Helper Class
File: `app/Helpers/QrCodeGenerator.php`

Fungsi utama:
```php
// Generate QR code sebagai base64 data URI
QrCodeGenerator::generateBase64(string $data, int $size = 150): string

// Generate token signature
QrCodeGenerator::generateSignatureToken(int $pengajuan_id, int $user_id): string

// Generate URL untuk QR code
QrCodeGenerator::generateQrUrl(string $signatureToken, string $baseUrl = null): string
```

### Controller Updates

#### VerifikasiPengajuanController.php
- Method `generateSurat()`: Secara otomatis generate signature token saat PDF dibuat
- Method `sendPdf()`: Generate signature token jika belum ada sebelum kirim email

#### PengajuanSuratController.php
- Method `verifySignature()`: Public endpoint untuk verifikasi QR code scan
  - Route: `GET /pengajuan/ttd?p={signature_token}`
  - Return: View dengan informasi surat lengkap

### Template Updates

File: `resources/views/pengajuan/surat-template.blade.php`

Setiap template surat (Warisan, Nikah, Tanah, Domisili, Kelahiran, Kematian, Tidak Mampu, Default) telah diupdate dengan:

```blade
@if($pengajuan->signature_token && $pengajuan->signature_generated_at)
    <!-- QR Code Digital Signature -->
    <div style="margin: 15px 0; text-align: center;">
        <img src="{{ App\Helpers\QrCodeGenerator::generateBase64(App\Helpers\QrCodeGenerator::generateQrUrl($pengajuan->signature_token)) }}" 
             alt="QR Code Tanda Tangan Digital" 
             style="width: 80px; height: 80px; display: inline-block;">
    </div>
    <div style="font-size: 9px; color: #666; margin-bottom: 10px;">
        Scan untuk verifikasi tanda tangan digital
    </div>
@endif
```

### Route
File: `routes/web.php`

```php
// Public route untuk verifikasi QR code
Route::get('/pengajuan/ttd', [PengajuanSuratController::class, 'verifySignature'])
    ->name('pengajuan.verify-signature');
```

### View Verifikasi
File: `resources/views/pengajuan/verify-signature.blade.php`

Menampilkan:
- Status verifikasi (valid/invalid)
- Data surat (nomor, jenis, pemohon, keperluan, dll)
- Informasi keamanan
- Waktu tanda tangan digital dibuat

## Alur Penggunaan

### Untuk Admin (Generate Surat)
1. Admin masuk ke halaman verifikasi pengajuan
2. Klik tombol "Generate Surat"
3. Sistem akan:
   - Membaca data pengajuan
   - Generate signature token unik
   - Simpan token ke database
   - Generate PDF dengan QR code embedded
   - Simpan file PDF

### Untuk Warga (Verifikasi Surat)
1. Warga menerima surat (fisik/digital) dengan QR code
2. Scan QR code menggunakan aplikasi scanner atau WhatsApp
3. Aplikasi akan membuka link: `https://domain.com/pengajuan/ttd?p={signature_token}`
4. Halaman verifikasi menampilkan:
   - Status validitas surat ✓
   - Informasi surat lengkap
   - Waktu tanda tangan digital
   - Pesan verifikasi

## Format QR Code URL

Berdasarkan referensi yang diberikan:
```
https://domain.com/pengajuan/ttd?p={signature_token}
```

Contoh:
```
https://localhost:8000/pengajuan/ttd?p=42|1705126800|5|a8f3b2c1
```

Dimana:
- `42` = ID pengajuan surat
- `1705126800` = Timestamp saat tanda tangan
- `5` = ID admin yang menandatangani
- `a8f3b2c1` = Hash random untuk keamanan

## Keamanan

1. **Token Unik**: Setiap surat memiliki token yang berbeda dan sulit diprediksi
2. **Timestamp**: Mencatat kapan surat ditandatangani
3. **User Tracking**: Mencatat siapa (admin) yang menandatangani
4. **Random Hash**: Tambahan layer keamanan
5. **Database Storage**: Token disimpan di database untuk validasi

## Pengembangan Lanjutan

Untuk masa depan, dapat ditambahkan:
1. **Digital Certificate**: Integrasi dengan sertifikat digital
2. **Blockchain Verification**: Verifikasi immutable di blockchain
3. **Timestamp Authority**: Integrasi dengan server waktu tersertifikasi
4. **Email Notification**: Notifikasi saat surat ditandatangani
5. **Audit Log**: Pencatatan lengkap setiap verifikasi
6. **Expiry Date**: QR code bisa set untuk expired pada tanggal tertentu

## Testing

### Manual Testing
1. Login sebagai admin
2. Buat pengajuan surat (user test)
3. Approve dan proses pengajuan (admin)
4. Generate surat
5. Download PDF dan lihat QR code
6. Scan QR code dengan smartphone
7. Verifikasi informasi yang ditampilkan

### Curl Testing (Verifikasi)
```bash
curl "http://localhost:8000/pengajuan/ttd?p=42|1705126800|5|a8f3b2c1"
```

## Troubleshooting

### QR Code tidak muncul di PDF
- Pastikan library `endroid/qr-code` sudah terinstall
- Cek apakah kolom `signature_token` sudah ada di database
- Jalankan `php artisan migrate`

### Link QR tidak valid
- Pastikan route `/pengajuan/ttd` sudah terdaftar
- Cek parameter `p` dikirim dengan benar
- Pastikan `signature_token` tersimpan di database

### Halaman verifikasi error
- Pastikan view `resources/views/pengajuan/verify-signature.blade.php` ada
- Cek koneksi database
- Lihat log di `storage/logs/laravel.log`

## File yang Dimodifikasi

1. `app/Helpers/QrCodeGenerator.php` - NEW
2. `app/Http/Controllers/VerifikasiPengajuanController.php` - Modified
3. `app/Http/Controllers/PengajuanSuratController.php` - Modified
4. `app/Models/PengajuanSurat.php` - Modified
5. `resources/views/pengajuan/surat-template.blade.php` - Modified
6. `resources/views/pengajuan/verify-signature.blade.php` - NEW
7. `routes/web.php` - Modified
8. `database/migrations/2026_01_13_000000_add_signature_token_to_pengajuan_surats_table.php` - NEW
9. `composer.json` - Updated (endroid/qr-code)

## Catatan Penting

- QR code di-generate **saat Generate Surat**, bukan saat create
- Signature token unik per pengajuan
- Halaman verifikasi **publik** (tidak perlu login)
- QR code embedded langsung dalam PDF sebagai base64 image
- Kompatibel dengan semua jenis surat di sistem
