<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold text-dark mb-0">2. Nilai Rata-rata / Konversi</h4>
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

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <p class="text-muted mb-4">Karena 1 User hanya memberi 1 kali penilaian pada 1 alternatif, maka nilai rata-ratanya sama dengan nilai konversi mentahnya.</p>
        <div class="table-responsive">
            <table class="table table-hover align-middle table-bordered text-center">
                <thead class="table-light">
                    <tr>
                        <th rowspan="2" class="align-middle" width="5%">No</th>
                        <th rowspan="2" class="align-middle text-start">Alternatif</th>
                        <th colspan="<?= count($kriteria) ?>">Nilai Kriteria</th>
                    </tr>
                    <tr>
                        <?php foreach($kriteria as $k): ?>
                            <th><small><?= esc($k['nama_kriteria']) ?></small></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; foreach ($alternatif as $a) : ?>
                    <!-- Hanya tampilkan alternatif yang sudah dinilai user ini -->
                    <?php if(isset($matrix[$a['id_alternatif']])): ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td class="text-start text-primary fw-bold"><?= esc($a['nama_alternatif']) ?></td>
                        <?php foreach($kriteria as $k): ?>
                            <td><?= isset($matrix[$a['id_alternatif']][$k['id_kriteria']]) ? esc($matrix[$a['id_alternatif']][$k['id_kriteria']]) : '-' ?></td>
                        <?php endforeach; ?>
                    </tr>
                    <?php endif; ?>
                    <?php endforeach; ?>

                    <?php if($i == 1): ?>
                    <tr>
                        <td colspan="<?= 2 + count($kriteria) ?>" class="text-center py-4 text-muted">Belum ada data untuk diproses.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
