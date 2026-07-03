# WijayCart

Aplikasi **e-commerce lifestyle** berbasis **Laravel 13** dengan nuansa warm minimalist. Menyediakan storefront lengkap, panel admin, dan fitur bisnis end-to-end.

---

## Teknologi

| Layer      | Stack                                  |
| ---------- | -------------------------------------- |
| Backend    | PHP 8.3, Laravel 13                    |
| Database   | MySQL (XAMPP / Laragon / lokal)        |
| Frontend   | Blade, Tailwind CSS 4, Flowbite        |
| JavaScript | Vite 8, Lucide Icons, Chart.js (admin) |

---

## Requirement

| Komponen     | Versi                                                  |
| ------------ | ------------------------------------------------------ |
| PHP          | 8.3+                                                   |
| Composer     | 2.x                                                    |
| Node.js      | 18+                                                    |
| npm          | 9+                                                     |
| MySQL        | 8+ (via XAMPP, Laragon, atau MySQL lokal)              |
| Ekstensi PHP | `pdo_mysql`, `mbstring`, `openssl`, `fileinfo`, `curl` |

---

## Instalasi

Panduan lengkap: [INSTALLATION.md](INSTALLATION.md)

```bash
composer install
npm install
copy .env.example .env          # Windows — Linux/Mac: cp .env.example .env
php artisan key:generate
```

Buat database **`wijaycart`** di phpMyAdmin (XAMPP/Laragon), lalu edit `.env`:

```env
APP_NAME=WijayCart
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=wijaycart
DB_USERNAME=root
DB_PASSWORD=
```

```bash
php artisan migrate --seed
php artisan storage:link
npm run build
```

---

## Cara Menjalankan

```bash
php artisan serve
```

Buka **http://localhost:8000**

Admin panel: **http://localhost:8000/admin**

---

## Akun Demo

Setelah `php artisan db:seed` (atau `migrate --seed`):

| Role     | Email                  | Password |
| -------- | ---------------------- | -------- |
| Admin    | admin@wijaycart.com    | password |
| Customer | customer@wijaycart.com | password |

---

## Struktur Project

```
wijaycart/
├── app/                 # Controllers, Models, Services, Policies
├── database/            # Migrations, seeders, factories
├── public/              # Document root
├── resources/           # Views, CSS, JavaScript
├── routes/web.php
├── tests/
├── INSTALLATION.md
└── README.md
```

---

## Fitur Utama

### Storefront (Customer)

- Katalog produk — search, filter, sort, pagination
- Keranjang belanja (AJAX)
- Checkout — COD, transfer bank, QRIS (simulasi)
- Pesanan — timeline, cancel, upload bukti bayar
- Review & rating produk
- Wishlist & dashboard customer
- Profil + upload avatar
- Newsletter & contact form
- Notifikasi in-app & dark mode

### Admin Panel

- Dashboard & laporan penjualan
- CRUD kategori & produk (multi-gambar, barcode)
- Kelola pesanan & pembayaran
- Pengaturan toko (footer, contact)
