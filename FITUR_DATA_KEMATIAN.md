# Fitur Data Kematian Penduduk

## Deskripsi Fitur
Fitur Data Kematian memungkinkan admin untuk mencatat data penduduk yang telah meninggal dengan informasi lengkap mengenai tanggal, penyebab, dan tempat kematian.

---

## 📋 Komponen yang Dibuat

### 1. **Database & Model**
- **Migration**: `database/migrations/2025_12_01_125705_create_kematians_table.php`
- **Model**: `app/Models/Kematian.php`

**Kolom Tabel Kematians:**
| Kolom | Tipe | Deskripsi |
|-------|------|-----------|
| id | bigint | Primary Key |
| penduduk_id | bigint FK | Referensi ke Tabel Penduduks (unique) |
| tanggal_kematian | date | Tanggal kematian penduduk |
| penyebab_kematian | string | Penyebab kematian (optional) |
| tempat_kematian | string | Tempat kematian (optional) |
| rs_atau_rumah | string | Tipe lokasi (RS/Rumah/Jalan/Lainnya) |
| usia_saat_meninggal | string | Usia saat meninggal |
| nama_diperiksa_oleh | string | Nama dokter/petugas yang memeriksa |
| keterangan | text | Catatan tambahan |
| input_oleh | string | Nama user yang input data |
| created_at, updated_at | timestamp | Timestamps |

**Relasi:**
- `belongsTo(Penduduk)` - Setiap data kematian terkait dengan satu penduduk

---

### 2. **Controller**
**File**: `app/Http/Controllers/Admin/KematianController.php`

**Methods:**
- `index()` - Tampilkan daftar semua data kematian (15 per halaman)
- `create()` - Form tambah data kematian
- `store()` - Simpan data kematian baru
- `show()` - Lihat detail data kematian
- `edit()` - Form edit data kematian
- `update()` - Update data kematian
- `destroy()` - Hapus data kematian

**Validasi:**
- `penduduk_id`: required, exists, unique (tidak boleh ada duplikat)
- `tanggal_kematian`: required, date format valid
- Fields lainnya: optional

---

### 3. **Routes**
**File**: `routes/web.php`

```php
Route::resource('admin/kematian', KematianController::class)->names('admin.kematian');
```

**Route yang Tersedia:**
| Method | Route | Nama | Fungsi |
|--------|-------|------|--------|
| GET | `/admin/kematian` | `admin.kematian.index` | Daftar kematian |
| GET | `/admin/kematian/create` | `admin.kematian.create` | Form tambah |
| POST | `/admin/kematian` | `admin.kematian.store` | Simpan data |
| GET | `/admin/kematian/{id}` | `admin.kematian.show` | Detail kematian |
| GET | `/admin/kematian/{id}/edit` | `admin.kematian.edit` | Form edit |
| PUT | `/admin/kematian/{id}` | `admin.kematian.update` | Update data |
| DELETE | `/admin/kematian/{id}` | `admin.kematian.destroy` | Hapus data |

---

### 4. **Views**
**Folder**: `resources/views/admin/kematian/`

#### a. `index.blade.php` - Daftar Data Kematian
- Menampilkan tabel dengan informasi:
  - No, Nama Penduduk, NIK, Tanggal Kematian, Penyebab, Tempat, Input Oleh, Tanggal Input
- Tombol aksi: Lihat, Edit, Hapus
- Pagination (15 per halaman)
- Alert success untuk notifikasi

#### b. `create.blade.php` - Form Tambah Data Kematian
- Input form untuk:
  - Pilih Penduduk (dropdown dengan nama dan NIK)
  - Tanggal Kematian (date picker)
  - Penyebab Kematian
  - Tempat Kematian
  - Lokasi Kematian (dropdown: Rumah Sakit/Rumah/Jalan/Lainnya)
  - Usia Saat Meninggal
  - Diperiksa Oleh (Nama Dokter/Petugas)
  - Keterangan (textarea)
- Validasi error inline
- Tombol Simpan dan Kembali

#### c. `edit.blade.php` - Form Edit Data Kematian
- Mirip dengan create, tapi value sudah terisi
- Untuk dropdown penduduk tetap bisa diubah

#### d. `show.blade.php` - Detail Data Kematian
- Menampilkan informasi dalam card sections:
  - **Identitas Penduduk**: Nama, NIK, TTL, Jenis Kelamin
  - **Informasi Kematian**: Tanggal, Penyebab, Tempat, Lokasi, Usia, Diperiksa Oleh
  - **Keterangan**: Catatan tambahan (jika ada)
  - **Data Input**: Siapa yang input dan kapan
- Tombol Edit dan Kembali

