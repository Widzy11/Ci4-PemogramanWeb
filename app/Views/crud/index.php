<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white d-flex flex-wrap justify-content-between align-items-center gap-2">
        <h5 class="mb-0">Daftar Data Pegawai</h5>
        <div class="d-flex gap-2">
            <a href="<?= base_url('crud/exportWord') ?>" class="btn btn-success btn-sm fw-bold">Export Word (.docx)</a>
            <a href="<?= base_url('crud/create') ?>" class="btn btn-light btn-sm text-primary fw-bold">+ Tambah Pegawai</a>
        </div>
    </div>
    <div class="card-body">
        <?php if (session()->getFlashdata('pesan')) : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('pesan') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- Search Autocomplete Pegawai (Select2 + jQuery AJAX) -->
        <div class="row mb-3 align-items-end">
            <div class="col-md-6">
                <label for="search_pegawai" class="form-label fw-semibold small text-muted mb-1">Cari Cepat Pegawai (Autocomplete AJAX)</label>
                <select id="search_pegawai" class="form-select"></select>
            </div>
            <?php if (!empty($selectedId)) : ?>
                <div class="col-md-auto mt-2 mt-md-0">
                    <a href="<?= base_url('crud') ?>" class="btn btn-outline-secondary btn-sm">Tampilkan Semua</a>
                </div>
            <?php endif; ?>
        </div>

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
                                    <a href="<?= base_url('crud/exportWord/' . $p['id']) ?>" class="btn btn-info btn-sm text-white" title="Export ke Word">Word</a>
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

<?= $this->section('scripts') ?>
<script>
    $(document).ready(function () {
        $('#search_pegawai').select2({
            theme: 'bootstrap-5',
            placeholder: 'Ketik nomor, nama pegawai, atau departemen...',
            allowClear: true,
            ajax: {
                url: '<?= base_url('crud/searchPegawai') ?>',
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
        }).on('select2:select', function (e) {
            const id = e.params.data.id;
            if (id) {
                window.location.href = '<?= base_url('crud') ?>?pegawai_id=' + encodeURIComponent(id);
            }
        });
    });
</script>
<?= $this->endSection() ?>
