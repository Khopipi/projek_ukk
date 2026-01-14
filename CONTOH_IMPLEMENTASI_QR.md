# Contoh Implementasi QR Digital Signature

## Alur Sistem

```
┌─────────────────────────────────────────────────────────────────┐
│                    ADMIN PANEL (Generate Surat)                 │
└──────────────────────────┬──────────────────────────────────────┘
                           │
                           ▼
         ┌─────────────────────────────────┐
         │  Click "Generate Surat" Button  │
         └──────────────┬──────────────────┘
                        │
                        ▼
         ┌──────────────────────────────────────────┐
         │  generateSurat() in Controller            │
         │  - Check PDF library                      │
         │  - Generate signature token               │
         │  - Save to database                       │
         └──────────────┬───────────────────────────┘
                        │
                        ▼
         ┌──────────────────────────────────────────┐
         │  Generate QR Code (Base64)               │
         │  - Encode signature token to QR          │
         │  - Create URL with token parameter       │
         └──────────────┬───────────────────────────┘
                        │
                        ▼
         ┌──────────────────────────────────────────┐
         │  Generate PDF (DomPDF)                   │
         │  - Load surat-template.blade.php         │
         │  - Embed QR code image in footer         │
         │  - Save PDF to storage                   │
         └──────────────┬───────────────────────────┘
                        │
                        ▼
         ┌──────────────────────────────────────────┐
         │  Update Database                         │
         │  - file_surat_hasil (PDF filename)       │
         │  - status = 'Selesai'                    │
         │  - tanggal_selesai (timestamp)           │
         │  - signature_token (stored)              │
         │  - signature_generated_at (timestamp)    │
         └──────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────────────┐
│                  USER/WARGA (Verifikasi Surat)                  │
└──────────────────────────┬──────────────────────────────────────┘
                           │
                           ▼
         ┌──────────────────────────────────────────┐
         │  Terima Surat Fisik/Digital              │
         │  (Surat memiliki QR Code di footer)      │
         └──────────────┬───────────────────────────┘
                        │
                        ▼
         ┌──────────────────────────────────────────┐
         │  Scan QR Code dengan Smartphone          │
         │  - WhatsApp Camera                       │
         │  - QR Code Scanner App                   │
         │  - Google Lens                           │
         └──────────────┬───────────────────────────┘
                        │
                        ▼
         ┌──────────────────────────────────────────┐
         │  Buka URL:                               │
         │  https://domain.com/pengajuan/ttd?p=... │
         └──────────────┬───────────────────────────┘
                        │
                        ▼
         ┌──────────────────────────────────────────┐
         │  verifySignature() Method                │
         │  - Ambil parameter 'p' dari URL          │
         │  - Query database dengan signature_token │
         │  - Tampilkan hasil verifikasi            │
         └──────────────┬───────────────────────────┘
                        │
                        ▼
         ┌──────────────────────────────────────────┐
         │  Verifikasi VALID ✓                      │
         │  - Tampilkan info surat lengkap          │
         │  - Tampilkan waktu tanda tangan          │
         │  - Tampilkan status                      │
         │  - Tampilkan pesan keamanan              │
         └──────────────────────────────────────────┘
```

## Contoh Data Signature Token

```
Format: {pengajuan_id}|{timestamp}|{user_id}|{random_hash}

Contoh 1:
42|1705126800|5|a8f3b2c1

Breakdown:
- pengajuan_id = 42
- timestamp = 1705126800 (January 13, 2025, 10:00:00)
- user_id = 5 (Admin yang menandatangani)
- random_hash = a8f3b2c1 (8 karakter hex random)

Contoh 2:
103|1705200600|7|f2c9e1b4

Breakdown:
- pengajuan_id = 103
- timestamp = 1705200600 (January 14, 2025, 10:10:00)
- user_id = 7 (Admin Gani)
- random_hash = f2c9e1b4
```

## URL QR Code

```
Standar URL:
https://domain.com/pengajuan/ttd?p={signature_token}

Contoh Nyata:
https://localhost:8000/pengajuan/ttd?p=42|1705126800|5|a8f3b2c1

Penguraian:
https://localhost:8000    = Domain/Host
/pengajuan/ttd            = Endpoint verifikasi
?p=...                    = Query parameter signature_token
42|1705126800|5|a8f3b2c1 = Signature token
```

## Contoh PDF dengan QR Code

```
┌─────────────────────────────────────────────────┐
│                 PEMERINTAH DESA SRUNI           │
│            SURAT KETERANGAN DOMISILI            │
│         No. SRT/20250113/0001                   │
└─────────────────────────────────────────────────┘

Dikeluarkan pada: 13 January 2025

Berdasarkan permohonan yang telah diajukan,
dengan ini kami menerangkan bahwa:

Nama          : Budi Santoso
NIK           : 1234567890123456
Tempat/Tgl L  : Surabaya, 01-01-1990
...

[Isi surat di tengah halaman]

┌─────────────────────────────────────────────────┐
│           TANDA TANGAN DIGITAL BAGIAN           │
├─────────────────────────────────────────────────┤
│                                                 │
│  LURAH DESA SRUNI,                             │
│                                                 │
│  ┌──────────────────────┐                      │
│  │  ▐░░░░░░░░░░░░░░▌  │  ◄─── QR CODE       │
│  │  ▐░░░░░░░░░░░░░░▌  │       EMBEDDED      │
│  │  ▐░░░░░░░░░░░░░░▌  │       (80x80px)     │
│  │  ▐░░░░░░░░░░░░░░▌  │                      │
│  │  ▐░░░░░░░░░░░░░░▌  │                      │
│  │  ▐░░░░░░░░░░░░░░▌  │                      │
│  │  ▐░░░░░░░░░░░░░░▌  │                      │
│  └──────────────────────┘                      │
│                                                 │
│  Scan untuk verifikasi tanda tangan digital   │
│                                                 │
│  ─────────────────────────                    │
│  (________________________)  ◄─── Tanda Tangan│
│  NIP: ........................                   │
│                                                 │
└─────────────────────────────────────────────────┘
```

