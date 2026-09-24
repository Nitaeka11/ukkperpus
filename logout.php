<?php
session_start(); // Memulai session

// Menghapus semua variabel session
$_SESSION = array();

// Jika ingin menghapus cookie session juga (opsional tapi disarankan)
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Menghancurkan session
session_destroy();

// Arahkan kembali ke halaman login (sesuaikan nama file login Anda, misal: index.php atau login.php)
header("Location: login.php");
exit();
?>