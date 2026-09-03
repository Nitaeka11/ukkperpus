# Desain Sistem Informasi Perpustakaan SMP N 2 Sanden
# 📚 Sistem Informasi Perpustakaan Digital SMP N 2 Sanden

<p align="center">
  <img src="https://img.shields.io/badge/PHP-8.x-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP">
  <img src="https://img.shields.io/badge/MySQL-Database-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
  <img src="https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white" alt="HTML5">
  <img src="https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white" alt="CSS3">
  <img src="https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black" alt="JavaScript">
  <img src="https://img.shields.io/badge/Bootstrap-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white" alt="Bootstrap">
</p>

<p align="center">
  <b>📖 Sistem Informasi Perpustakaan Digital</b><br>
  <i>SMP Negeri 2 Sanden </i>
   <i>Oleh NITA</i>
</p>

---

WIREFRAME: https://raw.githubusercontent.com/Nitaeka11/ukkperpus/refs/heads/main/WIREFRAME.png

## 📌 Tentang Project

**Sistem Informasi Perpustakaan Digital SMP N 2 Sanden** merupakan aplikasi berbasis web yang dibuat untuk membantu proses pengelolaan perpustakaan sekolah secara lebih mudah, cepat, terstruktur, dan terdigitalisasi.

Aplikasi ini dirancang untuk menggantikan proses pengelolaan perpustakaan yang sebelumnya dilakukan secara manual menjadi sistem berbasis komputer yang dapat digunakan oleh petugas/admin maupun siswa.

Sistem menyediakan berbagai fitur utama seperti:

* 🏠 Landing Page
* 🔐 Login
* 👨‍💼 Dashboard Admin/Petugas
* 👨‍🎓 Dashboard Siswa
* 📚 Data Buku
* 🏷️ Kategori Buku
* 👥 Data Anggota
* 📖 Peminjaman Buku
* 🔄 Pengembalian Buku
* 📊 Laporan Perpustakaan
* 🔎 Pencarian Buku
* 📈 Statistik Perpustakaan
* 📝 Pengelolaan Data Transaksi
* 🗃️ Database MySQL
* 📱 Tampilan responsive

Project ini dikembangkan menggunakan **PHP dan MySQL** serta dijalankan menggunakan web server seperti **XAMPP**.

---

# 🎯 Tujuan Project

Tujuan utama pembuatan aplikasi ini adalah:

1. Membantu petugas perpustakaan dalam mengelola data buku.
2. Mempermudah pengelolaan data anggota.
3. Mempermudah proses peminjaman buku.
4. Mempermudah proses pengembalian buku.
5. Mengurangi pencatatan manual.
6. Meminimalkan kesalahan dalam pencatatan transaksi.
7. Mempermudah pencarian data buku.
8. Menyediakan laporan perpustakaan secara terstruktur.
9. Membantu siswa mencari dan melihat koleksi buku.
10. Meningkatkan efisiensi pelayanan perpustakaan sekolah.

---

# 🏫 Informasi Project

| Informasi          | Detail                                |
| ------------------ | ------------------------------------- |
| Nama Sistem        | Sistem Informasi Perpustakaan Digital |
| Sekolah            | SMP Negeri 2 Sanden                   |
| Jenis Project      | Website Sistem Informasi              |
| Platform           | Web                                   |
| Bahasa Pemrograman | PHP                                   |
| Database           | MySQL                                 |
| Frontend           | HTML, CSS, JavaScript                 |
| Framework UI       | Bootstrap                             |
| Web Server         | Apache                                |
| Local Server       | XAMPP                                 |
| Database Name      | `ukk_perpus`                          |
| Target Pengguna    | Admin/Petugas dan Siswa               |

---

# ✨ Fitur Utama

## 🏠 1. Landing Page

Landing page merupakan halaman awal website yang menjadi pintu masuk pengguna ke dalam sistem.

Pada halaman ini pengguna dapat melihat:

* Identitas perpustakaan
* Informasi perpustakaan
* Deskripsi sistem
* Navigasi website
* Tombol masuk/login
* Informasi layanan perpustakaan
* Tampilan visual perpustakaan

Landing page dibuat agar pengguna mendapatkan gambaran mengenai sistem sebelum masuk ke halaman utama.

---

# 🔐 2. Sistem Login

Sistem menyediakan halaman login untuk membatasi akses ke dalam sistem.

Login digunakan untuk memastikan bahwa hanya pengguna yang memiliki akun yang dapat mengakses fitur tertentu.

Fitur login meliputi:

* Username/email
* Password
* Validasi input
* Session
* Logout
* Proteksi halaman
* Redirect setelah login

### Alur Login

```text
Landing Page
     │
     ▼
   Login
     │
     ▼
Validasi Akun
     │
 ┌───┴────┐
 │        │
Gagal   Berhasil
 │        │
 ▼        ▼
Login    Dashboard
lagi
```

---

# 👨‍💼 3. Dashboard Admin/Petugas

Dashboard admin/petugas merupakan pusat pengelolaan sistem perpustakaan.

