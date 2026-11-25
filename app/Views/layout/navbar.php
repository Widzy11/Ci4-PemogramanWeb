<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?= base_url('/') ?>">Navbar</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link <?= (uri_string() == '' || uri_string() == 'home') ? 'active' : '' ?>" href="<?= base_url('/') ?>">Home</a>
                </li>

                <?php if (function_exists('has_permission') && has_permission('data-pegawai')) : ?>
                    <li class="nav-item">
                        <a class="nav-link <?= (strpos(uri_string(), 'crud') === 0) ? 'active' : '' ?>" href="<?= base_url('crud') ?>">Data Pegawai</a>
                    </li>
                <?php endif; ?>

                <?php if (function_exists('has_permission') && has_permission('data-departemen')) : ?>
                    <li class="nav-item">
                        <a class="nav-link <?= (strpos(uri_string(), 'departemen') === 0) ? 'active' : '' ?>" href="<?= base_url('departemen') ?>">Data Departemen</a>
                    </li>
                <?php endif; ?>

                <?php if (function_exists('has_permission') && has_permission('data-penilaian')) : ?>
                    <li class="nav-item">
                        <a class="nav-link <?= (strpos(uri_string(), 'penilaian') === 0) ? 'active' : '' ?>" href="<?= base_url('penilaian') ?>">Data Penilaian</a>
                    </li>
                <?php endif; ?>

                <?php if (function_exists('has_permission') && has_permission('data-users')) : ?>
                    <li class="nav-item">
                        <a class="nav-link <?= (strpos(uri_string(), 'users') === 0) ? 'active' : '' ?>" href="<?= base_url('users') ?>">Data User</a>
                    </li>
                <?php endif; ?>

                <?php if (function_exists('logged_in') && logged_in()) : ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" id="navbarUserDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <?= esc(user()->username ?? user()->email) ?>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarUserDropdown">
                            <li><a class="dropdown-item" href="<?= base_url('profile') ?>">Profil</a></li>
                            <li><a class="dropdown-item" href="<?= base_url('profile/ubah-password') ?>">Ubah Password</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="<?= base_url('logout') ?>">Logout</a></li>
                        </ul>
                    </li>
                <?php else : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('login') ?>">Login</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
