<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="card shadow-sm" style="max-width: 600px;">
    <div class="card-header bg-warning text-dark">
        <h5 class="mb-0">Ubah Password</h5>
    </div>
    <div class="card-body">
        <?php if (session()->getFlashdata('pesan')) : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('pesan') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')) : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('profile/update-password') ?>" method="post">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label for="password_lama" class="form-label fw-semibold">Password Lama</label>
                <input type="password"
                       class="form-control <?= ($validation->hasError('password_lama')) ? 'is-invalid' : '' ?>"
                       id="password_lama"
                       name="password_lama">
                <div class="invalid-feedback">
                    <?= $validation->getError('password_lama') ?>
                </div>
            </div>

            <div class="mb-3">
                <label for="password_baru" class="form-label fw-semibold">Password Baru</label>
                <input type="password"
                       class="form-control <?= ($validation->hasError('password_baru')) ? 'is-invalid' : '' ?>"
                       id="password_baru"
                       name="password_baru">
                <div class="invalid-feedback">
                    <?= $validation->getError('password_baru') ?>
                </div>
            </div>

            <div class="mb-3">
                <label for="konfirmasi_password" class="form-label fw-semibold">Konfirmasi Password Baru</label>
                <input type="password"
                       class="form-control <?= ($validation->hasError('konfirmasi_password')) ? 'is-invalid' : '' ?>"
                       id="konfirmasi_password"
                       name="konfirmasi_password">
                <div class="invalid-feedback">
                    <?= $validation->getError('konfirmasi_password') ?>
                </div>
            </div>

            <button type="submit" class="btn btn-warning text-dark fw-bold">Simpan Password</button>
            <a href="<?= base_url('/') ?>" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
