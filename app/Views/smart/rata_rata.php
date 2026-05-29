<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="mb-4">
    <h3 class="fw-bold"><i class="fas fa-calculator me-2 text-primary"></i> 3. Rata-rata Penilaian</h3>
    <p class="text-muted">Nilai rata-rata dari seluruh responden untuk masing-masing kriteria pada setiap alternatif tempat makan.</p>
</div>

<div class="card card-custom">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle table-bordered text-center">
                <thead class="table-light">
                    <tr>
                        <th rowspan="2" class="align-middle" width="5%">No</th>
                        <th rowspan="2" class="align-middle text-start">Alternatif (Tempat Makan)</th>
                        <th colspan="<?= count($kriteria) ?>">Rata-rata Nilai Kriteria</th>
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
                            $val = $matrix[$a['id_alternatif']][$k['id_kriteria']] ?? 0;
                        ?>
                            <td><?= number_format($val, 2) ?></td>
                        <?php endforeach; ?>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <div class="d-flex justify-content-between mt-4">
            <a href="<?= base_url('smart/penilaian') ?>" class="btn btn-secondary btn-custom"><i class="fas fa-arrow-left me-2"></i> Sebelumnya</a>
            <a href="<?= base_url('smart/normalisasi') ?>" class="btn btn-primary btn-custom">Selanjutnya: Normalisasi Bobot <i class="fas fa-arrow-right ms-2"></i></a>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
