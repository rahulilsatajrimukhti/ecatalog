# E-Catalog

Aplikasi katalog produk dan mitra (vendor) berbasis Laravel. Punya dua sisi:

- **Customer** (publik): beranda, katalog produk, detail produk, daftar mitra.
- **Admin** (login): dashboard, kelola produk, vendor, kategori, sub-kategori, menu, user, dan hak akses per level user.

Dokumen ini ditujukan untuk developer yang akan melanjutkan atau memelihara aplikasi.

---

## 1. Stack

| Bagian | Teknologi |
|---|---|
| Framework | Laravel 13.6, PHP 8.3 |
| Tampilan | Blade |
| UI customer | Bootstrap 5.3.3 (CDN), CSS kustom berawalan `ec-` di layout customer |
| UI admin | SB Admin 2 (Bootstrap 4) |
| Database lokal | MySQL (Laragon) |
| Database production | TiDB Cloud Starter (kompatibel MySQL) |
| Penyimpanan gambar production | Supabase Storage (protokol S3) |
| Hosting | Vercel, runtime komunitas `vercel-php@0.9.0` |

## 2. Arsitektur

```
Pengunjung / Admin
        |
     Vercel  (aplikasi Laravel, region sin1)
      |     \
      |      \--> Supabase Storage  (gambar produk, bucket `products`)
      v
  TiDB Cloud  (database `ecatalog`, Singapore, wajib SSL)

GitHub (repo `ecatalog`)  --git push ke main-->  Vercel (deploy otomatis)
```

## 3. Setup lokal

```bash
git clone <url-repo>
cd ecatalog
composer install
cp .env.example .env
php artisan key:generate
```

Isi `.env` dengan koneksi MySQL lokal (`DB_*`), lalu:

```bash
php artisan migrate
php artisan storage:link
php artisan serve
```

Catatan: seeder belum didokumentasikan. Cek folder `database/seeders` untuk data awal (user admin, menu, level).

Di lokal, `PRODUCT_IMAGE_DISK` tidak perlu diisi (default `public`), sehingga gambar disimpan di `storage/app/public/products` dan diakses lewat symlink `public/storage`.

## 4. Environment variables

Nilai rahasia **tidak boleh** masuk Git. Di production semuanya diisi lewat **Vercel > Settings > Environment Variables**.

| Variabel | Fungsi |
|---|---|
| `APP_KEY` | Kunci enkripsi Laravel (sesi, cookie). Buat dengan `php artisan key:generate --show`. |
| `APP_ENV` | `production` di Vercel |
| `APP_URL` | URL publik, misalnya `https://ecatalog-one.vercel.app` |
| `DB_CONNECTION` | `mysql` |
| `DB_HOST`, `DB_PORT` | Alamat server TiDB dan port (`4000`) |
| `DB_DATABASE` | `ecatalog` |
| `DB_USERNAME`, `DB_PASSWORD` | Akun TiDB. Username lengkap berbentuk `xxxx.root`. |
| `DB_USE_SSL` | `true` di production. Mengaktifkan sertifikat `certs/tidb-ca.pem` (lihat `config/database.php`). Kosongkan di lokal. |
| `PRODUCT_IMAGE_DISK` | `s3` di production, kosong/`public` di lokal (dibaca `config/filesystems.php` sebagai `product_disk`) |
| `AWS_ENDPOINT` | Endpoint S3 Supabase (`https://<ref>.storage.supabase.co/storage/v1/s3`) |
| `AWS_DEFAULT_REGION` | `ap-southeast-1` |
| `AWS_ACCESS_KEY_ID`, `AWS_SECRET_ACCESS_KEY` | Access key S3 Supabase |
| `AWS_BUCKET` | `products` |
| `AWS_USE_PATH_STYLE_ENDPOINT` | `true` |
| `AWS_URL` | Alamat publik gambar (`https://<ref>.supabase.co/storage/v1/object/public/products`) |

Variabel berikut sudah diatur di `vercel.json` sehingga tidak perlu diisi di dashboard: `APP_NAME`, `APP_DEBUG`, `SESSION_DRIVER=cookie`, `CACHE_STORE=array`, `LOG_CHANNEL=stderr`, dan path cache di `/tmp`.

## 5. Struktur kode

