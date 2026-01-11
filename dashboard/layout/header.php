<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: ../login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Casa Market | Inventaris</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .navbar-brand { font-weight: 700; letter-spacing: 1px; }
        .main-content { min-height: 80vh; }
    </style>
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm mb-4">
    <div class="container">
        <a class="navbar-brand" href="index.php">🏠 CASA MARKET</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="index.php">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about.php">Tentang</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="tambah.php">Tambah Barang</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-danger" href="../logout.php">Keluar</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container main-content">