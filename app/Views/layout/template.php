<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Latihan CRUD') ?></title>

    <!-- Bootstrap 5 CSS (single source to avoid version/plugin conflicts) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- DataTables Bootstrap 5 CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <!-- Select2 CSS & Bootstrap 5 Theme -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <!-- Navbar -->
    <?= $this->include('layout/navbar') ?>

    <!-- Main Content Container -->
    <div class="container my-4">
        <?= $this->renderSection('content') ?>
    </div>

    <!-- Footer -->
    <div class="container">
        <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
            <p class="col-md-4 mb-0 text-muted">&copy; 2025 Sistem Penilaian Kepegawaian</p>
            <ul class="nav col-md-8 justify-content-end">
                <li class="nav-item"><a href="<?= base_url('/') ?>" class="nav-link px-2 text-muted">Home</a></li>
                <?php if (function_exists('has_permission') && has_permission('data-pegawai')) : ?>
                    <li class="nav-item"><a href="<?= base_url('crud') ?>" class="nav-link px-2 text-muted">Data Pegawai</a></li>
                <?php endif; ?>
                <?php if (function_exists('has_permission') && has_permission('data-departemen')) : ?>
                    <li class="nav-item"><a href="<?= base_url('departemen') ?>" class="nav-link px-2 text-muted">Data Departemen</a></li>
                <?php endif; ?>
                <?php if (function_exists('has_permission') && has_permission('data-penilaian')) : ?>
                    <li class="nav-item"><a href="<?= base_url('penilaian') ?>" class="nav-link px-2 text-muted">Data Penilaian</a></li>
                <?php endif; ?>
                <?php if (function_exists('has_permission') && has_permission('data-users')) : ?>
                    <li class="nav-item"><a href="<?= base_url('users') ?>" class="nav-link px-2 text-muted">Data User</a></li>
                <?php endif; ?>
            </ul>
        </footer>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- Bootstrap 5 JS Bundle (loaded once so dropdowns & modals work properly) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables JS & Bootstrap 5 Integration -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- Script DataTables & Image Preview -->
    <script>
        $(document).ready(function () {
            if ($('#example').length) {
                $('#example').DataTable({
                    language: {
                        search: "Cari:",
                        lengthMenu: "Tampilkan _MENU_ data per halaman",
                        zeroRecords: "Tidak ada data yang cocok ditemukan",
                        info: "Menampilkan halaman _PAGE_ dari _PAGES_",
                        infoEmpty: "Tidak ada data tersedia",
                        infoFiltered: "(disaring dari total _MAX_ data)",
                        paginate: {
                            first: "Awal",
                            last: "Akhir",
                            next: "Berikutnya",
                            previous: "Sebelumnya"
                        }
                    }
                });
            }
        });

        // Function Preview Gambar Upload
        function previewImage() {
            const foto = document.querySelector('#foto');
            const imgPreview = document.querySelector('.img-preview');

            if (foto && foto.files && foto.files[0]) {
                const fileReader = new FileReader();
                fileReader.readAsDataURL(foto.files[0]);

                fileReader.onload = function(e) {
                    imgPreview.src = e.target.result;
                }
            }
        }
    </script>

    <?= $this->renderSection('scripts') ?>
</body>
</html>
