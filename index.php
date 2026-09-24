<?php
/* =========================================================
   INDEX.PHP — Landing Page Perpustakaan SMP N 2 Sanden
   ========================================================= */
session_start();
include "config/koneksi.php";

// Ambil Statistik Real-Time dari Database
$q_buku = mysqli_query($conn, "SELECT COUNT(*) as total FROM buku");
$total_buku = mysqli_fetch_assoc($q_buku)['total'] ?? 0;

$q_anggota = mysqli_query($conn, "SELECT COUNT(*) as total FROM anggota");
$total_anggota = mysqli_fetch_assoc($q_anggota)['total'] ?? 0;

$q_pinjam = mysqli_query($conn, "SELECT COUNT(*) as total FROM peminjaman WHERE status='Dipinjam'");
$sedang_pinjam = mysqli_fetch_assoc($q_pinjam)['total'] ?? 0;

$q_kembali = mysqli_query($conn, "SELECT COUNT(*) as total FROM peminjaman WHERE status='Dikembalikan'");
$sudah_kembali = mysqli_fetch_assoc($q_kembali)['total'] ?? 0;

// [BARU] Total stok buku yang masih tersedia (query tambahan, read-only, tidak mengubah data apa pun)
$q_stok = mysqli_query($conn, "SELECT SUM(stok) as total FROM buku");
$total_stok = mysqli_fetch_assoc($q_stok)['total'] ?? 0;

// Fitur Pencarian Buku
$keyword = $_GET['cari'] ?? '';
if (!empty($keyword)) {
    $keyword_safe = mysqli_real_escape_string($conn, $keyword);
    $q_katalog = mysqli_query($conn, "SELECT * FROM buku WHERE judul_buku LIKE '%$keyword_safe%' OR pengarang LIKE '%$keyword_safe%' ORDER BY id_buku DESC");
} else {
    $q_katalog = mysqli_query($conn, "SELECT * FROM buku ORDER BY id_buku DESC");
}
$jumlah_hasil_katalog = $q_katalog ? mysqli_num_rows($q_katalog) : 0;

// Ambil Data Ulasan / Komentar secara Otomatis dari Database
// (deteksi otomatis nama kolom teks ulasan, disamakan dengan proses_ulasan.php & admin/notifikasi.php
//  supaya tidak ada lagi mismatch nama kolom antar halaman)
$kolom_teks_ulasan = 'ulasan';
$cek_kolom_ulasan = mysqli_query($conn, "SHOW COLUMNS FROM ulasan");
if ($cek_kolom_ulasan) {
    $kolom_ulasan_ada = [];
    while ($kc = mysqli_fetch_assoc($cek_kolom_ulasan)) $kolom_ulasan_ada[] = $kc['Field'];
    if (in_array('ulasan', $kolom_ulasan_ada)) {
        $kolom_teks_ulasan = 'ulasan';
    } elseif (in_array('komentar', $kolom_ulasan_ada)) {
        $kolom_teks_ulasan = 'komentar';
    }
}
$q_ulasan = mysqli_query($conn, "SELECT u.*, u.`$kolom_teks_ulasan` AS ulasan, a.nama_lengkap FROM ulasan u JOIN anggota a ON u.id_anggota = a.id_anggota ORDER BY u.id_ulasan DESC LIMIT 6");

// Cek keberadaan file gambar hero secara server-side (memastikan path benar sebelum dirender)
$hero_image = "gambar/smp2.jpeg";
$hero_image_exists = file_exists(__DIR__ . "/" . $hero_image);

// ================== FORM PUSAT BANTUAN (pesan tersimpan ke database, seperti Ulasan) ==================
$bantuan_error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['kirim_bantuan'])) {
    $nama_bantuan  = trim($_POST['nama_bantuan'] ?? '');
    $email_bantuan = trim($_POST['email_bantuan'] ?? '');
    $pesan_bantuan = trim($_POST['pesan_bantuan'] ?? '');

    if ($nama_bantuan === '' || $email_bantuan === '' || $pesan_bantuan === '') {
        $bantuan_error = 'Semua kolom wajib diisi.';
    } elseif (!filter_var($email_bantuan, FILTER_VALIDATE_EMAIL)) {
        $bantuan_error = 'Format email tidak valid.';
    } else {
        $nama_safe  = mysqli_real_escape_string($conn, $nama_bantuan);
        $email_safe = mysqli_real_escape_string($conn, $email_bantuan);
        $pesan_safe = mysqli_real_escape_string($conn, $pesan_bantuan);
        $insert_bantuan = mysqli_query($conn, "INSERT INTO pesan_bantuan (nama, email, pesan, tanggal) VALUES ('$nama_safe', '$email_safe', '$pesan_safe', NOW())");
        if ($insert_bantuan) {
            header("Location: index.php?bantuan=sukses#bantuan");
            exit;
        } else {
            $bantuan_error = 'Gagal mengirim pesan, silakan coba lagi nanti.';
        }
    }
}
$bantuan_sukses = (($_GET['bantuan'] ?? '') === 'sukses');

