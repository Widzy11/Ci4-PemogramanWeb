<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<?php if (session()->getFlashdata('error')) : ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= esc(session()->getFlashdata('error')) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="row justify-content-md-center">
    <div class="col-md-auto">
        <div class="card shadow-sm" style="max-width: 48rem;">
            <div class="card-body text-center">
                <h1 class="h3 mb-0">Selamat Datang di Sistem Penilaian Kepegawaian</h1>
            </div>
            <img src="https://www.telkomsel.com/enterprise/sites/default/files/2024-06/proses%20HR%2C%20seperti%20rekrutmen%2C%20manajemen%20kinerja%2C%20atau%20analisis%20data%20karyawan%20dapat%20diolah%20melalui%20sistem%20HRIS_0.png"
                 class="card-img-bottom"
                 alt="Sistem Penilaian Kepegawaian"
                 onerror="this.style.display='none'">
        </div>
    </div>
</div>

<div class="row justify-content-md-center g-3 mt-4">
    <div class="col-md-4 col-lg-3">
        <div class="card text-white bg-success shadow-sm h-100">
            <div class="card-header">Jumlah Data Pegawai</div>
            <div class="card-body">
                <h2 class="card-title mb-0"><?= esc($jumlahPegawai) ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-lg-3">
        <div class="card text-white bg-primary shadow-sm h-100">
            <div class="card-header">Jumlah Data Departemen</div>
            <div class="card-body">
                <h2 class="card-title mb-0"><?= esc($jumlahDepartemen) ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-lg-3">
        <div class="card text-white shadow-sm h-100" style="background: sienna;">
            <div class="card-header">Jumlah Penilaian</div>
            <div class="card-body">
                <h2 class="card-title mb-0"><?= esc($jumlahPenilaian) ?></h2>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
