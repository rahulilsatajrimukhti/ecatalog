# E-Catalog

Aplikasi katalog produk dan mitra (vendor) berbasis Laravel. Punya dua sisi:

- **Customer** (publik): beranda, katalog produk, detail produk, daftar mitra.
- **Admin** (login): dashboard, kelola produk, vendor, kategori, sub-kategori, menu, user, dan hak akses per level user.

Dokumen ini ditujukan untuk developer yang akan melanjutkan atau memelihara aplikasi.

---

## 1. Stack

| Bagian | Teknologi |
|---|---|
| Framework | Laravel 13, PHP 8.3 |
| Tampilan | Blade |
| UI customer | Bootstrap 5.3.3 (CDN), CSS kustom berawalan `ec-` di layout customer |
| UI admin | SB Admin 2 (Bootstrap 4) |
| Database | MySQL / MariaDB |
| Penyimpanan gambar | Disk Laravel yang bisa dikonfigurasi: lokal (`public`) atau object storage kompatibel S3 |

## 2. Arsitektur

```
Pengunjung / Admin
        |
   Web server (Nginx / Apache)
        |
   Aplikasi Laravel
      |         \
      v          v
  Database    Penyimpanan gambar
  (MySQL)     (disk lokal atau S3)
```

## 3. Setup lokal

```bash
git clone <url-repo>
cd ecatalog
composer install
cp .env.example .env
php artisan key:generate
```

Isi `.env` dengan koneksi database lokal (`DB_*`), lalu:

```bash
php artisan migrate
php artisan storage:link
php artisan serve
```

Catatan: seeder belum didokumentasikan. Cek folder `database/seeders` untuk data awal (user admin, menu, level).

## 4. Environment variables

Nilai rahasia **tidak boleh** masuk Git.

| Variabel | Fungsi |
|---|---|
| `APP_KEY` | Kunci enkripsi Laravel (sesi, cookie). Buat dengan `php artisan key:generate`. Gunakan kunci berbeda di tiap lingkungan. |
| `APP_ENV` | `local` atau `production` |
| `APP_DEBUG` | `false` di production |
| `APP_URL` | URL publik aplikasi |
| `DB_CONNECTION` | `mysql` |
| `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` | Koneksi database |
| `DB_USE_SSL` | Opsional. `true` untuk database yang mewajibkan SSL (memakai sertifikat CA di folder `certs/`, lihat `config/database.php`). Kosongkan jika tidak diperlukan. |
| `PRODUCT_IMAGE_DISK` | Disk penyimpanan gambar produk: `public` (default, disk lokal) atau `s3`. Dibaca `config/filesystems.php` sebagai `product_disk`. |
| `AWS_ACCESS_KEY_ID`, `AWS_SECRET_ACCESS_KEY`, `AWS_DEFAULT_REGION`, `AWS_BUCKET`, `AWS_ENDPOINT`, `AWS_USE_PATH_STYLE_ENDPOINT`, `AWS_URL` | Hanya dipakai jika `PRODUCT_IMAGE_DISK=s3`. `AWS_URL` adalah alamat publik gambar. |
| `SESSION_DRIVER`, `CACHE_STORE`, `LOG_CHANNEL` | Sesuaikan dengan lingkungan (lihat bagian Deploy) |

## 5. Struktur kode

Alur umum: **Route -> Controller -> Service -> Model**, dengan DTO (`app/DTO`) untuk membawa data form ke Service.

```
app/
  Http/Controllers/   controller tipis, memanggil Service
  Services/           logika bisnis: Auth, Categories, Dashboard, Menu,
                      Product, SubCategories, UserLevel, User, Vendor
  Models/             Categories, Menu, Product, SubCategories, User, UserLevel, Vendor
  DTO/                objek data untuk input form (mis. ProductDTO)
  Http/Requests/      validasi form (Store*/Update*)
  Http/Middleware/    CheckPermission (alias `check.permission`)
config/
  filesystems.php     disk gambar, termasuk `product_disk`
  database.php        opsi koneksi database, termasuk SSL opsional
bootstrap/app.php     routing, alias middleware, trustProxies
```

Hal yang perlu diketahui:

- **Gambar produk** disimpan dan dihapus lewat `ProductService`, yang membaca disk dari `config('filesystems.product_disk')`. Alamat gambar diambil lewat accessor `$product->image_url` di model `Product`. Jangan memakai `asset('storage/...')` langsung di Blade, supaya penyimpanan tetap bisa dipindah lewat konfigurasi.
- **Status stok** tersedia lewat accessor `stock_status` (`out`, `low`, `available`) dan scope `lowStock`, `outOfStock`, `needsAttention` di model `Product`.
- **Hak akses**: middleware `check.permission` memeriksa izin user berdasarkan level dan menu. Pengaturan izin ada di halaman `user-levels/{id}/permissions`.

## 6. Fitur dan route

### Customer (publik)

