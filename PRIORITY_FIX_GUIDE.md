# PANDUAN PERBAIKAN PRIORITAS PENGADUAN

## Masalah yang Ditemukan
User melaporkan bahwa saat mengirimkan pengaduan dengan prioritas berbeda (Biasa, Mendesak, Sangat Mendesak) dari role user, di admin hanya muncul "Mendesak" saja.

## Root Cause Analysis
Masalah terjadi karena:
1. ❌ Controller `PengaduanController` tidak menerima field `prioritas` dalam validation
2. ✅ Form sudah benar mengirim `prioritas`
3. ✅ Model sudah punya display logic

## Solusi yang Telah Diimplementasikan

### 1. Update Controller Validation ✅
**File:** `app/Http/Controllers/PengaduanController.php`

Menambahkan prioritas ke validation rules:
```php
'prioritas' => 'required|in:Rendah,Sedang,Tinggi',
```

### 2. Add Model Accessor ✅
**File:** `app/Models/Pengaduan.php`

Menambahkan accessor `getPrioritasLabelAttribute()` untuk display user-friendly:
- `Rendah` → "Biasa" (Green)
- `Sedang` → "Mendesak" (Yellow)  
- `Tinggi` → "Sangat Mendesak" (Red)

### 3. Update View Display ✅
**Files:**
- `resources/views/admin/pengaduan/index.blade.php`
- `resources/views/admin/pengaduan/show.blade.php`

Menggunakan accessor `prioritas_label` untuk display yang konsisten.

## Mapping Nilai Prioritas

| User-Friendly | Database Value | Display Color |
|---|---|---|
| Biasa | Rendah | Green (#28a745) |
| Mendesak | Sedang | Yellow (#ffc107) |
| Sangat Mendesak | Tinggi | Red (#dc3545) |

## Steps untuk Deployment

### Step 1: Update Database
Jalankan migration untuk fix existing data:
```bash
php artisan migrate
```

### Step 2: Clear Cache
```bash
php artisan cache:clear
php artisan config:clear
```

### Step 3: Test dengan Pengaduan Baru
1. Login sebagai user
2. Buat pengaduan baru dengan prioritas "Biasa"
3. Login sebagai admin dan verifikasi tampilan prioritas
4. Ulangi dengan prioritas "Mendesak" dan "Sangat Mendesak"

## Troubleshooting

### Jika masih hanya muncul "Mendesak":
1. Check database apakah prioritas field ada dan berisi nilai yang benar
2. Run: `php artisan tinker`
3. Query: `App\Models\Pengaduan::latest()->first();`
4. Lihat nilai field `prioritas`

### Jika migration error:
Pastikan table `pengaduans` sudah ada dan migration sebelumnya sudah jalan:
```bash
php artisan migrate:status
```

## File yang Dimodifikasi
1. ✅ `app/Http/Controllers/PengaduanController.php` - Validation
2. ✅ `app/Models/Pengaduan.php` - Accessor
3. ✅ `resources/views/admin/pengaduan/index.blade.php` - Display
4. ✅ `resources/views/admin/pengaduan/show.blade.php` - Display
5. ✅ `database/migrations/2025_01_20_120000_fix_pengaduan_prioritas.php` - Migration

## CSS Classes untuk Styling
```css
.badge-rendah-custom {
    background-color: #28a745 !important;  /* Green */
    color: white !important;
}

.badge-sedang-custom {
    background-color: #ffc107 !important;  /* Yellow */
    color: #333 !important;
}

.badge-tinggi-custom {
    background-color: #dc3545 !important;  /* Red */
    color: white !important;
}
```

## Selesai! ✅
Setelah mengikuti langkah-langkah di atas, sistem prioritas pengaduan seharusnya berfungsi dengan benar.