Dashboard menampilkan informasi penting secara ringkas sehingga petugas dapat mengetahui kondisi perpustakaan dengan cepat.

### Informasi Dashboard

Contohnya:

* 📚 Total Buku
* 👥 Total Anggota
* 📖 Total Peminjaman
* 🔄 Total Pengembalian
* ⚠️ Peminjaman Terlambat
* 📊 Statistik Peminjaman
* 📈 Grafik transaksi
* 🕐 Aktivitas terbaru

Dashboard dirancang dengan tampilan modern, bersih, dan mudah digunakan.

---

# 📚 4. Manajemen Data Buku

Fitur buku digunakan untuk mengelola seluruh koleksi buku perpustakaan.

Admin/petugas dapat:

* Menambahkan buku
* Melihat buku
* Mengedit buku
* Menghapus buku
* Mencari buku
* Melihat detail buku
* Mengelompokkan buku berdasarkan kategori
* Mengatur jumlah/stok buku

### Informasi Buku

Data buku dapat terdiri dari:

* ID Buku
* Kode Buku
* ISBN
* Judul Buku
* Penulis
* Penerbit
* Tahun Terbit
* Kategori
* Jumlah/Stok
* Lokasi/Rak
* Deskripsi
* Cover buku

---

# 🏷️ 5. Kategori Buku

Kategori digunakan untuk mengelompokkan koleksi buku berdasarkan jenisnya.

Contoh kategori:

* 📖 Fiksi
* 🔬 Sains
* 📚 Pendidikan
* 🕌 Agama
* 💻 Teknologi
* 🧮 Matematika
* 🌎 IPS
* 🔤 Bahasa
* 🎨 Seni
* 📕 Novel
* 📗 Referensi

Admin dapat:

* Menambah kategori
* Mengubah kategori
* Menghapus kategori
* Melihat jumlah buku dalam kategori

---

# 👥 6. Manajemen Anggota

Fitur anggota digunakan untuk mengelola data siswa yang terdaftar sebagai anggota perpustakaan.

Data anggota dapat meliputi:

* ID Anggota
* NIS
* Nama
* Kelas
* Jenis Kelamin
* Alamat
* Nomor Telepon
* Email
* Tanggal Daftar
* Status Anggota

Admin dapat melakukan:

* ➕ Tambah anggota
* 👁️ Lihat anggota
* ✏️ Edit anggota
* 🗑️ Hapus anggota
* 🔎 Cari anggota

---

# 📖 7. Peminjaman Buku

Fitur peminjaman digunakan untuk mencatat transaksi ketika anggota meminjam buku.

### Proses Peminjaman

```text
Pilih Anggota
      │
      ▼
Pilih Buku
      │
      ▼
Cek Ketersediaan
      │
      ▼
Tentukan Tanggal
      │
      ▼
Simpan Transaksi
      │
      ▼
Stok Buku Berkurang
      │
      ▼
Transaksi Berhasil
```

Data peminjaman dapat meliputi:

* ID Peminjaman
* ID Anggota
* Nama Anggota
* ID Buku
* Judul Buku
* Tanggal Peminjaman
* Tanggal Jatuh Tempo
* Status Peminjaman
* Petugas

---

# 🔄 8. Pengembalian Buku

Fitur pengembalian digunakan untuk mencatat buku yang telah dikembalikan oleh siswa.

Ketika buku dikembalikan, sistem dapat memperbarui:

* Status peminjaman
* Tanggal pengembalian
* Stok buku
* Status keterlambatan
* Denda apabila diperlukan

### Alur Pengembalian

```text
Cari Transaksi
      │
      ▼
Pilih Peminjaman
      │
      ▼
Klik Pengembalian
      │
      ▼
Cek Tanggal
      │
 ┌────┴─────┐
 │          │
Tepat    Terlambat
 │          │
 ▼          ▼
Tanpa      Hitung
Denda      Denda
 │          │
 └────┬─────┘
      ▼
Simpan Pengembalian
      │
      ▼
Stok Buku Bertambah
```

---

# 📊 9. Laporan Perpustakaan

Laporan digunakan untuk memberikan informasi lengkap mengenai aktivitas perpustakaan.

Laporan dapat digunakan oleh admin/petugas untuk melihat dan menyampaikan kondisi perpustakaan kepada pihak sekolah atau kepala sekolah.

### Laporan dapat mencakup:

* Total buku
* Total anggota
* Total peminjaman
* Total pengembalian
* Peminjaman aktif
* Buku terlambat
* Data anggota
* Data buku
* Data transaksi
* Riwayat peminjaman
* Riwayat pengembalian
* Data denda
* Statistik transaksi

### Contoh Ringkasan

```text
========================================
       LAPORAN PERPUSTAKAAN
        SMP N 2 SANDEN
========================================

Total Buku             : xxx
Total Anggota          : xxx
Total Peminjaman       : xxx
Total Pengembalian     : xxx
Peminjaman Aktif       : xxx
Keterlambatan          : xxx
========================================
```

