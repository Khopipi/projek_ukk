# ANALISIS DAN SOLUSI: LOGO TIDAK MUNCUL DI PDF

## Masalah
Logo tidak muncul di PDF (surat hasil) meskipun muncul di web.

## Root Cause Analysis
DomPDF (library generator PDF) memiliki kendala dengan path file lokal di Windows:
1. **surat-template.blade.php** (web): menggunakan `asset()` → menghasilkan URL relatif ✅ Muncul
2. **pdf.blade.php** (PDF): menggunakan `public_path()` → menghasilkan path string Windows
3. DomPDF tidak dapat membaca file lokal dengan path Windows secara konsisten

## Solusi yang Diterapkan

### 1. Helper Function ImageHelper.php
Membuat helper untuk konversi image ke base64 data URI:
```php
ImageHelper::imageToDataUri('assets/images/my/logo_Sidoarjo.svg.png')
// Output: data:image/png;base64,iVBORw0KGgoAAAANS...
```

### 2. Update Controller VerifikasiPengajuanController.php
Menambahkan konversi logo sebelum render PDF:
```php
$logoBase64 = \App\Helpers\ImageHelper::imageToDataUri('assets/images/my/logo_Sidoarjo.svg.png');
$html = view('pengajuan.pdf', ['pengajuan' => $pengajuanFresh, 'qrSvg' => $qrSvg, 'logoBase64' => $logoBase64])->render();
```

### 3. Update pdf.blade.php
Mengganti 8 referensi logo untuk menggunakan base64:
```blade
<!-- Dari: -->
<img src="{{ public_path('assets/images/my/logo_Sidoarjo.svg.png') }}" alt="Logo Sidoarjo">

<!-- Menjadi: -->
<img src="{{ $logoBase64 ?? public_path('assets/images/my/logo_Sidoarjo.svg.png') }}" alt="Logo Sidoarjo">
```

## Keuntungan Solusi

✅ **Base64 Data URI lebih reliable** untuk DomPDF
✅ **Fallback ke public_path** jika base64 gagal
✅ **Kompatibel** dengan semua OS (Windows, Linux, Mac)
✅ **Tidak perlu eksternal library tambahan**
✅ **Self-contained** dalam HTML/PDF

## Testing
Coba generate PDF baru dari admin panel:
1. Masuk ke Verifikasi Pengajuan
2. Pilih pengajuan
3. Klik "Generate Surat"
4. Logo seharusnya sudah muncul di PDF

## Files yang Diubah
- ✅ `app/Helpers/ImageHelper.php` (NEW)
- ✅ `app/Http/Controllers/VerifikasiPengajuanController.php`
- ✅ `resources/views/pengajuan/pdf.blade.php` (8 instances)
