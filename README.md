# Sistem Informasi Pelaporan IKU 7

## Cara Penggunaan

1. Clone repository

```bash
$ git clone https://github.com/HizkiaReppi/si-pelaporan-iku-7.git
```

2. Buka terminal dan arahkan ke direktori repository

```bash
$ cd si-pelaporan-iku-7
```

3. Install dependencies php dengan perintah `composer install`

```bash
$ composer install
```

4. Install dependencies nodejs dengan perintah `npm install`

```bash
$ npm install
```

5. Copy file `.env.example` menjadi `.env`

```bash
$ cp .env.example .env

atau

$ copy .env.example .env
```

6. Generate key aplikasi dengan perintah `php artisan key:generate`

```bash
$ php artisan key:generate
```

7. Buat database baru dan sesuaikan konfigurasi database pada file `.env`

8. Migrasi database dengan perintah `php artisan migrate` atau `php artisan migrate --seed` jika ingin mengisi data awal.

    _Catatan: ubah file `database/seeders/DatabaseSeeder.php` terlebih dahulu jika diperlukan, disarankan mengubah data admin yang akan digunakan untuk login termasuk passwordnya_

```bash
$ php artisan migrate

atau

$ php artisan migrate --seed
```

9. Jalankan server dengan perintah `php artisan serve`

```bash
$ php artisan serve
```

10. Jalankan vite dengan perintah `npm run dev`

```bash
$ npm run dev
```

11. Buka browser dan akses `http://127.0.0.1:8000/`

Create By Hizkia Reppi
