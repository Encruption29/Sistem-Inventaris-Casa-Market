<?php 
require_once '../koneksi.php';

// 1. Query: Pastikan Project Manager selalu paling atas (DESC pada kondisi boolean)
// Kemudian urutkan sisanya berdasarkan id_anggota
$stmt = $pdo->query("SELECT * FROM tim ORDER BY (role = 'Project Manager') DESC, id_anggota ASC");
$tim = $stmt->fetchAll();

include 'layout/header.php'; 
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="layout/style.css">
<style>
    /* Animasi Muncul */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .card-member {
        border: none;
        border-radius: 15px;
        /* GUNAKAN visibility agar tidak 'flashing' sebelum animasi */
        opacity: 0;
        visibility: hidden; 
        animation: fadeInUp 0.8s ease forwards;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    /* Class tambahan untuk memicu visibility saat animasi jalan */
    [class*="delay-"] {
        visibility: visible;
    }

    .card-member:hover {
        transform: translateY(-15px) scale(1.03);
        box-shadow: 0 15px 30px rgba(0,0,0,0.15) !important;
    }

    .img-profile {
        width: 140px;
        height: 140px;
        object-fit: cover;
        border: 5px solid #fff;
        transition: transform 0.5s ease;
    }

    .card-member:hover .img-profile {
        transform: rotate(5deg);
    }

    .leader-border {
        border: 2px solid #0d6efd !important;
        background: linear-gradient(to bottom, #ffffff, #f0f7ff);
    }

    /* PERBAIKAN: Gunakan delay yang lebih kecil (0.2s) agar mulus */
    /* Berikan delay minimal (0.1s) untuk kartu pertama agar tidak kaget */
    <?php for($i = 0; $i < 10; $i++): ?>
        .delay-<?= $i ?> { animation-delay: <?= ($i * 0.5) + 0.5 ?>s; }
    <?php endfor; ?>
</style>

<div class="container mt-4 pb-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold">Tim Casa Market</h2>
        <p class="text-muted small">Anggota pengembang sistem inventaris</p>
        <div class="mx-auto" style="width: 50px; height: 3px; background: #0d6efd;"></div>
    </div>

    <div class="row justify-content-center g-4">
        <?php foreach ($tim as $index => $member): ?>
        <div class="col-md-4 col-lg-2 mb-4" style="min-width: 240px;">
            <div class="card h-100 shadow-sm card-member text-center delay-<?= $index ?> <?= ($member->role == 'Project Manager') ? 'leader-border' : '' ?>">
                <div class="card-body py-4 position-relative">
                    
                    <?php if($member->role == 'Project Manager'): ?>
                        <span class="badge bg-primary position-absolute top-0 start-50 translate-middle shadow-sm px-3">
                            <i class="bi bi-star-fill me-1"></i> Team Leader
                        </span>
                    <?php endif; ?>

                    <div class="mb-3">
                        <?php if (!empty($member->foto)): ?>
                            <img src="data:image/jpeg;base64,<?= base64_encode($member->foto) ?>" 
                                 class="rounded-circle img-profile shadow-sm" 
                                 alt="<?= htmlspecialchars($member->nama) ?>">
                        <?php else: ?>
                            <div class="rounded-circle bg-secondary d-inline-flex align-items-center justify-content-center text-white img-profile">
                                No Photo
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <h6 class="fw-bold mb-1"><?= htmlspecialchars($member->nama) ?></h6>
                    <p class="text-primary mb-2 small fw-bold text-uppercase" style="letter-spacing: 1px;">
                        <?= htmlspecialchars($member->nim) ?>
                    </p>
                    <div class="mt-3">
                        <span class="badge rounded-pill bg-white text-dark border px-3">
                            <?= htmlspecialchars($member->role) ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <div class="row mt-5">
        <div class="col-12">
            <div class="card bg-dark text-white p-4 border-0 shadow-sm card-member delay-5">
                <div class="card-body text-center text-md-start">
                    <h5><i class="bi bi-lightning-fill text-warning me-2"></i>Misi Tim</h5>
                    <p class="mb-0 opacity-75 lh-lg">
                        Kami adalah kelompok mahasiswa yang berdedikasi untuk menciptakan solusi manajemen inventaris 
                        yang efisien, modern, dan mudah digunakan untuk membantu bisnis UMKM seperti Casa Market.
                        Aplikasi Inventaris Casa Market dikembangkan untuk memenuhi tugas mata kuliah <strong>Dasar Pemrograman</strong>. 
                        Sistem ini bertujuan untuk mempermudah pengelolaan stok barang, kategori, serta pemantauan harga barang secara akurat.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'layout/footer.php'; ?>