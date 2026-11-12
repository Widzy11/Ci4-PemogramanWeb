<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="card shadow-sm">
    <div class="card-header bg-warning text-dark">
        <h5 class="mb-0">Form Edit Data Departemen</h5>
    </div>
    <div class="card-body">
        <form action="<?= base_url('departemen/update/' . $departemen['id_departemen']) ?>" method="post">
            <?= csrf_field() ?>

            <!-- Nama Departemen -->
            <div class="mb-3">
                <label for="nama_departemen" class="form-label fw-semibold">Nama Departemen</label>
                <input type="text" 
                       class="form-control <?= ($validation->hasError('nama_departemen')) ? 'is-invalid' : '' ?>" 
                       id="nama_departemen" 
                       name="nama_departemen" 
                       value="<?= old('nama_departemen', $departemen['nama_departemen']) ?>" 
                       autofocus>
                <div class="invalid-feedback">
                    <?= $validation->getError('nama_departemen') ?>
                </div>
            </div>

            <!-- Nama Bagian -->
            <div class="mb-3">
                <label for="nama_bagian" class="form-label fw-semibold">Nama Bagian / Divisi</label>
                <input type="text" 
                       class="form-control <?= ($validation->hasError('nama_bagian')) ? 'is-invalid' : '' ?>" 
                       id="nama_bagian" 
                       name="nama_bagian" 
                       value="<?= old('nama_bagian', $departemen['nama_bagian']) ?>">
                <div class="invalid-feedback">
                    <?= $validation->getError('nama_bagian') ?>
                </div>
            </div>

            <button type="submit" class="btn btn-warning text-dark fw-bold">Update Data</button>
            <a href="<?= base_url('departemen') ?>" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
