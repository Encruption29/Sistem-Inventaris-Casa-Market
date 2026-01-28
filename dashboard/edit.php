<?php
require_once '../koneksi.php';

// Ambil ID dari URL
$id = isset($_GET['id']) ? $_GET['id'] : null;

if (!$id) {
    header("Location: index.php");
    exit();
}

// Ambil data produk berdasarkan ID
$stmt = $pdo->prepare("SELECT * FROM produk WHERE id_produk = ?");
$stmt->execute([$id]);
$produk = $stmt->fetch();

if (!$produk) {
    die("Data tidak ditemukan!");
}

// Ambil data kategori untuk dropdown
$queryKategori = $pdo->query("SELECT * FROM kategori ORDER BY nama_kategori ASC");
$categories = $queryKategori->fetchAll();

include 'layout/header.php';
?>

<link rel="stylesheet" href="layout/style.css">

<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="mb-3">
            <a href="index.php" class="text-decoration-none text-muted small">← Kembali</a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold text-warning text-center">Edit Data Barang</h5>
            </div>
            <div class="card-body p-4">
                <form action="proses_edit.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id_produk" value="<?= $produk->id_produk ?>">

                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Nama Barang</label>
                                <input type="text" name="nama_barang" class="form-control" value="<?= htmlspecialchars($produk->nama_barang) ?>" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Kategori</label>
                                <select name="id_kategori" class="form-select" required>
                                    <?php foreach($categories as $kat): ?>
                                        <option value="<?= $kat->id_kategori ?>" <?= ($kat->id_kategori == $produk->id_kategori) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($kat->nama_kategori) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4 text-center border-start">
                            <label class="form-label fw-semibold d-block">Foto Produk</label>
                            <div class="mb-2">
                                <?php if (!empty($produk->foto)): ?>
                                    <img id="img-preview" src="data:image/jpeg;base64,<?= base64_encode($produk->foto) ?>" 
                                         class="img-thumbnail" style="width: 120px; height: 120px; object-fit: cover;">
                                <?php else: ?>
                                    <img id="img-preview" src="img/default.jpg" 
                                         class="img-thumbnail" style="width: 120px; height: 120px; object-fit: cover;">
                                <?php endif; ?>
                            </div>
                            <input type="file" name="foto" class="form-control form-control-sm" accept="image/*" onchange="previewImage(this)">
                            <small class="text-muted" style="font-size: 0.7rem;">Kosongkan jika tidak ingin ganti foto</small>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Stok</label>
                            <input type="number" name="stok" class="form-control" value="<?= $produk->stok ?? 0 ?>" min="0" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Satuan</label>
                            <input type="text" name="satuan" class="form-control" value="<?= htmlspecialchars($produk->satuan) ?>" required>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold text-danger">Harga Beli</label>
                            <input type="number" name="harga_beli" class="form-control" value="<?= $produk->harga_beli ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold text-success">Harga Jual</label>
                            <input type="number" name="harga_jual" class="form-control" value="<?= $produk->harga_jual ?>" required>
                        </div>
                    </div>

                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-warning btn-lg text-white">Simpan Perubahan</button>
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
        }
    }
</script>
<?php include 'layout/footer.php'; ?>