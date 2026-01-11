<?php
session_start();

// Jika sudah login, lempar ke dashboard
if (isset($_SESSION['login'])) {
    header("Location: dashboard/index.php");
} else {
    // Jika belum login, lempar ke login
    header("Location: login.php");
}
exit();