Laporan dibuat agar data perpustakaan dapat dipantau dengan lebih mudah dan terstruktur.

---

# 🔎 10. Pencarian Buku

Sistem menyediakan fitur pencarian untuk membantu pengguna menemukan buku dengan cepat.

Pencarian dapat dilakukan berdasarkan:

* Judul buku
* Penulis
* Penerbit
* ISBN
* Kategori
* Kode buku

Contoh:

```text
Cari buku...
[________________________________]
             🔍
```

---

# 👨‍🎓 11. Dashboard Siswa

Dashboard siswa dibuat khusus untuk pengguna siswa.

Siswa dapat melihat informasi perpustakaan tanpa harus mengakses fitur administrasi.

Fitur siswa dapat meliputi:

* 📚 Koleksi Buku
* 🔎 Cari Buku
* 📖 Detail Buku
* 📋 Riwayat Peminjaman
* 🔄 Status Pengembalian
* 👤 Profil
* 🚪 Logout

---

# 📱 Responsive Design

Website dirancang agar dapat digunakan pada berbagai ukuran perangkat:

* 💻 Desktop
* 🖥️ Laptop
* 📱 Smartphone
* 📟 Tablet

Tampilan menyesuaikan ukuran layar sehingga pengguna tetap dapat mengakses sistem dengan nyaman.

---

# 🎨 Konsep UI/UX

Sistem menggunakan konsep desain yang:

* Modern
* Clean
* Simple
* User Friendly
* Responsive
* Mudah dipahami
* Konsisten
* Cocok untuk lingkungan sekolah

Warna utama menggunakan nuansa **biru laut/blue** yang memberikan kesan:

* 📘 Pendidikan
* 🌊 Tenang
* 💙 Profesional
* 🏫 Formal tetapi tetap menarik

---

# 🛠️ Teknologi yang Digunakan

## Backend

### PHP

PHP digunakan sebagai bahasa pemrograman utama untuk membangun sistem backend.

Digunakan untuk:

* Login
* Session
* CRUD
* Query database
* Validasi
* Transaksi peminjaman
* Pengembalian
* Laporan

---

## Database

### MySQL

MySQL digunakan sebagai sistem database untuk menyimpan seluruh data perpustakaan.

Database:

```text
ukk_perpus
```

---

## Frontend

### HTML5

Digunakan untuk membangun struktur halaman website.

### CSS3

Digunakan untuk:

* Layout
* Warna
* Animasi
* Responsive design
* Komponen UI

### JavaScript

Digunakan untuk membuat halaman lebih interaktif.

### Bootstrap

Digunakan untuk membantu pembuatan:

* Navbar
* Card
* Modal
* Table
* Button
* Form
* Responsive layout

---

# 🗄️ Struktur Database

Database utama:

```text
ukk_perpus
```

Beberapa tabel utama yang digunakan dalam sistem antara lain:

```text
ukk_perpus
│
├── admin
│
├── anggota
│
├── buku
│
├── kategori
│
└── peminjaman
```

---

# 🔗 Relasi Database

Gambaran sederhana hubungan antar tabel:

```text
              ┌─────────────┐
              │   KATEGORI  │
              └──────┬──────┘
                     │
                     │
                     ▼
              ┌─────────────┐
              │     BUKU    │
              └──────┬──────┘
                     │
                     │
                     ▼
┌─────────────┐  ┌─────────────┐
│   ANGGOTA   │──│ PEMINJAMAN  │
└─────────────┘  └─────────────┘
                     │
                     ▼
               PENGEMBALIAN
```

---

# 📂 Struktur Folder Project

Contoh struktur project:

```text
perpustakaan/
│
├── index.php
├── login.php
├── logout.php
├── koneksi.php
│
├── dashboard.php
├── dashboard_siswa.php
│
├── buku/
│   ├── buku.php
│   ├── tambah.php
│   ├── edit.php
│   ├── hapus.php
│   └── detail.php
│
├── kategori/
│   ├── kategori.php
│   ├── tambah.php
│   ├── edit.php
│   └── hapus.php
│
├── anggota/
│   ├── anggota.php
│   ├── tambah.php
│   ├── edit.php
│   └── hapus.php
│
├── peminjaman/
│   ├── peminjaman.php
│   ├── tambah.php
│   ├── detail.php
│   └── hapus.php
│
├── pengembalian/
│   ├── pengembalian.php
│   └── proses.php
│
├── laporan/
│   └── laporan.php
│
├── assets/
│   ├── css/
│   ├── js/
│   ├── img/
│   └── icons/
│
└── database/
    └── ukk_perpus.sql
```

> Nama file dapat disesuaikan dengan struktur project sebenarnya.

---

# ⚙️ Instalasi

## 1. Clone Repository

```bash
git clone https://github.com/USERNAME/NAMA-REPOSITORY.git
```

Kemudian masuk ke folder:

```bash
cd NAMA-REPOSITORY
```

---

# 2. Install XAMPP

Download dan install XAMPP pada komputer.

Pastikan:

