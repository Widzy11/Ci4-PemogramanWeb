<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="mb-3 d-flex gap-2">
    <a href="<?= base_url('penilaian/create') ?>" class="btn btn-primary">Tambah Data</a>
    <a href="<?= base_url('penilaian/exportWord') ?>" class="btn btn-warning text-dark">Cetak Data</a>
</div>

<hr>

<?php if (session()->getFlashdata('pesan')) : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('pesan') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="table-responsive bg-white p-3 rounded shadow-sm">
    <table id="example" class="table table-hover align-middle">
        <thead>
            <tr>
                <th scope="col">No Table</th>
                <th scope="col">No Pegawai</th>
                <th scope="col">Nama Pegawai</th>
                <th scope="col">Penilaian Kerja</th>
                <th scope="col">Keterangan</th>
                <th scope="col">Tanggal Penilaian</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($penilaian)) : ?>
                <?php $no = 1; foreach ($penilaian as $row) : ?>
                    <tr>
                        <td><strong><?= $no++ ?></strong></td>
                        <td><?= esc($row['nomor_pegawai']) ?></td>
                        <td><?= esc($row['nama_pegawai'] ?? '-') ?></td>
                        <td>
                            <?php if ((int) $row['penilaian_kerja'] === 1) : ?>
                                <span class="badge bg-success">Sangat Baik</span>
                            <?php elseif ((int) $row['penilaian_kerja'] === 2) : ?>
                                <span class="badge bg-info text-dark">Cukup</span>
                            <?php else : ?>
                                <span class="badge bg-danger">Buruk</span>
                            <?php endif; ?>
                        </td>
                        <td><?= esc($row['keterangan']) ?></td>
                        <td><?= esc($row['tanggal_penilaian']) ?></td>
                        <td>
                            <a href="<?= base_url('penilaian/edit/' . $row['id']) ?>" class="btn btn-info btn-sm text-dark">Ubah</a>
                            <?php if (function_exists('has_permission') && has_permission('data-pegawai')) : ?>
                                <a href="<?= base_url('penilaian/hapus/' . $row['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data penilaian ini?')">Hapus</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>
