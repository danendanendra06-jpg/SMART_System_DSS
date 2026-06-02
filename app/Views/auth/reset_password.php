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
        .reset-box {
            width: 400px;
            margin: 7% auto;
        }
        .card {
            border: 0;
            border-top: 4px solid #ffc107;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="reset-box">
            <div class="text-center mb-4">
                <h3 class="fw-bold text-dark">SPK SMART</h3>
            </div>
            <div class="card">
                <div class="card-body p-4">
                    <h5 class="text-center mb-4">Reset Password</h5>
                    <p class="text-muted text-center small mb-4">Masukkan email Anda untuk mengganti password.</p>
                    
                    <?php if (session()->getFlashdata('error')) : ?>
                        <div class="alert alert-danger p-2"><?= session()->getFlashdata('error') ?></div>
                    <?php endif; ?>

                    <form action="<?= base_url('auth/processReset') ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="mb-3">
                            <label class="form-label">Email Terdaftar</label>
                            <input type="email" name="email" class="form-control" required autofocus>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Password Baru</label>
                            <input type="password" name="new_password" class="form-control" required minlength="6">
                        </div>
                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-warning text-dark fw-bold">Reset Password</button>
                        </div>
                        <div class="text-center">
                            <a href="<?= base_url('auth/login') ?>" class="text-decoration-none text-muted">Batal & Kembali ke Login</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
