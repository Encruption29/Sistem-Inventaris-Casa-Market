<?php
require_once '../koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        // Karena foto disimpan di dalam database (BLOB), 
        // kita tidak perlu unlink() file fisik lagi.
        // Cukup hapus baris datanya, maka foto otomatis hilang.
        
        $sql = "DELETE FROM produk WHERE id_produk = ?";
        $stmt = $pdo->prepare($sql);
        
        if ($stmt->execute([$id])) {
            header("Location: index.php?status=hapus_sukses");
            exit();
        } else {
            header("Location: index.php?status=gagal");
            exit();
        }
    } catch (PDOException $e) {
        error_log($e->getMessage());
        header("Location: index.php?status=gagal");
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}