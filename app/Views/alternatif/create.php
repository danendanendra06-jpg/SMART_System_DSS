<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold"><i class="fas fa-plus-circle me-2 text-primary"></i> Tambah Alternatif</h3>
    <a href="<?= base_url('alternatif') ?>" class="btn btn-secondary btn-custom"><i class="fas fa-arrow-left me-2"></i> Kembali</a>
</div>

<div class="card card-custom">
    <div class="card-body p-4">
        <form action="<?= base_url('alternatif/store') ?>" method="post">
            <?= csrf_field() ?>
            
            <div class="mb-3">
                <label for="nama_alternatif" class="form-label fw-bold">Nama Alternatif (Tempat Makan)</label>
                <input type="text" class="form-control <?= ($validation->hasError('nama_alternatif')) ? 'is-invalid' : ''; ?>" id="nama_alternatif" name="nama_alternatif" value="<?= old('nama_alternatif') ?>" placeholder="Contoh: Nasgor 962">
                <div class="invalid-feedback">
                    <?= $validation->getError('nama_alternatif') ?>
                </div>
            </div>
            
            <div class="mb-4">
                <label for="lokasi" class="form-label fw-bold">Lokasi / Area</label>
                <input type="text" class="form-control <?= ($validation->hasError('lokasi')) ? 'is-invalid' : ''; ?>" id="lokasi" name="lokasi" value="<?= old('lokasi') ?>" placeholder="Contoh: Kantin Gedung Z">
                <div class="invalid-feedback">
                    <?= $validation->getError('lokasi') ?>
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary btn-custom"><i class="fas fa-save me-2"></i> Simpan Data</button>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
