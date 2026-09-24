<?php
session_start();
include "config/koneksi.php";

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];
    $role     = $_POST['role'];

    if ($role == 'admin') {
        $query = mysqli_query($conn, "SELECT * FROM admin WHERE username='$username'");
        if ($query && mysqli_num_rows($query) > 0) {
            $data = mysqli_fetch_assoc($query);
            // Cek password (mendukung teks biasa maupun password_hash)
            if ($password == $data['password'] || password_verify($password, $data['password'])) {
                $_SESSION['status'] = "login";
                $_SESSION['username'] = $data['username'];
                $_SESSION['nama'] = $data['nama_lengkap'];
                $_SESSION['role'] = "admin";
                header("location: admin/dashboard.php");
                exit();
            } else {
                header("location: login.php?pesan=gagal_password");
                exit();
            }
        } else {
            header("location: login.php?pesan=gagal_username");
            exit();
        }
    } else {
        header("location: login.php?pesan=gagal_role");
        exit();
    }
} else {
    header("location: login.php");
    exit();
}
?>