## Halaman Verifikasi (Valid)

```
╔════════════════════════════════════════════╗
║         ✓ Tanda Tangan Digital             ║
║              Terverifikasi                 ║
╚════════════════════════════════════════════╝

═══════════════════════════════════════════════

✓ Tanda tangan digital sah dan terverifikasi.

───────────────────────────────────────────────

DATA SURAT

Nomor Surat          : SRT/20250113/0001
Jenis Surat          : Surat Domisili
Nama Pemohon         : Budi Santoso
NIK                  : 1234567890123456
Keperluan            : Membuat paspor
Status               : ✓ Selesai
Tanggal Selesai      : 13 January 2025 10:30
Tanda Tangan Digital : ✓ Ditandatangani
                       13 January 2025 10:30:15

───────────────────────────────────────────────

ⓘ Surat ini telah ditandatangani secara digital 
  oleh Kepala Desa dan dapat dipercaya. Setiap 
  surat memiliki token unik yang dapat diverifikasi 
  untuk memastikan keaslian.

───────────────────────────────────────────────

[Kembali ke Beranda]
```

## Halaman Verifikasi (Invalid)

```
╔════════════════════════════════════════════╗
║    ✗ Tanda Tangan Digital Tidak Valid      ║
╚════════════════════════════════════════════╝

═══════════════════════════════════════════════

✗ Signature token tidak valid atau tidak 
  ditemukan dalam sistem.

───────────────────────────────────────────────

⚠ PERHATIAN

Surat ini tidak dapat diverifikasi. Hal ini 
mungkin terjadi karena:

• QR Code rusak atau tidak terbaca dengan benar
• Surat belum ditandatangani oleh Kepala Desa  
• Token signature telah kadaluarsa atau dihapus

───────────────────────────────────────────────

[Kembali ke Beranda]  [Login untuk Info Lanjutan]
```

## Database Record Contoh

```sql
-- Table: pengajuan_surats

id                      : 42
nomor_pengajuan         : SRT/20250113/0001
user_id                 : 1
jenis_surat             : Surat Domisili
keperluan               : Membuat paspor
nama_pemohon            : Budi Santoso
nik_pemohon             : 1234567890123456
...
status                  : Selesai
file_surat_hasil        : 1705126800_SRT_20250113_0001.pdf
signature_token         : 42|1705126800|5|a8f3b2c1  ◄─── NEW
signature_generated_at  : 2025-01-13 10:30:15       ◄─── NEW
tanggal_selesai         : 2025-01-13 10:30:15
diproses_oleh           : 5
...
```

## File PDF Generated

```
Filename: 1705126800_SRT_20250113_0001.pdf
Size: ~45 KB
Location: storage/app/public/surat_hasil/

Isi:
- HTML dari surat-template.blade.php
- QR Code sebagai base64 embedded image
  data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAA...
```

## Keamanan Token

```
Token Structure:

42|1705126800|5|a8f3b2c1

┌─────┬────────────┬───┬──────────┐
│  ID │ Timestamp  │ ID│  Random  │
└─────┴────────────┴───┴──────────┘

Keamanan:
1. ID unik per pengajuan
2. Timestamp mencegah duplikasi
3. User ID tracking siapa yang tanda tangan
4. Random hash mencegah brute force

Setiap kombinasi UNIK dan TIDAK DAPAT DIPREDIKSI
```

## Testing Curl Commands

```bash
# Test generate QR code
curl -X POST \
  http://localhost:8000/admin/pengajuan/42/generate-surat \
  -H "Authorization: Bearer {TOKEN}" \
  -H "Content-Type: application/json"

# Test verifikasi signature (public)
curl http://localhost:8000/pengajuan/ttd?p=42|1705126800|5|a8f3b2c1

# Test database
php artisan tinker
> $pengajuan = App\Models\PengajuanSurat::find(42);
> $pengajuan->signature_token
// Output: "42|1705126800|5|a8f3b2c1"
> $pengajuan->signature_generated_at
// Output: "2025-01-13 10:30:15"
```

## Integrasi dengan Sistem Lain

```
┌──────────────────┐
│  Aplikasi Desa   │
└────────┬─────────┘
         │
         ├─► PDF Generator (DomPDF)
         ├─► QR Code Generator (endroid/qr-code)
         ├─► Database (MySQL)
         └─► Email Notifier

Alur Integrasi:
1. User submit pengajuan
2. Admin approve & process
3. Admin generate surat → trigger QR generation
4. PDF dibuat dengan QR embedded
5. Email dikirim ke user dengan PDF attachment
6. User dapat verify melalui QR code
```