// [BARU] Konfigurasi kontak WhatsApp Pusat Bantuan (ganti nomor sesuai admin/petugas perpustakaan)
$wa_nomor = '087894837251'; // format internasional tanpa tanda "+"
$wa_pesan_default = 'Halo, saya butuh bantuan seputar Perpustakaan Digital SMP N 2 Sanden.';
$wa_link = 'https://wa.me/' . $wa_nomor . '?text=' . rawurlencode($wa_pesan_default);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan Digital - SMP N 2 Sanden</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --primary-color: #7c3aed;
            --primary-dark: #5b21b6;
            --accent-color: #f59e0b;
            --secondary-color: #10b981;
            --pink-color: #ec4899;
            --ink: #1e1b3a;
            --bg-body: #f6f4ff;
        }
        [data-theme="dark"] {
            --ink: #e5e3ff;
            --bg-body: #12102080;
        }
        * { scroll-behavior: smooth; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(160deg, #f5f3ff 0%, #fdf2f8 45%, #fff7ed 100%);
            color: var(--ink);
            transition: background .35s ease, color .35s ease;
        }
        body[data-theme="dark"] {
            background: linear-gradient(160deg, #16132b 0%, #1c1435 45%, #201229 100%);
            color: #ece9ff;
        }
        body[data-theme="dark"] .navbar,
        body[data-theme="dark"] .stats-card,
        body[data-theme="dark"] .card-custom,
        body[data-theme="dark"] .review-card,
        body[data-theme="dark"] .info-box,
        body[data-theme="dark"] .accordion-item {
            background: #1f1a38 !important;
            border-color: #33294f !important;
            color: #ece9ff;
        }
        body[data-theme="dark"] .text-muted { color: #b7aee0 !important; }
        body[data-theme="dark"] .bg-light { background: #191331 !important; }
        body[data-theme="dark"] .book-cover { background: #241d43; }

        /* Navbar */
        .navbar {
            background: linear-gradient(90deg, #4c1d95 0%, #7c3aed 55%, #a21caf 100%);
            box-shadow: 0 4px 20px rgba(124,58,237,0.25);
        }
        .navbar-brand span.d-block { color: #ffffff !important; }
        .navbar-brand .text-muted { color: #e9d5ff !important; }
        .navbar-brand i { color: #fcd34d !important; }
        .nav-link { font-weight: 600; color: #ede9fe !important; transition: 0.2s; }
        .nav-link:hover, .nav-link.active { color: #fcd34d !important; }
        #themeToggle {
            border: 1px solid rgba(255,255,255,0.5);
            color: #fff;
            background: rgba(255,255,255,0.12);
            border-radius: 50px;
            width: 40px; height: 40px;
        }
        #themeToggle:hover { background: rgba(255,255,255,0.25); }

        /* Hero Section */
        .hero-section {
            position: relative;
            color: #0f172a;
            padding: 80px 0;
            min-height: 520px;
            border-bottom: 1px solid #e2e8f0;
            overflow: hidden;
            display: flex;
            align-items: center;
            background: linear-gradient(135deg, #ddd6fe, #fbcfe8);
        }
        .hero-bg { position: absolute; top:0; left:0; width:100%; height:100%; object-fit: cover; object-position: center; z-index: 1; }
        .hero-overlay {
            position: absolute; top:0; left:0; width:100%; height:100%;
            background: linear-gradient(135deg, rgba(124,58,237,0.55) 0%, rgba(236,72,153,0.40) 100%);
            z-index: 2;
        }
        .hero-section .container { position: relative; z-index: 3; width: 100%; }
        .hero-title { font-weight: 800; font-size: 2.8rem; color: #ffffff; letter-spacing: -0.5px; text-shadow: 0 2px 16px rgba(0,0,0,0.35); }
        .hero-section p.lead { color: #f5f3ff !important; }

        .floating-box { animation: floatAnim 3s ease-in-out infinite; background: rgba(255,255,255,0.95); backdrop-filter: blur(8px); border: 1px solid rgba(255,255,255,0.8); }
        @keyframes floatAnim { 0% { transform: translateY(0px);} 50% { transform: translateY(-10px);} 100% { transform: translateY(0px);} }

        /* Stats Card */
        .stats-card { background: #fff; border-radius: 14px; border: 1px solid #ede9fe; padding: 20px; box-shadow: 0 6px 18px -6px rgba(124,58,237,0.15); transition: 0.3s; }
        .stats-card:hover { transform: translateY(-4px); box-shadow: 0 14px 24px -8px rgba(124,58,237,0.25); }
        .stat-icon { width: 56px; height: 56px; display:flex; align-items:center; justify-content:center; border-radius: 50%; }

        .section-alt-1 { background: linear-gradient(180deg, #faf5ff, #fdf2f8); }
        .section-alt-2 { background: linear-gradient(180deg, #fff7ed, #fef9c3); }

        /* Book Card */
        .card-custom { background: #fff; border: 1px solid #ede9fe; border-radius: 14px; transition: 0.2s; border-top: 4px solid var(--primary-color); }
        .card-custom:hover { box-shadow: 0 14px 24px -8px rgba(124,58,237,0.25); transform: translateY(-4px); }
        .book-cover { width: 100%; height: 210px; background: #f3f0ff; border-radius: 10px; overflow: hidden; display: flex; align-items: center; justify-content: center; }
        .book-cover img { width: 100%; height: 100%; object-fit: cover; }
        .badge-stok-terbatas { background: #fee2e2; color: #b91c1c; }
        .badge-stok-habis { background:#f1f5f9; color:#64748b; }

        .review-card { background: #fff; border-radius: 14px; border: 1px solid #ede9fe; padding: 20px; box-shadow: 0 4px 10px rgba(124,58,237,0.08); height: 100%; }

        .info-box { background:#fff; border:1px solid #ede9fe; border-radius: 16px; }

        /* Floating action buttons */
        .fab { position: fixed; right: 22px; width: 54px; height: 54px; border-radius: 50%; display:flex; align-items:center; justify-content:center; color:#fff; font-size: 1.3rem; box-shadow: 0 8px 20px rgba(0,0,0,0.25); z-index: 999; text-decoration:none; transition: .2s; }
        .fab:hover { transform: translateY(-3px); color:#fff; }
        #btnTop { bottom: 22px; background: linear-gradient(135deg, var(--primary-color), var(--pink-color)); border:none; display:none; }
        #btnWA { bottom: 90px; background: #25D366; }

        /* Newsletter */
        .newsletter-box { background: linear-gradient(120deg, #7c3aed, #ec4899); border-radius: 20px; color: #fff; }

        /* Footer */
        footer { background: linear-gradient(135deg, #1e1b3a 0%, #3b0764 100%); color: #cbd5e1; padding: 50px 0 20px 0; }
        footer h5 { color: white; font-weight: 700; margin-bottom: 15px; }
        footer ul li a { color: #c4b5fd; text-decoration: none; transition: 0.2s; }
        footer ul li a:hover { color: #fcd34d; text-decoration: underline; }

        .btn-primary { background: linear-gradient(135deg, var(--primary-color), var(--pink-color)); border: none; }
        .btn-primary:hover { background: linear-gradient(135deg, var(--primary-dark), var(--pink-color)); }
        .btn-outline-dark { border-color:#fff; color:#fff; }
        .btn-outline-dark:hover { background:#fff; color: var(--primary-dark); }

        .accordion-button:not(.collapsed) { background: #f3e8ff; color: var(--primary-dark); }
        .accordion-button:focus { box-shadow: none; }
    </style>
</head>
<body data-theme="light">

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="#beranda">
                <i class="fa-solid fa-book-open-reader fa-lg"></i>
                <div>
                    <span class="d-block fs-6 lh-1">PERPUSTAKAAN</span>
                    <span class="fs-7" style="font-size: 11px;">SMP N 2 SANDEN</span>
                </div>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav align-items-center gap-3">
                    <li><a href="#beranda" class="nav-link active">Beranda</a></li>
                    <li><a href="#katalog" class="nav-link">Katalog</a></li>
                    <li><a href="#pengumuman" class="nav-link">Pengumuman</a></li>
                    <li><a href="#panduan" class="nav-link">Panduan</a></li>
                    <li><a href="#faq" class="nav-link">FAQ</a></li>
                    <li><a href="#ulasan" class="nav-link">Ulasan</a></li>
                    <li><a href="#statistik" class="nav-link">Statistik</a></li>
                    <li><a href="#bantuan" class="nav-link">Bantuan</a></li>
                    <li>
                        <button id="themeToggle" title="Ganti Mode Terang/Gelap">
                            <i class="fa-solid fa-moon" id="themeIcon"></i>
                        </button>
                    </li>
                    <li>
                        <a href="login.php" class="btn btn-primary px-4 rounded-pill fw-bold shadow-sm">
                            <i class="fa-solid fa-right-to-bracket"></i> MASUK SISTEM
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- HERO SECTION -->
    <section id="beranda" class="hero-section">
        <?php if ($hero_image_exists): ?>
            <img src="<?= htmlspecialchars($hero_image) ?>" alt="Background Sekolah" class="hero-bg"
                 onerror="this.style.display='none';">
        <?php else: ?>
            <script>console.warn('Gambar hero tidak ditemukan di path: <?= htmlspecialchars($hero_image) ?>. Pastikan file ada di folder gambar/ dan nama/ekstensi sesuai (case-sensitive di server Linux).');</script>
        <?php endif; ?>
        <div class="hero-overlay"></div>

        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <span class="badge bg-white bg-opacity-25 text-white px-3 py-2 rounded-pill mb-3 fw-semibold border border-white border-opacity-50 shadow-sm">
                        <i class="fa-solid fa-school me-1"></i> Official Digital Library SMP N 2 Sanden
                    </span>
                    <h1 class="hero-title mb-3">Jelajahi Dunia Pengetahuan Tanpa Batas di Ujung Jari Anda.</h1>
                    <p class="mb-4 lead fs-6 fw-medium">
                        Temukan ribuan jendela dunia melalui koleksi buku pilihan, nikmati kemudahan peminjaman secara transparan, dan tingkatkan prestasi belajarmu bersama perpustakaan digital interaktif kami.
                    </p>
                    <div class="d-flex gap-3 flex-wrap">
                        <a href="#katalog" class="btn btn-primary btn-lg px-4 rounded-pill fw-bold shadow">
                            <i class="fa-solid fa-compass me-2"></i> Jelajahi Koleksi Buku
                        </a>
                        <a href="#pengumuman" class="btn btn-outline-dark btn-lg px-4 rounded-pill fw-bold">
                            <i class="fa-solid fa-bullhorn me-2"></i> Info Terbaru
                        </a>
                    </div>
                </div>
                <div class="col-lg-5 text-center mt-4 mt-lg-0">
                    <div class="p-5 rounded-4 shadow-lg floating-box d-inline-block border">
                        <div class="text-primary mb-3">
                            <i class="fa-solid fa-book-bookmark fa-4x"></i>
                        </div>
                        <h4 class="fw-bold text-dark mb-1">Literasi Digital</h4>
                        <p class="text-muted small mb-3">Membangun Generasi Cerdas & Berkarakter</p>
                        <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill fw-semibold">
                            <i class="fa-solid fa-circle-dot me-1"></i> Sistem Online 24/7
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- STATISTIK REAL-TIME -->
    <div class="container" style="margin-top: -35px; position: relative; z-index: 10;">
        <div class="row g-3">
            <div class="col-md-3">
                <div class="stats-card d-flex align-items-center gap-3">
                    <div class="stat-icon bg-primary bg-opacity-10 text-primary"><i class="fa-solid fa-book fa-lg"></i></div>
                    <div>
                        <h3 class="fw-bold mb-0 counter" data-target="<?= (int)$total_buku ?>">0</h3>
                        <span class="text-muted small">Total Buku</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card d-flex align-items-center gap-3">
                    <div class="stat-icon bg-success bg-opacity-10 text-success"><i class="fa-solid fa-users fa-lg"></i></div>
                    <div>
                        <h3 class="fw-bold mb-0 counter" data-target="<?= (int)$total_anggota ?>">0</h3>
                        <span class="text-muted small">Total Anggota</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card d-flex align-items-center gap-3">
                    <div class="stat-icon bg-warning bg-opacity-10 text-warning"><i class="fa-solid fa-book-open fa-lg"></i></div>
                    <div>
                        <h3 class="fw-bold mb-0 counter" data-target="<?= (int)$sedang_pinjam ?>">0</h3>
                        <span class="text-muted small">Sedang Dipinjam</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card d-flex align-items-center gap-3">
                    <div class="stat-icon bg-info bg-opacity-10 text-info"><i class="fa-solid fa-circle-check fa-lg"></i></div>
                    <div>
                        <h3 class="fw-bold mb-0 counter" data-target="<?= (int)$sudah_kembali ?>">0</h3>
                        <span class="text-muted small">Sudah Dikembalikan</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- TENTANG PERPUSTAKAAN -->
    <section id="tentang" class="py-5 section-alt-1">
        <div class="container py-4">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <h2 class="fw-bold mb-3">Mengenal Pusat Literasi SMP N 2 Sanden</h2>
                    <p class="text-muted">
                        Perpustakaan SMP N 2 Sanden bertransformasi menjadi ruang digital interaktif untuk mencetak generasi unggul yang gemar membaca dan berpikir kritis sesuai Kurikulum Merdeka.
                    </p>
                    <p class="text-muted">
                        Sistem ini dirancang untuk memudahkan siswa maupun guru dalam mengecek ketersediaan buku secara langsung, cepat, dan transparan dari mana saja.
                    </p>
                    <div class="d-flex align-items-center gap-2 fw-bold" style="color: var(--secondary-color);">
                        <i class="fa-solid fa-boxes-stacked fa-lg"></i>
                        Total Stok Buku Tersedia: <span class="text-dark"><?= (int)$total_stok ?></span> eksemplar
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="p-4 info-box rounded-4 shadow-sm">
                        <h5 class="fw-bold mb-3"><i class="fa-solid fa-star text-warning"></i> Keunggulan Layanan Kami</h5>
                        <ul class="list-unstyled mb-0 d-flex flex-column gap-3">
                            <li><i class="fa-solid fa-check text-success me-2"></i> <strong>Koleksi Terlengkap:</strong> Buku pelajaran, ensiklopedia, hingga novel fiksi.</li>
                            <li><i class="fa-solid fa-check text-success me-2"></i> <strong>Pencarian Pintar:</strong> Temukan judul buku incaran dalam hitungan detik.</li>
                            <li><i class="fa-solid fa-check text-success me-2"></i> <strong>Akses 24 Jam:</strong> Pantau riwayat peminjaman dan ulasan kapan pun Anda butuhkan.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- KATALOG BUKU -->
    <section id="katalog" class="py-5 border-top border-bottom">
        <div class="container">
            <div class="row align-items-center mb-4">
                <div class="col-md-6">
                    <h2 class="fw-bold mb-1">Katalog Buku Perpustakaan</h2>
                    <p class="text-muted mb-0">Menampilkan seluruh koleksi buku database (Total: <?= $jumlah_hasil_katalog ?> Buku)</p>
                </div>
                <div class="col-md-6 mt-3 mt-md-0">
                    <form action="index.php" method="GET" class="input-group shadow-sm" id="formCari">
                        <input type="text" name="cari" class="form-control form-control-lg border-0" placeholder="Cari judul buku atau pengarang..." value="<?= htmlspecialchars($keyword) ?>">
                        <button class="btn btn-primary px-4 fw-bold" type="submit"><i class="fa-solid fa-magnifying-glass"></i> Cari</button>
                        <?php if (!empty($keyword)): ?>
                            <a href="index.php#katalog" class="btn btn-outline-secondary d-flex align-items-center" title="Reset"><i class="fa-solid fa-rotate-left"></i></a>
                        <?php endif; ?>
                    </form>
                </div>
            </div>

            <div class="row g-4">
                <?php if ($jumlah_hasil_katalog > 0): ?>
                    <?php while ($b = mysqli_fetch_assoc($q_katalog)): ?>
                        <div class="col-md-3">
                            <div class="card card-custom h-100 p-3">
                                <div class="book-cover mb-3">
                                    <?php
                                    $cover = $b['id_cover'] ?? '';
                                    $path = "";
                                    if (!empty($cover)) {
                                        if (file_exists(__DIR__ . "/assets/cover/" . $cover)) $path = "assets/cover/" . $cover;
                                        elseif (file_exists(__DIR__ . "/admin/uploads/" . $cover)) $path = "admin/uploads/" . $cover;
                                        elseif (file_exists(__DIR__ . "/gambar/" . $cover)) $path = "gambar/" . $cover;
                                    }
                                    ?>
                                    <?php if (!empty($path)): ?>
                                        <img src="<?= htmlspecialchars($path) ?>" alt="Cover" loading="lazy">
                                    <?php else: ?>
                                        <div class="text-muted text-center"><i class="fa-solid fa-book fa-2x mb-1"></i><div class="small">No Cover</div></div>
                                    <?php endif; ?>
                                </div>
                                <h5 class="fw-bold fs-6 text-truncate mb-1" title="<?= htmlspecialchars($b['judul_buku']) ?>"><?= htmlspecialchars($b['judul_buku']) ?></h5>
                                <p class="text-muted small mb-3"><?= htmlspecialchars($b['pengarang']) ?></p>
                                <div class="mt-auto d-flex justify-content-between align-items-center">
                                    <?php if ((int)$b['stok'] <= 0): ?>
                                        <span class="badge badge-stok-habis px-2 py-1 small">Stok Habis</span>
                                        <button class="btn btn-sm btn-outline-secondary rounded-pill px-3" disabled>Pinjam</button>
                                    <?php elseif ((int)$b['stok'] <= 2): ?>
                                        <span class="badge badge-stok-terbatas px-2 py-1 small">Stok: <?= $b['stok'] ?> (Terbatas)</span>
                                        <a href="login.php" class="btn btn-sm btn-outline-primary rounded-pill px-3">Pinjam</a>
                                    <?php else: ?>
                                        <span class="badge bg-success bg-opacity-10 text-success px-2 py-1 small">Stok: <?= $b['stok'] ?></span>
                                        <a href="login.php" class="btn btn-sm btn-outline-primary rounded-pill px-3">Pinjam</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="col-12 text-center py-5">
                        <div class="text-muted mb-2"><i class="fa-solid fa-face-sad-tear fa-3x"></i></div>
                        <h5 class="fw-bold">Buku tidak ditemukan</h5>
                        <p class="text-muted small">Coba gunakan kata kunci pencarian yang lain.</p>
                        <a href="index.php#katalog" class="btn btn-sm btn-primary rounded-pill mt-2">Tampilkan Semua Buku</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- PENGUMUMAN -->
    <section id="pengumuman" class="py-5 section-alt-2">
        <div class="container py-3">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Pengumuman & Agenda Literasi</h2>
                <p class="text-muted">Informasi terbaru seputar kegiatan perpustakaan dan kunjungan buku.</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="p-4 info-box rounded-4 shadow-sm h-100">
                        <span class="badge bg-primary bg-opacity-10 text-primary mb-3 px-3 py-1 rounded-pill">Terbaru</span>
                        <h5 class="fw-bold mb-2">Jadwal Pengembalian Buku Semester Genap</h5>
                        <p class="text-muted small mb-3">Seluruh siswa kelas VII dan VIII diwajibkan mengembalikan buku paket pelajaran paling lambat akhir minggu depan.</p>
                        <small class="text-secondary"><i class="fa-solid fa-calendar-days me-1"></i> 27 Agustus 2026</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-4 info-box rounded-4 shadow-sm h-100">
                        <span class="badge bg-success bg-opacity-10 text-success mb-3 px-3 py-1 rounded-pill">Event</span>
                        <h5 class="fw-bold mb-2">Pemilihan Duta Baca SMP N 2 Sanden</h5>
                        <p class="text-muted small mb-3">Ayo daftarkan dirimu dan tunjukkan kecintaanmu pada buku dalam ajang pemilihan Duta Baca tingkat sekolah tahun ini.</p>
                        <small class="text-secondary"><i class="fa-solid fa-calendar-days me-1"></i> 05 September 2026</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-4 info-box rounded-4 shadow-sm h-100">
                        <span class="badge bg-warning bg-opacity-10 text-warning mb-3 px-3 py-1 rounded-pill">Fasilitas</span>
                        <h5 class="fw-bold mb-2">Penambahan Koleksi Buku Novel & Fiksi</h5>
                        <p class="text-muted small mb-3">Perpustakaan baru saja menerima puluhan judul novel fiksi remaja populer yang sudah bisa dibooking secara online.</p>
                        <small class="text-secondary"><i class="fa-solid fa-calendar-days me-1"></i> 10 September 2026</small>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- PANDUAN PENGGUNAAN -->
    <section id="panduan" class="py-5 border-top">
        <div class="container py-4">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Panduan Peminjaman Buku</h2>
                <p class="text-muted">Langkah mudah meminjam buku secara digital bagi siswa.</p>
            </div>
            <div class="row g-4 text-center">
                <div class="col-md-3">
                    <div class="p-4 info-box rounded-4 shadow-sm h-100">
                        <div class="display-6 fw-bold text-primary mb-3">01</div>
                        <h5 class="fw-bold">Login Anggota</h5>
                        <p class="text-muted small mb-0">Masuk menggunakan akun siswa yang telah terdaftar di sistem.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="p-4 info-box rounded-4 shadow-sm h-100">
                        <div class="display-6 fw-bold text-primary mb-3">02</div>
                        <h5 class="fw-bold">Cari Buku</h5>
                        <p class="text-muted small mb-0">Temukan buku favorit melalui fitur pencarian katalog interaktif.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="p-4 info-box rounded-4 shadow-sm h-100">
                        <div class="display-6 fw-bold text-primary mb-3">03</div>
                        <h5 class="fw-bold">Pinjam / Booking</h5>
                        <p class="text-muted small mb-0">Lakukan peminjaman online agar buku langsung disiapkan petugas.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="p-4 info-box rounded-4 shadow-sm h-100">
                        <div class="display-6 fw-bold text-primary mb-3">04</div>
                        <h5 class="fw-bold">Ambil & Baca</h5>
                        <p class="text-muted small mb-0">Ambil buku ke perpustakaan sekolah dan nikmati bacaannya.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section id="faq" class="py-5 section-alt-1 border-top">
        <div class="container py-3">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Pertanyaan yang Sering Diajukan</h2>
                <p class="text-muted">Belum menemukan jawaban? Hubungi kami melalui kontak yang tertera di footer.</p>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="accordion" id="accordionFaq">
                        <div class="accordion-item rounded-3 mb-2 overflow-hidden">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                    Berapa lama batas waktu peminjaman buku?
                                </button>
                            </h2>
                            <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#accordionFaq">
                                <div class="accordion-body text-muted">Batas peminjaman standar adalah 7 hari kerja dan dapat diperpanjang satu kali melalui petugas perpustakaan.</div>
                            </div>
                        </div>
                        <div class="accordion-item rounded-3 mb-2 overflow-hidden">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                    Apakah siswa bisa booking buku secara online?
                                </button>
                            </h2>
                            <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#accordionFaq">
                                <div class="accordion-body text-muted">Bisa. Login ke sistem, cari judul yang diinginkan, lalu klik tombol "Pinjam" pada buku yang tersedia.</div>
                            </div>
                        </div>
                        <div class="accordion-item rounded-3 mb-2 overflow-hidden">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                    Bagaimana jika buku yang dicari berstatus "Stok Terbatas"?
                                </button>
                            </h2>
                            <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#accordionFaq">
                                <div class="accordion-body text-muted">Segera lakukan booking karena stok tersisa sedikit dan bisa dipinjam siswa lain kapan saja.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ULASAN -->
    <section id="ulasan" class="py-5 border-top">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Ulasan & Komentar Pembaca</h2>
                <p class="text-muted">Pendapat jujur dari para siswa yang aktif menggunakan layanan perpustakaan.</p>
            </div>

            <?php
            // Susun data ulasan (dari database jika ada, jika tidak pakai data contoh) tanpa mengubah query asli
            $daftar_ulasan = [];
            if ($q_ulasan && mysqli_num_rows($q_ulasan) > 0) {
                while ($u = mysqli_fetch_assoc($q_ulasan)) { $daftar_ulasan[] = $u; }
            } else {
                $daftar_ulasan = [
                    ['rating' => 5, 'ulasan' => 'Sangat mudah mencari buku pelajaran maupun novel untuk dibaca saat jam istirahat!', 'nama_lengkap' => 'Hilya Annajma', 'kelas' => 'Siswa Kelas IX'],
                    ['rating' => 5, 'ulasan' => 'Fitur booking online-nya keren banget, jadi buku tidak kehabisan dipinjam orang lain.', 'nama_lengkap' => 'Rizki Ramadhan', 'kelas' => 'Siswa Kelas VIII'],
                    ['rating' => 4, 'ulasan' => 'Tampilannya modern dan sangat nyaman diakses lewat HP maupun komputer sekolah.', 'nama_lengkap' => 'Siti Fatimah', 'kelas' => 'Siswa Kelas IX'],
                ];
            }
            ?>
            <div id="carouselUlasan" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php $chunk = array_chunk($daftar_ulasan, 3); foreach ($chunk as $i => $group): ?>
                        <div class="carousel-item <?= $i === 0 ? 'active' : '' ?>">
                            <div class="row g-4">
                                <?php foreach ($group as $u): ?>
                                    <div class="col-md-4">
                                        <div class="review-card">
                                            <div class="d-flex text-warning mb-2">
                                                <?php
                                                $rating = $u['rating'] ?? 5;
                                                for ($s = 1; $s <= 5; $s++) {
                                                    echo $s <= $rating ? '<i class="fa-solid fa-star"></i>' : '<i class="fa-regular fa-star"></i>';
                                                }
                                                ?>
                                            </div>
                                            <p class="text-muted fst-italic mb-3">"<?= htmlspecialchars($u['ulasan'] ?? 'Sangat membantu proses peminjaman buku.') ?>"</p>
                                            <h6 class="fw-bold mb-0 text-dark"><?= htmlspecialchars($u['nama_lengkap']) ?></h6>
                                            <small class="text-muted"><?= htmlspecialchars($u['kelas'] ?? 'Siswa SMP N 2 Sanden') ?></small>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php if (count($chunk) > 1): ?>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselUlasan" data-bs-slide="prev" style="width:5%">
                        <span class="carousel-control-prev-icon bg-primary rounded-circle p-2"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselUlasan" data-bs-slide="next" style="width:5%">
                        <span class="carousel-control-next-icon bg-primary rounded-circle p-2"></span>
                    </button>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- STATISTIK GRAFIK -->
    <section id="statistik" class="py-5 section-alt-2 border-top">
        <div class="container py-3">
            <div class="row align-items-center">
                <div class="col-lg-5 mb-4 mb-lg-0">
                    <h2 class="fw-bold mb-3">Statistik Aktivitas Literasi</h2>
                    <p class="text-muted">
                        Grafik di samping menunjukkan perbandingan langsung antara total ketersediaan koleksi buku dengan tingkat peminjaman aktif oleh para siswa di SMP N 2 Sanden secara real-time.
                    </p>
                    <div class="d-flex align-items-center gap-2 text-success fw-bold">
                        <i class="fa-solid fa-chart-line fa-lg"></i> Sistem Terintegrasi Otomatis
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="p-4 info-box rounded-4 shadow-sm">
                        <canvas id="grafikStatistik" height="140"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- JAM LAYANAN & LOKASI -->
    <section class="py-5">
        <div class="container">
            <div class="newsletter-box p-5 shadow-lg">
                <div class="row align-items-center g-4">
                    <div class="col-lg-5 text-center text-lg-start">
                        <h3 class="fw-bold mb-2"><i class="fa-solid fa-clock me-2"></i>Jam Layanan Perpustakaan</h3>
                        <p class="mb-0 opacity-75">Kunjungi kami langsung di ruang perpustakaan sekolah pada jam berikut, atau akses katalog online kapan saja lewat sistem ini.</p>
                    </div>
                    <div class="col-lg-7">
                        <div class="row g-3 text-center">
                            <div class="col-6 col-md-3">
                                <div class="p-3 rounded-4" style="background: rgba(255,255,255,0.15);">
                                    <div class="fw-bold">Senin - Kamis</div>
                                    <div class="small opacity-75">07.00 - 15.00</div>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="p-3 rounded-4" style="background: rgba(255,255,255,0.15);">
                                    <div class="fw-bold">Jumat</div>
                                    <div class="small opacity-75">07.00 - 11.00</div>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="p-3 rounded-4" style="background: rgba(255,255,255,0.15);">
                                    <div class="fw-bold">Sabtu</div>
                                    <div class="small opacity-75">Tutup</div>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="p-3 rounded-4" style="background: rgba(255,255,255,0.15);">
                                    <div class="fw-bold">Katalog Online</div>
                                    <div class="small opacity-75">24 Jam</div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3 text-center text-lg-start small opacity-75">
                            <i class="fa-solid fa-location-dot me-1"></i> Jl. Sanden, Bantul, D.I. Yogyakarta
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- BANTUAN / HELP CENTER -->
    <section id="bantuan" class="py-5 section-alt-1 border-top">
        <div class="container py-4">
            <div class="text-center mb-5">
                <h2 class="fw-bold"><i class="fa-solid fa-circle-question me-2 text-primary"></i>Pusat Bantuan</h2>
                <p class="text-muted">Butuh bantuan seputar sistem perpustakaan? Pilih topik atau hubungi kami langsung.</p>
                <a href="<?= htmlspecialchars($wa_link) ?>" target="_blank" rel="noopener" class="btn btn-success rounded-pill px-4 mt-2">
                    <i class="fa-brands fa-whatsapp me-2"></i> Chat via WhatsApp
                </a>
            </div>
            <div class="row g-4 mb-4">
                <div class="col-md-4">
                    <div class="p-4 info-box rounded-4 shadow-sm h-100 text-center">
                        <div class="stat-icon bg-primary bg-opacity-10 text-primary mx-auto mb-3"><i class="fa-solid fa-key fa-lg"></i></div>
                        <h5 class="fw-bold mb-2">Kendala Login</h5>
                        <p class="text-muted small mb-0">Lupa username/password akun anggota? Hubungi petugas perpustakaan untuk reset akun.</p>
                        <a href="<?= htmlspecialchars($wa_link) ?>" target="_blank" rel="noopener" class="small d-inline-block mt-2 text-success fw-semibold"><i class="fa-brands fa-whatsapp me-1"></i>Chat WA</a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-4 info-box rounded-4 shadow-sm h-100 text-center">
                        <div class="stat-icon bg-success bg-opacity-10 text-success mx-auto mb-3"><i class="fa-solid fa-book-bookmark fa-lg"></i></div>
                        <h5 class="fw-bold mb-2">Kendala Peminjaman</h5>
                        <p class="text-muted small mb-0">Buku tidak bisa dibooking atau status tidak sesuai? Lihat kembali <a href="#panduan">Panduan Peminjaman</a> atau hubungi kami.</p>
                        <a href="<?= htmlspecialchars($wa_link) ?>" target="_blank" rel="noopener" class="small d-inline-block mt-2 text-success fw-semibold"><i class="fa-brands fa-whatsapp me-1"></i>Chat WA</a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-4 info-box rounded-4 shadow-sm h-100 text-center">
                        <div class="stat-icon bg-warning bg-opacity-10 text-warning mx-auto mb-3"><i class="fa-solid fa-circle-info fa-lg"></i></div>
                        <h5 class="fw-bold mb-2">Pertanyaan Umum</h5>
                        <p class="text-muted small mb-0">Cek dulu jawaban paling sering ditanyakan di bagian <a href="#faq">FAQ</a> sebelum menghubungi kami.</p>
                    </div>
                </div>
            </div>
            <div class="p-4 p-md-5 info-box rounded-4 shadow-sm">
                <div class="text-center mb-4">
                    <h5 class="fw-bold mb-2">Masih Perlu Bantuan Lebih Lanjut?</h5>
                    <p class="text-muted mb-0">Kirim pesan singkat, petugas perpustakaan akan menindaklanjuti pesanmu.</p>
                </div>
                <?php if (!empty($bantuan_error)): ?>
                    <div class="row justify-content-center">
                        <div class="col-md-10">
                            <div class="alert alert-danger rounded-3"><i class="fa-solid fa-triangle-exclamation me-2"></i><?= htmlspecialchars($bantuan_error) ?></div>
                        </div>
                    </div>
                <?php endif; ?>
                <form method="POST" action="index.php#bantuan" class="row g-3 justify-content-center">
                    <div class="col-md-5">
                        <label class="form-label small fw-semibold">Nama</label>
                        <input type="text" name="nama_bantuan" class="form-control" placeholder="Nama kamu" required value="<?= htmlspecialchars($_POST['nama_bantuan'] ?? '') ?>">
                    </div>
                    <div class="col-md-5">
                        <label class="form-label small fw-semibold">Email</label>
                        <input type="email" name="email_bantuan" class="form-control" placeholder="email@contoh.com" required value="<?= htmlspecialchars($_POST['email_bantuan'] ?? '') ?>">
                    </div>
                    <div class="col-md-10">
                        <label class="form-label small fw-semibold">Pesan</label>
                        <textarea name="pesan_bantuan" class="form-control" rows="3" placeholder="Tuliskan kendala atau pertanyaanmu di sini..." required><?= htmlspecialchars($_POST['pesan_bantuan'] ?? '') ?></textarea>
                    </div>
                    <div class="col-md-10 text-center">
                        <button type="submit" name="kirim_bantuan" class="btn btn-primary rounded-pill px-5 mt-2">
                            <i class="fa-solid fa-paper-plane me-1"></i> Kirim Pesan
                        </button>
                        <a href="#faq" class="btn btn-outline-primary rounded-pill px-4 mt-2 ms-2">
                            <i class="fa-solid fa-circle-question me-1"></i> Lihat FAQ
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer>
        <div class="container">
            <div class="row g-4 mb-4">
                <div class="col-md-5">
                    <h5 class="text-white mb-3"><i class="fa-solid fa-book-open-reader me-2" style="color:#fcd34d;"></i> Perpustakaan SMP N 2 Sanden</h5>
                    <p class="small text-secondary mb-3">Membangun budaya literasi dan kecintaan membaca melalui pengelolaan perpustakaan digital modern, cepat, dan transparan.</p>
                    <div class="d-flex gap-3 text-white">
                        <a href="#" class="text-secondary fs-5"><i class="fa-brands fa-facebook"></i></a>
                        <a href="#" class="text-secondary fs-5"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#" class="text-secondary fs-5"><i class="fa-brands fa-youtube"></i></a>
                    </div>
                </div>
                <div class="col-md-3">
                    <h5 class="text-white mb-3">Navigasi Cepat</h5>
                    <ul class="list-unstyled small d-flex flex-column gap-2">
                        <li><a href="#beranda"><i class="fa-solid fa-chevron-right fa-xs me-1" style="color:#fcd34d;"></i> Beranda Utama</a></li>
                        <li><a href="#tentang"><i class="fa-solid fa-chevron-right fa-xs me-1" style="color:#fcd34d;"></i> Tentang Kami</a></li>
                        <li><a href="#katalog"><i class="fa-solid fa-chevron-right fa-xs me-1" style="color:#fcd34d;"></i> Katalog Buku</a></li>
                        <li><a href="#pengumuman"><i class="fa-solid fa-chevron-right fa-xs me-1" style="color:#fcd34d;"></i> Pengumuman</a></li>
                        <li><a href="#panduan"><i class="fa-solid fa-chevron-right fa-xs me-1" style="color:#fcd34d;"></i> Panduan Peminjaman</a></li>
                        <li><a href="#faq"><i class="fa-solid fa-chevron-right fa-xs me-1" style="color:#fcd34d;"></i> FAQ</a></li>
                        <li><a href="#bantuan"><i class="fa-solid fa-chevron-right fa-xs me-1" style="color:#fcd34d;"></i> Bantuan</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5 class="text-white mb-3">Kontak & Lokasi</h5>
                    <p class="small text-secondary mb-2"><i class="fa-solid fa-location-dot me-2" style="color:#fcd34d;"></i> Jl. Samas, Srigading,Sanden, Bantul, D.I. Yogyakarta</p>
                    <p class="small text-secondary mb-2"><i class="fa-solid fa-envelope me-2" style="color:#fcd34d;"></i> perpus@smpn2sanden.sch.id</p>
                    <p class="small text-secondary mb-0"><i class="fa-solid fa-clock me-2" style="color:#fcd34d;"></i> Jam Layanan: Senin - Kamis (07.00 - 15.00)  Jumat (07.00 - 11.00) </p>
                </div>
            </div>
            <hr class="border-secondary opacity-50 my-4">
            <div class="row align-items-center">
                <div class="col-md-6 small text-secondary">
                    <span>© 2026 Sistem Peminjaman Buku Perpustakaan SMP N 2 Sanden. All rights reserved by Yuanita Eka P · SMK N 1 SANDEN.</span>
                </div>
                <div class="col-md-6 text-md-end small text-secondary">
                    <span>Designed for UKK RPL 2026</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- [BARU] Tombol Mengambang: Chat WhatsApp -->
    <a href="<?= htmlspecialchars($wa_link) ?>" target="_blank" rel="noopener" class="fab" id="btnWA" title="Chat via WhatsApp">
        <i class="fa-brands fa-whatsapp"></i>
    </a>

    <!-- Tombol Mengambang: Kembali ke Atas -->
    <button class="fab" id="btnTop" title="Kembali ke atas"><i class="fa-solid fa-arrow-up"></i></button>

    <!-- Toast Notifikasi -->
    <div class="position-fixed bottom-0 start-50 translate-middle-x p-3" style="z-index: 1080;">
        <?php if (!empty($keyword)): ?>
        <div id="toastPencarian" class="toast align-items-center text-bg-primary border-0 mt-2" role="alert">
            <div class="d-flex">
                <div class="toast-body"><i class="fa-solid fa-magnifying-glass me-2"></i>Ditemukan <?= $jumlah_hasil_katalog ?> buku untuk "<?= htmlspecialchars($keyword) ?>"</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
        <?php endif; ?>
        <?php if ($bantuan_sukses): ?>
        <div id="toastBantuan" class="toast align-items-center text-bg-success border-0 mt-2" role="alert">
            <div class="d-flex">
                <div class="toast-body"><i class="fa-solid fa-circle-check me-2"></i>Pesan berhasil dikirim! Petugas akan segera menindaklanjuti.</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- Script Grafik Chart.js -->
    <script>
        const ctx = document.getElementById('grafikStatistik').getContext('2d');
        const grafikStatistik = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Total Buku', 'Total Anggota', 'Sedang Dipinjam', 'Sudah Dikembalikan'],
                datasets: [{
                    label: 'Jumlah Data',
                    data: [<?= (int)$total_buku ?>, <?= (int)$total_anggota ?>, <?= (int)$sedang_pinjam ?>, <?= (int)$sudah_kembali ?>],
                    backgroundColor: [
                        'rgba(124, 58, 237, 0.75)',
                        'rgba(16, 185, 129, 0.75)',
                        'rgba(245, 158, 11, 0.75)',
                        'rgba(236, 72, 153, 0.75)'
                    ],
                    borderColor: [
                        'rgb(124, 58, 237)',
                        'rgb(16, 185, 129)',
                        'rgb(245, 158, 11)',
                        'rgb(236, 72, 153)'
                    ],
                    borderWidth: 1,
                    borderRadius: 8
                }]
            },
            options: {
                scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } },
                plugins: { legend: { display: false } }
            }
        });

        // Animasi counter angka statistik
        document.querySelectorAll('.counter').forEach(el => {
            const target = parseInt(el.dataset.target, 10) || 0;
            let current = 0;
            const steps = 40;
            const increment = Math.max(target / steps, 1);
            const timer = setInterval(() => {
                current += increment;
                if (current >= target) { current = target; clearInterval(timer); }
                el.textContent = Math.floor(current);
            }, 25);
        });

        // Toggle Dark / Light Mode
        const body = document.body;
        const themeIcon = document.getElementById('themeIcon');
        const savedTheme = localStorage.getItem('perpus-theme') || 'light';
        body.setAttribute('data-theme', savedTheme);
        themeIcon.className = savedTheme === 'dark' ? 'fa-solid fa-sun' : 'fa-solid fa-moon';

        document.getElementById('themeToggle').addEventListener('click', () => {
            const current = body.getAttribute('data-theme');
            const next = current === 'dark' ? 'light' : 'dark';
            body.setAttribute('data-theme', next);
            localStorage.setItem('perpus-theme', next);
            themeIcon.className = next === 'dark' ? 'fa-solid fa-sun' : 'fa-solid fa-moon';
        });

        // Tombol Kembali ke Atas
        const btnTop = document.getElementById('btnTop');
        window.addEventListener('scroll', () => {
            btnTop.style.display = window.scrollY > 300 ? 'flex' : 'none';
            btnTop.style.alignItems = 'center';
            btnTop.style.justifyContent = 'center';
        });
        btnTop.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));

        // Tampilkan toast hasil pencarian otomatis jika ada keyword
        <?php if (!empty($keyword)): ?>
        const toastPencarian = new bootstrap.Toast(document.getElementById('toastPencarian'));
        toastPencarian.show();
        <?php endif; ?>

        // Tampilkan toast sukses kirim pesan bantuan
        <?php if ($bantuan_sukses): ?>
        const toastBantuan = new bootstrap.Toast(document.getElementById('toastBantuan'));
        toastBantuan.show();
        <?php endif; ?>
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>