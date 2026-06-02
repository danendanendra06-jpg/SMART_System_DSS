<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-md-12 mb-4">
        <h4 class="fw-bold text-dark border-bottom pb-2">Sistem Pendukung Keputusan Pemilihan Tempat Makan</h4>
        <p class="text-muted mt-2">
            Selamat datang di Dashboard Sistem Pendukung Keputusan menggunakan metode **SMART (Simple Multi Attribute Rating Technique)**.
        </p>
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
                    <h6>Langkah-langkah SMART:</h6>
                    <ol class="text-muted">
                        <li>Menentukan kriteria yang digunakan dalam menyelesaikan masalah.</li>
                        <li>Menentukan bobot preferensi masing-masing kriteria.</li>
                        <li>Menentukan penilaian alternatif pada setiap kriteria.</li>
                        <li>Menghitung nilai normalisasi bobot dari kriteria.</li>
                        <li>Menghitung nilai *utility* (kegunaan) untuk setiap alternatif.</li>
                        <li>Menghitung nilai akhir dan melakukan perankingan.</li>
                    </ol>
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