```text
Apache
MySQL
```

dapat dijalankan.

---

# 3. Letakkan Project

Pindahkan folder project ke:

```text
C:\xampp\htdocs\
```

Contoh:

```text
C:\xampp\htdocs\perpustakaan\
```

---

# 4. Jalankan XAMPP

Buka XAMPP Control Panel kemudian aktifkan:

```text
Apache → Start
MySQL  → Start
```

---

# 5. Membuat Database

Buka:

```text
http://localhost/phpmyadmin
```

Buat database:

```text
ukk_perpus
```

Kemudian import file:

```text
ukk_perpus.sql
```

---

# 6. Konfigurasi Database

Sesuaikan file:

```text
koneksi.php
```

Contoh konfigurasi:

```php
<?php

$host = "localhost";
$user = "root";
$pass = "";
$db   = "ukk_perpus";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>
```

Sesuaikan konfigurasi dengan server yang digunakan.

---

# 7. Menjalankan Website

Buka browser:

```text
http://localhost/perpustakaan/
```

Jika project berada di folder lain, sesuaikan URL dengan nama folder project.

---

# 🌐 Versi Online

Project juga dapat digunakan secara online melalui hosting.

Website:

**Perpustakaan Digital SMP N 2 Sanden**

```text
https://perpusnita.free.nf/
```

> URL dapat berubah apabila hosting, domain, atau konfigurasi website diubah.

---

# 🔐 Keamanan Sistem

Beberapa aspek keamanan yang perlu diperhatikan:

* Menggunakan session untuk autentikasi.
* Validasi input pengguna.
* Validasi login.
* Proteksi halaman admin.
* Logout untuk menghapus session.
* Validasi data sebelum masuk database.
* Menghindari query database secara sembarangan.
* Menggunakan prepared statement untuk sistem yang lebih aman.
* Password sebaiknya disimpan menggunakan `password_hash()`.

Contoh:

```php
$password_hash = password_hash($password, PASSWORD_DEFAULT);
```

Untuk proses login:

```php
password_verify($password, $password_hash);
```

---

# 🔄 CRUD System

Sistem menggunakan konsep CRUD:

```text
C = Create
R = Read
U = Update
D = Delete
```

### Create

Menambahkan data baru.

### Read

Menampilkan data dari database.

### Update

Mengubah data.

### Delete

Menghapus data.

CRUD digunakan pada berbagai modul seperti:

* Buku
* Kategori
* Anggota
* Peminjaman
* Data admin

---

# 📚 Alur Sistem Perpustakaan

```text
                    START
                      │
                      ▼
                LANDING PAGE
                      │
                      ▼
                    LOGIN
                      │
               ┌──────┴──────┐
               │             │
               ▼             ▼
             ADMIN          SISWA
               │             │
               ▼             ▼
          DASHBOARD      DASHBOARD
               │             │
      ┌────────┼────────┐    │
      │        │        │    │
      ▼        ▼        ▼    ▼
     BUKU   ANGGOTA  LAPORAN KOLEKSI
      │        │        │    │
      └────────┼────────┘    │
               │             │
               ▼             ▼
          PEMINJAMAN     CARI BUKU
               │
               ▼
         PENGEMBALIAN
               │
               ▼
             SELESAI
```

---

# 📖 Alur Peminjaman

```text
Siswa memilih buku
        │
        ▼
Sistem mengecek stok
        │
   ┌────┴────┐
   │         │
 Tersedia  Habis
   │         │
   ▼         ▼
Pinjam    Tidak bisa
   │
   ▼
Simpan transaksi
   │
   ▼
Stok berkurang
   │
   ▼
Peminjaman aktif
```

---

# 🔄 Alur Pengembalian

```text
Buku dikembalikan
       │
       ▼
Cari transaksi
       │
       ▼
Cek tanggal kembali
       │
   ┌───┴────┐
   │        │
Tepat    Terlambat
   │        │
   ▼        ▼
Tanpa    Hitung
denda    denda
   │        │
   └───┬────┘
       ▼
Update transaksi
       │
       ▼
Tambah stok buku
       │
       ▼
Selesai
```

---

# 📊 Statistik Dashboard

Dashboard dapat menampilkan statistik seperti:

```text
┌─────────────────┐
│   TOTAL BUKU    │
│      1.250      │
└─────────────────┘

┌─────────────────┐
│ TOTAL ANGGOTA   │
│       350       │
└─────────────────┘

┌─────────────────┐
│ PEMINJAMAN      │
│       125       │
└─────────────────┘

┌─────────────────┐
│ PENGEMBALIAN    │
│       100       │
└─────────────────┘
```

Angka tersebut harus diambil secara dinamis dari database, bukan ditulis secara manual.

---

# 📈 Grafik Peminjaman

Dashboard dapat menggunakan grafik untuk menunjukkan perkembangan transaksi perpustakaan.

Contoh:

```text
Jumlah
  │
50│       █
40│   █   █
30│   █   █   █
20│ █ █   █   █
10│ █ █ █ █   █
  └────────────────
    Jan Feb Mar Apr
```

