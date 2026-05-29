<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold"><i class="fas fa-users me-2 text-primary"></i> Data Responden</h3>
    <a href="<?= base_url('responden/create') ?>" class="btn btn-primary btn-custom"><i class="fas fa-plus me-2"></i> Tambah Responden</a>
</div>

<div class="card card-custom">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th width="5%" class="text-center">No</th>
                        <th>Nama Responden</th>
                        <th>Tanggal Input</th>
                        <th width="15%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; foreach ($responden as $r) : ?>
                    <tr>
                        <td class="text-center"><?= $i++ ?></td>
                        <td class="fw-bold"><?= esc($r['nama_responden']) ?></td>
                        <td><?= esc($r['tanggal_input']) ?></td>
                        <td class="text-center">
                            <a href="<?= base_url('responden/edit/' . $r['id_responden']) ?>" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                            <form action="<?= base_url('responden/delete/' . $r['id_responden']) ?>" method="post" class="d-inline">
                                <?= csrf_field() ?>
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus responden ini? Semua data penilaiannya juga akan terhapus.')"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    
                    <?php if(empty($responden)): ?>
                    <tr>
                        <td colspan="4" class="text-center py-4 text-muted">Belum ada data responden.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
