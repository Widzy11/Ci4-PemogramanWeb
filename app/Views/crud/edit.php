<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="card shadow-sm">
    <div class="card-header bg-warning text-dark">
        <h5 class="mb-0">Form Edit Data Pegawai</h5>
    </div>
    <div class="card-body">
        <form action="<?= base_url('crud/update/' . $pegawai['id']) ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <input type="hidden" name="fotoLama" value="<?= esc($pegawai['foto']) ?>">
            <input type="hidden" id="id_pegawai" value="<?= esc($pegawai['id']) ?>">

            <!-- Nomor Pegawai dengan Cek Realtime -->
            <div class="mb-3">
                <label for="nomor_pegawai" class="form-label fw-semibold">Nomor Pegawai</label>
                <div class="input-group">
                    <input type="text" 
                           class="form-control <?= ($validation->hasError('nomor_pegawai')) ? 'is-invalid' : '' ?>" 
                           id="nomor_pegawai" 
                           name="nomor_pegawai" 
                           value="<?= old('nomor_pegawai', $pegawai['nomor_pegawai']) ?>" 
                           autocomplete="off"
                           autofocus>
                    <span class="input-group-text d-none" id="loading-spinner">
                        <span class="spinner-border spinner-border-sm text-primary" role="status"></span>
                    </span>
                </div>
                <!-- Pesan Notifikasi Realtime -->
                <div id="pesan-nomor" class="mt-1 small"></div>
                <?php if ($validation->hasError('nomor_pegawai')) : ?>
                    <div class="invalid-feedback d-block">
                        <?= $validation->getError('nomor_pegawai') ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Nama Pegawai -->
            <div class="mb-3">
                <label for="nama_pegawai" class="form-label fw-semibold">Nama Pegawai</label>
                <input type="text" 
                       class="form-control <?= ($validation->hasError('nama_pegawai')) ? 'is-invalid' : '' ?>" 
                       id="nama_pegawai" 
                       name="nama_pegawai" 
                       value="<?= old('nama_pegawai', $pegawai['nama_pegawai']) ?>">
                <div class="invalid-feedback">
                    <?= $validation->getError('nama_pegawai') ?>
                </div>
            </div>

            <!-- Dropdown Departemen Dinamis -->
            <div class="mb-3">
                <label for="id_departemen" class="form-label fw-semibold">Departemen</label>
                <select class="form-select <?= ($validation->hasError('id_departemen')) ? 'is-invalid' : '' ?>" 
                        id="id_departemen" 
                        name="id_departemen">
                    <option value="">-- Pilih Departemen --</option>
                    <?php foreach ($departemen as $d) : ?>
                        <option value="<?= $d['id_departemen'] ?>" <?= (old('id_departemen', $pegawai['id_departemen']) == $d['id_departemen']) ? 'selected' : '' ?>>
                            <?= esc($d['nama_departemen']) ?> - <?= esc($d['nama_bagian']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <div class="invalid-feedback">
                    <?= $validation->getError('id_departemen') ?>
                </div>
            </div>

            <!-- Upload Foto & Preview -->
            <div class="mb-3">
                <label for="foto" class="form-label fw-semibold">Foto Pegawai</label>
                <div class="mb-2">
                    <img src="<?= base_url('img/' . $pegawai['foto']) ?>" class="img-thumbnail img-preview d-block" width="120" height="120" alt="Preview Foto">
                </div>
                <input class="form-control <?= ($validation->hasError('foto')) ? 'is-invalid' : '' ?>" 
                       type="file" 
                       id="foto" 
                       name="foto" 
                       onchange="previewImage()">
                <div class="invalid-feedback">
                    <?= $validation->getError('foto') ?>
                </div>
                <div class="form-text">Biarkan kosong jika tidak ingin mengganti foto profil.</div>
            </div>

            <button type="submit" id="btn-simpan" class="btn btn-warning text-dark fw-bold">Update Data</button>
            <a href="<?= base_url('crud') ?>" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>

<!-- Script AJAX Cek Nomor Pegawai Realtime (Edit) -->
<script>
    const inputNomor = document.getElementById('nomor_pegawai');
    const pesanNomor = document.getElementById('pesan-nomor');
    const btnSimpan = document.getElementById('btn-simpan');
    const idPegawai = document.getElementById('id_pegawai').value;
    const spinner = document.getElementById('loading-spinner');
    let timeout = null;

    inputNomor.addEventListener('input', function () {
        const val = this.value.trim();

        clearTimeout(timeout);
        if (val === '') {
            pesanNomor.innerHTML = '';
            inputNomor.classList.remove('is-invalid', 'is-valid');
            btnSimpan.disabled = false;
            if (spinner) spinner.classList.add('d-none');
            return;
        }

        if (spinner) spinner.classList.remove('d-none');

        timeout = setTimeout(() => {
            fetch('<?= base_url('crud/cekNomorPegawai') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: 'nomor_pegawai=' + encodeURIComponent(val) + '&id=' + encodeURIComponent(idPegawai)
            })
            .then(res => res.json())
            .then(data => {
                if (spinner) spinner.classList.add('d-none');
                if (data.status === 'exists') {
                    inputNomor.classList.remove('is-valid');
                    inputNomor.classList.add('is-invalid');
                    pesanNomor.innerHTML = '<span class="text-danger fw-bold">&#10006; ' + data.message + '</span>';
                    btnSimpan.disabled = true;
                } else if (data.status === 'available') {
                    inputNomor.classList.remove('is-invalid');
                    inputNomor.classList.add('is-valid');
                    pesanNomor.innerHTML = '<span class="text-success fw-bold">&#10004; ' + data.message + '</span>';
                    btnSimpan.disabled = false;
                }
            })
            .catch(() => {
                if (spinner) spinner.classList.add('d-none');
            });
        }, 300);
    });
</script>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    $(document).ready(function () {
        $('#id_departemen').select2({
            theme: 'bootstrap-5',
            placeholder: '-- Pilih / Cari Departemen --',
            allowClear: true,
            ajax: {
                url: '<?= base_url('departemen/search') ?>',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return { q: params.term || '' };
                },
                processResults: function (data) {
                    return { results: data.results };
                },
                cache: true
            }
        });
    });
</script>
<?= $this->endSection() ?>