Grafik dapat digunakan untuk mengetahui:

* Jumlah peminjaman per bulan
* Jumlah pengembalian
* Buku paling sering dipinjam
* Aktivitas anggota

---

# 🧪 Testing

Sebelum sistem digunakan, lakukan pengujian terhadap fitur utama.

| Fitur        | Pengujian                |
| ------------ | ------------------------ |
| Login        | Username/password benar  |
| Login        | Username/password salah  |
| Buku         | Tambah buku              |
| Buku         | Edit buku                |
| Buku         | Hapus buku               |
| Buku         | Cari buku                |
| Anggota      | Tambah anggota           |
| Anggota      | Edit anggota             |
| Anggota      | Hapus anggota            |
| Peminjaman   | Tambah transaksi         |
| Peminjaman   | Cek stok                 |
| Pengembalian | Pengembalian tepat waktu |
| Pengembalian | Pengembalian terlambat   |
| Laporan      | Menampilkan data         |
| Logout       | Session terhapus         |

---

# 🐛 Troubleshooting

## Database tidak terkoneksi

Pastikan:

```text
MySQL = Running
```

Kemudian periksa:

```php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "ukk_perpus";
```

---

## Website tidak dapat dibuka

Pastikan Apache aktif.

Kemudian buka:

```text
http://localhost/
```

Jika berhasil, coba:

```text
http://localhost/perpustakaan/
```

---

## Error Table Doesn't Exist

Pastikan database:

```text
ukk_perpus
```

sudah dibuat dan file SQL sudah di-import.

---

## Error Unknown Database

Pastikan nama database sama:

```text
ukk_perpus
```

---

# 🚀 Pengembangan Selanjutnya

Sistem masih dapat dikembangkan dengan berbagai fitur tambahan.

### Fitur yang dapat ditambahkan:

* 📱 Progressive Web App
* 📲 QR Code buku
* 🔍 Barcode scanner
* 📧 Notifikasi email
* 🔔 Notifikasi jatuh tempo
* 📊 Grafik lebih lengkap
* 🖨️ Cetak laporan
* 📄 Export PDF
* 📊 Export Excel
* 👤 Profil pengguna
* 🔑 Reset password
* 🖼️ Upload cover buku
* ⭐ Rating buku
* ❤️ Buku favorit
* 🔎 Pencarian lebih advanced
* 📚 Rekomendasi buku
* 📱 Tampilan mobile yang lebih optimal

---

# 🎓 Manfaat Bagi Sekolah

Dengan adanya sistem ini, perpustakaan sekolah dapat:

* Mengurangi penggunaan pencatatan manual.
* Mempercepat pelayanan siswa.
* Mempermudah pencarian buku.
* Mempermudah pengelolaan anggota.
* Mempermudah monitoring transaksi.
* Menghasilkan laporan dengan lebih cepat.
* Menyimpan data secara terstruktur.
* Meningkatkan efisiensi kerja petugas.
* Memberikan pengalaman digital kepada siswa.

---

# 👨‍💻 Developer

Project ini dikembangkan sebagai project pembelajaran dan pengembangan sistem informasi perpustakaan berbasis web.

### Project

**Sistem Informasi Perpustakaan Digital SMP N 2 Sanden**

### Teknologi

```text
PHP
MySQL
HTML5
CSS3
JavaScript
Bootstrap
XAMPP
```

---

# 📜 License

Project ini dibuat untuk tujuan pembelajaran dan pengembangan sistem informasi perpustakaan sekolah.

Penggunaan, pengembangan, dan modifikasi project dapat disesuaikan dengan kebutuhan sekolah.

---

# ❤️ Acknowledgement

Terima kasih kepada:

* SMP Negeri 2 Sanden
* Guru pembimbing
* Petugas perpustakaan
* Teman-teman yang membantu proses pengembangan
* Semua pihak yang memberikan dukungan dalam pembuatan sistem

---

# 📞 Contact

Untuk informasi lebih lanjut mengenai project, silakan menghubungi developer melalui repository GitHub atau kontak yang tersedia pada project.

---

# 🌐 Website

**Live Demo:**

https://perpusnita.free.nf/

---

# ⭐ Support Project

Jika project ini membantu atau bermanfaat, jangan lupa memberikan ⭐ pada repository GitHub.

```text
⭐ Star Repository
🍴 Fork Repository
🐛 Report Issue
💡 Suggest Feature
```

---

## 📌 Kesimpulan

**Sistem Informasi Perpustakaan Digital SMP N 2 Sanden** dibuat sebagai solusi digital untuk membantu pengelolaan perpustakaan sekolah.

Dengan sistem ini, proses pengelolaan:

```text
📚 Buku
👥 Anggota
📖 Peminjaman
🔄 Pengembalian
📊 Laporan
```

dapat dilakukan secara lebih terstruktur, cepat, dan efisien.

Project ini juga menjadi sarana pembelajaran dalam penerapan:

