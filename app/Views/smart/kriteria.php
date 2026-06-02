<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="mb-4">
    <h3 class="fw-bold"><i class="fas fa-list me-2 text-primary"></i> 1. Kriteria Master</h3>
    <p class="text-muted">Daftar kriteria yang digunakan dalam pemilihan tempat makan. (Bobot ditentukan secara spesifik oleh masing-masing user pada menu Atur Bobot).</p>
</div>

<div class="card card-custom">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th width="5%">No</th>
                        <th>Kode</th>
                        <th class="text-start">Nama Kriteria</th>
                        <th>Jenis Kriteria</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; foreach ($kriteria as $k) : ?>
                    <tr>
                        <td><?= $i ?></td>
                        <td>C<?= $i ?></td>
                        <td class="text-start fw-bold"><?= esc($k['nama_kriteria']) ?></td>
                        <td>
                            <?php if($k['jenis'] == 'Benefit'): ?>
                                <span class="badge bg-success"><i class="fas fa-plus-circle me-1"></i> Benefit</span>
                            <?php else: ?>
                                <span class="badge bg-danger"><i class="fas fa-minus-circle me-1"></i> Cost</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php 
                        $i++; 
                    endforeach; 
                    ?>
                </tbody>
            </table>
        </div>
        
        <div class="d-flex justify-content-end mt-3">
            <a href="<?= base_url('smart/penilaian') ?>" class="btn btn-primary btn-custom">Selanjutnya: Data Penilaian <i class="fas fa-arrow-right ms-2"></i></a>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
