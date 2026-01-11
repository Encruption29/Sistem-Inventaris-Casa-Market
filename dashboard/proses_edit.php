<?php
require_once '../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id     = $_POST['id_produk'];
    $nama   = trim($_POST['nama_barang']);
    $id_kat = $_POST['id_kategori'];
    $stok   = (int)$_POST['stok'];
    $h_beli = (float)$_POST['harga_beli'];
    $h_jual = (float)$_POST['harga_jual'];
    $satuan = trim($_POST['satuan']);

    try {
        $sql = "UPDATE produk SET 
                nama_barang = ?, 
                id_kategori = ?, 
                stok = ?, 
                harga_beli = ?, 
                harga_jual = ?, 
                satuan = ? 
                WHERE id_produk = ?";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nama, $id_kat, $stok, $h_beli, $h_jual, $satuan, $id]);

        header("Location: index.php?status=edit_sukses");
        exit();

    } catch (PDOException $e) {
        error_log($e->getMessage());
        header("Location: index.php?status=gagal");
        exit();
    }
}