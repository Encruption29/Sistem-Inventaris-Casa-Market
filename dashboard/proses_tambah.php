<?php
require_once '../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // 1. Tangkap dan bersihkan data (Sanitasi)
    $nama   = trim($_POST['nama_barang']);
    $id_kat = $_POST['id_kategori'];
    $stok   = (int)$_POST['stok'];
    $h_beli = (float)$_POST['harga_beli'];
    $h_jual = (float)$_POST['harga_jual'];
    $satuan = trim($_POST['satuan']);

    // 2. Validasi Sederhana
    // Memastikan tidak ada kolom penting yang kosong atau harga negatif
    if (empty($nama) || empty($id_kat) || $h_beli < 0 || $h_jual < 0) {
        header("Location: tambah.php?status=error_input");
        exit();
    }

    try {
        // 3. Query Insert
        $sql = "INSERT INTO produk (nama_barang, id_kategori, stok, harga_beli, harga_jual, satuan) 
                VALUES (?, ?, ?, ?, ?, ?)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nama, $id_kat, $stok, $h_beli, $h_jual, $satuan]);

        // Berhasil: Arahkan ke index
        header("Location: index.php?status=sukses");
        exit();

    } catch (PDOException $e) {
        // Gagal: Simpan log error atau tampilkan pesan
        // Di tahap produksi, sebaiknya jangan tampilkan $e->getMessage() ke user umum
        error_log($e->getMessage()); 
        header("Location: index.php?status=gagal");
        exit();
    }

} else {
    // Akses ilegal (tanpa POST)
    header("Location: index.php");
    exit();
}