```text
PHP
↓
MySQL
↓
CRUD
↓
Session & Authentication
↓
Database Relationship
↓
UI/UX
↓
Sistem Informasi
```

**📚 Membaca lebih mudah. Mengelola lebih cepat. Perpustakaan lebih modern. 💙**

---

<p align="center">
  <b>📖 Sistem Informasi Perpustakaan Digital</b><br>
  <b>SMP Negeri 2 Sanden</b>
</p>

<p align="center">
  Made with 💙 using PHP & MySQL
</p>



Dokumen ini disusun berdasarkan analisis source code (folder `admin/`, `petugas/`, `anggota/`, `config/koneksi.php`, dll) dari project **ukkbaru.zip**. Sistem memiliki 3 aktor: **Admin**, **Petugas**, dan **Anggota (siswa)**, dengan fitur utama: manajemen data buku & anggota, peminjaman, booking, pengembalian & denda, notifikasi, dan ulasan buku.

---

## 1. Algoritma Sistem

### 1.1 Algoritma Login
```
MULAI
1. User membuka halaman login.php
2. INPUT username, password, role (admin/petugas/anggota)
3. JIKA role = "admin" MAKA
     Cari data di tabel admin WHERE username = input
4. JIKA role = "petugas" MAKA
     Cari data di tabel petugas WHERE username = input
5. JIKA role = "anggota" MAKA
     Cari data di tabel anggota WHERE nis = input ATAU nama_lengkap = input
6. JIKA data ditemukan DAN password cocok MAKA
     Simpan session sesuai role
     Alihkan ke dashboard (admin/petugas/anggota)
   SEBALIKNYA
     Tampilkan pesan "Login gagal"
SELESAI
```

### 1.2 Algoritma Peminjaman / Booking Buku (Anggota)
```
MULAI
1. Anggota login dan membuka katalog.php
2. Anggota memilih buku, klik "Pinjam"
3. Sistem cek: apakah anggota sudah meminjam buku yang sama & belum kembali?
   JIKA YA -> tolak, tampilkan pesan error
4. Sistem cek: apakah anggota sudah booking buku ini & masih "Menunggu"?
   JIKA YA -> tolak, tampilkan pesan error
5. Sistem cek stok buku
   JIKA stok <= 0 MAKA
        tampilkan pesan "Stok buku habis"
        SELESAI
6. JIKA proses = "pinjam langsung" MAKA
     a. INSERT ke tabel peminjaman (status='Dipinjam', kondisi_buku='Baik', denda_per_hari=1000,
        tgl_pinjam=hari ini, tgl_hrs_kembali=hari ini+7)
     b. UPDATE stok buku (stok = stok - 1)
   SEBALIKNYA (proses = "booking")
     a. Buat kode_booking unik
     b. INSERT ke tabel booking (status='Menunggu', batas_ambil=+2 hari,
        tanggal_jatuh_tempo perkiraan=+9 hari)
     c. INSERT notifikasi baru untuk petugas ("Booking Baru Masuk")
7. Tampilkan pesan sukses ke anggota
SELESAI
```

### 1.3 Algoritma Persetujuan Booking (Petugas)
```
MULAI
1. Petugas login, membuka booking.php / kelola_booking.php
2. Sistem tampilkan daftar booking WHERE status='Menunggu'
3. Petugas memilih satu booking, lalu:
   JIKA aksi = "Setujui" MAKA
        a. Cek ulang stok buku
        b. JIKA stok tersedia:
             - INSERT ke tabel peminjaman (status='Dipinjam')
             - UPDATE stok buku (stok - 1)
             - UPDATE booking SET status='Dipinjam'
             - INSERT notifikasi "Booking Disetujui"
           SEBALIKNYA:
             - tampilkan pesan stok habis
   JIKA aksi = "Tolak" MAKA
        a. UPDATE booking SET status='Ditolak'
        b. INSERT notifikasi "Booking Ditolak"
SELESAI
```

### 1.4 Algoritma Pengembalian Buku & Denda (Petugas)
```
MULAI
1. Petugas membuka transaksi.php, pilih data peminjaman aktif
2. Klik tombol "Kembalikan"
3. UPDATE peminjaman SET status='Dikembalikan', tanggal_dikembalikan = hari ini
4. JIKA tanggal_dikembalikan > tgl_hrs_kembali MAKA
     hitung selisih hari terlambat
     total_denda = selisih_hari * denda_per_hari
     UPDATE peminjaman SET total_denda, status_denda='Belum Lunas'
5. UPDATE stok buku (stok = stok + 1) [pengembalian fisik]
6. INSERT notifikasi pengembalian
7. Admin dapat memproses pembayaran denda melalui proses_bayar_denda.php
   -> UPDATE peminjaman SET status_denda='Lunas'
SELESAI
```

### 1.5 Algoritma Ulasan Buku (Anggota)
```
MULAI
1. Anggota memilih buku pada katalog, isi rating (1-5) dan komentar
2. Sistem cek apakah anggota sudah pernah mengulas buku ini
   JIKA SUDAH -> UPDATE data ulasan (rating & teks) 
   JIKA BELUM -> INSERT data ulasan baru (id_anggota, id_buku, rating, ulasan, tanggal)
3. Tampilkan pesan sukses, ulasan tampil di halaman utama (index.php)
SELESAI
```

