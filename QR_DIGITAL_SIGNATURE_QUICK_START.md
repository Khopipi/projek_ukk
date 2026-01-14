# Quick Start - QR Digital Signature

## Instalasi Cepat

Sudah selesai! Berikut yang sudah dilakukan:

### ✅ Library
```bash
composer require endroid/qr-code
```

### ✅ Database Migration
```bash
php artisan migrate
```

Menambahkan kolom:
- `signature_token`
- `signature_generated_at`

### ✅ Helper Class
`app/Helpers/QrCodeGenerator.php` - Class untuk generate QR code

### ✅ Routes
- `GET /pengajuan/ttd?p={token}` - Verifikasi QR code (public)

### ✅ Views
- `resources/views/pengajuan/verify-signature.blade.php` - Halaman verifikasi

### ✅ Controllers
- `app/Http/Controllers/PengajuanSuratController.php`
- `app/Http/Controllers/VerifikasiPengajuanController.php`

## Cara Kerja

1. **Admin Generate Surat**
   - Admin klik "Generate Surat" di halaman verifikasi pengajuan
   - Sistem otomatis membuat signature token
   - PDF di-generate dengan QR code embedded

2. **Warga Verifikasi Surat**
   - Warga scan QR code dengan smartphone
   - Terbuka halaman verifikasi yang menampilkan info surat
   - Dapat membuktikan keaslian surat

## Testing

### 1. Buat Test Data
```bash
php artisan tinker
```

```php
// Buat user test
$user = App\Models\User::factory()->create(['role' => 'user']);

// Buat pengajuan surat
$pengajuan = App\Models\PengajuanSurat::create([
    'user_id' => $user->id,
    'nomor_pengajuan' => 'SRT/20250113/0001',
    'jenis_surat' => 'Surat Domisili',
    'keperluan' => 'Membuat paspor',
    'nama_pemohon' => 'Budi Santoso',
    'nik_pemohon' => '1234567890123456',
    'tempat_lahir_pemohon' => 'Surabaya',
    'tanggal_lahir_pemohon' => '1990-01-01',
    'jenis_kelamin_pemohon' => 'Laki-laki',
    'pekerjaan_pemohon' => 'Karyawan',
    'alamat_pemohon' => 'Jl. Merpati No. 5',
    'no_telepon_pemohon' => '08123456789',
    'status' => 'Menunggu'
]);
```

### 2. Generate Signature (dari Controller)
Signature token akan otomatis di-generate saat admin klik "Generate Surat"

Atau test manual:
```php
$token = App\Helpers\QrCodeGenerator::generateSignatureToken(1, 5);
// Output: "1|1705126800|5|a8f3b2c1"

$url = App\Helpers\QrCodeGenerator::generateQrUrl($token);
// Output: "http://localhost:8000/pengajuan/ttd?p=1|1705126800|5|a8f3b2c1"
```

### 3. Test Verifikasi
Buka URL di browser:
```
http://localhost:8000/pengajuan/ttd?p={signature_token}
```

Contoh:
```
http://localhost:8000/pengajuan/ttd?p=1|1705126800|5|a8f3b2c1
```

## Struktur QR Code Token

Format: `{pengajuan_id}|{timestamp}|{admin_id}|{random_hash}`

```
Contoh: 42|1705126800|5|a8f3b2c1

42         = ID pengajuan surat
1705126800 = Unix timestamp (January 13, 2025)
5          = ID admin yang menandatangani
a8f3b2c1   = Random hash 8 karakter
```

## URLs

### Generate PDF (Admin)
```
POST /admin/pengajuan/{id}/generate-surat
```

### Verifikasi QR Code (Public)
```
GET /pengajuan/ttd?p={signature_token}
```

## File-file Baru

| File | Deskripsi |
|------|-----------|
| `app/Helpers/QrCodeGenerator.php` | Helper untuk generate QR code |
| `resources/views/pengajuan/verify-signature.blade.php` | Halaman verifikasi |
| `FITUR_QR_DIGITAL_SIGNATURE.md` | Dokumentasi lengkap |
| `database/migrations/2026_01_13_000000_...` | Migration untuk kolom baru |

## File yang Dimodifikasi

| File | Perubahan |
|------|-----------|
| `app/Models/PengajuanSurat.php` | Tambah fillable & cast |
| `app/Http/Controllers/PengajuanSuratController.php` | Tambah method verifySignature |
| `app/Http/Controllers/VerifikasiPengajuanController.php` | Modifikasi generateSurat & sendPdf |
| `resources/views/pengajuan/surat-template.blade.php` | Tambah QR code di footer |
| `routes/web.php` | Tambah route verifikasi |
| `composer.json` | Tambah endroid/qr-code |

## Informasi Lebih Lanjut

Lihat dokumentasi lengkap di: `FITUR_QR_DIGITAL_SIGNATURE.md`

## Troubleshooting

### QR Code tidak muncul
1. Jalankan migration: `php artisan migrate`
2. Cek log: `storage/logs/laravel.log`
3. Cek apakah `endroid/qr-code` terinstall: `composer show | grep qr`

### Verifikasi gagal
1. Pastikan signature token tersimpan: 
   ```php
   App\Models\PengajuanSurat::find(1)->signature_token
   ```
2. Cek URL parameter: `?p=` harus dengan token yang benar
3. Lihat error di log file

## Dukungan

Untuk bantuan lebih lanjut, lihat dokumentasi di `FITUR_QR_DIGITAL_SIGNATURE.md`
