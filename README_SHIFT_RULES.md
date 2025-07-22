# Dokumentasi Aturan Penjadwalan Shift

## Overview

Sistem penjadwalan shift telah diimplementasikan dengan aturan-aturan yang kompleks untuk memastikan keadilan, efisiensi, dan kepatuhan terhadap kebijakan perusahaan.

## Aturan-aturan Logika Penjadwalan

### 1. Pembagian Shift Harian

-   **Tiga shift per hari**: Pagi (08:00-16:00), Siang (16:00-00:00), Malam (00:00-08:00)
-   **Minimal 2 karyawan per shift**: Memastikan keamanan dan efisiensi kerja
-   **Satu shift per karyawan per hari**: Mencegah kelelahan dan konflik jadwal

### 2. Rotasi Shift

-   **Rotasi mingguan**: Karyawan diputar setiap minggu untuk keadilan
-   **Prioritas shift**: Jika minggu lalu malam, minggu ini prioritas pagi/siang
-   **Sistem scoring**: Menggunakan algoritma scoring untuk menentukan prioritas

### 3. Pengisian Shift Kosong

-   **Daftar shift darurat**: Shift kosong ditampilkan untuk pengambilan sukarela
-   **Validasi eligibility**: Sistem mengecek apakah karyawan eligible sebelum pengambilan
-   **Interface user-friendly**: Karyawan dapat melihat dan mengambil shift kosong

### 4. Penanganan Cuti

-   **Otomatis exclude**: Karyawan cuti tidak dijadwalkan selama periode cuti
-   **Shift darurat**: Shift kosong akibat cuti masuk daftar darurat
-   **Validasi status**: Hanya cuti yang disetujui yang dipertimbangkan

### 5. Validasi Jadwal

-   **Deteksi konflik**: Sistem mendeteksi multiple shift per hari
-   **Cek staff minimum**: Memastikan setiap shift memiliki minimal 2 karyawan
-   **Laporan konflik**: Menampilkan detail konflik untuk perbaikan

## Implementasi Teknis

### Service: ShiftRuleEngineService

File: `app/Services/ShiftRuleEngineService.php`

#### Method Utama:

1. **`penjadwalanOtomatis()`**: Menjalankan penjadwalan otomatis berdasarkan aturan
2. **`jadwalkanHari()`**: Menjadwalkan shift untuk satu hari tertentu
3. **`pilihKaryawanUntukShift()`**: Memilih karyawan terbaik untuk shift tertentu
4. **`isKaryawanEligible()`**: Mengecek eligibility karyawan
5. **`validasiJadwal()`**: Memvalidasi jadwal untuk konflik
6. **`getShiftKosong()`**: Mendapatkan daftar shift kosong
7. **`ambilShiftKosong()`**: Karyawan mengambil shift kosong

#### Algoritma Scoring:

```php
$score = 0;

// 1. Prioritas: tidak ada shift di hari yang sama
if ($hasShiftToday) $score += 1000;

// 2. Rotasi mingguan
if ($weekDiff == 0) $score += 500;
if ($lastShift->jenis_shift === 'malam' && in_array($shiftType, ['pagi', 'siang'])) {
    $score -= 100; // Prioritas tinggi
}

// 3. Fairness: jumlah shift bulan ini
$score += $shiftCountThisMonth * 10;

// 4. Jeda minimum
if ($jeda < $minJeda) $score += 200;
```

### Controller: ShiftController

File: `app/Http/Controllers/Admin/ShiftController.php`

#### Fitur Admin:

-   **Dashboard**: Statistik shift, tombol aksi penjadwalan
-   **Penjadwalan Otomatis**: Form dengan periode yang dapat dipilih
-   **Validasi Jadwal**: Menampilkan konflik dan saran perbaikan
-   **Shift Kosong**: Daftar shift kosong dengan statistik
-   **Assign Manual**: Menugaskan karyawan ke shift kosong

### Views

1. **Dashboard**: `resources/views/pages/admin/shift/dashboard.blade.php`
2. **Validasi**: `resources/views/pages/admin/shift/validasi.blade.php`
3. **Shift Kosong**: `resources/views/pages/admin/shift/kosong.blade.php`

## Database Schema

### Tabel: rule_shift

