<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Form Tambah Data Pegawai</h5>
    </div>
    <div class="card-body">
        <form action="<?= base_url('crud/create') ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <!-- Nomor Pegawai -->
            <div class="mb-3">
                <label for="nomor_pegawai" class="form-label fw-semibold">Nomor Pegawai</label>
                <input type="text" 
                       class="form-control <?= ($validation->hasError('nomor_pegawai')) ? 'is-invalid' : '' ?>" 
                       id="nomor_pegawai" 
                       name="nomor_pegawai" 
                       value="<?= old('nomor_pegawai') ?>" 
                       placeholder="Contoh: PEG-003" 
                       autofocus>
                <div class="invalid-feedback">
                    <?= $validation->getError('nomor_pegawai') ?>
                </div>
            </div>

            <!-- Nama Pegawai -->
            <div class="mb-3">
                <label for="nama_pegawai" class="form-label fw-semibold">Nama Pegawai</label>
                <input type="text" 
                       class="form-control <?= ($validation->hasError('nama_pegawai')) ? 'is-invalid' : '' ?>" 
                       id="nama_pegawai" 
                       name="nama_pegawai" 
                       value="<?= old('nama_pegawai') ?>" 
                       placeholder="Masukkan nama lengkap pegawai">
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
                        <option value="<?= $d['id_departemen'] ?>" <?= old('id_departemen') == $d['id_departemen'] ? 'selected' : '' ?>>
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
                    <img src="<?= base_url('img/default.jpg') ?>" class="img-thumbnail img-preview d-block" width="120" height="120" alt="Preview Foto">
                </div>
                <input class="form-control <?= ($validation->hasError('foto')) ? 'is-invalid' : '' ?>" 
                       type="file" 
                       id="foto" 
                       name="foto" 
                       onchange="previewImage()">
                <div class="invalid-feedback">
                    <?= $validation->getError('foto') ?>
                </div>
                <div class="form-text">Maksimal 1MB (JPG, JPEG, PNG). Jika dikosongkan akan menggunakan foto default.</div>
            </div>

            <button type="submit" class="btn btn-primary">Simpan Data</button>
            <a href="<?= base_url('crud') ?>" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
