@echo off
title AA Songkok - Installer
color 0E
echo.
echo ================================================
echo    AA SONGKOK - INSTALLER OTOMATIS
echo ================================================
echo.

:: Cek PHP
php -v >nul 2>&1
if %errorlevel% neq 0 (
    echo [ERROR] PHP tidak ditemukan!
    echo Silakan install XAMPP dari https://www.apachefriends.org/
    echo Lalu tambahkan C:\xampp\php ke PATH
    pause
    exit /b 1
)
echo [OK] PHP ditemukan

:: Cek Composer
composer -V >nul 2>&1
if %errorlevel% neq 0 (
    echo [ERROR] Composer tidak ditemukan!
    echo Silakan install dari https://getcomposer.org/download/
    pause
    exit /b 1
)
echo [OK] Composer ditemukan

echo.
echo [1/6] Menginstall dependencies Laravel...
composer install --no-interaction --prefer-dist
if %errorlevel% neq 0 (
    echo [ERROR] composer install gagal!
    pause
    exit /b 1
)

echo.
echo [2/6] Membuat symlink storage...
php artisan storage:link

echo.
echo [3/6] Membuat APP_KEY...
php artisan key:generate --force

echo.
echo ================================================
echo  PENTING: Setup Database MySQL
echo ================================================
echo  Pastikan MySQL sudah berjalan (via XAMPP)
echo  Buat database dengan nama: aa_songkok
echo  Caranya:
echo    1. Buka http://localhost/phpmyadmin
echo    2. Klik "New" di sidebar kiri
echo    3. Ketik nama database: aa_songkok
echo    4. Klik "Create"
echo.
echo  Jika password MySQL Anda bukan kosong,
echo  edit file .env, ubah DB_PASSWORD=isi_password_anda
echo.
pause

echo.
echo [4/6] Menjalankan migrasi database...
php artisan migrate --force
if %errorlevel% neq 0 (
    echo [ERROR] Migrasi gagal! Cek koneksi database.
    pause
    exit /b 1
)

echo.
echo [5/6] Mengisi data dummy (seeder)...
php artisan db:seed --force

echo.
echo [6/6] Membersihkan cache...
php artisan config:clear
php artisan cache:clear
php artisan view:clear

echo.
echo ================================================
echo  INSTALASI SELESAI!
echo ================================================
echo.
echo  Akun Login:
echo  - Admin : admin@aasongkok.com / password
echo  - User  : user@aasongkok.com  / password
echo.
echo  Menjalankan server...
echo  Buka browser: http://localhost:8000
echo.
php artisan serve
