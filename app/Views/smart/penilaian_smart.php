<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold text-dark mb-0">1. Data Penilaian Responden (SMART)</h4>
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
    <h6 class="alert-heading fw-bold"><i class="fas fa-info-circle me-2"></i>Penilaian Alternatif</h6>
    <p class="mb-2 small">Pengguna memberikan penilaian menggunakan skala 1 sampai 5. Nilai tersebut kemudian dikonversi menjadi nilai numerik untuk proses SMART.</p>
    <div class="row small font-monospace">
        <div class="col-md-2">1 = Sangat Buruk (20)</div>
        <div class="col-md-2">2 = Buruk (40)</div>
        <div class="col-md-2">3 = Cukup (60)</div>
        <div class="col-md-2">4 = Baik (80)</div>
        <div class="col-md-4">5 = Sangat Baik (100)</div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle table-bordered text-center">
                <thead class="table-light">
                    <tr>
                        <th rowspan="2" class="align-middle" width="5%">No</th>
                        <th rowspan="2" class="align-middle text-start">Alternatif</th>
                        <th colspan="<?= count($kriteria) ?>">Nilai Kriteria (Konversi)</th>
                    </tr>
                    <tr>
                        <?php foreach($kriteria as $k): ?>
                            <th><small><?= esc($k['nama_kriteria']) ?></small></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; foreach ($penilaian as $p) : ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td class="text-start text-primary fw-bold"><?= esc($p['nama_alternatif']) ?></td>
                        
                        <?php foreach($kriteria as $k): ?>
                            <td><?= isset($nilaiMatrix[$p['id_penilaian']][$k['id_kriteria']]) ? esc($nilaiMatrix[$p['id_penilaian']][$k['id_kriteria']]) : '-' ?></td>
                        <?php endforeach; ?>
                    </tr>
                    <?php endforeach; ?>
                    
                    <?php if(empty($penilaian)): ?>
                    <tr>
                        <td colspan="<?= 2 + count($kriteria) ?>" class="text-center py-4 text-muted">Belum ada data penilaian dari User ini.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
