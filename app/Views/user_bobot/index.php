<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold text-dark border-bottom pb-2">Atur Bobot Preferensi Kriteria</h4>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <p class="text-muted mb-4">
            Sebagai Decision Maker, Anda dapat menentukan tingkat kepentingan (bobot) untuk masing-masing kriteria. 
            Silakan pilih seberapa penting setiap kriteria menurut Anda. Sistem otomatis akan mengonversi skala 1-5 ini menjadi bobot matematis metode SMART.
        </p>

        <form action="<?= base_url('userbobot/store') ?>" method="post">
            <?= csrf_field() ?>
            <div class="table-responsive">
                <table class="table table-bordered align-middle text-center">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">No</th>
                            <th width="35%" class="text-start">Kriteria</th>
                            <th width="20%">Jenis (Sifat)</th>
                            <th width="40%">Tingkat Kepentingan (1-5)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1; foreach($kriteria as $k): ?>
                            <?php $current_bobot = isset($bobotMap[$k['id_kriteria']]) ? $bobotMap[$k['id_kriteria']] : ''; ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td class="text-start fw-bold"><?= esc($k['nama_kriteria']) ?></td>
                                <td>
                                    <?php if($k['jenis'] == 'Benefit'): ?>
                                        <span class="badge bg-success">Benefit</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Cost</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <select name="bobot[<?= $k['id_kriteria'] ?>]" class="form-select" required>
                                        <option value="" disabled <?= $current_bobot == '' ? 'selected' : '' ?>>-- Pilih Tingkat Kepentingan --</option>
                                        <option value="1" <?= $current_bobot == 1 ? 'selected' : '' ?>>1 - Sangat Tidak Penting</option>
                                        <option value="2" <?= $current_bobot == 2 ? 'selected' : '' ?>>2 - Tidak Penting</option>
                                        <option value="3" <?= $current_bobot == 3 ? 'selected' : '' ?>>3 - Cukup Penting</option>
                                        <option value="4" <?= $current_bobot == 4 ? 'selected' : '' ?>>4 - Penting</option>
                                        <option value="5" <?= $current_bobot == 5 ? 'selected' : '' ?>>5 - Sangat Penting</option>
                                    </select>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4 text-end">
                <button type="submit" class="btn btn-primary px-4 fw-bold"><i class="fas fa-save me-2"></i> Simpan Bobot Saya</button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
