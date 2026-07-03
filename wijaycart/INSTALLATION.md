# WijayCart — Installation Guide

Panduan instalasi untuk menjalankan aplikasi **secara lokal** (XAMPP, Laragon, atau environment Laravel lokal).

---

## Persyaratan

| Komponen     | Versi                                                  |
| ------------ | ------------------------------------------------------ |
| PHP          | 8.3+                                                   |
| Composer     | 2.x                                                    |
| Node.js      | 18+                                                    |
| npm          | 9+                                                     |
| MySQL        | 8+                                                     |
| Ekstensi PHP | `pdo_mysql`, `mbstring`, `openssl`, `fileinfo`, `curl` |

**XAMPP / Laragon:** Pastikan Apache (atau `php artisan serve`) dan MySQL sudah berjalan.

---

## Langkah Instalasi

### 1. Dependensi PHP & Node

```bash
composer install
npm install
```

### 2. Environment

```bash
copy .env.example .env
```

> Linux/Mac: `cp .env.example .env`

```bash
php artisan key:generate
```

### 3. Konfigurasi Database

Buat database **`wijaycart`** di phpMyAdmin, lalu edit `.env`:

```env
APP_NAME=WijayCart
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=wijaycart
DB_USERNAME=root
DB_PASSWORD=
```

> XAMPP/Laragon: `DB_USERNAME=root`, `DB_PASSWORD=` (kosong) biasanya sudah benar.

### 4. Database, Storage & Seed

```bash
php artisan migrate --seed
php artisan storage:link
```

### 5. Build Frontend

```bash
npm run build
```

### 6. Jalankan Aplikasi

```bash
php artisan serve
```

Akses: **http://localhost:8000**

---

## Instalasi Cepat (Alternatif)

Jika belum ada `.env`:

```bash
composer setup
php artisan db:seed
```

`composer setup` menjalankan: `composer install`, copy `.env`, `key:generate`, `migrate --force`, `storage:link`, `npm install`, `npm run build`.

---

## Akun Demo

| Role     | Email                  | Password |
| -------- | ---------------------- | -------- |
| Admin    | admin@wijaycart.com    | password |
| Customer | customer@wijaycart.com | password |

Admin panel: **http://localhost:8000/admin**

---

## Asset Gambar

Letakkan foto asli pada folder berikut sebelum menjalankan aplikasi:

```text
public/images/products/      → satu file .webp per produk (lihat database/seeders/data/catalog.php)
public/images/placeholders/  → product.jpg, avatar.jpg
```

Setelah file gambar siap:

```bash
php artisan migrate:fresh --seed
php artisan storage:link
```

Upload produk baru dari admin panel tetap disimpan di `storage/app/public/products/`.

---

## Troubleshooting

| Masalah                      | Solusi                                                         |
| ---------------------------- | -------------------------------------------------------------- |
| Gambar upload tidak tampil   | `php artisan storage:link`                                     |
| Error migration / koneksi DB | Pastikan MySQL berjalan; buat database `wijaycart`; cek `.env` |
| Vite manifest not found      | `npm run build`                                                |
| Port 8000 sudah dipakai      | `php artisan serve --port=8001`                                |

---

## Testing (Opsional)

```bash
php artisan test
```
