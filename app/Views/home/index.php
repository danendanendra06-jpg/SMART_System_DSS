<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-md-12 mb-4">
        <h4 class="fw-bold text-dark border-bottom pb-2">Dashboard Sistem Pendukung Keputusan</h4>
        <p class="text-muted mt-2">
            Selamat datang di SPK Pemilihan Tempat Makan menggunakan metode <strong>SMART (Simple Multi Attribute Rating Technique)</strong>.
        </p>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm h-100 border-start border-4 border-primary">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-3"><i class="fas fa-question-circle text-primary me-2"></i> Kasus Permasalahan</h5>
                <p class="text-muted mb-0" style="text-align: justify;">
                    Mahasiswa sering mengalami kesulitan dalam menentukan tempat makan yang sesuai dengan kebutuhan dan preferensi masing-masing. Setiap mahasiswa memiliki pertimbangan yang berbeda, seperti harga yang murah, porsi yang banyak, rasa yang enak, kebersihan tempat, variasi menu, maupun kecepatan pelayanan. Oleh karena itu dibutuhkan Sistem Pendukung Keputusan (SPK) yang dapat membantu memberikan rekomendasi tempat makan terbaik secara objektif berdasarkan preferensi pengguna.
                </p>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card border-0 shadow-sm h-100 border-start border-4 border-success">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-3"><i class="fas fa-bullseye text-success me-2"></i> Tujuan Sistem</h5>
                <p class="text-muted mb-0" style="text-align: justify;">
                    Sistem ini bertujuan membantu mahasiswa dalam memilih tempat makan terbaik menggunakan metode SMART (Simple Multi Attribute Rating Technique) berdasarkan beberapa kriteria yang telah ditentukan sehingga proses pengambilan keputusan menjadi lebih cepat, objektif, dan terukur.
                </p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <h5 class="fw-bold border-bottom pb-2">Metode SMART</h5>
                <p class="text-muted mt-3" style="text-align: justify;">
                    SMART adalah metode pengambilan keputusan multi kriteria. Teknik pembuatan keputusan multi kriteria ini didasarkan pada teori bahwa setiap alternatif terdiri dari sejumlah kriteria yang memiliki nilai-nilai dan setiap kriteria memiliki bobot yang menggambarkan seberapa penting ia dibandingkan dengan kriteria lain.
                </p>
                <div class="mt-4">
                    <h6>Tahapan Metode SMART:</h6>
                    <ol class="text-muted mb-0">
                        <li>Menentukan Bobot Preferensi Kriteria</li>
                        <li>Memberikan Penilaian Alternatif</li>
                        <li>Menghitung Bobot Normalisasi</li>
                        <li>Menghitung Nilai Utility</li>
                        <li>Menghitung Nilai Akhir SMART</li>
                        <li>Menentukan Ranking Alternatif</li>
                    </ol>
                </div>
            </div>
        </div>
        </div>
        
        <div class="card border-0 shadow-sm mt-4">
            <div class="card-body p-4">
                <h5 class="fw-bold border-bottom pb-2">Rumus Metode SMART</h5>
                <div class="row mt-3 text-muted">
                    <div class="col-md-6 mb-3">
                        <strong class="text-dark">1. Normalisasi Bobot</strong>
                        <div class="bg-light p-2 rounded mt-1 text-center font-monospace small">Wj = wj / Σwj</div>
                        <small>Membuat total seluruh bobot menjadi 1.</small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong class="text-dark">2. Nilai Akhir SMART</strong>
                        <div class="bg-light p-2 rounded mt-1 text-center font-monospace small">U(ai) = Σ(Wj × Uij)</div>
                        <small>Perkalian bobot normalisasi dengan utility.</small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong class="text-dark">3. Utility (Benefit)</strong>
                        <div class="bg-light p-2 rounded mt-1 text-center font-monospace small">U = (Cout - Cmin) / (Cmax - Cmin)</div>
                        <small>Digunakan jika kriteria semakin besar semakin baik.</small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong class="text-dark">4. Utility (Cost)</strong>
                        <div class="bg-light p-2 rounded mt-1 text-center font-monospace small">U = (Cmax - Cout) / (Cmax - Cmin)</div>
                        <small>Digunakan jika kriteria semakin kecil semakin baik.</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4 text-center">
                <h5 class="fw-bold border-bottom pb-2">Anggota Kelompok</h5>
                <div class="mt-4 text-start px-2">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-light rounded-circle p-2 me-3">
                            <i class="fas fa-user text-primary"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold">Danendra Mahardika Putra Utama</h6>
                            <small class="text-muted">NIM: 2407412017</small>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-light rounded-circle p-2 me-3">
                            <i class="fas fa-user text-primary"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold">Fathi Khairan Pratama</h6>
                            <small class="text-muted">NIM: 2407412024</small>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-light rounded-circle p-2 me-3">
                            <i class="fas fa-user text-primary"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold">Husain</h6>
                            <small class="text-muted">NIM: 2407412012</small>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="bg-light rounded-circle p-2 me-3">
                            <i class="fas fa-user text-primary"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold">Nashwan Azzam Hilmy</h6>
                            <small class="text-muted">NIM: 2407412011</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-2">
    <div class="col-md-12 text-center">
        <?php if (session()->get('role') == 'user'): ?>
            <a href="<?= base_url('userbobot') ?>" class="btn btn-primary px-4 py-2 fw-bold">Mulai Atur Bobot (SMART)</a>
        <?php else: ?>
            <a href="<?= base_url('smart/rata-rata') ?>" class="btn btn-primary px-4 py-2 fw-bold">Lihat Proses SMART</a>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>