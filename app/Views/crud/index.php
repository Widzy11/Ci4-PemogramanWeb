<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Daftar Data Pegawai</h5>
        <a href="<?= base_url('crud/create') ?>" class="btn btn-light btn-sm text-primary fw-bold">+ Tambah Pegawai</a>
    </div>
    <div class="card-body">
        <?php if (session()->getFlashdata('pesan')) : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('pesan') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="table-responsive">
            <table id="example" class="table table-hover table-bordered align-middle">
                <thead class="table-dark">
                    <tr>
                        <th scope="col" style="width: 5%;">No</th>
                        <th scope="col" style="width: 10%;">Foto</th>
                        <th scope="col" style="width: 20%;">Nomor Pegawai</th>
                        <th scope="col" style="width: 25%;">Nama Pegawai</th>
                        <th scope="col" style="width: 25%;">Departemen</th>
                        <th scope="col" style="width: 15%;" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($pegawai)) : ?>
                        <?php $no = 1; foreach ($pegawai as $p) : ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td class="text-center">
                                    <img src="<?= base_url('img/' . $p['foto']) ?>" alt="Foto" width="50" height="50" class="rounded-circle shadow-sm object-fit-cover">
                                </td>
                                <td><?= esc($p['nomor_pegawai']) ?></td>
                                <td><?= esc($p['nama_pegawai']) ?></td>
                                <td>
                                    <span class="badge bg-info text-dark"><?= esc($p['nama_departemen']) ?></span>
                                    <small class="text-muted d-block"><?= esc($p['nama_bagian']) ?></small>
                                </td>
                                <td class="text-center">
                                    <a href="<?= base_url('crud/edit/' . $p['id']) ?>" class="btn btn-warning btn-sm text-dark">Edit</a>
                                    <a href="<?= base_url('crud/hapus/' . $p['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin?')">Hapus</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
