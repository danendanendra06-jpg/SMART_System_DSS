<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title') ?? 'SPK SMART' ?></title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            color: #333;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }
        .sidebar {
            min-height: 100vh;
            background-color: #212529;
            color: #fff;
            width: 250px;
            position: fixed;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
        }
        .sidebar-brand {
            padding: 20px;
            text-align: center;
            font-size: 1.1rem;
            font-weight: bold;
            border-bottom: 1px solid #495057;
            margin-bottom: 10px;
            color: #fff;
        }
        .sidebar a {
            color: #adb5bd;
            text-decoration: none;
            display: block;
            padding: 10px 20px;
            margin: 2px 10px;
            border-radius: 4px;
        }
        .sidebar a:hover, .sidebar a.active {
            background-color: #343a40;
            color: #fff;
        }
        .sidebar-heading {
            font-size: 0.75rem;
            text-transform: uppercase;
            color: #6c757d;
            padding: 10px 20px;
            margin-top: 15px;
            font-weight: bold;
        }
        .main-content {
            margin-left: 250px;
            padding: 20px 30px;
            min-height: 100vh;
        }
        .topbar {
            background-color: #fff;
            padding: 15px 30px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            margin-left: 250px;
            display: flex;
            justify-content: flex-end;
            align-items: center;
        }
        .card {
            border: 1px solid #dee2e6;
            border-radius: 6px;
            box-shadow: none;
            margin-bottom: 20px;
        }
        .table thead th {
            background-color: #f1f3f5;
            color: #495057;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <?php $role = session()->get('role'); ?>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-brand">
            <i class="fas fa-desktop me-2"></i> SPK SMART
        </div>
        
        <a href="<?= base_url('home') ?>" class="<?= (current_url() == base_url('home')) ? 'active' : '' ?>">
            <i class="fas fa-home me-2"></i> Dashboard
        </a>

        <?php if ($role == 'admin'): ?>
            <div class="sidebar-heading">Kelola Master Data</div>
            <a href="<?= base_url('smart/kriteria') ?>" class="<?= strpos(current_url(), 'smart/kriteria') !== false ? 'active' : '' ?>">
                <i class="fas fa-list me-2"></i> Data Kriteria
            </a>
            <a href="<?= base_url('penilaian') ?>" class="<?= strpos(current_url(), 'penilaian') !== false && strpos(current_url(), 'smart/penilaian') === false ? 'active' : '' ?>">
                <i class="fas fa-clipboard-check me-2"></i> Penilaian Global
            </a>
        <?php endif; ?>

        <?php if ($role == 'user'): ?>
            <div class="sidebar-heading">Decision Maker</div>
            <a href="<?= base_url('alternatif') ?>" class="<?= strpos(current_url(), 'alternatif') !== false ? 'active' : '' ?>">
                <i class="fas fa-store me-2"></i> Kelola Alternatif
            </a>
            <a href="<?= base_url('penilaian') ?>" class="<?= strpos(current_url(), 'penilaian') !== false ? 'active' : '' ?>">
                <i class="fas fa-edit me-2"></i> Isi Penilaian
            </a>
            <a href="<?= base_url('userbobot') ?>" class="<?= strpos(current_url(), 'userbobot') !== false ? 'active' : '' ?>">
                <i class="fas fa-sliders-h me-2"></i> Atur Tingkat Kepentingan
            </a>
        <?php endif; ?>
        
        <?php if ($role == 'admin'): ?>
            <div class="sidebar-heading">Monitoring SMART</div>
            <a href="<?= base_url('smart/penilaian') ?>" class="<?= strpos(current_url(), 'smart/penilaian') !== false ? 'active' : '' ?>">
                <i class="fas fa-search me-2"></i> Data Penilaian
            </a>
            <a href="<?= base_url('smart/rata-rata') ?>" class="<?= strpos(current_url(), 'smart/rata-rata') !== false ? 'active' : '' ?>">
                <i class="fas fa-calculator me-2"></i> Rata-rata Penilaian
            </a>
            <a href="<?= base_url('smart/normalisasi') ?>" class="<?= strpos(current_url(), 'smart/normalisasi') !== false ? 'active' : '' ?>">
                <i class="fas fa-percent me-2"></i> Normalisasi Bobot
            </a>
            <a href="<?= base_url('smart/utility') ?>" class="<?= strpos(current_url(), 'smart/utility') !== false ? 'active' : '' ?>">
                <i class="fas fa-chart-line me-2"></i> Nilai Utility
            </a>
            <a href="<?= base_url('smart/nilai-akhir') ?>" class="<?= strpos(current_url(), 'smart/nilai-akhir') !== false ? 'active' : '' ?>">
                <i class="fas fa-star me-2"></i> Nilai Akhir
            </a>
        <?php endif; ?>

        <?php if ($role == 'admin'): ?>
            <div class="sidebar-heading">Evaluasi Sistem</div>
            <a href="<?= base_url('feedback/admin') ?>" class="<?= strpos(current_url(), 'feedback/admin') !== false ? 'active' : '' ?>">
                <i class="fas fa-comments me-2"></i> Monitoring Feedback
            </a>
        <?php endif; ?>

        <div class="sidebar-heading">Hasil Keputusan</div>
        <a href="<?= base_url('smart/ranking') ?>" class="<?= strpos(current_url(), 'smart/ranking') !== false ? 'active' : '' ?>">
            <i class="fas fa-trophy me-2"></i> Hasil Ranking
        </a>
    </div>
    
    <!-- Topbar -->
    <div class="topbar">
        <div class="dropdown">
            <a href="#" class="text-decoration-none text-dark dropdown-toggle fw-bold" data-bs-toggle="dropdown">
                <i class="fas fa-user-circle me-1"></i> <?= session()->get('nama') ?? 'Guest' ?> (<?= ucfirst($role) ?>)
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                <li><a class="dropdown-item text-danger" href="<?= base_url('auth/logout') ?>"><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
            </ul>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content flex-grow-1">
        <?php if(session()->getFlashdata('success')) : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('success'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        
        <?php if(session()->getFlashdata('error')) : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('error'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?= $this->renderSection('content') ?>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <?= $this->renderSection('scripts') ?>
</body>
</html>
