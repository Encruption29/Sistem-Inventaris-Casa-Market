<?php
require_once '../koneksi.php';

// Ambil data kategori untuk dropdown
// Pastikan fetch mode sudah diset ke FETCH_OBJ di koneksi.php agar konsisten
$queryKategori = $pdo->query("SELECT * FROM kategori ORDER BY nama_kategori ASC");
$categories = $queryKategori->fetchAll();

// 1. Panggil Header (Otomatis memuat CSS dan Navbar)
include 'layout/header.php'; 
?>

<link rel="stylesheet" href="layout/style.css">

<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="mb-3">
            <a href="index.php" class="text-decoration-none text-muted small">
                ← Kembali ke Daftar Barang
            </a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="mb-0 fw-bold text-primary text-center">Form Tambah Barang Baru</h5>
            </div>
            <div class="card-body p-4">
                <form action="proses_tambah.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Barang</label>
                        <input type="text" name="nama_barang" class="form-control form-control-lg" placeholder="Contoh: Beras Premium" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Kategori</label>
                        <select name="id_kategori" class="form-select" required>
                            <option value="">-- Pilih Kategori --</option>
                            <?php foreach($categories as $kat): ?>
                                <option value="<?= $kat->id_kategori ?>">
                                    <?= htmlspecialchars($kat->nama_kategori) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Stok Awal</label>
                            <input type="number" name="stok" class="form-control" min="0" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Satuan</label>
                            <input type="text" name="satuan" class="form-control" placeholder="Pcs / Kg / Box" required>
                        </div>
                    </div>

                    <hr class="my-4 text-muted">

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold text-danger">Harga Beli (Modal)</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" name="harga_beli" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold text-success">Harga Jual</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" name="harga_jual" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" name="submit" class="btn btn-primary btn-lg">
                            Simpan ke Database
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php 
// 2. Panggil Footer (Otomatis menutup container dan memuat JS)
include 'layout/footer.php'; 
?>