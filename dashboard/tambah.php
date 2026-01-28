<?php
require_once '../koneksi.php';

// Ambil data kategori untuk dropdown
$queryKategori = $pdo->query("SELECT * FROM kategori ORDER BY nama_kategori ASC");
$categories = $queryKategori->fetchAll();

include 'layout/header.php'; 
?>

<link rel="stylesheet" href="layout/style.css">

<div class="row justify-content-center">
    <div class="col-md-8 col-lg-7"> <div class="mb-3">
            <a href="index.php" class="text-decoration-none text-muted small">
                ← Kembali ke Daftar Barang
            </a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="mb-0 fw-bold text-primary text-center">Form Tambah Barang Baru</h5>
            </div>
            <div class="card-body p-4">
                <form action="proses_tambah.php" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Nama Barang</label>
                                <input type="text" name="nama_barang" class="form-control" placeholder="Contoh: Beras Premium" required>
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
                        </div>

                        <div class="col-md-4 text-center border-start">
                            <label class="form-label fw-semibold d-block">Foto Produk</label>
                            <div class="mb-2">
                                <img id="img-preview" src="img/default.jpg" class="img-thumbnail" style="width: 120px; height: 120px; object-fit: cover;">
                            </div>
                            <input type="file" name="foto" id="foto-input" class="form-control form-control-sm" accept="image/*" onchange="previewImage(this)">
                            <small class="text-muted" style="font-size: 0.7rem;">Format: JPG/PNG, Maks 2MB</small>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Stok Awal</label>
                            <input type="number" name="stok" class="form-control" min="0" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Satuan</label>
                            <input type="text" name="satuan" class="form-control" placeholder="Pcs / Kg / Box" required>
                        </div>
                    </div>

                    <hr class="my-3 text-muted">

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold text-danger">Harga Beli</label>
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

<script>
function previewImage(input) {
    const preview = document.getElementById('img-preview');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
    } else {
        preview.src = 'img/default.jpg';
    }
}
</script>

<?php 
include 'layout/footer.php'; 
?>