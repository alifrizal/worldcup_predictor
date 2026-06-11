# Deploy Guide

Panduan deploy aplikasi Ndukun Piala Dunia 2026 ke GitLab dan production server.

---

## Daftar Isi

- [Persiapan GitLab](#1-persiapan-gitlab)
- [Konfigurasi .gitignore](#2-konfigurasi-gitignore)
- [Push ke GitLab](#3-push-ke-gitlab)
- [Persiapan Server](#4-persiapan-server)
- [Deploy Manual ke Server](#5-deploy-manual-ke-server)
- [GitLab CI/CD (Opsional)](#6-gitlab-cicd-opsional)
- [Checklist Production](#7-checklist-production)

---

## 1. Persiapan GitLab

### Buat Repository Baru

1. Login ke [gitlab.com](https://gitlab.com)
2. Klik **New Project → Create blank project**
3. Isi nama project: `ndukun-pd2026`
4. Set visibility: **Private** atau **Public** sesuai kebutuhan
5. **Jangan** centang "Initialize repository with a README" — kita akan push dari lokal
6. Klik **Create project**

---

## 2. Konfigurasi `.gitignore`

Pastikan `.gitignore` sudah mengecualikan file sensitif. Buka `.gitignore` di root project, pastikan baris berikut ada:

```gitignore
/node_modules
/public/build
/public/hot
/public/storage
/storage/*.key
/vendor
.env
.env.backup
.env.production
.phpunit.result.cache
Homestead.json
Homestead.yaml
auth.json
npm-debug.log
yarn-error.log
/.fleet
/.idea
/.vscode
```

> **Penting:** File `.env` **tidak boleh** masuk ke repository karena berisi kredensial database dan secret key.

### Buat `.env.example`

File `.env.example` adalah template yang boleh di-commit. Buat dari `.env` yang sudah ada:

```bash
cp .env .env.example
```

Lalu edit `.env.example` — kosongkan semua nilai sensitif:

```env
APP_NAME="Ndukun Piala Dunia 2026"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=https://domain-kamu.com
APP_TIMEZONE=Asia/Jakarta
APP_LOCALE=id

DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=worldcup2026
DB_USERNAME=
DB_PASSWORD=

CACHE_STORE=database
SESSION_DRIVER=database
QUEUE_CONNECTION=database

MAIL_MAILER=log
MAIL_FROM_ADDRESS="noreply@domain-kamu.com"
MAIL_FROM_NAME="${APP_NAME}"
```

---

## 3. Push ke GitLab

### Inisialisasi Git (jika belum)

```bash
cd /path/to/project
git init
git add .
git commit -m "feat: initial commit"
```

### Hubungkan ke GitLab

```bash
git remote add origin https://gitlab.com/username/ndukun-pd2026.git
git branch -M main
git push -u origin main
```

### Verifikasi

Buka `https://gitlab.com/username/ndukun-pd2026` — semua file harus sudah ada kecuali `vendor/`, `node_modules/`, dan `.env`.

---

## 4. Persiapan Server

### Requirement Server

- Ubuntu 22.04 / 24.04 LTS
- PHP 8.5 + ekstensi: `pgsql`, `pdo_pgsql`, `mbstring`, `xml`, `curl`, `zip`, `bcmath`, `tokenizer`
- Composer 2.7.x
- Node.js 20.x + NPM
- PostgreSQL 14+
- Nginx atau Apache
- Git

### Install PHP & Ekstensi (Ubuntu)

```bash
sudo apt update
sudo apt install -y software-properties-common
sudo add-apt-repository ppa:ondrej/php
sudo apt update
sudo apt install -y php8.5 php8.5-fpm php8.5-pgsql php8.5-mbstring \
    php8.5-xml php8.5-curl php8.5-zip php8.5-bcmath php8.5-tokenizer \
    php8.5-intl php8.5-redis
```

### Install Composer

```bash
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
composer --version  # harus 2.7.x
```

### Install Node.js

```bash
curl -fsSL https://deb.nodesource.com/setup_20.x | sudo -E bash -
sudo apt install -y nodejs
node --version  # harus v20.x
```

### Install PostgreSQL

```bash
sudo apt install -y postgresql postgresql-contrib
sudo systemctl start postgresql
sudo systemctl enable postgresql

# Buat user & database
sudo -u postgres psql -c "CREATE USER ndukun WITH PASSWORD 'strong_password_here';"
sudo -u postgres psql -c "CREATE DATABASE worldcup2026 OWNER ndukun;"
sudo -u postgres psql -c "GRANT ALL PRIVILEGES ON DATABASE worldcup2026 TO ndukun;"
```

### Konfigurasi Nginx

Buat file konfigurasi Nginx:

```bash
sudo nano /etc/nginx/sites-available/ndukun-pd2026
```

Isi dengan:

```nginx
server {
    listen 80;
    listen [::]:80;
    server_name domain-kamu.com www.domain-kamu.com;
    root /var/www/ndukun-pd2026/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;
    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.5-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_hide_header X-Powered-By;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

Aktifkan konfigurasi:

```bash
sudo ln -s /etc/nginx/sites-available/ndukun-pd2026 /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx
```

---

## 5. Deploy Manual ke Server

### Clone Repository di Server

```bash
cd /var/www
sudo git clone https://gitlab.com/username/ndukun-pd2026.git
sudo chown -R www-data:www-data ndukun-pd2026
cd ndukun-pd2026
```

### Jalankan Script Deploy

Buat file `deploy.sh` di root project:

```bash
#!/bin/bash
set -e

echo "🚀 Memulai deployment..."

# 1. Pull kode terbaru
echo "📥 Pull kode terbaru..."
git pull origin main

# 2. Install/update PHP dependencies
echo "📦 Install PHP dependencies..."
composer install --no-dev --optimize-autoloader --no-interaction

# 3. Build frontend assets
echo "🎨 Build frontend assets..."
npm ci
npm run build

# 4. Jalankan migration
echo "🗄️  Jalankan migration..."
php artisan migrate --force

# 5. Clear & rebuild cache
echo "⚡ Rebuild cache..."
php artisan optimize:clear
php artisan optimize

# 6. Restart queue worker (jika ada)
# php artisan queue:restart

# 7. Set permission
echo "🔒 Set permission..."
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache

echo "✅ Deployment selesai!"
```

Jadikan executable:

```bash
chmod +x deploy.sh
```

### Setup `.env` di Server

```bash
cp .env.example .env
nano .env  # isi semua nilai yang diperlukan
php artisan key:generate
```

### Setup Storage Link

```bash
php artisan storage:link
```

### Jalankan Migration & Seeder

```bash
php artisan migrate --force
php artisan db:seed --force
```

### Deploy Pertama Kali

```bash
bash deploy.sh
```

### Update Berikutnya

Setiap ada perubahan kode, cukup jalankan:

```bash
cd /var/www/ndukun-pd2026
bash deploy.sh
```

---

## 6. GitLab CI/CD (Opsional)

Jika ingin deployment otomatis setiap push ke branch `main`, buat file `.gitlab-ci.yml` di root project:

```yaml
stages:
    - test
    - deploy

variables:
    PHP_VERSION: "8.5"

# ── TEST ──────────────────────────────────────────────────────
test:
    stage: test
    image: php:8.5-cli
    services:
        - postgres:16
    variables:
        POSTGRES_DB: worldcup2026_test
        POSTGRES_USER: postgres
        POSTGRES_PASSWORD: postgres
        DB_CONNECTION: pgsql
        DB_HOST: postgres
        DB_PORT: 5432
        DB_DATABASE: worldcup2026_test
        DB_USERNAME: postgres
        DB_PASSWORD: postgres
        APP_KEY: base64:test_key_for_ci_only_32chars==
        APP_ENV: testing
        CACHE_STORE: array
        SESSION_DRIVER: array
    before_script:
        - apt-get update -qq && apt-get install -y libpq-dev zip unzip git
        - docker-php-ext-install pdo pdo_pgsql
        - curl -sS https://getcomposer.org/installer | php
        - php composer.phar install --no-interaction --no-progress
        - cp .env.example .env
        - php artisan key:generate
        - php artisan migrate --force
    script:
        - php artisan test --stop-on-failure
    only:
        - main
        - merge_requests

# ── DEPLOY ────────────────────────────────────────────────────
deploy:
    stage: deploy
    image: alpine:latest
    before_script:
        - apk add --no-cache openssh-client bash
        - eval $(ssh-agent -s)
        - echo "$SSH_PRIVATE_KEY" | tr -d '\r' | ssh-add -
        - mkdir -p ~/.ssh
        - chmod 700 ~/.ssh
        - ssh-keyscan $SERVER_IP >> ~/.ssh/known_hosts
    script:
        - ssh $SERVER_USER@$SERVER_IP "cd /var/www/ndukun-pd2026 && bash deploy.sh"
    only:
        - main
    when: on_success
```

### Setup CI/CD Variables di GitLab

Buka **Settings → CI/CD → Variables**, tambahkan:

| Variable          | Value                              | Protected | Masked |
| ----------------- | ---------------------------------- | --------- | ------ |
| `SSH_PRIVATE_KEY` | Private key SSH untuk akses server | ✅        | ✅     |
| `SERVER_IP`       | IP address server production       | ✅        | ❌     |
| `SERVER_USER`     | User SSH (misal: `ubuntu`)         | ✅        | ❌     |

### Setup SSH Key di Server

```bash
# Di lokal, generate SSH key khusus CI/CD
ssh-keygen -t ed25519 -C "gitlab-ci-ndukun" -f ~/.ssh/gitlab_ci_ndukun

# Copy public key ke server
ssh-copy-id -i ~/.ssh/gitlab_ci_ndukun.pub ubuntu@server-ip

# Copy private key ke GitLab CI/CD variable SSH_PRIVATE_KEY
cat ~/.ssh/gitlab_ci_ndukun
```

---

## 7. Checklist Production

Sebelum go-live, pastikan semua item ini sudah dikerjakan:

### Environment

- [ ] `APP_ENV=production`
- [ ] `APP_DEBUG=false`
- [ ] `APP_KEY` sudah di-generate
- [ ] `APP_URL` diisi dengan domain yang benar
- [ ] `APP_TIMEZONE=Asia/Jakarta`

### Database

- [ ] Migration sudah dijalankan: `php artisan migrate --force`
- [ ] Seeder sudah dijalankan: `php artisan db:seed --force`
- [ ] Backup database sudah dikonfigurasi

### Cache & Optimasi

- [ ] `php artisan optimize` sudah dijalankan
- [ ] `php artisan storage:link` sudah dijalankan
- [ ] Asset production sudah di-build: `npm run build`

### Security

- [ ] File `.env` tidak bisa diakses publik
- [ ] Directory listing dinonaktifkan di Nginx
- [ ] HTTPS sudah dikonfigurasi (SSL/TLS via Let's Encrypt)
- [ ] User admin sudah diset: `php artisan tinker` → update `is_admin`

### SSL (Let's Encrypt)

```bash
sudo apt install -y certbot python3-certbot-nginx
sudo certbot --nginx -d domain-kamu.com -d www.domain-kamu.com
sudo systemctl reload nginx
```

---

## Troubleshooting

### Permission Error

```bash
sudo chown -R www-data:www-data /var/www/ndukun-pd2026
sudo chmod -R 775 /var/www/ndukun-pd2026/storage
sudo chmod -R 775 /var/www/ndukun-pd2026/bootstrap/cache
```

### 500 Error Setelah Deploy

```bash
# Lihat log error
tail -50 /var/www/ndukun-pd2026/storage/logs/laravel.log

# Clear semua cache
php artisan optimize:clear
php artisan optimize
```

### Migration Error

```bash
# Lihat status migration
php artisan migrate:status

# Rollback jika perlu
php artisan migrate:rollback
```

### Composer Memory Error

```bash
COMPOSER_MEMORY_LIMIT=-1 composer install --no-dev --optimize-autoloader
```
