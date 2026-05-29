<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="mb-4">
    <h3 class="fw-bold"><i class="fas fa-percent me-2 text-primary"></i> 4. Normalisasi Bobot Kriteria</h3>
    <p class="text-muted">Proses pembobotan ulang agar total bobot menjadi 1 (atau 100%).</p>
</div>

<div class="card card-custom">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th width="5%">No</th>
                        <th>Kode Kriteria</th>
                        <th class="text-start">Nama Kriteria</th>
                        <th>Bobot Awal (Wj)</th>
                        <th>Bobot Normalisasi (Wj / Total)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $i = 1; 
                        $totalNorm = 0;
                        foreach ($normalisasi as $n) : 
                            $totalNorm += $n['normalisasi'];
                    ?>
                    <tr>
                        <td><?= $i ?></td>
                        <td>C<?= $i ?></td>
                        <td class="text-start fw-bold"><?= esc($n['nama_kriteria']) ?></td>
                        <td><?= esc($n['bobot']) ?></td>
                        <td class="text-primary fw-bold"><?= number_format($n['normalisasi'], 4) ?></td>
                    </tr>
                    <?php 
                        $i++; 
                    endforeach; 
                    ?>
                </tbody>
                <tfoot class="table-secondary fw-bold">
                    <tr>
                        <td colspan="3" class="text-end">Total</td>
                        <td><?= $totalBobot ?></td>
                        <td class="text-primary"><?= number_format($totalNorm, 4) ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        
        <div class="d-flex justify-content-between mt-4">
            <a href="<?= base_url('smart/rata_rata') ?>" class="btn btn-secondary btn-custom"><i class="fas fa-arrow-left me-2"></i> Sebelumnya</a>
            <a href="<?= base_url('smart/utility') ?>" class="btn btn-primary btn-custom">Selanjutnya: Nilai Utility <i class="fas fa-arrow-right ms-2"></i></a>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
