# Sistem Penilaian Kepegawaian — CodeIgniter 4 CRUD

Proyek **Sistem Penilaian Kepegawaian** berbasis **CodeIgniter 4** yang mengikuti seluruh materi dari playlist YouTube:
[Tutorial CodeIgniter 4 Terbaru 2025 | CRUD](https://youtube.com/playlist?list=PLzfy7lWzYumFlUqvfl0mQbTJ0VCTL7ghF&si=9BA_VtaQP9nwjHct)

---

## Checklist Kesesuaian Playlist YouTube (11 / 11 Video)

- [x] **Video 1** — [Tutorial Codeigniter 4 Untuk Pemula | Terbaru 2025 | CRUD Codeigniter 4](https://www.youtube.com/watch?v=Anb3akC65o4)
  - Instalasi & konfigurasi CodeIgniter 4 (`v4.1.8`), `.env`, koneksi database MySQL (`latihan`), dan setup dasar routing/controller.
- [x] **Video 2** — [Tutorial Codeigniter 4 Untuk Pemula | Terbaru 2025 | CRUD Codeigniter 4 #2](https://www.youtube.com/watch?v=TTmTarQqyPI)
  - Layout dinamis dengan Bootstrap 5 (`app/Views/layout/template.php`, `app/Views/layout/navbar.php`) serta tampilan daftar data pegawai (`Read`).
- [x] **Video 3** — [Tutorial Codeigniter 4 Untuk Pemula | Terbaru 2025 | CRUD Codeigniter 4 #3](https://www.youtube.com/watch?v=y34yxksvfgk)
  - Fitur tambah data (`Create`) pegawai melalui `Crud::create` & `Crud::save` dengan flashdata notifikasi.
- [x] **Video 4** — [Tutorial Codeigniter 4 Untuk Pemula | Terbaru 2025 | CRUD Codeigniter 4 #4](https://www.youtube.com/watch?v=6z3eSVsG5XY)
  - Fitur ubah (`Update`) dan hapus (`Delete`) data pegawai (`Crud::edit`, `Crud::update`, `Crud::delete`).
- [x] **Video 5** — [Tutorial Codeigniter 4 Untuk Pemula | Terbaru 2025 | From validation dan Relasi table #5](https://www.youtube.com/watch?v=0KuOVWLJGGk)
  - Form validation (aturan `required`, `is_unique`, pesan error per field) dan relasi tabel `pegawai` ↔ `departemen` (`Departemen` CRUD + `JOIN` pada `CrudModel`).
- [x] **Video 6** — [Tutorial Codeigniter 4 Untuk Pemula | Terbaru 2025 | Datables CRUD with Images & Files #6.1](https://www.youtube.com/watch?v=vkLI3fNvUsM)
  - Integrasi DataTables (`#example`), halaman beranda/dashboard (`Home::index` dengan kartu jumlah Pegawai, Departemen, dan Penilaian), serta struktur upload foto.
- [x] **Video 7** — [Tutorial Codeigniter 4 Untuk Pemula | Terbaru 2025 | CRUD with Images & Files #6.2](https://www.youtube.com/watch?v=LwsobRY92Io)
  - Upload, preview, edit (hapus foto lama), dan delete foto profil pegawai di `public/img/` dengan validasi ukuran & tipe gambar (`JPG`, `JPEG`, `PNG`).
- [x] **Video 8** — [Tutorial Codeigniter 4 Untuk Pemula | Terbaru 2025 | Search Autocomplete Files #7](https://www.youtube.com/watch?v=BqBemGU4o80)
  - Modul **Data Penilaian** (`Penilaian` CRUD, tabel `penilaian`, badge `Sangat Baik`/`Cukup`/`Buruk`) dengan **Select2 dropdown search / autocomplete** untuk memilih pegawai serta AJAX search (`/crud/searchPegawai`, `/departemen/search`, `/crud/cekNomorPegawai`).
- [x] **Video 9** — [Tutorial Codeigniter 4 Untuk Pemula 2025 #8-1 | Membuat Sistem Login & Registrasi](https://www.youtube.com/watch?v=tYxOjkrl1-8)
  - Instalasi & migrasi **Myth/Auth** (`lonnieezell/myth-auth`), sistem login/registrasi/logout, filter autentikasi global (`login`), serta **multi-role & permission** (`admin` dan `pengawas` di `auth_groups`, `auth_permissions`, `auth_groups_permissions`, `auth_groups_users`).
- [x] **Video 10** — [Tutorial Codeigniter 4 Untuk Pemula 2025 #8-2 | Membuat Sistem Login & Registrasi](https://www.youtube.com/watch?v=9iMlFpqVlwA)
  - Modul **Data User** khusus admin (`Users` CRUD: tambah user password default `123456`, reset password, hapus user) serta menu dropdown user di navbar (**Profil**, **Ubah Password**, **Logout**) melalui controller `Profile`.
- [x] **Video 11** — [Tutorial Codeigniter 4 Untuk Pemula 2025 #9 | Export to Word (CI4 + PhpWord)](https://www.youtube.com/watch?v=s1tGwYTCOz4)
  - Instalasi **PhpWord** (`phpoffice/phpword`) dan fitur **Cetak Data / Export Word (`.docx`)** pada **Data Penilaian** (`/penilaian/exportWord`) maupun **Data Pegawai** (`/crud/exportWord` & `/crud/exportWord/{id}` lengkap dengan foto).

---

## Ringkasan Database (`latihan`)

- `pegawai` — 8 data pegawai lengkap (`PEG-001` s/d `PEG-008`) beserta foto di `public/img/pegawai_01.jpg` s/d `pegawai_08.jpg`.
- `departemen` — 5 departemen (`Administrasi`, `Teknologi Informasi`, `Data & Informasi`, `Operasional`, `Pemasaran`).
- `penilaian` — 8 data penilaian kinerja untuk seluruh pegawai.
- Tabel Myth/Auth (`users`, `auth_groups`, `auth_permissions`, `auth_groups_permissions`, `auth_groups_users`, `auth_logins`, `auth_tokens`, `auth_activation_attempts`, `auth_reset_attempts`, `auth_users_permissions`).

### File Hasil Export Word
- `exports/Data_Pegawai.docx`
- `exports/Laporan_Penilaian_Pegawai.docx`

---

## Cara Menjalankan

1. Pastikan layanan **MySQL** (XAMPP) aktif dan database `latihan` sudah tersedia.
2. Jalankan server pengembangan CodeIgniter 4:
   ```powershell
   php spark serve
   ```
3. Buka di browser: `http://localhost:8080/`

### Akun Login
| Role | Username | Email | Password | Hak Akses |
|---|---|---|---|---|
| **Admin** | `admin` | `admin@example.com` | `Rahasia2025!` | Semua menu (`Home`, `Data Pegawai`, `Data Departemen`, `Data Penilaian` + Hapus, `Data User`, `Profil`, `Ubah Password`) |
| **Pengawas** | `pengawas1` | `pengawas1@example.com` | `123456` | `Home`, `Data Penilaian` (Tambah, Ubah, Cetak Word — tanpa Hapus), `Profil`, `Ubah Password` |
