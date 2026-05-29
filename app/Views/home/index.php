<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="hero-section text-center">
    <h1 class="display-5 fw-bold mb-3"><i class="fas fa-utensils"></i> SPK Pemilihan Tempat Makan</h1>
    <p class="lead mb-4">Sistem Pendukung Keputusan Pemilihan Tempat Makan Hemat Mahasiswa di Lingkungan Kampus PNJ Menggunakan Metode SMART</p>
    <a href="<?= base_url('smart/kriteria') ?>" class="btn btn-light btn-lg btn-custom px-4 text-primary">Mulai Perhitungan SMART <i class="fas fa-arrow-right ms-2"></i></a>
</div>

<!-- Team Section -->
<div class="row mb-5 justify-content-center">
    <div class="col-md-12 text-center mb-4">
        <h4 class="fw-bold text-primary text-uppercase" style="letter-spacing: 1px;"><i class="fas fa-users-cog me-2"></i> Kelompok 3</h4>
        <div class="mx-auto bg-primary rounded" style="width: 50px; height: 3px;"></div>
    </div>
    
    <div class="col-md-10">
        <div class="row g-3 justify-content-center">
            <div class="col-lg-3 col-md-6">
                <div class="card card-custom text-center h-100 py-3 shadow-sm bg-light">
                    <div class="card-body">
                        <i class="fas fa-user-graduate fa-2x text-primary mb-3"></i>
                        <h6 class="fw-bold mb-2">Danendra Mahardika Putra Utama</h6>
                        <span class="badge bg-secondary rounded-pill px-3">2407412017</span>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="card card-custom text-center h-100 py-3 shadow-sm bg-light">
                    <div class="card-body">
                        <i class="fas fa-user-graduate fa-2x text-primary mb-3"></i>
                        <h6 class="fw-bold mb-2">Fathi Khairan Pratama</h6>
                        <span class="badge bg-secondary rounded-pill px-3">2407412024</span>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="card card-custom text-center h-100 py-3 shadow-sm bg-light">
                    <div class="card-body">
                        <i class="fas fa-user-graduate fa-2x text-primary mb-3"></i>
                        <h6 class="fw-bold mb-2">Husain</h6>
                        <span class="badge bg-secondary rounded-pill px-3">2407412012</span>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="card card-custom text-center h-100 py-3 shadow-sm bg-light">
                    <div class="card-body">
                        <i class="fas fa-user-graduate fa-2x text-primary mb-3"></i>
                        <h6 class="fw-bold mb-2">Nashwan Azzam Hilmy</h6>
                        <span class="badge bg-secondary rounded-pill px-3">2407412011</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-5">
    <div class="col-md-4">
        <div class="card card-custom text-center py-4 border-0 shadow-sm">
            <i class="fas fa-store fa-3x text-info mb-3"></i>
            <h3 class="fw-bold text-dark"><?= $countAlternatif ?></h3>
            <p class="text-muted mb-0">Total Alternatif</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-custom text-center py-4 border-0 shadow-sm">
            <i class="fas fa-users fa-3x text-danger mb-3"></i>
            <h3 class="fw-bold text-dark"><?= $countResponden ?></h3>
            <p class="text-muted mb-0">Total Responden</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-custom text-center py-4 border-0 shadow-sm">
            <i class="fas fa-crown fa-3x text-warning mb-3"></i>
            <h3 class="fw-bold text-dark text-truncate px-3"><?= esc($terbaik) ?></h3>
            <p class="text-muted mb-0">Tempat Makan Terbaik</p>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="card h-100 card-custom border-0 shadow-sm">
            <div class="card-body p-4">
                <h5 class="card-title fw-bold text-primary mb-3"><i class="fas fa-info-circle me-2"></i> Tentang Project</h5>
                <p class="card-text text-muted">Project ini bertujuan untuk membantu mahasiswa Politeknik Negeri Jakarta (PNJ) dalam menentukan tempat makan yang hemat dan sesuai dengan preferensi menggunakan metode <strong>Simple Multi Attribute Rating Technique (SMART)</strong>.</p>
                <p class="card-text text-muted mb-0">Sistem ini menerima masukan dari banyak responden untuk setiap tempat makan, kemudian menghitung nilai rata-rata dari setiap kriteria sebelum masuk ke perhitungan SMART.</p>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card h-100 card-custom border-0 shadow-sm">
            <div class="card-body p-4">
                <h5 class="card-title fw-bold text-success mb-3"><i class="fas fa-project-diagram me-2"></i> Alur Metode SMART</h5>
                <ul class="text-muted mb-0" style="line-height: 1.8;">
                    <li>Menentukan kriteria dan bobotnya (Harga, Porsi, Rasa, dll).</li>
                    <li>Mengumpulkan penilaian dari responden (Inisial diperbolehkan).</li>
                    <li>Menghitung rata-rata nilai kriteria dari semua responden.</li>
                    <li>Normalisasi bobot kriteria.</li>
                    <li>Menghitung nilai utility untuk setiap kriteria.</li>
                    <li>Menghitung nilai akhir dan perankingan alternatif.</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
