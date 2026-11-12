<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Latihan CRUD') ?></title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('css/bootstrap.min.css') ?>">

    <!-- DataTables Bootstrap 5 CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
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
            <p class="col-md-4 mb-0 text-muted">&copy; 2025 CRUD CodeIgniter 4</p>
            <ul class="nav col-md-4 justify-content-end">
                <li class="nav-item"><a href="<?= base_url('crud') ?>" class="nav-link px-2 text-muted">Pegawai</a></li>
                <li class="nav-item"><a href="<?= base_url('departemen') ?>" class="nav-link px-2 text-muted">Departemen</a></li>
            </ul>
        </footer>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('js/bootstrap.bundle.min.js') ?>"></script>
    <!-- DataTables JS & Bootstrap 5 Integration -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

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
</body>
</html>
