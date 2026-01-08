## e-Tamu — Panduan Singkat Menjalankan Proyek Ini

Panduan ini menjelaskan langkah-langkah untuk menyiapkan, menjalankan, dan mengembangkan proyek Laravel yang ada di repositori ini.

**Prasyarat**
- PHP 8.1+ (atau versi yang sesuai dengan `composer.json`)
- Composer
- Node.js + npm / pnpm / yarn
- MySQL / MariaDB atau database lain yang terkonfigurasi di `config/database.php`
- Git

**1. Salin repositori (jika belum)**
Jika Anda belum mengkloning, jalankan:

```bash
git clone https://github.com/Aeriz14/e-tamuProjectV.1.git
cd e-tamuProjectV.1
```

**2. Pasang dependensi PHP**

```bash
composer install --no-interaction --prefer-dist
```

**3. Pasang dependensi JavaScript & bangun aset**

```bash
npm install
npm run build    # atau `npm run dev` untuk mode development
```

**4. Konfigurasi environment**
 - Salin file contoh environment:

```bash
cp .env.example .env
```

 - Buka `.env` dan atur nilai `DB_*` untuk koneksi database Anda (DB_DATABASE, DB_USERNAME, DB_PASSWORD).

**5. Buat application key**

```bash
php artisan key:generate
```

**6. Migrasi database & seeding**

```bash
php artisan migrate
php artisan db:seed    # jika seeder tersedia dan Anda ingin memasukkan data contoh
```

Catatan: Jika Anda menggunakan Windows dan encountering permission errors, jalankan command prompt/PowerShell sebagai Administrator atau sesuaikan permission folder `storage` dan `bootstrap/cache`.

**7. Buat symbolic link untuk penyimpanan (opsional untuk file yang dapat diakses publik)**

```bash
php artisan storage:link
```

**8. Menjalankan server lokal**

```bash
php artisan serve
# Akses di http://127.0.0.1:8000
```

**9. Menjalankan test**

Jika proyek menggunakan Pest atau PHPUnit:

```bash
./vendor/bin/pest
# atau
php artisan test
```

**10. Tips deployment singkat**
- Pastikan environment production (`.env`) berisi konfigurasi yang aman (APP_ENV=production, APP_DEBUG=false).
- Jalankan `composer install --no-dev --optimize-autoloader` di server produksi.
- Jalankan `php artisan config:cache`, `php artisan route:cache`, dan `php artisan view:cache` untuk performa.
- Set permission folder `storage` dan `bootstrap/cache` agar webserver dapat menulis.

**11. Integrasi GitHub / CI (opsional)**
- Anda dapat menambahkan workflow GitHub Actions untuk menjalankan test dan build otomatis. Contoh singkat (satu file `.github/workflows/ci.yml`) akan menjalankan `composer install` dan `npm ci` lalu `php artisan test`.

**Troubleshooting umum**
- Error koneksi DB: periksa nilai `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` di `.env`.
- Kunci aplikasi tidak ada: jalankan `php artisan key:generate`.
- Aset tidak muncul: pastikan `npm run build` selesai dan file di `public/build` tersedia.