---

### 5. **Menu & Navigation**
**File**: `resources/views/admin/sidebar.blade.php`

- Ditambahkan menu **"Data Kematian"** di sidebar admin
- Icon: `ti ti-death-icon` dengan emoji ⚰️
- Styling konsisten dengan menu lainnya

**File**: `resources/views/admin/dashboard.blade.php`

#### a. **Statistik KPI Cards** (6 cards):
1. Total Penduduk
2. Penduduk Input Manual (whereNull user_id)
3. **Penduduk Meninggal** (count dari Kematian) 🆕
4. Pengajuan Menunggu
5. Selesai (Bulan Ini)
6. Pengaduan Aktif

#### b. **Quick Actions** (5 buttons):
- Verifikasi Pengajuan
- Tanggapi Pengaduan
- Tambah Penduduk
- Upload Surat Hasil
- **Input Data Kematian** (dengan total) 🆕

#### c. **Tabel Data Kematian Terbaru** (5 terakhir) 🆕
- Kolom: No, Nama, NIK, Tanggal Kematian, Penyebab, Tempat Kematian, Aksi
- Link ke detail

#### d. **Statistik Penduduk** (Progress Bar) 🆕
- Total Penduduk
- Input Manual
- Registrasi Akun
- Penduduk Hidup
- Penduduk Meninggal

#### e. **Detail Penduduk** (Box Cards) 🆕
- Card: Total Penduduk
- Card: Input Manual
- Card: Registrasi Akun
- Card: Meninggal
- Info helper text

---

## 🚀 Cara Menggunakan

### **Menambah Data Kematian**
1. Login sebagai Admin
2. Klik **"Data Kematian"** di sidebar
3. Klik **"Tambah Data Kematian"** atau **"Input Data Kematian"** dari dashboard
4. Isi form dengan data lengkap:
   - Pilih penduduk dari dropdown
   - Isi tanggal kematian (required)
   - Isi data opsional lainnya
5. Klik **"Simpan Data Kematian"**

### **Melihat Daftar Kematian**
1. Klik **"Data Kematian"** di sidebar
2. Daftar lengkap semua data kematian akan ditampilkan
3. Gunakan pagination untuk halaman berikutnya

### **Melihat Detail Kematian**
1. Di halaman daftar, klik tombol **"Lihat"** (eye icon)
2. Informasi lengkap akan ditampilkan dalam format card

### **Edit Data Kematian**
1. Di halaman daftar, klik tombol **"Edit"** (pencil icon)
2. Ubah data yang diperlukan
3. Klik **"Update Data Kematian"**

### **Hapus Data Kematian**
1. Di halaman daftar, klik tombol **"Hapus"** (trash icon)
2. Konfirmasi penghapusan
3. Data akan dihapus

### **Melihat Dashboard Analytics**
1. Admin Dashboard menampilkan:
   - **Card KPI**: Jumlah penduduk meninggal di card merah
   - **Data Terbaru**: 5 data kematian terakhir dalam tabel
   - **Statistik**: Progress bar untuk semua kategori penduduk
   - **Detail Cards**: Ringkas info penduduk Input vs Registrasi vs Meninggal

---

## 📊 Database Relationships

```
Kematian
├── belongsTo: Penduduk
└── Attributes:
    ├── penduduk_id (FK unique)
    ├── tanggal_kematian
    ├── penyebab_kematian
    ├── tempat_kematian
    ├── rs_atau_rumah
    ├── usia_saat_meninggal
    ├── nama_diperiksa_oleh
    ├── keterangan
    └── input_oleh
```

---

## 🔐 Security & Validation

- **Authorization**: Hanya admin yang bisa akses fitur ini (middleware `cekRole:admin`)
- **Unique Constraint**: Satu penduduk hanya bisa di-record sekali sebagai meninggal
- **Validation**: All required fields divalidasi di server-side
- **Error Handling**: User-friendly error messages untuk setiap validasi

---

## 📝 Notes

- Data kematian akan **otomatis** mengurangi jumlah "Penduduk Hidup" di dashboard
- Info user yang input disimpan untuk audit trail
- Jika penduduk tidak ada di list, harus tambah penduduk terlebih dahulu
- Setiap tambah/edit/hapus akan dicatat dengan timestamp

---

## 🔧 Technical Stack

- **Framework**: Laravel 12
- **ORM**: Eloquent
- **Template Engine**: Blade
- **Database**: MySQL
- **Frontend**: Bootstrap 5 + Tabler Components
- **Icons**: Tabler Icons (ti ti-death-icon)

---

**Dibuat**: 1 Desember 2025
**Version**: 1.0
**Status**: ✅ Production Ready
