<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold text-dark border-bottom pb-2">Beri Penilaian Tempat Makan</h4>
    <a href="<?= base_url('penilaian') ?>" class="btn btn-secondary px-4"><i class="fas fa-arrow-left me-2"></i> Kembali</a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <form action="<?= base_url('penilaian/store') ?>" method="post">
            <?= csrf_field() ?>
            
            <div class="mb-4">
                <label for="id_alternatif" class="form-label fw-bold">Pilih Tempat Makan (Katalog)</label>
                <select class="form-select" id="id_alternatif" name="id_alternatif" required>
                    <option value="" disabled selected>-- Pilih Tempat Makan --</option>
                    <?php foreach ($alternatif as $a) : ?>
                        <option value="<?= $a['id_alternatif'] ?>" <?= old('id_alternatif') == $a['id_alternatif'] ? 'selected' : '' ?>><?= esc($a['nama_alternatif']) ?></option>
                    <?php endforeach; ?>
                </select>
                <?php if(empty($alternatif)): ?>
                    <small class="text-danger mt-2 d-block">Semua tempat makan di katalog sudah Anda nilai. Silakan tambahkan tempat makan baru di menu Data Alternatif.</small>
                <?php endif; ?>
            </div>

            <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i> Silakan beri penilaian skala 1-5 untuk setiap kriteria. Sistem akan otomatis mengonversinya menjadi nilai SMART.
            </div>

            <div class="row">
                <?php foreach ($kriteria as $k) : ?>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold"><?= esc($k['nama_kriteria']) ?></label>
                    <select class="form-select" name="nilai[<?= $k['id_kriteria'] ?>]" required>
                        <option value="" disabled selected>-- Pilih Skala --</option>
                        <option value="1">1 - Sangat Buruk</option>
                        <option value="2">2 - Buruk</option>
                        <option value="3">3 - Cukup</option>
                        <option value="4">4 - Baik</option>
                        <option value="5">5 - Sangat Baik</option>
                    </select>
                </div>
                <?php endforeach; ?>
            </div>
            
            <hr class="my-4">
            <button type="submit" class="btn btn-primary fw-bold px-4"><i class="fas fa-save me-2"></i> Simpan Penilaian</button>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
