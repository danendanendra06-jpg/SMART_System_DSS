<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold text-dark border-bottom pb-2"><?= session()->get('role') == 'admin' ? 'Data Penilaian Global' : 'Data Penilaian Saya' ?></h4>
    <?php if(session()->get('role') == 'user'): ?>
    <a href="<?= base_url('penilaian/create') ?>" class="btn btn-primary px-4 fw-bold"><i class="fas fa-plus me-2"></i> Beri Penilaian</a>
    <?php endif; ?>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle table-bordered text-center">
                <thead class="table-light">
                    <tr>
                        <th rowspan="2" class="align-middle" width="5%">No</th>
                        <?php if(session()->get('role') == 'admin'): ?>
                        <th rowspan="2" class="align-middle text-start">Responden (User)</th>
                        <?php endif; ?>
                        <th rowspan="2" class="align-middle text-start">Alternatif</th>
                        <th colspan="<?= count($kriteria) ?>">Nilai SMART (Konversi)</th>
                        <th rowspan="2" class="align-middle" width="10%">Aksi</th>
                    </tr>
                    <tr>
                        <?php foreach($kriteria as $k): ?>
                            <th><small><?= esc($k['nama_kriteria']) ?></small></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; foreach ($penilaian as $p) : ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <?php if(session()->get('role') == 'admin'): ?>
                        <td class="text-start fw-bold"><?= esc($p['nama_user']) ?></td>
                        <?php endif; ?>
                        <td class="text-start text-primary fw-bold"><?= esc($p['nama_alternatif']) ?></td>
                        
                        <?php foreach($kriteria as $k): ?>
                            <td><?= isset($nilaiMatrix[$p['id_penilaian']][$k['id_kriteria']]) ? esc($nilaiMatrix[$p['id_penilaian']][$k['id_kriteria']]) : '-' ?></td>
                        <?php endforeach; ?>

                        <td>
                            <?php if(session()->get('role') == 'admin' || session()->get('id_user') == $p['id_user']): ?>
                                <a href="<?= base_url('penilaian/edit/' . $p['id_penilaian']) ?>" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                <form action="<?= base_url('penilaian/delete/' . $p['id_penilaian']) ?>" method="post" class="d-inline">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus penilaian ini?')"><i class="fas fa-trash"></i></button>
                                </form>
                            <?php else: ?>
                                <span class="badge bg-secondary">Akses Terbatas</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    
                    <?php if(empty($penilaian)): ?>
                    <tr>
                        <td colspan="<?= (session()->get('role') == 'admin' ? 5 : 4) + count($kriteria) ?>" class="text-center py-4 text-muted">Belum ada data penilaian.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
