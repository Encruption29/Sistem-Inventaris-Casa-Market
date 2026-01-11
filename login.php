<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Casa Market</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f8f9fa; height: 100vh; display: flex; align-items: center; }
        .login-card { border: none; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
    </style>
    <link rel="stylesheet" href="dashboard/layout/style.css">
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="text-center mb-4">
                <h2 class="fw-bold text-primary">CASA MARKET</h2>
                <p class="text-muted small">Sistem Inventaris Barang</p>
            </div>
            
            <div class="card login-card p-4">
                <div class="card-body">
                    <h5 class="text-center mb-4">Silakan Masuk</h5>
                    
                    <?php if(isset($_GET['pesan']) && $_GET['pesan'] == 'gagal'): ?>
                        <div class="alert alert-danger small p-2 text-center">Username atau Password salah!</div>
                    <?php endif; ?>

                    <form action="proses_login.php" method="POST">
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Username</label>
                            <input type="text" name="username" class="form-control" required autofocus>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary py-2 fw-bold">Masuk</button>
                        </div>
                    </form>
                </div>
            </div>
            <p class="text-center mt-4 text-muted small">&copy; 2026 Casa Market Team</p>
        </div>
    </div>
</div>

</body>
</html>