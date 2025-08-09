#!/bin/bash

# Script untuk import database Zoya Cookies
# Pastikan MySQL/MariaDB sudah berjalan

echo "======================================"
echo "Import Database Zoya Cookies"
echo "======================================"

# Konfigurasi database
DB_HOST="localhost"
DB_USER="root"
DB_PASS=""
DB_NAME="zoya_cookies_db"
SQL_FILE="database.sql"

# Cek apakah file SQL ada
if [ ! -f "$SQL_FILE" ]; then
    echo "Error: File $SQL_FILE tidak ditemukan!"
    exit 1
fi

echo "Mengimport database..."

# Import database
mysql -h$DB_HOST -u$DB_USER -p$DB_PASS < $SQL_FILE

if [ $? -eq 0 ]; then
    echo "✅ Database berhasil diimport!"
    echo ""
    echo "Informasi Login Default:"
    echo "Username: admin"
    echo "Password: admin123"
    echo ""
    echo "Akses sistem di: http://localhost/persediaan-barang"
else
    echo "❌ Gagal mengimport database!"
    echo "Pastikan MySQL/MariaDB sudah berjalan dan konfigurasi benar."
fi

echo "======================================"