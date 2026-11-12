<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="<?= base_url('crud') ?>">Aplikasi CRUD CI4</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link <?= (uri_string() == '' || uri_string() == 'crud' || strpos(uri_string(), 'crud') === 0) ? 'active' : '' ?>" href="<?= base_url('crud') ?>">Data Pegawai</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= (strpos(uri_string(), 'departemen') === 0) ? 'active' : '' ?>" href="<?= base_url('departemen') ?>">Data Departemen</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
