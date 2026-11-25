<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Form Tambah Data User</h5>
    </div>
    <div class="card-body">
        <div class="alert alert-info py-2 small">
            Password default untuk user baru adalah <strong>123456</strong>. User dapat mengubah password sendiri melalui menu <strong>Profil &rarr; Ubah Password</strong>.
        </div>

        <form action="<?= base_url('users/create') ?>" method="post">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label for="username" class="form-label fw-semibold">Username</label>
                <input type="text"
                       class="form-control <?= ($validation->hasError('username')) ? 'is-invalid' : '' ?>"
                       id="username"
                       name="username"
                       value="<?= old('username') ?>"
                       placeholder="Masukkan username"
                       autofocus>
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
                       value="<?= old('email') ?>"
                       placeholder="contoh@email.com">
                <div class="invalid-feedback">
                    <?= $validation->getError('email') ?>
                </div>
            </div>

            <div class="mb-3">
                <label for="group_id" class="form-label fw-semibold">Role Akses</label>
                <select class="form-select <?= ($validation->hasError('group_id')) ? 'is-invalid' : '' ?>"
                        id="group_id"
                        name="group_id">
                    <option value="">-- Pilih Role --</option>
                    <?php foreach ($groups as $g) : ?>
                        <option value="<?= esc($g['id']) ?>" <?= old('group_id') == $g['id'] ? 'selected' : '' ?>>
                            <?= esc($g['name']) ?> - <?= esc($g['description']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <div class="invalid-feedback">
                    <?= $validation->getError('group_id') ?>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Simpan Data</button>
            <a href="<?= base_url('users') ?>" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
