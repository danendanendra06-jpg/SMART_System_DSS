<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="mb-4 text-center">
    <h3 class="fw-bold"><i class="fas fa-star me-2 text-warning"></i> 6. Nilai Akhir</h3>
    <p class="text-muted">Hasil perhitungan akhir dari (Utility x Bobot Normalisasi) untuk menentukan nilai final setiap alternatif.</p>
</div>

<div class="card card-custom">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle table-bordered text-center">
                <thead class="table-light">
                    <tr>
                        <th rowspan="2" class="align-middle" width="5%">No</th>
                        <th rowspan="2" class="align-middle text-start">Alternatif (Tempat Makan)</th>
                        <th colspan="<?= count($kriteria) ?>">Nilai (Utility × Bobot) per Kriteria</th>
                        <th rowspan="2" class="align-middle text-success" width="15%">Total Nilai Akhir</th>
                    </tr>
                    <tr>
                        <?php foreach($kriteria as $k): ?>
                            <th><?= esc($k['nama_kriteria']) ?> <br> <small class="text-muted fw-normal">(<?= number_format($normBobot[$k['id_kriteria']], 3) ?>)</small></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; foreach ($alternatif as $a) : ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td class="text-start fw-bold"><?= esc($a['nama_alternatif']) ?></td>
                        <?php foreach($kriteria as $k): 
                            $id_k = $k['id_kriteria'];
                            $u = $utility[$a['id_alternatif']][$id_k] ?? 0;
                            $w = $normBobot[$id_k];
                            $calc = $u * $w;
                        ?>
                            <td><?= number_format($calc, 4) ?></td>
                        <?php endforeach; ?>
                        
                        <td class="fw-bold text-success fs-5"><?= number_format($nilaiAkhir[$a['id_alternatif']], 4) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <div class="d-flex justify-content-between mt-4">
            <a href="<?= base_url('smart/utility') ?>" class="btn btn-secondary btn-custom"><i class="fas fa-arrow-left me-2"></i> Sebelumnya</a>
            <a href="<?= base_url('smart/ranking') ?>" class="btn btn-warning btn-custom text-white fw-bold">Lihat Ranking Akhir <i class="fas fa-trophy ms-2"></i></a>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
