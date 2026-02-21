# Perbaikan Flow Status Pengajuan Surat

## Ringkasan Masalah

Saat admin menekan tombol **"Proses"** di halaman index, status pengajuan berubah langsung menjadi **"Selesai"** padahal seharusnya hanya berubah ke **"Diproses"**. Indikator timeline juga langsung menunjukkan selesai bukan proses.

**Permintaan User**: 
- Saat tombol Proses diklik → status berubah ke "Diproses" (step 2)
- Setelah surat diupload dan email dikirim → baru status berubah ke "Selesai" (step 3)

## Penyebab Masalah

Method `sendPdf()` di controller melakukan 2 hal:
1. Otomatis generate PDF jika belum ada
2. Otomatis set status menjadi "Selesai" saat PDF dibuat

Ini menyebabkan jika ada trigger otomatis pengiriman email, status langsung menjadi Selesai tanpa melalui tahap Diproses dengan baik.

## Solusi yang Diimplementasikan

### 1. Perbaikan Controller: `app/Http/Controllers/VerifikasiPengajuanController.php`

**Method: `uploadSurat()` - Hanya upload file, TIDAK ubah status**

**Sebelumnya:**
```php
$pengajuan->update([
    'file_surat_hasil' => $filename,
    'status' => 'Selesai',           // ❌ LANGSUNG SELESAI
    'tanggal_selesai' => now()
]);
```

**Sesudahnya:**
```php
$pengajuan->update([
    'file_surat_hasil' => $filename  // ✅ HANYA SIMPAN FILE
    // Status tetap 'Disetujui' sampai email dikirim
]);
```

**Method: `sendPdf()` - Kirim email dan ubah status**

**Sebelumnya:**
```php
// Auto-generate PDF jika belum ada
// Auto set status to Selesai tanpa control yang ketat
```

**Sesudahnya:**
```php
// Check: status HARUS Disetujui (PDF harus sudah diupload)
if ($pengajuan->status !== 'Disetujui') {
    return error: "Pengajuan harus berstatus Disetujui terlebih dahulu"
}

// Check: PDF HARUS sudah ada (TIDAK auto-generate)
if (!$filename || !file_exists($path)) {
    return error: "File surat hasil belum diupload"
}

// Send email
Mail::to($userEmail)->send(new PengajuanHasilMail($pengajuan->fresh()));

// Update status to Selesai HANYA setelah email berhasil terkirim
$pengajuan->update([
    'status' => 'Selesai',
    'tanggal_selesai' => now()
]);
```

### 2. Update View: `resources/views/admin/pengajuan/show.blade.php`

**Ditambahkan: Tombol "Kirim Email ke User"**

```blade
@if($pengajuan->file_surat_hasil && $pengajuan->status == 'Disetujui')
<form action="{{ route('admin.pengajuan.send-pdf', $pengajuan->id) }}" method="POST">
    @csrf
    <button type="submit" class="btn btn-success w-100 mb-2">
        <i class="ti ti-mail me-1"></i> Kirim Email ke User
    </button>
</form>
@endif
```

Tombol ini hanya tampil jika:
- File surat sudah diupload
- Status masih "Disetujui" (belum selesai)

## Flow Baru yang Benar

```
Status: Menunggu (Step 1)
    ↓
Tombol "Proses" → Status: Diproses (Step 2) ✓
    ↓
Tombol "Setujui" → Status: Disetujui (Upload Modal)
    ↓
Upload File PDF → Status: Tetap Disetujui (File tersimpan)
    ↓
Tombol "Kirim Email ke User" → Email dikirim → Status: Selesai (Step 3) ✓
```

## Detail Alur Admin

### 1️⃣ **Tahap: Menunggu**
- Admin melihat pengajuan berstatus "Menunggu"
- Tombol tersedia: "Tandai Diproses"

### 2️⃣ **Tahap: Diproses** (setelah klik "Proses")
- Status berubah ke "Diproses"
- Indikator timeline menunjukkan step 2 (Diproses)
- Tombol tersedia: "Setujui Pengajuan" / "Tolak Pengajuan"

### 3️⃣ **Tahap: Disetujui** (setelah klik "Setujui")
- Status berubah ke "Disetujui"
- Modal upload file muncul
- Admin upload file PDF surat
- **Status TETAP "Disetujui"** (tidak berubah)
- Tombol tersedia: "Upload Surat Hasil", "Kirim Email ke User" (setelah upload)

### 4️⃣ **Tahap: Selesai** (setelah klik "Kirim Email")
- Email dikirim ke user dengan notifikasi & PDF attachment
- Status berubah ke "Selesai"
- Indikator timeline menunjukkan step 3 (Selesai)

## Keuntungan Perbaikan

✅ **Jelas & Terstruktur**
- Flow status yang jelas: Menunggu → Diproses → Disetujui → Selesai

✅ **Aman dari Error**
- Tidak akan otomatis generate PDF dan ubah status tanpa sengaja
- Admin harus eksplisit upload file dan kirim email

✅ **User Experience Lebih Baik**
- User tahu kapan surat mereka diproses
- User tahu kapan surat mereka selesai dan dikirim

✅ **Tracking Lebih Akurat**
- Timestamp untuk setiap tahap tercatat dengan jelas
- Email hanya dikirim setelah semua proses selesai

## File yang Diubah

| File | Perubahan |
|------|-----------|
| `app/Http/Controllers/VerifikasiPengajuanController.php` | ✅ Refactor method `sendPdf()` - hanya kirim email, tidak auto generate PDF atau ubah status |
| `resources/views/admin/pengajuan/show.blade.php` | ✅ Tambah tombol "Kirim Email ke User" - muncul hanya saat status Disetujui dengan file sudah upload |

## Testing Checklist

- [ ] Klik tombol "Proses" → Status berubah ke "Diproses" ✓
- [ ] Indikator timeline menunjukkan step 2 saat status "Diproses" ✓
- [ ] Klik tombol "Setujui" → Status berubah ke "Disetujui" ✓
- [ ] Tombol "Upload Surat Hasil" muncul saat status "Disetujui" ✓
- [ ] Tombol "Kirim Email ke User" muncul setelah file diupload ✓
- [ ] Klik "Kirim Email" → Email dikirim dan status menjadi "Selesai" ✓
- [ ] Indikator timeline menunjukkan step 3 saat status "Selesai" ✓
- [ ] Email yang diterima user adalah notifikasi (bukan isi template surat) ✓

## Catatan Penting

1. **Status Disetujui tidak akan berubah otomatis** - Admin harus eksplisit klik tombol "Kirim Email"
2. **Email hanya dikirim jika file sudah diupload** - Tidak bisa mengirim email tanpa file surat
3. **Setelah email terkirim**, status akan berubah menjadi "Selesai"
4. **Email template** sudah menggunakan notifikasi profesional (bukan isi surat)