| URL | Route name | Controller | Fungsi |
|---|---|---|---|
| `/` | `customer.home` | `HomeController@index` | Beranda |
| `/katalog` | `customer.products.index` | `CustomerProductController@index` | Daftar produk, filter kategori, pencarian `?search=` |
| `/produk/{product}` | `customer.products.show` | `CustomerProductController@show` | Detail produk |
| `/mitra` | `customer.vendors.index` | `CustomerVendorController@index` | Daftar vendor, pencarian `?search=` |
| `/mitra/{vendor}` | `customer.vendors.show` | `CustomerVendorController@show` | Detail vendor |

### Autentikasi

| URL | Route name | Fungsi |
|---|---|---|
| `GET /login` | `login` | Form login (`AuthController@showLogin`) |
| `POST /login` | `login.process` | Proses login |
| `POST /logout` | `logout` | Logout |

### Admin

Semua resource memakai pola resource standar (`index`, `create`, `store`, `show`, `edit`, `update`, `destroy`):

| Prefix | Controller | Fungsi |
|---|---|---|
| `/dashboard` | `DashboardController` | Ringkasan dan daftar produk |
| `/products` | `ProductController` | Kelola produk, termasuk unggah gambar |
| `/vendors` | `VendorController` | Kelola vendor |
| `/categories` | `CategoriesController` | Kelola kategori |
| `/sub-categories` | `SubCategoriesController` | Kelola sub-kategori |
| `/menus` | `MenuController` | Kelola menu admin |
| `/users` | `UserController` | Kelola user |
| `/user-levels` | `UserLevelController` | Kelola level user |
| `/user-levels/{id}/permissions` | `UserLevelController@permissions`, `@updatePermissions` | Atur izin menu per level |

Daftar lengkap: `php artisan route:list --except-vendor`.

## 7. Database

Ada 11 tabel di database `ecatalog`:

| Tabel | Fungsi |
|---|---|
| `products` | Data produk (kode, nama, harga, stok, stok minimum, satuan, gambar, status aktif) |
| `categories`, `sub_categories` | Kategori dan sub-kategori produk |
| `vendors` | Data mitra/vendor |
| `users` | Akun admin. Masih memuat kolom sisa (`member_code`, `avatar`) yang belum dipakai dan boleh dibersihkan nanti. |
| `user_levels` | Level user |
| `menus`, `user_level_menus` | Menu admin dan izin menu per level user |
| `sessions`, `password_reset_tokens`, `migrations` | Tabel bawaan Laravel |

## 8. Deploy ke server (Linux, Nginx/Apache)

1. Siapkan PHP 8.3 beserta ekstensi yang dibutuhkan Laravel, serta Composer.
2. Arahkan web server ke folder `public/` (bukan root project).
3. Clone repo, lalu `composer install --no-dev --optimize-autoloader`.
4. Buat `.env` dari `.env.example`, lalu isi `APP_KEY`, `APP_ENV=production`, `APP_DEBUG=false`, `APP_URL`, dan koneksi database.
5. Atur driver untuk production, misalnya `SESSION_DRIVER=database` (tabel `sessions` sudah ada), `CACHE_STORE=file` atau `database`, dan `LOG_CHANNEL=daily`.
6. `php artisan migrate --force`
7. Penyimpanan gambar: dengan `PRODUCT_IMAGE_DISK=public`, jalankan `php artisan storage:link`. Atau isi variabel `AWS_*` dan `PRODUCT_IMAGE_DISK=s3` bila memakai object storage.
8. Beri izin tulis ke `storage/` dan `bootstrap/cache/` untuk user web server.
9. `php artisan config:cache`, `php artisan route:cache`, dan `php artisan view:cache`.
10. Pasang HTTPS. Jika aplikasi berada di belakang load balancer atau reverse proxy, pastikan `trustProxies` di `bootstrap/app.php` dibatasi ke IP proxy tersebut.

Memindahkan data dari lingkungan lain:

- **Database:** ekspor dengan `mysqldump --default-character-set=utf8mb4`, impor dengan opsi charset yang sama.
- **Gambar:** salin ke `storage/app/public/products` dengan nama file yang sama (kolom `image` menyimpan path seperti `products/namafile.png`).

Setelah mengubah `.env`, jalankan ulang `php artisan config:cache`.

## 9. Catatan penting

- **Gunakan `image_url`, bukan `asset('storage/...')`**, untuk menampilkan gambar produk.
- **Jangan memakai ulang `APP_KEY`, password, atau access key** antar lingkungan. Buat yang baru untuk tiap lingkungan, dan jangan commit `.env`.
- **Charset database:** gunakan `utf8mb4` saat ekspor dan impor agar karakter tidak rusak.
- **Perubahan skema** hanya lewat migrasi (`database/migrations`), lalu `php artisan migrate --force` di tiap lingkungan.
- **Mengubah `config/` atau `.env`** di production perlu `php artisan config:cache` ulang.