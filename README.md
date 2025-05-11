# Aplikasi Buku Tamu

Aplikasi web sederhana untuk manajemen buku tamu dengan fitur user authentication dan komentar.

## Fitur

- Registrasi dan Login user
- Sistem autentikasi dan session
- Penambahan komentar oleh user yang telah login
- Manajemen komentar (lihat, tambah, edit, hapus)
- Interface responsif dengan Tailwind CSS

## Struktur Database

Database terdiri dari dua tabel utama:
1. `users` - menyimpan data pengguna
2. `comment` - menyimpan komentar yang terhubung ke user

## Persyaratan Sistem

- PHP 7.4 atau lebih tinggi
- MySQL/MariaDB
- Web server (Apache/Nginx)

## Instalasi

1. Clone repositori ini ke direktori web server Anda:
   ```
   git clone https://github.com/username/buku_tamu.git
   ```
   atau download dan ekstrak secara manual.

2. Buat database MySQL bernama `buku_tamu`.

3. Import struktur database menggunakan file `database.sql` yang disediakan:
   ```
   mysql -u username -p buku_tamu < database.sql
   ```
   
   Atau jalankan SQL script secara manual di phpMyAdmin atau MySQL client.

4. Konfigurasikan koneksi database di file `config/conn.php`:
   ```php
   $host = "localhost"; // Host database
   $username = "root";  // Username database
   $password = "";      // Password database
   $database = "buku_tamu"; // Nama database
   ```

5. Pastikan direktori web server memiliki izin akses yang tepat.

6. Akses aplikasi melalui browser:
   ```
   http://localhost/buku_tamu/
   ```

## Penggunaan

1. **Register**: Buat akun baru dengan username, email, dan password.
2. **Login**: Masuk ke akun yang sudah ada.
3. **Dashboard**: Lihat dan kelola komentar Anda.
4. **Beranda**: Lihat semua komentar dari semua pengguna.

## Keamanan

Aplikasi ini menerapkan beberapa fitur keamanan dasar:
- Password di-hash menggunakan `password_hash()` dan `PASSWORD_DEFAULT`
- Prepared statements untuk mencegah SQL Injection
- Validasi input di sisi server
- Sanitasi output untuk mencegah XSS
- Pengecekan sesi untuk validasi akses

## Pengembangan Lebih Lanjut

Beberapa ide untuk pengembangan aplikasi:
- Implementasi AJAX untuk menambahkan komentar tanpa refresh halaman
- Penambahan fitur upload foto profil user
- Penambahan fitur balasan komentar
- Implementasi sistem role/permission (admin, user)
- Implementasi fitur moderasi komentar
