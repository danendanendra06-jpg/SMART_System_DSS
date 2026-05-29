<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title') ?? 'SPK SMART - Pemilihan Tempat Makan' ?></title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f4f7f6;
            color: #333;
        }
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(180deg, #1e3c72 0%, #2a5298 100%);
            color: #fff;
            width: 260px;
            position: fixed;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }
        .sidebar-brand {
            padding: 20px;
            text-align: center;
            font-size: 1.2rem;
            font-weight: 700;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 20px;
        }
        .sidebar a {
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            display: block;
            padding: 12px 20px;
            margin: 0 15px 5px 15px;
            border-radius: 8px;
            transition: all 0.3s ease;
            font-weight: 500;
        }
        .sidebar a:hover, .sidebar a.active {
            background-color: rgba(255,255,255,0.2);
            color: #fff;
            transform: translateX(5px);
        }
        .sidebar-heading {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: rgba(255,255,255,0.5);
            padding: 10px 20px;
            margin-top: 10px;
        }
        .main-content {
            margin-left: 260px;
            padding: 30px;
            min-height: 100vh;
        }
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 60px 40px;
            border-radius: 15px;
            margin-bottom: 30px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            margin-bottom: 25px;
            transition: transform 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .table-responsive {
            border-radius: 10px;
            overflow: hidden;
        }
        .table thead th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #e9ecef;
            color: #495057;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            padding: 12px 15px;
        }
        .btn-custom {
            border-radius: 8px;
            font-weight: 500;
            padding: 8px 20px;
            transition: all 0.3s;
        }
    </style>
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-brand">
                <i class="fas fa-utensils me-2"></i> SPK SMART
            </div>
            
            <a href="<?= base_url() ?>" class="<?= (current_url() == base_url() || current_url() == base_url('index.php')) ? 'active' : '' ?>">
                <i class="fas fa-home me-2"></i> Beranda
            </a>
            
            <div class="sidebar-heading">Manajemen Data</div>
            <a href="<?= base_url('alternatif') ?>" class="<?= strpos(current_url(), 'alternatif') !== false ? 'active' : '' ?>">
                <i class="fas fa-store me-2"></i> Data Alternatif
            </a>

            <a href="<?= base_url('penilaian') ?>" class="<?= strpos(current_url(), 'penilaian') !== false && strpos(current_url(), 'smart/penilaian') === false ? 'active' : '' ?>">
                <i class="fas fa-clipboard-list me-2"></i> Input Penilaian
            </a>
            
            <div class="sidebar-heading">Proses SMART</div>
            <a href="<?= base_url('smart/kriteria') ?>" class="<?= strpos(current_url(), 'smart/kriteria') !== false ? 'active' : '' ?>">
                <i class="fas fa-list me-2"></i> 1. Kriteria & Bobot
            </a>
            <a href="<?= base_url('smart/penilaian') ?>" class="<?= strpos(current_url(), 'smart/penilaian') !== false ? 'active' : '' ?>">
                <i class="fas fa-users me-2"></i> 2. Penilaian Responden
            </a>
            <a href="<?= base_url('smart/rata-rata') ?>" class="<?= strpos(current_url(), 'smart/rata-rata') !== false ? 'active' : '' ?>">
                <i class="fas fa-calculator me-2"></i> 3. Rata-rata Penilaian
            </a>
            <a href="<?= base_url('smart/normalisasi') ?>" class="<?= strpos(current_url(), 'smart/normalisasi') !== false ? 'active' : '' ?>">
                <i class="fas fa-percent me-2"></i> 4. Normalisasi Bobot
            </a>
            <a href="<?= base_url('smart/utility') ?>" class="<?= strpos(current_url(), 'smart/utility') !== false ? 'active' : '' ?>">
                <i class="fas fa-chart-line me-2"></i> 5. Nilai Utility
            </a>
            <a href="<?= base_url('smart/nilai-akhir') ?>" class="<?= strpos(current_url(), 'smart/nilai-akhir') !== false ? 'active' : '' ?>">
                <i class="fas fa-star me-2"></i> 6. Nilai Akhir
            </a>
            <a href="<?= base_url('smart/ranking') ?>" class="<?= strpos(current_url(), 'smart/ranking') !== false ? 'active' : '' ?>">
                <i class="fas fa-trophy me-2 text-warning"></i> 7. Ranking
            </a>
        </div>
        
        <!-- Main Content -->
        <div class="main-content flex-grow-1">
            <?php if(session()->getFlashdata('success')) : ?>
                <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                    <?= session()->getFlashdata('success'); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            
            <?php if(session()->getFlashdata('error')) : ?>
                <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                    <?= session()->getFlashdata('error'); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?= $this->renderSection('content') ?>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <?= $this->renderSection('scripts') ?>
</body>
</html>
