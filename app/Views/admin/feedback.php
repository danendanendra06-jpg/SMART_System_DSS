<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>
Monitoring Evaluasi Sistem | SPK SMART
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row mb-4">
    <div class="col-md-12">
        <h4 class="fw-bold text-dark border-bottom pb-2">Monitoring Feedback Rekomendasi</h4>
        <p class="text-muted mt-2">Halaman ini menampilkan rekapitulasi evaluasi pengguna terhadap akurasi hasil rekomendasi yang diberikan oleh sistem.</p>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-primary text-white">
            <div class="card-body text-center">
                <h6 class="text-uppercase fw-bold">Total Feedback</h6>
                <h2 class="mb-0 fw-bold"><?= $total ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-success text-white">
            <div class="card-body text-center">
                <h6 class="text-uppercase fw-bold">Setuju</h6>
                <h2 class="mb-0 fw-bold"><?= $setuju ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-danger text-white">
            <div class="card-body text-center">
                <h6 class="text-uppercase fw-bold">Tidak Setuju</h6>
                <h2 class="mb-0 fw-bold"><?= $tidakSetuju ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-info text-white">
            <div class="card-body text-center">
                <h6 class="text-uppercase fw-bold">Tingkat Penerimaan</h6>
                <h2 class="mb-0 fw-bold"><?= $persentase ?>%</h2>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white fw-bold py-3">
        Detail Feedback Pengguna
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th width="5%">No</th>
                        <th width="20%">Nama User</th>
                        <th width="25%">Rekomendasi Terbaik (Ranking 1)</th>
                        <th width="15%">Feedback</th>
                        <th width="20%">Alasan</th>
                        <th width="15%">Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($feedbacks)): ?>
                        <tr>
                            <td colspan="6" class="text-muted py-4">Belum ada feedback yang masuk.</td>
                        </tr>
                    <?php else: ?>
                        <?php $no = 1; foreach ($feedbacks as $f): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td class="text-start"><?= esc($f['nama_user']) ?></td>
                                <td class="fw-bold text-primary"><?= esc($f['nama_alternatif_rekomendasi']) ?></td>
                                <td>
                                    <?php if ($f['status_feedback'] == 'Setuju'): ?>
                                        <span class="badge bg-success"><i class="fas fa-check me-1"></i> Setuju</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger"><i class="fas fa-times me-1"></i> Tidak Setuju</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-start small"><?= $f['alasan'] ? esc($f['alasan']) : '-' ?></td>
                                <td class="small text-muted"><?= date('d M Y H:i', strtotime($f['created_at'])) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
