<?php
require_once '../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // 1. Tangkap data teks
    $nama   = trim($_POST['nama_barang']);
    $id_kat = $_POST['id_kategori'];
    $stok   = (int)$_POST['stok'];
    $h_beli = (float)$_POST['harga_beli'];
    $h_jual = (float)$_POST['harga_jual'];
    $satuan = trim($_POST['satuan']);

    // 2. Logika Ambil Data Biner Foto
    $foto_biner = null; 

    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
        $file_tmp = $_FILES["foto"]["tmp_name"];
        $ekstensi = strtolower(pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION));
        $ekstensi_boleh = ['jpg', 'jpeg', 'png', 'webp'];

        if (in_array($ekstensi, $ekstensi_boleh)) {
            // Membaca isi file menjadi data biner
            $foto_biner = file_get_contents($file_tmp);
        }
    }

    // Jika user tidak upload foto, kita bisa mengosongkan atau tetap pakai file default
    // Tapi karena sistem biner, biasanya kita biarkan NULL jika tidak ada foto.

    // 3. Validasi Data Teks
    if (empty($nama) || empty($id_kat)) {
        header("Location: tambah.php?status=error_input");
        exit();
    }

    try {
        // 4. Query Insert
        $sql = "INSERT INTO produk (nama_barang, id_kategori, stok, harga_beli, harga_jual, satuan, foto) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $pdo->prepare($sql);
        
        // Menggunakan bindParam atau langsung execute. 
        // Untuk data besar (BLOB), PDO akan menanganinya secara otomatis.
        $stmt->execute([$nama, $id_kat, $stok, $h_beli, $h_jual, $satuan, $foto_biner]);

        header("Location: index.php?status=sukses");
        exit();

    } catch (PDOException $e) {
        error_log($e->getMessage()); 
        header("Location: index.php?status=gagal");
        exit();
    }

} else {
    header("Location: index.php");
    exit();
}