<?php
session_start();
include "config/koneksi.php"; 

$error = "";
$sukses = false;
$redirect_to = "";
$nama_tampil = "";

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];
    $role = $_POST['role'];

    if ($role == 'admin') {
        $query = mysqli_query($conn, "SELECT * FROM admin WHERE username='$username'");
        if ($query && mysqli_num_rows($query) > 0) {
            $data = mysqli_fetch_assoc($query);
            if ($password == $data['password'] || password_verify($password, $data['password'])) {
                $_SESSION['status'] = "login";
                $_SESSION['id_admin'] = $data['id_admin'];
                $_SESSION['username'] = $data['username'];
                $_SESSION['nama'] = $data['nama_lengkap'];
                $_SESSION['role'] = "admin";
                $sukses = true;
                $redirect_to = "admin/dashboard.php";
                $nama_tampil = $data['nama_lengkap'];
            } else { $error = "Password admin salah!"; }
        } else { $error = "Username admin tidak ditemukan!"; }
    } elseif ($role == 'petugas') {
        $query = mysqli_query($conn, "SELECT * FROM petugas WHERE username='$username'");
        if ($query && mysqli_num_rows($query) > 0) {
            $data = mysqli_fetch_assoc($query);
            if ($password == $data['password'] || password_verify($password, $data['password'])) {
                $_SESSION['status'] = "login";
                $_SESSION['id_petugas'] = $data['id_petugas'];
                $_SESSION['username'] = $data['username'];
                $_SESSION['nama'] = $data['nama_petugas'];
                $_SESSION['role'] = "petugas";
                $sukses = true;
                $redirect_to = "petugas/dashboard.php";
                $nama_tampil = $data['nama_petugas'];
            } else { $error = "Password petugas salah!"; }
        } else { $error = "Username petugas tidak ditemukan!"; }
    } elseif ($role == 'anggota') {
        $query = mysqli_query($conn, "SELECT * FROM anggota WHERE nis='$username' OR nama_lengkap='$username'");
        if ($query && mysqli_num_rows($query) > 0) {
            $data = mysqli_fetch_assoc($query);
            if (isset($data['password']) && ($password == $data['password'] || password_verify($password, $data['password']))) {
                $_SESSION['status'] = "login";
                $_SESSION['id_anggota'] = $data['id_anggota'];
                $_SESSION['nama'] = $data['nama_lengkap'];
                $_SESSION['role'] = "anggota";
                $sukses = true;
                $redirect_to = "anggota/dashboard.php";
                $nama_tampil = $data['nama_lengkap'];
            } else { $error = "Password anggota salah!"; }
        } else { $error = "Nama lengkap tidak terdaftar!"; }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Perpustakaan Digital</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.3/dist/confetti.browser.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #0f172a;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow-x: hidden;
        }

        .video-bg {
            position: fixed;
            top: 50%; left: 50%;
            min-width: 100%; min-height: 100%;
            width: auto; height: auto;
            transform: translate(-50%, -50%);
            object-fit: cover;
            z-index: 0;
        }
        .video-overlay {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(15, 23, 42, 0.75);
            z-index: 1;
        }

        .login-card {
            position: relative;
            z-index: 2;
            background: #1e293b;
            width: 100%;
            max-width: 420px;
            border-radius: 20px;
            padding: 25px 30px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.5);
            color: #f8fafc;
            border: 1px solid rgba(255,255,255,0.1);
            margin: 20px 0;
        }

        /* 📺 Pengaturan Ukuran & Jarak Video di dalam Card */
        .card-video {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 12px;
            margin-top: 12px;
            margin-bottom: 12px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            display: block;
            background: #0f172a;
        }

        .role-tabs { display: flex; gap: 5px; background: #0f172a; padding: 5px; border-radius: 12px; margin-bottom: 15px; }
        .role-btn { flex: 1; background: none; border: none; color: #94a3b8; padding: 8px; font-size: 0.8rem; font-weight: 600; border-radius: 8px; cursor: pointer; transition: 0.3s; }
        .role-btn.active { background: linear-gradient(135deg, #7c3aed 0%, #a855f7 100%); color: #ffffff; }

        .form-control { background: #0f172a; border: 1px solid rgba(255,255,255,0.1); color: #fff; padding: 9px 15px; border-radius: 10px; font-size: 0.9rem; }
        .form-control:focus { background: #0f172a; color: #fff; border-color: #a855f7; box-shadow: none; }

        .btn-login { background: linear-gradient(135deg, #7c3aed 0%, #a855f7 100%); color: #ffffff; font-weight: 700; width: 100%; padding: 10px; border-radius: 10px; border: none; margin-top: 5px; transition: 0.3s; }
        .btn-login:hover { background: linear-gradient(135deg, #6d28d9 0%, #9333ea 100%); color: #ffffff; }

        .register-link { text-align: center; margin-top: 14px; font-size: 0.85rem; color: #94a3b8; display: none; }
        .register-link.show { display: block; }
        .register-link a { color: #c084fc; font-weight: 600; text-decoration: none; }
        .register-link a:hover { text-decoration: underline; }

        @keyframes shakeLucu {
            0%, 100% { transform: translateX(0) rotate(0deg); }
            20% { transform: translateX(-8px) rotate(-1deg); }
            40% { transform: translateX(8px) rotate(1deg); }
            60% { transform: translateX(-4px); }
            80% { transform: translateX(4px); }
        }
        .shake-lucu { animation: shakeLucu 0.5s ease-in-out; border-color: #ef4444 !important; }
        .swal2-lucu-gagal { border: 2px solid #ef4444 !important; }
        .swal2-lucu-sukses { border: 2px solid #a855f7 !important; }
    </style>
</head>
<body>

    <video class="video-bg" autoplay muted loop playsinline preload="auto">
        <source src="vidio/background.MP4.mp4" type="video/mp4">
        <source src="vidio/background.mp4" type="video/mp4">
    </video>
    <div class="video-overlay"></div>

    <div class="login-card" id="loginCard">
        <h4 class="text-center mb-0 fw-bold" style="font-size: 1.15rem;">PERPUSTAKAAN DIGITAL SMP N 2 SANDEN</h4>

        <!-- Video di bawah judul dengan jarak yang proporsional -->
        <video class="card-video" autoplay muted loop playsinline preload="auto" poster="">
            <source src="vidio/background.MP4.mp4" type="video/mp4">
            <source src="vidio/background.mp4" type="video/mp4">
            Browser Anda tidak mendukung video.
        </video>

        <p class="text-center text-muted mb-3" style="font-size: 0.8rem;">Silakan masuk sesuai hak akses</p>

        <?php if (!empty($error)) { ?>
            <div class="alert alert-danger py-2 mb-3" style="font-size: 0.82rem;"><?php echo $error; ?></div>
        <?php } ?>

        <form action="" method="POST">
            <input type="hidden" name="role" id="roleInput" value="anggota">

            <div class="role-tabs">
                <button type="button" class="role-btn active" id="tabAnggota" onclick="setRole('anggota', event)">Anggota</button>
                <button type="button" class="role-btn" id="tabPetugas" onclick="setRole('petugas', event)">Petugas</button>
                <button type="button" class="role-btn" id="tabAdmin" onclick="setRole('admin', event)">Admin</button>
            </div>

            <div class="mb-2">
                <label class="form-label mb-1" id="labelUsername" style="font-size: 0.82rem;"> Username Anggota </label>
                <input type="text" name="username" id="inputUsername" class="form-control" required autocomplete="off">
            </div>

            <div class="mb-3">
                <label class="form-label mb-1" style="font-size: 0.82rem;">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <button type="submit" name="login" class="btn-login">Masuk Sistem</button>
        </form>

        <div class="register-link show" id="registerLink">
            Belum punya akun? <a href="register.php">Daftar di sini</a>
        </div>
    </div>

    <script>
        function setRole(role, e) {
            e.preventDefault();
            document.getElementById('roleInput').value = role;
            document.querySelectorAll('.role-btn').forEach(btn => btn.classList.remove('active'));
            document.getElementById('tab' + role.charAt(0).toUpperCase() + role.slice(1)).classList.add('active');

            const label = document.getElementById('labelUsername');
            if(role === 'anggota') label.innerText = "Username Anggota";
            else if(role === 'petugas') label.innerText = "Username Petugas";
            else if(role === 'admin') label.innerText = "Username Admin";

            const regLink = document.getElementById('registerLink');
            if (role === 'anggota') {
                regLink.classList.add('show');
            } else {
                regLink.classList.remove('show');
            }
        }
    </script>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const adaError = <?php echo json_encode(!empty($error)); ?>;
        const pesanError = <?php echo json_encode($error); ?>;
        const adaSukses = <?php echo json_encode($sukses); ?>;
        const namaTampil = <?php echo json_encode($nama_tampil); ?>;
        const redirectTo = <?php echo json_encode($redirect_to); ?>;

        if (adaSukses) {
            const end = Date.now() + 1800;
            const colors = ['#a855f7', '#ec4899', '#3b82f6', '#10b981'];
            (function frame() {
                confetti({ particleCount: 6, angle: 60, spread: 55, origin: { x: 0 }, colors: colors });
                confetti({ particleCount: 6, angle: 120, spread: 55, origin: { x: 1 }, colors: colors });
                if (Date.now() < end) requestAnimationFrame(frame);
            }());

            Swal.fire({
                icon: 'success',
                title: '🎉 Yeay! Login Berhasil!',
                html: '<div style="font-size:1.1em;margin:8px 0;">Selamat datang kembali,</div><div style="color:#c084fc;font-size:1.3em;font-weight:700;">' + namaTampil + ' 👋</div>',
                confirmButtonColor: '#7c3aed',
                background: '#1e293b', color: '#f8fafc', iconColor: '#a855f7',
                timer: 2000, timerProgressBar: true, showConfirmButton: false, allowOutsideClick: false
            }).then(() => { window.location.href = redirectTo; });
            setTimeout(function () { window.location.href = redirectTo; }, 2200);

        } else if (adaError) {
            const card = document.getElementById('loginCard');
            if (card) { card.classList.add('shake-lucu'); setTimeout(() => card.classList.remove('shake-lucu'), 600); }
            Swal.fire({
                icon: 'error',
                title: '😅 Ups! Ada yang salah nih',
                html: '<div style="font-size:1em;margin:10px 0;color:#fca5a5;">' + pesanError + '</div>',
                confirmButtonColor: '#ef4444', confirmButtonText: 'Oke, Coba Lagi! 💪',
                background: '#1e293b', color: '#f8fafc', iconColor: '#ef4444'
            });
        }
    });
    </script>
</body>
</html>