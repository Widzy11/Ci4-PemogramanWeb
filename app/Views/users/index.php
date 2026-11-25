<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="mb-3">
    <a href="<?= base_url('users/create') ?>" class="btn btn-primary">Tambah Data</a>
</div>

<hr>

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

<div class="table-responsive bg-white p-3 rounded shadow-sm">
    <table id="example" class="table table-hover align-middle">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Username</th>
                <th scope="col">Email</th>
                <th scope="col">Role</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($users)) : ?>
                <?php $no = 1; foreach ($users as $u) : ?>
                    <tr>
                        <td><strong><?= $no++ ?></strong></td>
                        <td><?= esc($u['username']) ?></td>
                        <td><?= esc($u['email']) ?></td>
                        <td>
                            <?php if (($u['role'] ?? '') === 'admin') : ?>
                                <span class="badge bg-primary">admin</span>
                            <?php elseif (($u['role'] ?? '') === 'pengawas') : ?>
                                <span class="badge bg-info text-dark">pengawas</span>
                            <?php else : ?>
                                <span class="badge bg-secondary"><?= esc($u['role'] ?? '-') ?></span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <form action="<?= base_url('users/reset-password/' . $u['id']) ?>" method="post" class="d-inline" onsubmit="return confirm('Reset password user <?= esc($u['username']) ?> menjadi 123456?')">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn btn-warning btn-sm text-dark">Reset Password</button>
                            </form>
                            <form action="<?= base_url('users/hapus/' . $u['id']) ?>" method="post" class="d-inline" onsubmit="return confirm('Hapus user <?= esc($u['username']) ?>?')">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>