Alur umum: **Route -> Controller -> Service -> Model**, dengan DTO (`app/DTO`) untuk membawa data form ke Service.

```
app/
  Http/Controllers/   controller tipis, memanggil Service
  Services/           logika bisnis: Auth, Categories, Dashboard, Menu,
                      Product, SubCategories, UserLevel, User, Vendor
  Models/             Categories, Menu, Product, SubCategories, User, UserLevel, Vendor
  DTO/                objek data untuk input form (mis. ProductDTO)
  Http/Middleware/    CheckPermission (alias `check.permission`)
config/
  filesystems.php     disk gambar, termasuk `product_disk`
  database.php        opsi SSL untuk TiDB
certs/tidb-ca.pem     sertifikat CA TiDB (publik, aman di Git)
api/index.php         pintu masuk Laravel di Vercel
vercel.json           konfigurasi deploy Vercel
bootstrap/app.php     routing, alias middleware, trustProxies
```

Hal yang perlu diketahui:

- **Gambar produk** disimpan dan dihapus lewat `ProductService`, yang membaca disk dari `config('filesystems.product_disk')`. Alamat gambar diambil lewat accessor `$product->image_url` di model `Product`. Jangan memakai `asset('storage/...')` langsung di Blade.
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

Daftar lengkap: `php artisan route:list --except-vendor` (60 route).

## 7. Database

Ada 11 tabel di database `ecatalog`:

| Tabel | Fungsi |
|---|---|
| `products` | Data produk (kode, nama, harga, stok, stok minimum, satuan, gambar, status aktif) |
| `categories`, `sub_categories` | Kategori dan sub-kategori produk |
| `vendors` | Data mitra/vendor |
| `users` | Akun admin. Masih memuat kolom sisa perpustakaan (`member_code`, `avatar`) yang belum dipakai dan boleh dibersihkan nanti. |
| `user_levels` | Level user |
| `menus`, `user_level_menus` | Menu admin dan izin menu per level user |
| `sessions`, `password_reset_tokens`, `migrations` | Tabel bawaan Laravel |

Catatan: di production `SESSION_DRIVER=cookie`, jadi tabel `sessions` tidak dipakai di Vercel.

## 8. Deploy

Setiap `git push` ke `main` memicu deploy otomatis di Vercel.

Perubahan skema database **tidak** otomatis. Jalankan migrasi terhadap TiDB secara manual:

1. Isi `.env` lokal sementara dengan kredensial TiDB, ditambah `DB_USE_SSL=true`.
2. `php artisan migrate --force`
3. Kembalikan `.env` ke koneksi lokal.

Mengganti rahasia (password TiDB, access key Supabase, `APP_KEY`): ubah di Vercel, lalu **Redeploy**. Mengganti `APP_KEY` membuat semua user logout.

## 9. Catatan penting (gotchas)

- **Disk Vercel tidak permanen.** File yang diunggah ke `storage/` hilang. Karena itu gambar produk memakai disk `s3` (Supabase) di production.
- **Symlink `public/storage` tidak berfungsi di Vercel.** Jangan mengandalkannya untuk production.
- **TiDB mewajibkan SSL.** Sertifikat ada di `certs/tidb-ca.pem` dan diaktifkan lewat `DB_USE_SSL=true`.
- **Charset saat ekspor/impor database.** Gunakan `--default-character-set=utf8mb4` pada `mysqldump` dan `mysql`. Di Windows charset bawaan (`cp850`) ditolak TiDB.
- **`trustProxies(at: '*')` di `bootstrap/app.php`** diperlukan agar Laravel mengenali HTTPS dari proxy Vercel. Tanpa itu, URL dan aset bisa terbaca `http://`.
- **Rute aset statis** (`img`, `css`, `js`, `vendor`, `fonts`) dideklarasikan eksplisit di `vercel.json`. Jika menambah folder statis baru di `public/`, tambahkan ke rute tersebut.
- **`.vercelignore` memakai `/vendor`** (dengan garis miring di depan) agar hanya folder Composer di root yang dibuang, bukan `public/vendor/`.
- **Paket gratis** Vercel (Hobby), TiDB Starter, dan Supabase punya batas dan syarat yang bisa berubah. Hobby ditujukan untuk penggunaan non-komersial. Supabase gratis dapat menjeda project yang lama tidak aktif.