```sql
- id (primary key)
- nama_rule (string)
- deskripsi (text)
- max_shift_per_bulan (integer)
- min_jeda_hari (integer)
- min_karyawan_per_shift (integer, default: 2)
- rotasi_mingguan (boolean, default: true)
- fairness (boolean, default: true)
- prioritas_shift_malam (boolean, default: true)
- aktif (boolean, default: true)
- timestamps
```

### Tabel: shifts

```sql
- id (primary key)
- tanggal_shift (date)
- jenis_shift (enum: pagi, siang, malam)
- jam_mulai (time)
- jam_selesai (time)
- user_id (foreign key)
- status (enum: kosong, diambil, selesai, dibatalkan)
- keterangan (text)
- timestamps
```

## Routes

### Admin Routes:

```php
// Dashboard dan statistik
GET /admin/shift/dashboard

// Penjadwalan otomatis
POST /admin/shift/penjadwalan-otomatis

// Validasi jadwal
POST /admin/shift/validasi-jadwal

// Shift kosong
POST /admin/shift/shift-kosong

// Assign karyawan
POST /admin/shift/{id}/assign

// CRUD standar
Route::resource('shift', ShiftController::class);
```

## Seeder dan Testing

### ShiftRuleSeeder

File: `database/seeders/ShiftRuleSeeder.php`

Membuat 3 rule berbeda:

1. **Aturan Standar**: Untuk operasi normal
2. **Aturan Shift Malam**: Khusus untuk shift malam dengan jeda lebih lama
3. **Aturan Periode Sibuk**: Untuk periode sibuk dengan staff lebih banyak

### Menjalankan Seeder:

```bash
php artisan db:seed --class=ShiftRuleSeeder
```

## Fitur Khusus

### 1. Rotasi Mingguan

-   Sistem menghitung minggu berdasarkan `weekOfYear`
-   Prioritas diberikan berdasarkan shift minggu sebelumnya
-   Mencegah monotonitas jadwal

### 2. Fairness Algorithm

-   Menghitung jumlah shift per karyawan per bulan
-   Memberikan prioritas kepada karyawan dengan shift lebih sedikit
-   Memastikan distribusi yang adil

### 3. Eligibility Check

-   Cek cuti: Karyawan cuti tidak eligible
-   Cek konflik: Tidak boleh ada multiple shift per hari
-   Cek limit: Tidak boleh melebihi max shift per bulan
-   Cek jeda: Harus memenuhi minimal jeda hari

### 4. Validasi Jadwal

-   Deteksi multiple shift per hari per karyawan
-   Cek jumlah karyawan per shift (minimal 2)
-   Laporan detail konflik dengan saran perbaikan

## Penggunaan

### 1. Penjadwalan Otomatis

1. Buka dashboard shift admin
2. Pilih periode penjadwalan
3. Klik "Penjadwalan Otomatis"
4. Sistem akan menjadwalkan berdasarkan aturan

### 2. Validasi Jadwal

1. Pilih periode validasi
2. Klik "Validasi Jadwal"
3. Lihat hasil validasi dan konflik
4. Gunakan "Perbaiki Otomatis" jika ada konflik

### 3. Pengelolaan Shift Kosong

1. Lihat daftar shift kosong
2. Assign karyawan manual atau gunakan otomatis
3. Monitor statistik shift kosong

## Monitoring dan Maintenance

### Logs

-   Semua error penjadwalan dicatat di Laravel logs
-   Debug information untuk troubleshooting

### Performance

-   Query optimization untuk database
-   Caching untuk data yang sering diakses
-   Pagination untuk data besar

### Backup

-   Backup database secara berkala
-   Export jadwal shift untuk arsip

## Troubleshooting

### Masalah Umum:

1. **Shift tidak ter-assign**: Cek eligibility karyawan
2. **Konflik jadwal**: Gunakan validasi jadwal
3. **Rule tidak aktif**: Pastikan rule aktif di database
4. **Performance lambat**: Cek query dan indexing

### Debug:

```php
// Tambahkan di service untuk debug
Log::info('Debug info', $data);
dd($variable); // Untuk debugging sementara
```

## Kesimpulan

Sistem penjadwalan shift telah diimplementasikan dengan aturan-aturan yang kompleks dan fleksibel. Sistem ini memastikan:

-   Keadilan dalam pembagian shift
-   Efisiensi dalam penjadwalan
-   Kepatuhan terhadap kebijakan perusahaan
-   Kemudahan dalam monitoring dan maintenance

Semua aturan dapat dikonfigurasi melalui database dan interface admin yang user-friendly.
