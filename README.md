# 📖 RuangKisah — Web App Cerpen (PHP Native + MySQL Laragon)

**RuangKisah** adalah aplikasi web berbasis **PHP Native** dan **MySQL** yang mengusung tema **Apple Minimalist Design**. Menggunakan palet utama *dark charcoal*, *cream*, *putih*, dan *abu-abu*, tanpa foto/cover yang mengalihkan perhatian, dengan fokus menonjolkan judul karya cerita secara elegan dan tipografi ramah pembaca.

---

## 🌟 Fitur Utama (CRUD & Interaktif)

1. **Create (Tambah Cerpen)** (`tambah.php`):
   - Form input judul, nama penulis, pilihan genre kategori, sinopsis ringkas, dan isi cerita lengkap.
   - Pilihan URL cover gambar dengan **Live Image Preview**.
   - **Live Word Counter** & estimasi waktu membaca secara otomatis saat mengetik.
   - Fitur cerdas: jika sinopsis dikosongkan, sistem otomatis membuat ringkasan dari potongan awal cerita.

2. **Read (Jelajah & Baca Cerpen)** (`index.php` & `baca.php`):
   - **Katalog Cerpen**: Tampilan kartu modern dengan badge genre, nama penulis, tanggal, dan cover.
   - **Live Search & Filter**: Pencarian instan berdasarkan judul/penulis/kata kunci dan filter berdasarkan kategori (Romantis, Horor, Fantasi, Komedi, Drama, Misteri, Sci-Fi).
   - **Sorting**: Urutkan berdasarkan Terbaru, Terpopuler (paling banyak dibaca), Judul (A-Z), atau Terlama.
   - **Reading View**: Mode baca fokus dengan tipografi editorial (`Merriweather`), drop-cap huruf awal, pengatur ukuran font (`A-`, `A`, `A+`), serta otomatis menambah jumlah pembaca (*views counter*).

3. **Update (Edit Cerpen)** (`edit.php`):
   - Mengubah isi judul, kategori, penulis, cover, maupun naskah cerita yang sudah ada.
   - Form otomatis terisi data lama (*pre-filled*).
   - Validasi data server-side & client-side dengan notifikasi sukses.

4. **Delete (Hapus Cerpen)** (`hapus.php`):
   - Fitur penghapusan cerita dengan perlindungan **Modal Dialog Konfirmasi** agar tidak terhapus secara tidak sengaja.
   - Feedback notifikasi Toast alert setelah proses hapus selesai.

---

## 📂 Struktur Direktori Proyek

```text
LaprakCC3/
│
├── config/
│   └── database.php        # Konfigurasi koneksi PDO ke MySQL (Laragon)
├── includes/
│   ├── header.php          # Navbar, link CSS, Google Fonts, Flash Message
│   └── footer.php          # Modal konfirmasi hapus, footer, script JS
├── assets/
│   ├── css/
│   │   └── style.css       # Pure Vanilla CSS modern (Glassmorphism & Dark theme)
│   └── js/
│       └── main.js         # Interaktivitas: modal, counter kata, filter, font resizer
├── database.sql            # Skrip SQL: membuat database, tabel, dan data awal
├── index.php               # Halaman utama (Katalog & Pencarian - READ)
├── baca.php                # Halaman membaca detail cerpen (READ)
├── tambah.php              # Halaman menulis cerpen baru (CREATE)
├── edit.php                # Halaman ubah cerpen (UPDATE)
├── hapus.php               # Handler penghapusan cerpen (DELETE)
└── README.md               # Dokumentasi panduan instalasi dan penggunaan
```

---

## 🚀 Panduan Menjalankan dengan Laragon & phpMyAdmin

### Langkah 1: Nyalakan Laragon
1. Buka aplikasi **Laragon** di komputer Anda.
2. Klik tombol **Start All** (memastikan Apache & MySQL aktif).

### Langkah 2: Import Database ke phpMyAdmin
1. Buka browser dan kunjungi phpMyAdmin:
   ```text
   http://localhost/phpmyadmin
   ```
2. Klik menu tab **Import** di bagian atas (atau buat database baru bernama `db_cerpen`).
3. Klik tombol **Choose File / Browse**, lalu pilih file `database.sql` yang ada di dalam folder project ini:
   `c:\Users\Amrul\Documents\LaprakCC3\database.sql`
4. Gulir ke bawah lalu klik tombol **Import** (atau **Kirim**).
5. Database `db_cerpen` beserta tabel `cerpen` dan 4 contoh cerpen siap digunakan!

### Langkah 3: Menjalankan Web App

Ada 2 cara mudah untuk membukanya:

#### Opsi A: Jalankan dengan PHP Built-in Server (Sangat Praktis & Cepat)
Buka terminal / PowerShell di folder ini, lalu ketik:
```bash
php -S localhost:8000
```
Lalu buka browser Anda ke:
```text
http://localhost:8000
```

#### Opsi B: Akses Lewat Folder `www` Laragon
Jika folder project ini berada di `C:\laragon\www\LaprakCC3`, Anda bisa langsung membuka:
```text
http://localhost/LaprakCC3
```
*(Atau buat Virtual Host di Laragon).*

---

## 🛠️ Konfigurasi Database (Bila Diperlukan)

Secara default, Laragon menggunakan konfigurasi berikut pada file `config/database.php`:
- **Host**: `localhost`
- **User**: `root`
- **Password**: *(kosong)*
- **Database**: `db_cerpen`

Jika Anda menggunakan password khusus pada MySQL Laragon, cukup sesuaikan nilai `$db_pass` di file `config/database.php`.

---

## 📝 Catatan Laporan Praktikum (Laprak)
Aplikasi ini sudah memenuhi kriteria:
1. **Full CRUD**:
   - **Create**: `tambah.php`
   - **Read**: `index.php` (katalog) dan `baca.php` (detail)
   - **Update**: `edit.php`
   - **Delete**: `hapus.php`
2. **PHP Native**: Menggunakan sintaks PHP murni tanpa framework, dengan PDO prepared statements untuk keamanan dari serangan SQL Injection.
3. **Database phpMyAdmin**: Didukung file `database.sql` yang siap di-import langsung.
