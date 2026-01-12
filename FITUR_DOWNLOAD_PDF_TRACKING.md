# Fitur Download PDF dengan Tracking Riwayat

## Ringkasan Fitur
Fitur ini memungkinkan admin untuk:
1. **Generate PDF** dari preview surat
2. **Download PDF** langsung dengan tracking otomatis
3. **Melihat riwayat download** semua surat

## Komponen yang Ditambahkan

### 1. Database & Model
- **Migration**: `database/migrations/2025_12_01_104810_create_download_histories_table.php`
  - Membuat tabel `download_histories` untuk tracking download
  - Columns: id, pengajuan_surat_id, user_id, filename, ip_address, user_agent, timestamps

- **Model**: `app/Models/DownloadHistory.php`
  - Relasi ke PengajuanSurat dan User
  - Fillable: pengajuan_surat_id, user_id, filename, ip_address, user_agent

### 2. Controller Methods
- **`downloadPdf(PengajuanSurat $pengajuan)`**
  - Memverifikasi PDF ada sebelum download
  - Mencatat download history (user, IP, user agent)
  - Return file download dengan nama: `{nomor_pengajuan}.pdf`

- **`showDownloadHistory()`**
  - Menampilkan daftar semua download history
  - Pagination: 20 items per halaman
  - Informasi: siapa download, kapan, dari IP berapa, surat apa

### 3. Routes
```php
Route::get('/{pengajuan}/download-pdf', 'downloadPdf')->name('download-pdf');
Route::get('/download-history', 'showDownloadHistory')->name('download-history');
```

### 4. Views
- **`resources/views/admin/pengajuan/preview-surat.blade.php`** (Updated)
  - Tombol "Generate PDF" (Generate + simpan ke storage)
  - Tombol "Download PDF" (Download + track history) - disabled jika belum ada file
  - Tombol "Kirim Email" (Kirim ke user)
  - Tombol "Kembali" (Kembali ke detail)

- **`resources/views/admin/pengajuan/download-history.blade.php`** (New)
  - Tabel riwayat download dengan info lengkap
  - Columns: Nomor Pengajuan, Jenis Surat, Didownload Oleh, File, IP Address, Waktu Download
  - Link ke detail pengajuan
  - Pagination

## Workflow

### Dari Preview Page (http://127.0.0.1:8000/admin/pengajuan/5/preview-surat)

1. **Generate PDF**
   - Klik "Generate PDF"
   - System membuat PDF dari template surat
   - Simpan ke: `storage/app/public/surat_hasil/{timestamp}_{nomor_pengajuan}.pdf`
   - Update pengajuan: file_surat_hasil, status=Selesai, tanggal_selesai=now()

2. **Download PDF**
   - Tombol "Download PDF" menjadi aktif (setelah generate)
   - Klik untuk download
   - System membuat record di tabel download_histories dengan:
     - pengajuan_surat_id (ID pengajuan)
     - user_id (ID admin yang download)
     - filename (nama file yang didownload)
     - ip_address (IP admin)
     - user_agent (browser/device info)
   - File di-download dengan nama: `{nomor_pengajuan}.pdf`

3. **Kirim Email**
   - Klik "Kirim Email"
   - Jika PDF belum ada, auto-generate terlebih dahulu
   - Attach PDF ke email
   - Kirim ke email user pemohon

### Lihat Riwayat Download
- **Route**: `admin/pengajuan/download-history`
- **Link**: Button "Riwayat Download" di halaman Verifikasi Pengajuan index
- **Info yang ditampilkan**:
  - Nomor pengajuan (link ke detail)
  - Jenis surat
  - Nama & email admin yang download
  - Nama file
  - IP address
  - Waktu download (format: "d M Y H:i:s" + "X minutes ago")

## Penggunaan

### Step 1: Generate PDF (dari preview)
```
Admin masuk preview page → Klik "Generate PDF" → Tunggu proses → File tersimpan
```

### Step 2: Download PDF (tracked)
```
Admin klik "Download PDF" → Download otomatis → History tercatat di DB
```

### Step 3: Lihat Riwayat
```
Admin klik "Riwayat Download" di halaman Verifikasi Pengajuan → Lihat semua download history
```

## Database Schema

```sql
CREATE TABLE download_histories (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    pengajuan_surat_id BIGINT UNSIGNED NOT NULL,
    user_id BIGINT UNSIGNED NULLABLE,
    filename VARCHAR(255) NOT NULL,
    ip_address VARCHAR(45) NULLABLE,
    user_agent TEXT NULLABLE,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (pengajuan_surat_id) REFERENCES pengajuan_surats(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);
```

## Security Notes
- Download hanya bisa dilakukan oleh admin (middleware: cekRole:admin)
- IP address & user agent dicatat untuk audit trail
- File path validasi: pastikan file ada sebelum download
- Filename sanitasi: nomor_pengajuan.pdf (aman dari path traversal)

## Testing Checklist
- [ ] Generate PDF dari preview page
- [ ] Download PDF dengan tracking
- [ ] Lihat history download mencatat admin yang tepat
- [ ] Lihat IP address tercatat
- [ ] Lihat waktu download tercatat
- [ ] File PDF exist di storage/app/public/surat_hasil/
- [ ] Download history paginasi berfungsi
- [ ] Link ke detail pengajuan dari history bekerja
