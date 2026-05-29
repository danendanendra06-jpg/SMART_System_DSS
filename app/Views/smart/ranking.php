<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="mb-4 text-center">
    <h2 class="fw-bold"><i class="fas fa-trophy me-2 text-warning"></i> Hasil Akhir & Ranking</h2>
    <p class="text-muted">Rekomendasi tempat makan hemat untuk Mahasiswa PNJ berdasarkan metode SMART.</p>
</div>

<?php if(isset($ranking[0])): ?>
<div class="row justify-content-center mb-5">
    <div class="col-md-8">
        <div class="card card-custom text-white" style="background: linear-gradient(135deg, #f6d365 0%, #fda085 100%) !important; border: none; box-shadow: 0 10px 20px rgba(253, 160, 133, 0.3);">
            <div class="card-body text-center py-5">
                <i class="fas fa-crown fa-4x mb-3 text-white"></i>
                <h4 class="mb-1">Rekomendasi Terbaik</h4>
                <h1 class="display-4 fw-bold mb-0"><?= esc($ranking[0]['nama_alternatif']) ?></h1>
                <p class="lead mt-2"><i class="fas fa-map-marker-alt me-1"></i> <?= esc($ranking[0]['lokasi']) ?></p>
                <div class="mt-4">
                    <span class="badge bg-white text-dark fs-5 px-4 py-2">Skor: <?= number_format($ranking[0]['nilai_akhir'], 4) ?></span>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<div class="card card-custom">
    <div class="card-body">
        <h5 class="card-title fw-bold mb-4 text-primary"><i class="fas fa-list-ol me-2"></i> Detail Peringkat Keseluruhan</h5>
        <div class="table-responsive">
            <table class="table table-hover align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th width="10%">Peringkat</th>
                        <th class="text-start">Nama Alternatif (Tempat Makan)</th>
                        <th>Lokasi</th>
                        <th>Nilai Akhir SMART</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ranking as $r) : ?>
                    <tr class="<?= $r['ranking'] == 1 ? 'table-warning fw-bold' : '' ?>">
                        <td>
                            <?php if($r['ranking'] == 1): ?>
                                <i class="fas fa-medal text-warning fa-2x"></i>
                            <?php elseif($r['ranking'] == 2): ?>
                                <i class="fas fa-medal text-secondary fa-2x"></i>
                            <?php elseif($r['ranking'] == 3): ?>
                                <i class="fas fa-medal text-danger fa-2x" style="color: #cd7f32 !important;"></i>
                            <?php else: ?>
                                <span class="fs-4"><?= $r['ranking'] ?></span>
                            <?php endif; ?>
                        </td>
                        <td class="text-start fs-5"><?= esc($r['nama_alternatif']) ?></td>
                        <td><?= esc($r['lokasi']) ?></td>
                        <td class="fs-5 text-primary fw-bold"><?= number_format($r['nilai_akhir'], 4) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <div class="d-flex justify-content-start mt-4">
            <a href="<?= base_url('smart/nilai_akhir') ?>" class="btn btn-secondary btn-custom"><i class="fas fa-arrow-left me-2"></i> Kembali ke Nilai Akhir</a>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
