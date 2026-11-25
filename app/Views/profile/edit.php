<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="card shadow-sm" style="max-width: 600px;">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Edit Profil</h5>
    </div>
    <div class="card-body">
        <?php if (session()->getFlashdata('pesan')) : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('pesan') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('profile/update') ?>" method="post">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label for="username" class="form-label fw-semibold">Username</label>
                <input type="text"
                       class="form-control <?= ($validation->hasError('username')) ? 'is-invalid' : '' ?>"
                       id="username"
                       name="username"
                       value="<?= old('username', $user['username']) ?>">
                <div class="invalid-feedback">
                    <?= $validation->getError('username') ?>
                </div>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label fw-semibold">Email</label>
                <input type="email"
                       class="form-control <?= ($validation->hasError('email')) ? 'is-invalid' : '' ?>"
                       id="email"
                       name="email"
                       value="<?= old('email', $user['email']) ?>">
                <div class="invalid-feedback">
                    <?= $validation->getError('email') ?>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="<?= base_url('/') ?>" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
