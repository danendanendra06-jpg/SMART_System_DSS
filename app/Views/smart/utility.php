<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="mb-4">
    <h3 class="fw-bold"><i class="fas fa-chart-line me-2 text-primary"></i> 5. Nilai Utility</h3>
    <p class="text-muted">Hasil perhitungan nilai utility berdasarkan kriteria (Benefit / Cost) untuk setiap alternatif.</p>
</div>

<!-- Informasi Cmax dan Cmin -->
<div class="card card-custom mb-4 bg-light border-0">
    <div class="card-body">
        <h5 class="fw-bold text-secondary mb-3"><i class="fas fa-info-circle me-2"></i> Nilai Maximum (Cmax) & Minimum (Cmin) per Kriteria</h5>
        <div class="row">
            <?php foreach($kriteria as $k): 
                $id_k = $k['id_kriteria'];
            ?>
            <div class="col-md-4 col-sm-6 mb-3">
                <div class="p-3 border rounded bg-white shadow-sm">
                    <span class="d-block fw-bold text-primary mb-1"><?= esc($k['nama_kriteria']) ?> <span class="badge bg-secondary ms-1"><?= esc($k['jenis']) ?></span></span>
                    <div class="d-flex justify-content-between text-muted small">
                        <span>Cmax: <strong class="text-dark"><?= number_format($cMax[$id_k], 2) ?></strong></span>
                        <span>Cmin: <strong class="text-dark"><?= number_format($cMin[$id_k], 2) ?></strong></span>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<div class="card card-custom">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle table-bordered text-center">
                <thead class="table-light">
                    <tr>
                        <th rowspan="2" class="align-middle" width="5%">No</th>
                        <th rowspan="2" class="align-middle text-start">Alternatif (Tempat Makan)</th>
                        <th colspan="<?= count($kriteria) ?>">Nilai Utility Kriteria</th>
                    </tr>
                    <tr>
                        <?php foreach($kriteria as $k): ?>
                            <th><?= esc($k['nama_kriteria']) ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; foreach ($alternatif as $a) : ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td class="text-start fw-bold text-primary"><?= esc($a['nama_alternatif']) ?></td>
                        <?php foreach($kriteria as $k): 
                            $u = $utility[$a['id_alternatif']][$k['id_kriteria']] ?? 0;
                        ?>
                            <td><?= number_format($u, 4) ?></td>
                        <?php endforeach; ?>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <div class="d-flex justify-content-between mt-4">
            <a href="<?= base_url('smart/normalisasi') ?>" class="btn btn-secondary btn-custom"><i class="fas fa-arrow-left me-2"></i> Sebelumnya</a>
            <a href="<?= base_url('smart/nilai-akhir') ?>" class="btn btn-primary btn-custom">Selanjutnya: Nilai Akhir <i class="fas fa-arrow-right ms-2"></i></a>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
