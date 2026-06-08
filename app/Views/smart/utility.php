<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold text-dark mb-0">4. Nilai Utility</h4>
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
    <h6 class="alert-heading fw-bold"><i class="fas fa-info-circle me-2"></i>Penjelasan Tahap 4: Nilai Utility</h6>
    <div class="row">
        <div class="col-md-6">
            <p class="mb-1 fw-bold text-success">Kriteria Benefit</p>
            <span class="badge bg-success fs-6 font-monospace mb-2">Utility = (Cout - Cmin) / (Cmax - Cmin)</span>
            <p class="small mb-2">Semakin besar nilai maka semakin baik. (Porsi, Rasa, Kebersihan, Variasi, Pelayanan)</p>
        </div>
        <div class="col-md-6">
            <p class="mb-1 fw-bold text-danger">Kriteria Cost</p>
            <span class="badge bg-danger fs-6 font-monospace mb-2">Utility = (Cmax - Cout) / (Cmax - Cmin)</span>
            <p class="small mb-2">Semakin kecil nilai maka semakin baik. (Harga)</p>
        </div>
    </div>
    <hr class="my-2 opacity-25">
    <ul class="mb-0 small list-inline">
        <li class="list-inline-item me-3"><strong>Cout</strong> = Nilai alternatif yang dihitung</li>
        <li class="list-inline-item me-3"><strong>Cmin</strong> = Nilai minimum</li>
        <li class="list-inline-item"><strong>Cmax</strong> = Nilai maksimum</li>
    </ul>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle table-bordered text-center">
                <thead class="table-light">
                    <tr>
                        <th rowspan="2" class="align-middle" width="5%">No</th>
                        <th rowspan="2" class="align-middle text-start">Alternatif</th>
                        <th colspan="<?= count($kriteria) ?>">Nilai Utility Berdasarkan Jenis</th>
                    </tr>
                    <tr>
                        <?php foreach($kriteria as $k): ?>
                            <th><small><?= esc($k['nama_kriteria']) ?> (<?= $k['jenis'] ?>)<br>
                            Max: <?= $cMax[$k['id_kriteria']] ?> | Min: <?= $cMin[$k['id_kriteria']] ?></small></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; foreach ($alternatif as $a) : ?>
                    <?php if(isset($utility[$a['id_alternatif']])): ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td class="text-start text-primary fw-bold"><?= esc($a['nama_alternatif']) ?></td>
                        <?php foreach($kriteria as $k): ?>
                            <td><?= number_format($utility[$a['id_alternatif']][$k['id_kriteria']], 4) ?></td>
                        <?php endforeach; ?>
                    </tr>
                    <?php endif; ?>
                    <?php endforeach; ?>

                    <?php if($i == 1): ?>
                    <tr>
                        <td colspan="<?= 2 + count($kriteria) ?>" class="text-center py-4 text-muted">Belum ada data.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
