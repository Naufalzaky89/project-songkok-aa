# AA Songkok - PowerShell Installer
Write-Host "================================================" -ForegroundColor Yellow
Write-Host "   AA SONGKOK - INSTALLER OTOMATIS" -ForegroundColor Yellow
Write-Host "================================================" -ForegroundColor Yellow
Write-Host ""

# Cek PHP
try {
    $phpVersion = php -v 2>&1 | Select-Object -First 1
    Write-Host "[OK] $phpVersion" -ForegroundColor Green
} catch {
    Write-Host "[ERROR] PHP tidak ditemukan! Install XAMPP dari https://www.apachefriends.org/" -ForegroundColor Red
    Read-Host "Tekan Enter untuk keluar"
    exit
}

# Cek Composer
try {
    composer -V 2>&1 | Out-Null
    Write-Host "[OK] Composer ditemukan" -ForegroundColor Green
} catch {
    Write-Host "[ERROR] Composer tidak ditemukan! Install dari https://getcomposer.org/download/" -ForegroundColor Red
    Read-Host "Tekan Enter untuk keluar"
    exit
}

Write-Host ""
Write-Host "[1/6] Menginstall dependencies Laravel..." -ForegroundColor Cyan
composer install --no-interaction --prefer-dist

Write-Host ""
Write-Host "[2/6] Membuat APP_KEY baru..." -ForegroundColor Cyan
php artisan key:generate --force

Write-Host ""
Write-Host "[3/6] Membuat symlink storage..." -ForegroundColor Cyan
php artisan storage:link

Write-Host ""
Write-Host "================================================" -ForegroundColor Yellow
Write-Host " SETUP DATABASE" -ForegroundColor Yellow
Write-Host "================================================" -ForegroundColor Yellow
Write-Host " 1. Pastikan XAMPP MySQL sudah berjalan" -ForegroundColor White
Write-Host " 2. Buka http://localhost/phpmyadmin" -ForegroundColor White
Write-Host " 3. Buat database baru: aa_songkok" -ForegroundColor White
Write-Host " 4. Jika password MySQL bukan kosong, edit .env" -ForegroundColor White
Write-Host ""
Read-Host "Tekan Enter setelah database dibuat"

Write-Host ""
Write-Host "[4/6] Menjalankan migrasi database..." -ForegroundColor Cyan
php artisan migrate --force

Write-Host ""
Write-Host "[5/6] Mengisi data dummy..." -ForegroundColor Cyan
php artisan db:seed --force

Write-Host ""
Write-Host "[6/6] Membersihkan cache..." -ForegroundColor Cyan
php artisan config:clear
php artisan cache:clear
php artisan view:clear

Write-Host ""
Write-Host "================================================" -ForegroundColor Green
Write-Host " INSTALASI SELESAI!" -ForegroundColor Green
Write-Host "================================================" -ForegroundColor Green
Write-Host ""
Write-Host " Akun Login:" -ForegroundColor White
Write-Host " Admin : admin@aasongkok.com / password" -ForegroundColor Cyan
Write-Host " User  : user@aasongkok.com  / password" -ForegroundColor Cyan
Write-Host ""
Write-Host " Menjalankan server di http://localhost:8000" -ForegroundColor Yellow
Write-Host ""
php artisan serve
