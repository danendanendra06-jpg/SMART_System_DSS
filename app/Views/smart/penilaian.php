<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="mb-4">
    <h3 class="fw-bold"><i class="fas fa-users me-2 text-primary"></i> 2. Penilaian Responden</h3>
    <p class="text-muted">Data mentah hasil penilaian dari setiap responden terhadap alternatif tempat makan. Nilai telah dikonversi ke dalam skala 10-100.</p>
</div>

<div class="card card-custom">
    <div class="card-body">
        <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
            <table class="table table-bordered table-hover align-middle text-center mb-0">
                <thead class="table-light sticky-top">
                    <tr>
                        <th rowspan="2" class="align-middle" width="5%">No</th>
                        <th rowspan="2" class="align-middle text-start">Responden</th>
                        <th rowspan="2" class="align-middle text-start">Alternatif (Tempat Makan)</th>
                        <th colspan="<?= count($kriteria) ?>">Nilai Konversi Kriteria</th>
                    </tr>
                    <tr>
                        <?php foreach($kriteria as $k): ?>
                            <th><?= esc($k['nama_kriteria']) ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; foreach ($penilaian as $p) : ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td class="text-start"><?= esc($p['nama_responden']) ?></td>
                        <td class="text-start fw-bold text-primary"><?= esc($p['nama_alternatif']) ?></td>
                        <?php foreach($kriteria as $k): ?>
                            <td><?= isset($nilaiMatrix[$p['id_penilaian']][$k['id_kriteria']]) ? esc($nilaiMatrix[$p['id_penilaian']][$k['id_kriteria']]) : '-' ?></td>
                        <?php endforeach; ?>
                    </tr>
                    <?php endforeach; ?>
                    
                    <?php if(empty($penilaian)): ?>
                    <tr>
                        <td colspan="<?= 3 + count($kriteria) ?>" class="text-center py-4 text-muted">Belum ada data penilaian responden. Silakan input pada menu Data Penilaian.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <div class="d-flex justify-content-between mt-4">
            <a href="<?= base_url('smart/kriteria') ?>" class="btn btn-secondary btn-custom"><i class="fas fa-arrow-left me-2"></i> Sebelumnya</a>
            <a href="<?= base_url('smart/rata-rata') ?>" class="btn btn-primary btn-custom">Selanjutnya: Rata-rata Penilaian <i class="fas fa-arrow-right ms-2"></i></a>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
