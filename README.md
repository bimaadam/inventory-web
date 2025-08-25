# Sistem Persediaan Barang Zoya Cookies

Halo, Acep!

Ini adalah sistem persediaan barang yang sudah saya buat untuk tugas akhir kamu. Sistem ini membantu kamu mencatat barang masuk dan keluar, serta melihat stok barang.

---

## Cara Menggunakan Sistem Ini (Singkat)

### 1. Persiapan Awal (Hanya Sekali)

Sistem ini perlu diinstal di komputer kamu. Jika kamu sudah punya XAMPP atau sejenisnya, langkahnya:
*   **Copy folder `persediaan-barang`** ini ke dalam folder `htdocs` di XAMPP kamu.
    *   Contoh: `C:\xampp\htdocs\persediaan-barang` (Windows) atau `/opt/lampp/htdocs/persediaan-barang` (Linux).
*   **Nyalakan Apache dan MySQL** dari XAMPP Control Panel.
*   **Buka Browser**: Ketik `http://localhost/persediaan-barang` di alamat browser kamu.

### 2. Login ke Sistem

*   **Halaman Login**: Kamu akan melihat halaman login.
*   **Username**: `admin`
*   **Password**: `admin123`
*   Klik tombol **"Masuk"**.

### 3. Fitur Utama

Setelah login, kamu akan masuk ke **Dashboard**. Di sebelah kiri ada menu-menu utama:

*   **Dashboard**: Melihat ringkasan stok dan barang yang hampir habis.
*   **Master Data**:
    *   **Kategori**: Mengatur jenis-jenis barang (misal: Kue Kering, Kue Basah).
    *   **Barang**: Mengatur daftar barang yang kamu punya (nama, harga, deskripsi).
    *   **Pemasok**: Mengatur daftar tempat kamu membeli barang.
*   **Transaksi**:
    *   **Barang Masuk**: Mencatat barang yang baru datang (stok akan bertambah otomatis).
    *   **Barang Keluar**: Mencatat barang yang keluar (stok akan berkurang otomatis).
*   **Laporan**: Melihat laporan stok, barang masuk, dan barang keluar. Kamu bisa cetak laporan ini dari browser (pilih "Save as PDF" saat mencetak).

---

## Penting!

*   **Username & Password Admin**: `admin` / `admin123` (ini bisa diganti nanti jika perlu).
*   **Database**: `zoya_cookies_db` (sudah dibuat otomatis saat setup awal).

Semoga berhasil dengan tugas akhirnya, Acep!

---