---

## 2. Entity Relationship Diagram (ERD)

```mermaid
erDiagram
    KATEGORI ||--o{ BUKU : "memiliki"
    BUKU ||--o{ PEMINJAMAN : "dipinjam pada"
    ANGGOTA ||--o{ PEMINJAMAN : "melakukan"
    BUKU ||--o{ BOOKING : "dibooking pada"
    ANGGOTA ||--o{ BOOKING : "mengajukan"
    BUKU ||--o{ ULASAN : "diberi"
    ANGGOTA ||--o{ ULASAN : "menulis"
    PETUGAS ||--o{ PESAN_BANTUAN : "menindaklanjuti"

    ADMIN {
        int id_admin PK
        string username
        string password
    }

    PETUGAS {
        int id_petugas PK
        string nama_petugas
        string username
        string email
        string no_hp
        string password
    }

    ANGGOTA {
        int id_anggota PK
        string kode_anggota
        string nis
        string nama_lengkap
        string password
        string jk
        string tempat_lahir
        date tanggal_lahir
        string kelas
        string jurusan
        string alamat
        string status
    }

    KATEGORI {
        int id_kategori PK
        string nama_kategori
    }

    BUKU {
        int id_buku PK
        string id_cover
        string kode_buku
        string isbn
        string judul_buku
        int id_kategori FK
        string pengarang
        string penerbit
        string tahun_terbit
        string rak
        string lokasi_rak
        int stok
        string kondisi
        string catatan
    }

    PEMINJAMAN {
        int id_peminjaman PK
        int id_anggota FK
        int id_buku FK
        date tgl_pinjam
        date tgl_hrs_kembali
        date tanggal_dikembalikan
        string status
        string kondisi_buku
        int denda_per_hari
        string status_denda
        int total_denda
    }

    BOOKING {
        int id_booking PK
        string kode_booking
        int id_anggota FK
        string nama_anggota
        int id_buku FK
        string kode_buku
        string judul_buku
        datetime tanggal_booking
        date batas_ambil
        date tanggal_jatuh_tempo
        string status
    }

    ULASAN {
        int id_ulasan PK
        int id_anggota FK
        int id_buku FK
        int rating
        string ulasan
        date tanggal
    }

    NOTIFIKASI {
        int id_notif PK
        string judul
        string pesan
        string tipe
        string status
        datetime created_at
    }

    PESAN_BANTUAN {
        int id_pesan PK
        string nama
        string email
        string pesan
        date tanggal
        string status
        int id_petugas FK
    }
```

---

## 3. Flowchart Sistem (Alur Peminjaman & Booking Buku)

```mermaid
flowchart TD
    A([Mulai]) --> B[Anggota Login]
    B --> C[Buka Halaman Katalog Buku]
    C --> D{Pilih Buku & Klik Pinjam}
    D --> E{Sedang meminjam buku\nyang sama?}
    E -- Ya --> E1[Tampilkan pesan error]
    E1 --> Z([Selesai])
    E -- Tidak --> F{Ada booking aktif\nuntuk buku ini?}
    F -- Ya --> F1[Tampilkan pesan error]
    F1 --> Z
    F -- Tidak --> G{Stok buku > 0?}
    G -- Tidak --> G1[Tampilkan pesan\nstok habis]
    G1 --> Z
    G -- Ya --> H{Mode transaksi?}
    H -- Pinjam Langsung --> I[Simpan ke tabel peminjaman\nstatus = Dipinjam]
    I --> J[Kurangi stok buku]
    J --> K[Tampilkan pesan sukses]
    K --> Z
    H -- Booking --> L[Simpan ke tabel booking\nstatus = Menunggu]
    L --> M[Buat notifikasi\nuntuk petugas]
    M --> N[Tampilkan pesan\nbooking terkirim]
    N --> O[Petugas meninjau booking]
    O --> P{Petugas setujui?}
    P -- Ya --> Q{Stok masih ada?}
    Q -- Ya --> R[Buat data peminjaman\nUpdate stok\nUpdate booking = Dipinjam]
    R --> S[Notifikasi: Booking Disetujui]
    S --> Z
    Q -- Tidak --> T[Notifikasi stok habis]
    T --> Z
    P -- Tidak --> U[Update booking = Ditolak]
    U --> V[Notifikasi: Booking Ditolak]
    V --> Z
```

---

## 4. Use Case Diagram

