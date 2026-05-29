<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold"><i class="fas fa-edit me-2 text-warning"></i> Edit Penilaian Responden</h3>
    <a href="<?= base_url('penilaian') ?>" class="btn btn-secondary btn-custom"><i class="fas fa-arrow-left me-2"></i> Kembali</a>
</div>

<div class="card card-custom">
    <div class="card-body p-4">
        <form action="<?= base_url('penilaian/update/' . $penilaian['id_penilaian']) ?>" method="post">
            <?= csrf_field() ?>
            
            <div class="row mb-4">
                <div class="col-md-6">
                    <label for="nama_responden" class="form-label fw-bold">Nama Responden / Inisial</label>
                    <input type="text" class="form-control" id="nama_responden" name="nama_responden" value="<?= old('nama_responden', $penilaian['nama_responden']) ?>" required>
                    <div class="form-text text-muted"><i class="fas fa-info-circle me-1"></i> Nama responden dapat menggunakan inisial atau kode responden (Contoh: R1, R2, DMP, dll).</div>
                </div>
                <div class="col-md-6">
                    <label for="id_alternatif" class="form-label fw-bold">Pilih Alternatif (Tempat Makan)</label>
                    <select class="form-select" id="id_alternatif" name="id_alternatif" required>
                        <option value="">-- Pilih Alternatif --</option>
                        <?php foreach($alternatif as $a): ?>
                            <option value="<?= $a['id_alternatif'] ?>" <?= old('id_alternatif', $penilaian['id_alternatif']) == $a['id_alternatif'] ? 'selected' : '' ?>><?= esc($a['nama_alternatif']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <h5 class="fw-bold mb-3 border-bottom pb-2">Nilai Kriteria</h5>
            <p class="text-muted small"><i class="fas fa-info-circle me-1"></i> Nilai 1-5 akan otomatis dikonversi ke nilai SMART oleh sistem.</p>

            <div class="row g-3 mb-4">
                <?php 
                $skalaOptions = [
                    'Harga (Cost)' => [
                        1 => '1 (Sangat Mahal)',
                        2 => '2 (Mahal)',
                        3 => '3 (Standar Mahasiswa)',
                        4 => '4 (Murah)',
                        5 => '5 (Sangat Murah)',
                    ],
                    'Porsi (Benefit)' => [
                        1 => '1 (Sangat Sedikit)',
                        2 => '2 (Sedikit)',
                        3 => '3 (Cukup)',
                        4 => '4 (Banyak)',
                        5 => '5 (Melimpah)',
                    ],
                    'Rasa Makanan (Benefit)' => [
                        1 => '1 (Sangat Kurang)',
                        2 => '2 (Kurang)',
                        3 => '3 (Cukup)',
                        4 => '4 (Enak)',
                        5 => '5 (Sangat Enak)',
                    ],
                    'Kebersihan (Benefit)' => [
                        1 => '1 (Sangat Kurang Bersih)',
                        2 => '2 (Kurang Bersih)',
                        3 => '3 (Standar)',
                        4 => '4 (Bersih)',
                        5 => '5 (Sangat Bersih & Higienis)',
                    ],
                    'Variasi Menu (Benefit)' => [
                        1 => '1 (Sangat Sedikit)',
                        2 => '2 (Sedikit)',
                        3 => '3 (Cukup)',
                        4 => '4 (Banyak)',
                        5 => '5 (Sangat Banyak)',
                    ],
                    'Waktu Pelayanan (Benefit)' => [
                        1 => '1 (Sangat Lambat)',
                        2 => '2 (Lambat)',
                        3 => '3 (Cukup)',
                        4 => '4 (Cepat)',
                        5 => '5 (Sangat Cepat)',
                    ]
                ];
                
                $defaultScale = [
                    1 => '1 (Sangat Buruk)',
                    2 => '2 (Buruk)',
                    3 => '3 (Cukup)',
                    4 => '4 (Baik)',
                    5 => '5 (Sangat Baik)',
                ];

                foreach($kriteria as $k): 
                    $options = $skalaOptions[$k['nama_kriteria']] ?? $defaultScale;
                    $current_nilai = $nilaiSelesai[$k['id_kriteria']] ?? '';
                ?>
                <div class="col-md-4">
                    <label class="form-label fw-bold text-primary"><?= esc($k['nama_kriteria']) ?> (<?= esc($k['jenis']) ?>)</label>
                    <select class="form-select" name="nilai[<?= $k['id_kriteria'] ?>]" required>
                        <option value="">-- Pilih Penilaian --</option>
                        <?php foreach($options as $val => $label): ?>
                            <option value="<?= $val ?>" <?= old('nilai.'.$k['id_kriteria'], $current_nilai) == $val ? 'selected' : '' ?>><?= $label ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <?php endforeach; ?>
            </div>
            
            <button type="submit" class="btn btn-warning btn-custom text-white"><i class="fas fa-save me-2"></i> Simpan Perubahan</button>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
