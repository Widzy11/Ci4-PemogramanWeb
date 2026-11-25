<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Form Tambah Data Penilaian</h5>
    </div>
    <div class="card-body">
        <form action="<?= base_url('penilaian/create') ?>" method="post">
            <?= csrf_field() ?>

            <!-- Dropdown Search Select2 Pegawai (#7) -->
            <div class="mb-3">
                <label for="pegawai" class="form-label fw-semibold">No Pegawai / Nama Pegawai</label>
                <select class="form-select <?= ($validation->hasError('nomor_pegawai')) ? 'is-invalid' : '' ?>"
                        id="pegawai"
                        name="nomor_pegawai">
                    <option value="">-- Pilih / Cari Pegawai --</option>
                    <?php foreach ($pegawai as $p) : ?>
                        <option value="<?= esc($p['nomor_pegawai']) ?>" <?= old('nomor_pegawai') == $p['nomor_pegawai'] ? 'selected' : '' ?>>
                            <?= esc($p['nomor_pegawai']) ?> - <?= esc($p['nama_pegawai']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <div class="invalid-feedback">
                    <?= $validation->getError('nomor_pegawai') ?>
                </div>
            </div>

            <div class="mb-3">
                <label for="penilaian_kerja" class="form-label fw-semibold">Penilaian Kerja</label>
                <select class="form-select <?= ($validation->hasError('penilaian_kerja')) ? 'is-invalid' : '' ?>"
                        id="penilaian_kerja"
                        name="penilaian_kerja">
                    <option value="">-- Pilih Penilaian --</option>
                    <option value="1" <?= old('penilaian_kerja') == '1' ? 'selected' : '' ?>>Sangat Baik</option>
                    <option value="2" <?= old('penilaian_kerja') == '2' ? 'selected' : '' ?>>Cukup</option>
                    <option value="3" <?= old('penilaian_kerja') == '3' ? 'selected' : '' ?>>Buruk</option>
                </select>
                <div class="invalid-feedback">
                    <?= $validation->getError('penilaian_kerja') ?>
                </div>
            </div>

            <div class="mb-3">
                <label for="keterangan" class="form-label fw-semibold">Keterangan</label>
                <input type="text"
                       class="form-control <?= ($validation->hasError('keterangan')) ? 'is-invalid' : '' ?>"
                       id="keterangan"
                       name="keterangan"
                       value="<?= old('keterangan') ?>"
                       placeholder="Contoh: Lanjutkan / Tingkatkan Kinerja / Perbaiki Kinerja">
                <div class="invalid-feedback">
                    <?= $validation->getError('keterangan') ?>
                </div>
            </div>

            <div class="mb-3">
                <label for="tanggal_penilaian" class="form-label fw-semibold">Tanggal Penilaian</label>
                <input type="date"
                       class="form-control <?= ($validation->hasError('tanggal_penilaian')) ? 'is-invalid' : '' ?>"
                       id="tanggal_penilaian"
                       name="tanggal_penilaian"
                       value="<?= old('tanggal_penilaian', date('Y-m-d')) ?>">
                <div class="invalid-feedback">
                    <?= $validation->getError('tanggal_penilaian') ?>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Simpan Data</button>
            <a href="<?= base_url('penilaian') ?>" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    $(document).ready(function () {
        $('#pegawai').select2({
            theme: 'bootstrap-5',
            placeholder: '-- Pilih / Cari Pegawai --',
            allowClear: true
        });
    });
</script>
<?= $this->endSection() ?>