```mermaid
flowchart LR
    Admin([👤 Admin])
    Petugas([👤 Petugas])
    Anggota([👤 Anggota / Siswa])

    subgraph SI["Sistem Informasi Perpustakaan SMP N 2 Sanden"]
        UC1((Login))
        UC2((Kelola Data Buku & Kategori))
        UC3((Kelola Data Anggota))
        UC4((Kelola Data Petugas))
        UC5((Lihat Laporan))
        UC6((Kelola Data Denda))
        UC7((Kelola Booking Peminjaman))
        UC8((Verifikasi Kondisi Buku))
        UC9((Kelola Transaksi\nPeminjaman & Pengembalian))
        UC10((Kelola Notifikasi))
        UC11((Tanggapi Pesan Bantuan))
        UC12((Registrasi Akun))
        UC13((Lihat Katalog Buku))
        UC14((Ajukan Peminjaman / Booking))
        UC15((Beri Ulasan & Rating Buku))
        UC16((Lihat Riwayat Peminjaman))
        UC17((Lihat Notifikasi))
        UC18((Kirim Pesan Bantuan))
    end

    Admin --> UC1
    Admin --> UC2
    Admin --> UC3
    Admin --> UC4
    Admin --> UC5
    Admin --> UC6
    Admin --> UC10

    Petugas --> UC1
    Petugas --> UC7
    Petugas --> UC8
    Petugas --> UC9
    Petugas --> UC10
    Petugas --> UC11

    Anggota --> UC12
    Anggota --> UC1
    Anggota --> UC13
    Anggota --> UC14
    Anggota --> UC15
    Anggota --> UC16
    Anggota --> UC17
    Anggota --> UC18
```

---

## 5. Activity Diagram (Proses Peminjaman Buku hingga Pengembalian)

```mermaid
flowchart TD
    subgraph Anggota
        A1([Mulai]) --> A2[Login]
        A2 --> A3[Buka Katalog Buku]
        A3 --> A4[Pilih Buku & Ajukan Pinjam/Booking]
    end

    subgraph Sistem
        S1{Validasi status peminjaman,\nbooking, dan stok}
        S2[Simpan transaksi\nke database]
        S3[Kirim notifikasi\nke petugas]
        S4[Update status\npeminjaman/booking]
    end

    subgraph Petugas
        P1[Terima notifikasi]
        P2{Cek kelayakan\n& stok}
        P3[Setujui booking]
        P4[Tolak booking]
        P5[Catat pengembalian\n& cek keterlambatan]
        P6[Hitung denda\njika terlambat]
    end

    A4 --> S1
    S1 -- Valid --> S2
    S1 -- Tidak valid --> A5[Tampilkan pesan gagal]
    A5 --> A6([Selesai])
    S2 --> S3
    S3 --> P1
    P1 --> P2
    P2 -- Layak --> P3
    P2 -- Tidak layak --> P4
    P3 --> S4
    P4 --> S4
    S4 --> A7[Anggota terima notifikasi\nhasil pengajuan]
    A7 --> A8{Ambil & pinjam buku\ndi perpustakaan}
    A8 --> P5
    P5 --> P6
    P6 --> A9[Anggota menerima info\ndenda jika ada]
    A9 --> A6
```

---

## 6. User Flow (Sisi Anggota / Siswa)

```mermaid
flowchart TD
    Start([Buka Website Perpustakaan]) --> Reg{Sudah Punya Akun?}
    Reg -- Belum --> Register[Isi Form Registrasi\nregister.php]
    Register --> Login
    Reg -- Sudah --> Login[Login\nlogin.php]

    Login --> Dash[Dashboard Anggota\ndashboard.php\nRingkasan: sedang dipinjam,\nbooking, riwayat]

    Dash --> Katalog[Buka Katalog Buku\nkatalog.php]
    Katalog --> Cari[Cari / Filter Buku]
    Cari --> Detail[Lihat Detail Buku]
    Detail --> Aksi{Pilih Aksi}
    Aksi -- Pinjam/Booking --> Proses[proses_peminjaman.php]
    Proses --> Notif1[Lihat Notifikasi\nStatus Pengajuan]
    Aksi -- Beri Ulasan --> Ulasan[Isi Rating & Komentar\nproses_ulasan.php]
    Ulasan --> Katalog

    Dash --> Pinjam[Halaman Peminjaman\npeminjaman.php\nLihat status pinjam & booking]
    Dash --> Notif2[Halaman Notifikasi\nnotifikasi.php]

    Notif1 --> Selesai([Ambil Buku di Perpustakaan])
    Pinjam --> Selesai
    Selesai --> Kembali[Kembalikan Buku\nsesuai jatuh tempo]
    Kembali --> End([Selesai])
```

---

### Catatan
- Diagram di atas dibuat berdasarkan struktur tabel & alur logika yang benar-benar ada di kode (`config/koneksi.php`, `admin/*.php`, `petugas/*.php`, `anggota/*.php`).
- Tabel `admin` tidak memiliki fitur tambah/edit di kode (hanya dipakai untuk login), sehingga di ERD hanya field dasarnya yang disertakan.
- File ini bisa dibuka di editor yang mendukung **Mermaid** (mis. Markdown preview di VS Code, Typora, atau Mermaid Live Editor di mermaid.live) untuk melihat diagram secara visual, atau di-convert ke gambar/PDF bila diperlukan untuk laporan UKK.
