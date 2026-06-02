<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold text-dark mb-0"><i class="fas fa-trophy text-warning me-2"></i> Ranking Hasil Keputusan</h4>
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
            <span class="badge bg-info text-dark mt-2"><i class="fas fa-user me-1"></i> Hasil Ranking Personal</span>
        <?php endif; ?>
    </div>
</div>

<div class="row">
    <div class="col-md-8 mx-auto">
        <?php if(!empty($ranking)): ?>
        <div class="alert alert-success border-0 shadow-sm mb-4 text-center p-4">
            <h5 class="mb-3">Rekomendasi Tempat Makan Terbaik (Berdasarkan Preferensi Anda)</h5>
            <h2 class="fw-bold text-success mb-2"><?= esc($ranking[0]['nama_alternatif']) ?></h2>
            <p class="mb-0 text-muted"><i class="fas fa-map-marker-alt me-2"></i><?= esc($ranking[0]['lokasi']) ?></p>
            <div class="mt-3">
                <span class="badge bg-success fs-6">Nilai Akhir: <?= number_format($ranking[0]['nilai_akhir'], 4) ?></span>
            </div>
        </div>
        <?php endif; ?>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 text-center">
                        <thead class="table-light">
                            <tr>
                                <th width="15%" class="py-3">Ranking</th>
                                <th class="text-start py-3">Nama Tempat Makan</th>
                                <th class="py-3">Nilai Akhir</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($ranking as $r) : ?>
                            <tr class="<?= $r['ranking'] == 1 ? 'table-warning' : '' ?>">
                                <td class="fw-bold fs-5 <?= $r['ranking'] <= 3 ? 'text-primary' : 'text-muted' ?>">
                                    <?php if($r['ranking'] == 1): ?>
                                        <i class="fas fa-medal text-warning me-1"></i>
                                    <?php elseif($r['ranking'] == 2): ?>
                                        <i class="fas fa-medal text-secondary me-1"></i>
                                    <?php elseif($r['ranking'] == 3): ?>
                                        <i class="fas fa-medal" style="color: #cd7f32;"></i>
                                    <?php endif; ?>
                                    #<?= $r['ranking'] ?>
                                </td>
                                <td class="text-start">
                                    <div class="fw-bold"><?= esc($r['nama_alternatif']) ?></div>
                                    <small class="text-muted"><i class="fas fa-map-marker-alt me-1"></i> <?= esc($r['lokasi']) ?></small>
                                </td>
                                <td class="fw-bold"><?= number_format($r['nilai_akhir'], 4) ?></td>
                            </tr>
                            <?php endforeach; ?>
                            
                            <?php if(empty($ranking)): ?>
                            <tr>
                                <td colspan="3" class="text-center py-4 text-muted">Belum ada hasil ranking yang dapat ditampilkan.</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
