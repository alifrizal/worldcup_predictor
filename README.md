# ⚽ Ndukun Piala Dunia 2026

Aplikasi mobile web tebak skor Piala Dunia 2026 berbasis Laravel. Prediksi skor setiap pertandingan, kumpulkan poin, dan bersaing di leaderboard global maupun regional.

![Laravel](https://img.shields.io/badge/Laravel-13.x-FF2D20?style=flat&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.5-777BB4?style=flat&logo=php)
![PostgreSQL](https://img.shields.io/badge/PostgreSQL-16-336791?style=flat&logo=postgresql)

---

## Daftar Isi

- [Fitur](#fitur)
- [Sistem Poin](#sistem-poin)
- [Requirement](#requirement)
- [Instalasi Lokal](#instalasi-lokal)
- [Konfigurasi Environment](#konfigurasi-environment)
- [Menjalankan Aplikasi](#menjalankan-aplikasi)
- [Perintah Artisan](#perintah-artisan)
- [Akses Admin](#akses-admin)
- [Menjalankan Test](#menjalankan-test)
- [Struktur Proyek](#struktur-proyek)
- [Deploy ke Production](#deploy-ke-production)

---

## Fitur

| Fitur              | Deskripsi                                                         |
| ------------------ | ----------------------------------------------------------------- |
| **Auth**           | Register & login via Laravel Breeze                               |
| **Fixture**        | Jadwal lengkap dari fase grup hingga final                        |
| **Prediksi**       | Tebak skor sebelum kick-off, terkunci otomatis saat match dimulai |
| **Ranking Global** | Leaderboard semua player berdasarkan total poin                   |
| **Ranking Kota**   | Leaderboard berdasarkan lokasi/kota user                          |
| **Ranking Tim**    | Leaderboard berdasarkan tim yang didukung                         |
| **History**        | Riwayat semua tebakan dengan filter                               |
| **Statistik**      | Breakdown exact/close/result/wrong + poin per stage               |
| **Admin**          | Update skor & status pertandingan via browser atau CLI            |

---

## Sistem Poin

| Tipe       | Poin    | Kondisi                                          |
| ---------- | ------- | ------------------------------------------------ |
| **Exact**  | 3 pts   | Skor tepat sama persis                           |
| **Close**  | 1.5 pts | Hasil benar & selisih margin gol ≤ 1             |
| **Result** | 1 pt    | Hasil (menang/seri/kalah) benar tapi tidak close |
| **Wrong**  | 0 pts   | Hasil tidak tepat                                |

> **Definisi Close:** Selisih margin gol (home−away) antara prediksi dan aktual ≤ 1. Untuk hasil imbang, selisih skor per tim masing-masing ≤ 1.

---

## Requirement

- PHP >= 8.5
- Composer 2.7.1
- Node.js >= 20.x & NPM
- PostgreSQL >= 14
- Git

---

## Instalasi Lokal

### 1. Clone Repository

```bash
git clone https://gitlab.com/username/ndukun-pd2026.git
cd ndukun-pd2026
```

### 2. Install Dependency PHP

```bash
composer install
```

### 3. Install Dependency Node

```bash
npm install
```

### 4. Salin File Environment

```bash
cp .env.example .env
php artisan key:generate
```

### 5. Buat Database PostgreSQL

```bash
psql -U postgres -c "CREATE DATABASE worldcup2026;"
```

### 6. Konfigurasi `.env`

```env
APP_NAME="Ndukun Piala Dunia 2026"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000
APP_TIMEZONE=Asia/Jakarta
APP_LOCALE=id

DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=worldcup2026
DB_USERNAME=postgres
DB_PASSWORD=your_password
```

### 7. Jalankan Migration & Seeder

```bash
php artisan migrate
php artisan db:seed
```

Seeder akan mengisi:

- **48 tim** Piala Dunia 2026 beserta pembagian grup A–L
- **~115 kota** (34 kota Indonesia + 81 kota internasional)
- **72 fixture** fase grup

### 8. Build Asset

```bash
# Development
npm run dev

# Production
npm run build
```

---

## Konfigurasi Environment

| Key                | Default        | Keterangan                                     |
| ------------------ | -------------- | ---------------------------------------------- |
| `APP_TIMEZONE`     | `Asia/Jakarta` | Timezone untuk tampilan waktu                  |
| `APP_LOCALE`       | `id`           | Locale bahasa                                  |
| `DB_CONNECTION`    | `pgsql`        | Harus PostgreSQL                               |
| `CACHE_STORE`      | `database`     | Bisa diganti `redis` untuk performa lebih baik |
| `SESSION_DRIVER`   | `database`     | Driver session                                 |
| `QUEUE_CONNECTION` | `database`     | Driver queue                                   |

---

## Menjalankan Aplikasi

```bash
php artisan serve
```

Buka `http://localhost:8000` di browser.

---

## Perintah Artisan

### Update Skor Match (Interaktif)

```bash
php artisan match:update-score {id}
```

### Update Skor Match (Langsung)

```bash
php artisan match:update-score 1 --status=live --home=1 --away=0
php artisan match:update-score 1 --status=finished --home=2 --away=1
```

### Evaluasi Prediksi Manual

Dijalankan otomatis saat status match diset ke `finished`. Bisa juga dijalankan manual:

```bash
php artisan predictions:evaluate {match_id}
```

### Optimasi Cache

```bash
php artisan optimize        # cache semua
php artisan optimize:clear  # clear semua cache
```

---

## Akses Admin

### Set User sebagai Admin

```bash
php artisan tinker
>>> \App\Models\User::where('email', 'admin@email.com')->update(['is_admin' => true]);
```

### Halaman Admin

Setelah login sebagai admin, akses:

```
http://localhost:8000/admin/matches
```

Fitur admin:

- Lihat semua jadwal pertandingan
- Update status (scheduled → live → finished)
- Update skor pertandingan
- Evaluasi poin prediksi otomatis saat status `finished`

---

## Menjalankan Test

```bash
# Semua test
php artisan test

# Unit test scoring saja
php artisan test --filter=ScoringTest

# Feature test prediksi
php artisan test --filter=PredictionTest
```

### Setup Database Testing Terpisah (Rekomendasi)

Agar `RefreshDatabase` tidak menghapus data development:

```bash
psql -U postgres -c "CREATE DATABASE worldcup2026_test;"
```

Tambahkan di `phpunit.xml`:

```xml
<env name="DB_DATABASE" value="worldcup2026_test"/>
```

---

## Struktur Proyek

```
app/
├── Console/Commands/
│   ├── EvaluatePredictions.php   # Hitung poin prediksi
│   └── UpdateMatchScore.php      # Update skor via CLI
├── Http/
│   ├── Controllers/
│   │   ├── Admin/MatchController.php
│   │   ├── FixtureController.php
│   │   ├── HistoryController.php
│   │   ├── PredictionController.php
│   │   ├── RankingController.php
│   │   └── StatisticController.php
│   ├── Middleware/
│   │   └── AdminMiddleware.php
│   └── Requests/
│       └── RegisterRequest.php
├── Models/
│   ├── City.php
│   ├── Fixture.php
│   ├── Prediction.php
│   ├── User.php
│   └── WorldCupTeam.php
└── Services/
    └── PredictionScoringService.php

database/
├── migrations/
├── seeders/
│   ├── CitySeeder.php            # ~115 kota
│   ├── FixtureSeeder.php         # 72 fixture fase grup
│   └── WorldCupTeamSeeder.php    # 48 tim + grup
└── factories/

resources/views/
├── auth/          # login, register
├── admin/         # kelola match
├── fixtures/      # jadwal
├── history/       # riwayat tebakan
├── predictions/   # live & tebak
├── rankings/      # global, kota, tim
├── statistics/    # statistik personal
├── profile/       # profil user
└── layouts/       # app.blade.php, guest.blade.php
```

---

## Deploy ke Production

Lihat [DEPLOY.md](DEPLOY.md) untuk panduan lengkap deployment ke server.

---

## Lisensi

Proyek ini dibuat untuk keperluan komunitas. Bebas digunakan dan dimodifikasi.
