<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold"><i class="fas fa-edit me-2 text-warning"></i> Edit Alternatif</h3>
    <a href="<?= base_url('alternatif') ?>" class="btn btn-secondary btn-custom"><i class="fas fa-arrow-left me-2"></i> Kembali</a>
</div>

<div class="card card-custom">
    <div class="card-body p-4">
        <form action="<?= base_url('alternatif/update/' . $alternatif['id_alternatif']) ?>" method="post">
            <?= csrf_field() ?>
            
            <div class="mb-3">
                <label for="nama_alternatif" class="form-label fw-bold">Nama Alternatif (Tempat Makan)</label>
                <input type="text" class="form-control <?= ($validation->hasError('nama_alternatif')) ? 'is-invalid' : ''; ?>" id="nama_alternatif" name="nama_alternatif" value="<?= old('nama_alternatif', $alternatif['nama_alternatif']) ?>">
                <div class="invalid-feedback">
                    <?= $validation->getError('nama_alternatif') ?>
                </div>
            </div>
            
            <div class="mb-4">
                <label for="lokasi" class="form-label fw-bold">Lokasi / Area</label>
                <input type="text" class="form-control <?= ($validation->hasError('lokasi')) ? 'is-invalid' : ''; ?>" id="lokasi" name="lokasi" value="<?= old('lokasi', $alternatif['lokasi']) ?>">
                <div class="invalid-feedback">
                    <?= $validation->getError('lokasi') ?>
                </div>
            </div>
            
            <button type="submit" class="btn btn-warning btn-custom text-white"><i class="fas fa-save me-2"></i> Simpan Perubahan</button>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
