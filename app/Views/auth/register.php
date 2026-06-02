<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
        }
        .register-box {
            width: 450px;
            margin: 5% auto;
        }
        .card {
            border: 0;
            border-top: 4px solid #198754;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="register-box">
            <div class="text-center mb-4">
                <h3 class="fw-bold text-dark">SPK SMART</h3>
                <p class="text-muted">Pendaftaran Akun Decision Maker</p>
            </div>
            <div class="card">
                <div class="card-body p-4">
                    <h5 class="text-center mb-4">Register User</h5>
                    
                    <?php if (session()->getFlashdata('validation')) : ?>
                        <div class="alert alert-danger p-2">
                            <?= session()->getFlashdata('validation')->listErrors() ?>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('auth/processRegister') ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" value="<?= old('nama') ?>" required autofocus>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="<?= old('email') ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required minlength="6">
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Konfirmasi Password</label>
                            <input type="password" name="confirm_password" class="form-control" required minlength="6">
                        </div>
                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-success">Daftar Akun</button>
                        </div>
                        <div class="text-center">
                            <a href="<?= base_url('auth/login') ?>" class="text-decoration-none text-muted">Sudah punya akun? Login di sini</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
