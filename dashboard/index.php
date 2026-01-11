<?php
require_once '../koneksi.php';

// 1. Konfigurasi Pagination
$limit = 10; 
$page = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
$offset = ($page - 1) * $limit;

// 2. Ambil parameter filter
$search = isset($_GET['cari']) ? $_GET['cari'] : '';
$filter_kategori = isset($_GET['kategori']) ? $_GET['kategori'] : '';

// 3. Ambil daftar kategori untuk dropdown filter
$stmt_cat = $pdo->query("SELECT * FROM kategori ORDER BY nama_kategori ASC");
$semua_kategori = $stmt_cat->fetchAll();

// 4. Bangun Query SQL secara dinamis
$query = "SELECT produk.*, kategori.nama_kategori 
          FROM produk 
          JOIN kategori ON produk.id_kategori = kategori.id_kategori 
          WHERE 1=1"; 

$params = [];

if ($search) {
    $query .= " AND produk.nama_barang LIKE ?";
    $params[] = "%$search%";
}

if ($filter_kategori) {
    $query .= " AND produk.id_kategori = ?";
    $params[] = $filter_kategori;
}

// Hitung total data untuk pagination
$stmt_count = $pdo->prepare($query);
$stmt_count->execute($params);
$total_data = $stmt_count->rowCount();
$total_halaman = ceil($total_data / $limit);

// Tambahkan limit dan offset untuk tampilan
$query .= " ORDER BY produk.id_produk DESC LIMIT $limit OFFSET $offset";
$stmt = $pdo->prepare($query);
$stmt->execute($params);
$daftar_produk = $stmt->fetchAll();

// PANGGIL HEADER (Pastikan header.php sudah berisi <html><head><body>)
include 'layout/header.php'; 
?>

<link rel="stylesheet" href="layout/style.css">

<div class="container mt-2 pb-5">
    <?php if (isset($_GET['status'])): ?>
        <?php if ($_GET['status'] == 'gagal'): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Galat!</strong> Terjadi kesalahan sistem saat memproses data.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php else: ?>
            <div class="alert alert-<?= ($_GET['status'] == 'hapus_sukses' ? 'warning' : 'success') ?> alert-dismissible fade show" role="alert">
                <strong>Info:</strong> 
                <?php 
                    if($_GET['status'] == 'sukses') echo "Barang berhasil ditambahkan.";
                    if($_GET['status'] == 'hapus_sukses') echo "Data barang telah dihapus.";
                    if($_GET['status'] == 'edit_sukses') echo "Data barang diperbarui.";
                ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>📦 Daftar Inventaris Barang</h2>
        <a href="tambah.php" class="btn btn-primary">+ Tambah Barang</a>
    </div>

    <div class="card mb-4 shadow-sm border-0">
        <div class="card-body">
            <form action="" method="GET" class="row g-3">
                <div class="col-md-4">
                    <input type="text" name="cari" class="form-control" placeholder="Cari nama barang..." value="<?= htmlspecialchars($search) ?>">
                </div>
                <div class="col-md-3">
                    <select name="kategori" class="form-select">
                        <option value="">-- Semua Kategori --</option>
                        <?php foreach($semua_kategori as $kat): ?>
                            <option value="<?= $kat->id_kategori ?>" <?= $filter_kategori == $kat->id_kategori ? 'selected' : '' ?>>
                                <?= htmlspecialchars($kat->nama_kategori) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-dark w-100">Filter</button>
                </div>
                <?php if($search || $filter_kategori): ?>
                    <div class="col-md-1">
                        <a href="index.php" class="btn btn-outline-secondary">Reset</a>
                    </div>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="ps-3">Nama Barang</th>
                            <th>Kategori</th>
                            <th>Stok</th>
                            <th>Harga Jual</th>
                            <th>Satuan</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($daftar_produk) > 0): ?>
                            <?php foreach ($daftar_produk as $row): ?>
                            <tr>
                                <td class="ps-3 fw-bold"><?= htmlspecialchars($row->nama_barang) ?></td>
                                <td><span class="badge bg-info text-dark"><?= htmlspecialchars($row->nama_kategori) ?></span></td>
                                <td>
                                    <span class="badge <?= ($row->stok < 10) ? 'bg-danger' : 'bg-success' ?>">
                                        <?= $row->stok ?>
                                    </span>
                                </td>
                                <td>Rp <?= number_format($row->harga_jual, 0, ',', '.') ?></td>
                                <td><?= htmlspecialchars($row->satuan) ?></td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="edit.php?id=<?= $row->id_produk ?>" class="btn btn-sm btn-outline-warning">Edit</a>
                                        <a href="hapus.php?id=<?= $row->id_produk ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin hapus barang ini?')">Hapus</a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">Data tidak ditemukan.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php if($total_halaman > 1): ?>
    <nav class="mt-4">
        <ul class="pagination justify-content-center">
            <?php for($i=1; $i <= $total_halaman; $i++): ?>
                <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                    <a class="page-link" href="?halaman=<?= $i ?>&cari=<?= urlencode($search) ?>&kategori=<?= $filter_kategori ?>">
                        <?= $i ?>
                    </a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
    <?php endif; ?>
</div>

<?php 
// PANGGIL FOOTER (Pastikan footer.php berisi </body></html>)
include 'layout/footer.php'; 
?>