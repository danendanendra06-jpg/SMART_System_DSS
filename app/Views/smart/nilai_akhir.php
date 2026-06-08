<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold text-dark mb-0">5. Nilai Akhir</h4>
        <?php if(session()->get('role') == 'admin'): ?>
            <div class="mt-2 d-flex align-items-center bg-light p-2 rounded border">
                <label class="me-2 fw-bold text-muted small"><i class="fas fa-filter me-1"></i> Mode Monitoring:</label>
                <form method="GET" action="<?= current_url() ?>" class="m-0 p-0">
                    <select name="u" class="form-select form-select-sm w-auto d-inline-block fw-bold text-primary" onchange="this.form.submit()">
                        <option value="global" <?= $activeUser == 'global' ? 'selected' : '' ?>>Semua User (Agregasi Global)</option>
                        <optgroup label="Spesifik User">
                        <?php foreach($allUsers as $usr): ?>
                            <option value="<?= $usr['id_user'] ?>" <?= $activeUser == $usr['id_user'] ? 'selected' : '' ?>><?= esc($usr['nama']) ?></option>
                        <?php endforeach; ?>
                        </optgroup>
                    </select>
                </form>
            </div>
        <?php else: ?>
            <span class="badge bg-info text-dark mt-2"><i class="fas fa-user me-1"></i> Data Anda Sendiri</span>
        <?php endif; ?>
    </div>
</div>

<div class="alert alert-info border-0 shadow-sm mb-4">
    <h6 class="alert-heading fw-bold"><i class="fas fa-info-circle me-2"></i>Penjelasan Tahap 5: Nilai Akhir SMART</h6>
    <div class="d-flex align-items-center mb-2">
        <span class="badge bg-primary fs-6 me-2 font-monospace">U(ai) = Σ(Wj × Uij)</span>
    </div>
    <ul class="mb-2 small">
        <li><strong>U(ai)</strong> = Nilai akhir alternatif</li>
        <li><strong>Wj</strong> = Bobot normalisasi</li>
        <li><strong>Uij</strong> = Nilai utility</li>
    </ul>
    <p class="mb-0 small"><strong>Penjelasan:</strong> Nilai akhir diperoleh dari penjumlahan hasil perkalian bobot normalisasi dengan nilai utility pada setiap kriteria.</p>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle table-bordered text-center">
                <thead class="table-light">
                    <tr>
                        <th rowspan="2" class="align-middle" width="5%">No</th>
                        <th rowspan="2" class="align-middle text-start">Alternatif</th>
                        <th colspan="<?= count($kriteria) ?>">Utility × Normalisasi Bobot</th>
                        <th rowspan="2" class="align-middle bg-primary text-white">Nilai Akhir (Total)</th>
                    </tr>
                    <tr>
                        <?php foreach($kriteria as $k): ?>
                            <th><small><?= esc($k['nama_kriteria']) ?><br>W=<?= number_format($normBobot[$k['id_kriteria']], 4) ?></small></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; foreach ($alternatif as $a) : ?>
                    <?php if(isset($nilaiAkhir[$a['id_alternatif']])): ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td class="text-start fw-bold"><?= esc($a['nama_alternatif']) ?></td>
                        <?php foreach($kriteria as $k): ?>
                            <td>
                                <small class="text-muted">
                                    <?= number_format($utility[$a['id_alternatif']][$k['id_kriteria']], 2) ?> × <?= number_format($normBobot[$k['id_kriteria']], 2) ?>
                                </small>
                            </td>
                        <?php endforeach; ?>
                        <td class="fw-bold fs-5 text-primary">
                            <?= number_format($nilaiAkhir[$a['id_alternatif']], 4) ?>
                        </td>
                    </tr>
                    <?php endif; ?>
                    <?php endforeach; ?>

                    <?php if($i == 1): ?>
                    <tr>
                        <td colspan="<?= 3 + count($kriteria) ?>" class="text-center py-4 text-muted">Belum ada data.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
