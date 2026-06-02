<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold text-dark mb-0">3. Normalisasi Bobot Preferensi</h4>
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
        <div class="alert alert-info border-0 mb-4">
            <i class="fas fa-info-circle me-2"></i> <strong>Total Bobot:</strong> <?= $totalBobot ?>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle table-bordered text-center">
                <thead class="table-light">
                    <tr>
                        <th width="10%">No</th>
                        <th class="text-start">Nama Kriteria</th>
                        <th>Bobot Mentah (User)</th>
                        <th>Normalisasi (Bobot/Total)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; foreach ($normalisasi as $n) : ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td class="text-start fw-bold"><?= esc($n['nama_kriteria']) ?></td>
                        <td><?= $n['bobot'] ?></td>
                        <td class="text-success fw-bold"><?= number_format($n['normalisasi'], 4) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
