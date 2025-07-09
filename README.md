# 📦 Sistem Inventory Produk API

Proyek ini merupakan backend RESTful API berbasis Laravel 12 yang berfungsi untuk mengelola produk, lokasi penyimpanan, serta riwayat mutasi keluar/masuk stok produk. Dibangun menggunakan PHP 8.2, Laravel Sanctum untuk autentikasi, serta dapat dijalankan dengan Docker untuk memudahkan pengembangan dan deployment.

---

## 🚀 Fitur Utama

-   ✅ Autentikasi menggunakan **Bearer Token (Sanctum)**
-   ✅ Manajemen **User** & **Role-based Access Control**
-   ✅ CRUD **Produk**, **Kategori Produk**, **Lokasi**
-   ✅ Relasi many-to-many **Produk ↔ Lokasi** (dengan stok)
-   ✅ Riwayat **Mutasi produk (masuk / keluar)** berdasarkan Produk & User
-   ✅ Inisialisasi stok per produk/lokasi
-   ✅ Docker-ready untuk local dev & server deploy

---

## 🛠️ Teknologi yang Digunakan

-   PHP 8.2 + Laravel 12
-   Laravel Sanctum (auth)
-   MySQL 8 (via Docker)
-   phpMyAdmin (opsional)
-   Docker & Docker Compose

---

## 📄 Struktur Direktori Docker

```bash
.
├── app/
├── docker/
│   └── vhost.conf         # Apache virtual host config
├── Dockerfile             # Image Laravel + PHP 8.2 + Apache
├── docker-compose.yml     # Service Laravel + MySQL + phpMyAdmin
├── .env.docker            # Environment khusus Docker
├── README.md
```

---

## 🧑‍💻 Cara Menjalankan Secara Lokal

### 1. Clone Repository

```bash
git clone https://github.com/Iemaduddin/product-inventory-api.git
cd product-inventory-api
```

### 2. Jalankan Docker

```bash
docker compose up -d --build
```

### 3. Masuk ke Container Laravel

```bash
docker exec -it laravel-app bash
```

### 4. Setup Laravel

```bash
cp .env.docker .env
composer install
php artisan key:generate
php artisan migrate --seed
```

---

## 🌐 Akses Aplikasi

| Layanan     | URL                   |
| ----------- | --------------------- |
| Laravel API | http://localhost:8000 |
| phpMyAdmin  | http://localhost:8080 |

---

## 🔐 Login API

Gunakan endpoint `/login` untuk mendapatkan Bearer Token, lalu kirim token tersebut di header:

```http
Authorization: Bearer <your-token>
```

---

## 📘️ Dokumentasi API

Seluruh endpoint REST API dapat dilihat & dicoba langsung melalui dokumentasi berikut:

👉 [**Link Dokumentasi Postman**](https://orange-meadow-847678.postman.co/workspace/restful-api-2-p13~90d99b38-0f5d-4109-897f-ed0445b858f6/collection/27459823-1e24a14e-f908-42c7-ae73-6cc066f89c44?action=share&creator=27459823&active-environment=27459823-2cd4e2e9-9de8-4741-a73d-fe74f5dbeecf)

---

## ✨ Kontribusi

Pull request terbuka untuk perbaikan atau fitur tambahan. Pastikan untuk membuat cabang dan deskripsikan perubahan yang kamu buat.

---

### 💫 Develope by :

-   Nama: Iemaduddin
-   Email: iemaduddin17@gmail.com
-   Github:[@Iemaduddin](https://github.com/Iemaduddin)
