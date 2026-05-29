<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold"><i class="fas fa-clipboard-list me-2 text-primary"></i> Data Penilaian Responden</h3>
    <a href="<?= base_url('penilaian/create') ?>" class="btn btn-primary btn-custom"><i class="fas fa-plus me-2"></i> Input Penilaian</a>
</div>

<div class="card card-custom">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle table-bordered text-center">
                <thead class="table-light">
                    <tr>
                        <th rowspan="2" class="align-middle" width="5%">No</th>
                        <th rowspan="2" class="align-middle text-start">Responden</th>
                        <th rowspan="2" class="align-middle text-start">Alternatif</th>
                        <th colspan="<?= count($kriteria) ?>">Nilai Kriteria</th>
                        <th rowspan="2" class="align-middle" width="10%">Aksi</th>
                    </tr>
                    <tr>
                        <?php foreach($kriteria as $k): ?>
                            <th><?= esc($k['nama_kriteria']) ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; foreach ($penilaian as $p) : ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td class="text-start fw-bold"><?= esc($p['nama_responden']) ?></td>
                        <td class="text-start text-primary fw-bold"><?= esc($p['nama_alternatif']) ?></td>
                        
                        <?php foreach($kriteria as $k): ?>
                            <td><?= isset($nilaiMatrix[$p['id_penilaian']][$k['id_kriteria']]) ? esc($nilaiMatrix[$p['id_penilaian']][$k['id_kriteria']]) : '-' ?></td>
                        <?php endforeach; ?>

                        <td>
                            <a href="<?= base_url('penilaian/edit/' . $p['id_penilaian']) ?>" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                            <form action="<?= base_url('penilaian/delete/' . $p['id_penilaian']) ?>" method="post" class="d-inline">
                                <?= csrf_field() ?>
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus data penilaian ini?')"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    
                    <?php if(empty($penilaian)): ?>
                    <tr>
                        <td colspan="<?= 4 + count($kriteria) ?>" class="text-center py-4 text-muted">Belum ada data penilaian.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
