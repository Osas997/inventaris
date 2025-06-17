### Cara Install

### 1. Clone Repository

```bash
git clone https://github.com/Osas997/inventaris
cd inventaris
```

### 2. Install Dependency

```bash
composer install
```

### 3. Copy file env

```bash
cp .env.example .env
```

### 4. Generate Key App

```bash
php artisan key:generate
```

### 5. Setup Database pada file .env

```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=inventaris
DB_USERNAME=root
DB_PASSWORD=
```

### 6. Jalankan Migrations dan Seeder

```bash
php artisan migrate -seed
```

### 6. Jalankan Server

```bash
php artisan serve
```

### 6. Buka Dokumentasi Swagger pada endpoint

```bash
http://localhost:8000/api/docs
```

### 7. Login Menggunakan Akun Admin

```bash
username=admin
password=password
```
