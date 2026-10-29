# Arsip: deploy demo ke Vercel

Catatan deploy versi demo online. Tidak dipakai untuk server perusahaan, disimpan sebagai arsip.

## Layanan yang dipakai

| Layanan | Tugas |
|---|---|
| GitHub | Menyimpan kode, setiap `git push` ke `main` memicu deploy otomatis |
| Vercel | Menjalankan aplikasi Laravel (region `sin1`, runtime komunitas `vercel-php@0.9.0`) |
| TiDB Cloud Starter | Database (kompatibel MySQL, Singapore, wajib SSL) |
| Supabase Storage | Penyimpanan gambar produk (bucket publik `products`, protokol S3) |

## File khusus Vercel di repo

- `vercel.json`: runtime PHP, rute file statis (`img`, `css`, `js`, `vendor`, `fonts`), region, dan environment variable bawaan.
- `api/index.php`: pintu masuk Laravel di Vercel.
- `.vercelignore`: berisi `/vendor` (dengan garis miring di depan, supaya `public/vendor/` tidak ikut terbuang).
- `certs/tidb-ca.pem`: sertifikat CA publik untuk koneksi SSL ke TiDB.
- Paket `revolution/laravel-vercel-installer` (dev).

## Environment variables di Vercel

Diisi lewat **Settings > Environment Variables**, lalu **Redeploy**.

- Aplikasi: `APP_KEY`, `APP_ENV=production`, `APP_URL`
- Database: `DB_CONNECTION=mysql`, `DB_HOST`, `DB_PORT=4000`, `DB_DATABASE=ecatalog`, `DB_USERNAME` (bentuk `xxxx.root`), `DB_PASSWORD`, `DB_USE_SSL=true`
- Gambar: `PRODUCT_IMAGE_DISK=s3`, `AWS_ENDPOINT`, `AWS_DEFAULT_REGION=ap-southeast-1`, `AWS_ACCESS_KEY_ID`, `AWS_SECRET_ACCESS_KEY`, `AWS_BUCKET=products`, `AWS_USE_PATH_STYLE_ENDPOINT=true`, `AWS_URL`

Sudah diatur di `vercel.json`: `APP_NAME`, `APP_DEBUG=false`, `SESSION_DRIVER=cookie`, `CACHE_STORE=array`, `LOG_CHANNEL=stderr`, dan path cache di `/tmp`.

## Hal yang perlu diingat

- **Disk Vercel tidak permanen**, dan symlink `public/storage` tidak berfungsi. Karena itu gambar memakai disk `s3`.
- **`trustProxies(at: '*')`** di `bootstrap/app.php` diperlukan agar Laravel mengenali HTTPS dari proxy Vercel.
- **TiDB mewajibkan SSL.** `DB_USE_SSL=true` mengaktifkan `certs/tidb-ca.pem` (lihat `config/database.php`).
- **Migrasi tidak otomatis.** Jalankan terhadap TiDB dengan kredensial TiDB yang diberikan lewat variabel di terminal, lalu `php artisan migrate --force`.
- **Folder statis baru** di `public/` perlu ditambahkan ke rute di `vercel.json`.
- **Paket gratis** Vercel (Hobby), TiDB Starter, dan Supabase punya batas dan syarat yang bisa berubah. Hobby ditujukan untuk penggunaan non-komersial, dan Supabase gratis dapat menjeda project yang lama tidak aktif.