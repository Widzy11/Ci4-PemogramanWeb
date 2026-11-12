<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Daftar Data Departemen</h5>
        <a href="<?= base_url('departemen/create') ?>" class="btn btn-light btn-sm text-primary fw-bold">+ Tambah Departemen</a>
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
                        <th scope="col" style="width: 10%;">No</th>
                        <th scope="col" style="width: 40%;">Nama Departemen</th>
                        <th scope="col" style="width: 35%;">Nama Bagian / Divisi</th>
                        <th scope="col" style="width: 15%;" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($departemen)) : ?>
                        <?php $no = 1; foreach ($departemen as $d) : ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><span class="badge bg-primary fs-6"><?= esc($d['nama_departemen']) ?></span></td>
                                <td><?= esc($d['nama_bagian']) ?></td>
                                <td class="text-center">
                                    <a href="<?= base_url('departemen/edit/' . $d['id_departemen']) ?>" class="btn btn-warning btn-sm text-dark">Edit</a>
                                    <a href="<?= base_url('departemen/hapus/' . $d['id_departemen']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Menghapus departemen ini juga akan mempengaruhi data pegawai terkait. Lanjutkan?')">Hapus</a>
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
