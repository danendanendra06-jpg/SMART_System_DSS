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
        .login-box {
            width: 400px;
            margin: 7% auto;
        }
        .card {
            border: 0;
            border-top: 4px solid #0d6efd;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-box">
            <div class="text-center mb-4">
                <h3 class="fw-bold text-dark">SPK SMART</h3>
                <p class="text-muted">Sistem Pendukung Keputusan</p>
            </div>
            <div class="card">
                <div class="card-body p-4">
                    <h5 class="text-center mb-4">Login Akademik</h5>
                    
                    <?php if (session()->getFlashdata('error')) : ?>
                        <div class="alert alert-danger p-2"><?= session()->getFlashdata('error') ?></div>
                    <?php endif; ?>
                    
                    <?php if (session()->getFlashdata('success')) : ?>
                        <div class="alert alert-success p-2"><?= session()->getFlashdata('success') ?></div>
                    <?php endif; ?>

                    <form action="<?= base_url('auth/processLogin') ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required autofocus>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary">Login</button>
                        </div>
                        <div class="text-center">
                            <a href="<?= base_url('auth/register') ?>" class="text-decoration-none">Belum punya akun? Register</a><br>
                            <a href="<?= base_url('auth/reset_password') ?>" class="text-decoration-none text-muted small">Lupa password?</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
