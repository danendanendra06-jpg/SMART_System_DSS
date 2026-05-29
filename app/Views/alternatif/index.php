<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold"><i class="fas fa-store me-2 text-primary"></i> Data Alternatif</h3>
    <a href="<?= base_url('alternatif/create') ?>" class="btn btn-primary btn-custom"><i class="fas fa-plus me-2"></i> Tambah Alternatif</a>
</div>

<div class="card card-custom">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th width="5%" class="text-center">No</th>
                        <th>Nama Alternatif (Tempat Makan)</th>
                        <th>Lokasi</th>
                        <th width="15%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; foreach ($alternatif as $a) : ?>
                    <tr>
                        <td class="text-center"><?= $i++ ?></td>
                        <td class="fw-bold"><?= esc($a['nama_alternatif']) ?></td>
                        <td><i class="fas fa-map-marker-alt text-danger me-1"></i> <?= esc($a['lokasi']) ?></td>
                        <td class="text-center">
                            <a href="<?= base_url('alternatif/edit/' . $a['id_alternatif']) ?>" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                            <form action="<?= base_url('alternatif/delete/' . $a['id_alternatif']) ?>" method="post" class="d-inline">
                                <?= csrf_field() ?>
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini? Semua data penilaian dan hasil terkait juga akan terhapus.')"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    
                    <?php if(empty($alternatif)): ?>
                    <tr>
                        <td colspan="4" class="text-center py-4 text-muted">Belum ada data alternatif.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
