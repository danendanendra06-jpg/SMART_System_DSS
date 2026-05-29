<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold"><i class="fas fa-edit me-2 text-warning"></i> Edit Responden</h3>
    <a href="<?= base_url('responden') ?>" class="btn btn-secondary btn-custom"><i class="fas fa-arrow-left me-2"></i> Kembali</a>
</div>

<div class="card card-custom">
    <div class="card-body p-4">
        <form action="<?= base_url('responden/update/' . $responden['id_responden']) ?>" method="post">
            <?= csrf_field() ?>
            
            <div class="mb-4">
                <label for="nama_responden" class="form-label fw-bold">Nama Responden / Mahasiswa</label>
                <input type="text" class="form-control <?= ($validation->hasError('nama_responden')) ? 'is-invalid' : ''; ?>" id="nama_responden" name="nama_responden" value="<?= old('nama_responden', $responden['nama_responden']) ?>">
                <div class="form-text text-muted"><i class="fas fa-info-circle me-1"></i> Nama responden dapat menggunakan inisial atau kode responden (Contoh: R1, R2, DMP, dll) karena digunakan hanya untuk simulasi.</div>
                <div class="invalid-feedback">
                    <?= $validation->getError('nama_responden') ?>
                </div>
            </div>
            
            <button type="submit" class="btn btn-warning btn-custom text-white"><i class="fas fa-save me-2"></i> Simpan Perubahan</button>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
