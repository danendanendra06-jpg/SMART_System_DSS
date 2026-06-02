<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold text-dark border-bottom pb-2">Tambah Tempat Makan Baru</h4>
    <a href="<?= base_url('alternatif') ?>" class="btn btn-secondary px-4"><i class="fas fa-arrow-left me-2"></i> Kembali</a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <p class="text-muted mb-4">Silakan daftarkan tempat makan baru ke dalam katalog. Sistem akan mendeteksi apabila tempat makan tersebut sudah ada.</p>
        <form action="<?= base_url('alternatif/store') ?>" method="post">
            <?= csrf_field() ?>
            
            <div class="mb-3 position-relative">
                <label for="nama_alternatif" class="form-label fw-bold">Nama Tempat Makan</label>
                <input type="text" class="form-control <?= ($validation->hasError('nama_alternatif')) ? 'is-invalid' : ''; ?>" id="nama_alternatif" name="nama_alternatif" value="<?= old('nama_alternatif') ?>" placeholder="Contoh: Nasgor 962" autocomplete="off">
                <div class="invalid-feedback">
                    <?= $validation->getError('nama_alternatif') ?>
                </div>
                <!-- Autocomplete Dropdown Container -->
                <ul class="list-group position-absolute w-100 shadow-sm mt-1" id="autocomplete-list" style="z-index: 1000; display: none;">
                    <!-- Items will be appended here by JS -->
                </ul>
            </div>
            
            <div class="mb-4">
                <label for="lokasi" class="form-label fw-bold">Lokasi / Area</label>
                <input type="text" class="form-control <?= ($validation->hasError('lokasi')) ? 'is-invalid' : ''; ?>" id="lokasi" name="lokasi" value="<?= old('lokasi') ?>" placeholder="Contoh: Kantin Gedung Z PNJ">
                <div class="invalid-feedback">
                    <?= $validation->getError('lokasi') ?>
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary px-4 fw-bold">Simpan ke Katalog</button>
        </form>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const inputField = document.getElementById('nama_alternatif');
    const resultList = document.getElementById('autocomplete-list');

    inputField.addEventListener('input', function() {
        let query = this.value;
        if(query.length > 1) {
            fetch('<?= base_url('alternatif/search') ?>?q=' + encodeURIComponent(query))
            .then(response => response.json())
            .then(data => {
                resultList.innerHTML = '';
                if(data.length > 0) {
                    resultList.style.display = 'block';
                    data.forEach(item => {
                        let li = document.createElement('li');
                        li.className = 'list-group-item list-group-item-action text-danger fw-bold cursor-pointer';
                        li.innerHTML = '<i class="fas fa-exclamation-triangle me-2"></i>' + item.nama_alternatif + ' <small class="text-muted fw-normal">(Sudah ada di sistem)</small>';
                        li.style.cursor = 'pointer';
                        li.addEventListener('click', function() {
                            alert('Alternatif "' + item.nama_alternatif + '" sudah tersedia. Gunakan alternatif yang sudah ada di menu Penilaian!');
                            inputField.value = '';
                            resultList.style.display = 'none';
                        });
                        resultList.appendChild(li);
                    });
                } else {
                    resultList.style.display = 'none';
                }
            });
        } else {
            resultList.style.display = 'none';
        }
    });

    document.addEventListener('click', function(e) {
        if(e.target !== inputField && e.target !== resultList) {
            resultList.style.display = 'none';
        }
    });
});
</script>
<?= $this->endSection() ?>
