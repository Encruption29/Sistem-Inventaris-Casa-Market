<?php
require_once '../koneksi.php';

$id = isset($_GET['id']) ? $_GET['id'] : null;

if ($id) {
    try {
        $stmt = $pdo->prepare("DELETE FROM produk WHERE id_produk = ?");
        $stmt->execute([$id]);
        header("Location: index.php?status=hapus_sukses");
    } catch (PDOException $e) {
        header("Location: index.php?status=gagal");
    }
} else {
    header("Location: index.php");
}
exit();