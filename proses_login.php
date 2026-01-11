<?php
session_start();
require_once 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Cari user di database
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    // Verifikasi user dan password (menggunakan password_verify)
    if ($user && password_verify($password, $user->password)) {
        // Simpan data ke session
        $_SESSION['login'] = true;
        $_SESSION['id_user'] = $user->id_user;
        $_SESSION['nama'] = $user->nama_lengkap;

        header("Location: dashboard/index.php");
        exit();
    } else {
        header("Location: login.php?pesan=gagal");
        exit();
    }
}