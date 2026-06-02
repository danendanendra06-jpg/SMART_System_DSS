<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold text-dark border-bottom pb-2">Edit Penilaian Tempat Makan</h4>
    <a href="<?= base_url('penilaian') ?>" class="btn btn-secondary px-4"><i class="fas fa-arrow-left me-2"></i> Kembali</a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <form action="<?= base_url('penilaian/update/' . $penilaian['id_penilaian']) ?>" method="post">
            <?= csrf_field() ?>
            
            <div class="mb-4">
                <label for="id_alternatif" class="form-label fw-bold">Tempat Makan</label>
                <select class="form-select" id="id_alternatif" name="id_alternatif" required>
                    <option value="" disabled>-- Pilih Tempat Makan --</option>
                    <?php foreach ($alternatif as $a) : ?>
                        <option value="<?= $a['id_alternatif'] ?>" <?= ($penilaian['id_alternatif'] == $a['id_alternatif']) ? 'selected' : '' ?>><?= esc($a['nama_alternatif']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i> Ubah penilaian skala 1-5.
            </div>

            <div class="row">
                <?php foreach ($kriteria as $k) : ?>
                <?php $current_val = isset($nilaiSelesai[$k['id_kriteria']]) ? $nilaiSelesai[$k['id_kriteria']] : ''; ?>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold"><?= esc($k['nama_kriteria']) ?></label>
                    <select class="form-select" name="nilai[<?= $k['id_kriteria'] ?>]" required>
                        <option value="" disabled <?= $current_val == '' ? 'selected' : '' ?>>-- Pilih Skala --</option>
                        <option value="1" <?= $current_val == '1' ? 'selected' : '' ?>>1 - Sangat Buruk</option>
                        <option value="2" <?= $current_val == '2' ? 'selected' : '' ?>>2 - Buruk</option>
                        <option value="3" <?= $current_val == '3' ? 'selected' : '' ?>>3 - Cukup</option>
                        <option value="4" <?= $current_val == '4' ? 'selected' : '' ?>>4 - Baik</option>
                        <option value="5" <?= $current_val == '5' ? 'selected' : '' ?>>5 - Sangat Baik</option>
                    </select>
                </div>
                <?php endforeach; ?>
            </div>
            
            <hr class="my-4">
            <button type="submit" class="btn btn-warning fw-bold px-4 text-dark"><i class="fas fa-save me-2"></i> Simpan Perubahan</button>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
