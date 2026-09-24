<?php
// Koneksi database
$host = "localhost";
$user = "root";
$pass = "";
$db   = "perpusku";

$koneksi = new mysqli($host, $user, $pass, $db);
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Logika ketika tombol Daftar ditekan
$pesan_error = "";
if (isset($_POST['daftar'])) {
    $nama_lengkap        = mysqli_real_escape_string($koneksi, $_POST['nama_lengkap']);
    $password            = $_POST['password'];
    $konfirmasi_password = $_POST['konfirmasi_password'];
    $nis                 = mysqli_real_escape_string($koneksi, $_POST['nis']);
    $kode_anggota        = mysqli_real_escape_string($koneksi, $_POST['kode_anggota']);
    $jk                  = mysqli_real_escape_string($koneksi, $_POST['jk']);
    $kelas               = mysqli_real_escape_string($koneksi, $_POST['kelas']);
    $jurusan             = mysqli_real_escape_string($koneksi, $_POST['jurusan']);
    $alamat              = mysqli_real_escape_string($koneksi, $_POST['alamat']);
    $status              = "Aktif";

    // Validasi Password
    if ($password !== $konfirmasi_password) {
        $pesan_error = "Konfirmasi password tidak cocok!";
    } else {
        // Cek duplikat NIS atau Kode Anggota
        $cek = $koneksi->query("SELECT * FROM anggota WHERE nis = '$nis' OR kode_anggota = '$kode_anggota'");
        if ($cek->num_rows > 0) {
            $pesan_error = "NIS atau Kode Anggota sudah terdaftar di sistem!";
        } else {
            // Hash Password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert ke tabel anggota (kolom password diletakkan setelah nama_lengkap sesuai database Anda)
            $sql = "INSERT INTO anggota (kode_anggota, nis, nama_lengkap, password, jk, kelas, jurusan, alamat, status) 
                    VALUES ('$kode_anggota', '$nis', '$nama_lengkap', '$hashed_password', '$jk', '$kelas', '$jurusan', '$alamat', '$status')";

            if ($koneksi->query($sql) === TRUE) {
                echo "<script>alert('Pendaftaran Berhasil! Silakan Login.'); window.location='login.php';</script>";
                exit();
            } else {
                $pesan_error = "Gagal mendaftar: " . $koneksi->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - Perpustakaan Digital</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #0f172a;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #fff;
        }
        .card-register {
            background: #1e293b;
            border: none;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.3);
        }
        .form-control, .form-select {
            background-color: #0f172a;
            border: 1px solid #334155;
            color: #fff;
        }
        .form-control:focus, .form-select:focus {
            background-color: #0f172a;
            border-color: #f59e0b;
            color: #fff;
            box-shadow: none;
        }
        label {
            font-size: 14px;
            color: #cbd5e1;
            margin-bottom: 4px;
        }
        .btn-beranda {
            background: #1e293b;
            color: #f59e0b;
            border: 1px solid #334155;
            font-weight: 600;
            font-size: 14px;
            padding: 6px 16px;
            border-radius: 8px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: 0.2s;
        }
        .btn-beranda:hover {
            background: #334155;
            color: #fbbf24;
        }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <a href="login.php" class="btn-beranda mb-3">&larr; Ke Beranda</a>
            <div class="card card-register p-4">
                <div class="text-center mb-4">
                    <h3 class="fw-bold text-white">DAFTAR AKUN</h3>
                    <!-- Teks subtitle terang agar mudah dibaca -->
                    <p class="small mb-0" style="color: #94a3b8; font-weight: 500;">Pendaftaran khusus anggota / user perpustakaan</p>
                </div>

                <!-- Notifikasi Error jika ada -->
                <?php if (!empty($pesan_error)) : ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= $pesan_error; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <form action="" method="POST">
                    
                    <!-- Nama Lengkap -->
                    <div class="mb-3">
                        <label>Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" class="form-control" placeholder="Masukkan nama lengkap" required>
                    </div>

                    <!-- Password & Konfirmasi Password -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Konfirmasi Password</label>
                            <input type="password" name="konfirmasi_password" class="form-control" placeholder="Ulangi password" required>
                        </div>
                    </div>

                    <!-- NIS & Kode Anggota -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>NIS</label>
                            <input type="text" name="nis" class="form-control" placeholder="Nomor Induk Siswa" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Kode Anggota</label>
                            <input type="text" name="kode_anggota" class="form-control" placeholder="Contoh: AG-001" required>
                        </div>
                    </div>

                    <!-- Jenis Kelamin & Kelas -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Jenis Kelamin</label>
                            <select name="jk" class="form-select" required>
                                <option value="">Pilih...</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Kelas</label>
                            <input type="text" name="kelas" class="form-control" placeholder="Contoh: XI RPL" required>
                        </div>
                    </div>

                    <!-- Jurusan -->
                    <div class="mb-3">
                        <label>Jurusan</label>
                        <input type="text" name="jurusan" class="form-control" placeholder="Contoh: Rekayasa Perangkat Lunak" required>
                    </div>

                    <!-- Alamat -->
                    <div class="mb-3">
                        <label>Alamat Lengkap</label>
                        <textarea name="alamat" class="form-control" rows="2" placeholder="Masukkan alamat rumah" required></textarea>
                    </div>

                    <!-- Tombol Daftar -->
                    <button type="submit" name="daftar" class="btn btn-warning w-100 fw-bold py-2 mt-2">Daftar Sekarang</button>
                    
                    <div class="text-center mt-3">
                        <small style="color: #cbd5e1;">Sudah punya akun? <a href="login.php" class="fw-bold text-decoration-none" style="color: #f59e0b;">Login disini</a></small>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>