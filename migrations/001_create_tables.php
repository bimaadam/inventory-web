<?php
// migrations/001_create_tables.php

require_once __DIR__ . '/../config/database.php';

try {
    // Tabel Users
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS `users` (
            `id_user` INT AUTO_INCREMENT PRIMARY KEY,
            `nama_lengkap` VARCHAR(100) NOT NULL,
            `username` VARCHAR(50) NOT NULL UNIQUE,
            `password` VARCHAR(255) NOT NULL,
            `role` ENUM('admin', 'staf') NOT NULL DEFAULT 'staf',
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB;
    ");
    echo "Tabel 'users' berhasil dibuat atau sudah ada.
";

    // Tabel Pemasok
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS `pemasok` (
            `id_pemasok` INT AUTO_INCREMENT PRIMARY KEY,
            `nama_pemasok` VARCHAR(100) NOT NULL,
            `alamat` TEXT,
            `telepon` VARCHAR(20),
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB;
    ");
    echo "Tabel 'pemasok' berhasil dibuat atau sudah ada.
";

    // Tabel Barang Masuk
    // Pastikan tabel 'barang' sudah ada dengan primary key 'id_barang'
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS `barang_masuk` (
            `id_masuk` INT AUTO_INCREMENT PRIMARY KEY,
            `id_barang` INT NOT NULL,
            `id_pemasok` INT,
            `jumlah` INT NOT NULL,
            `tanggal_masuk` DATETIME NOT NULL,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (`id_barang`) REFERENCES `barang`(`id_barang`) ON DELETE CASCADE,
            FOREIGN KEY (`id_pemasok`) REFERENCES `pemasok`(`id_pemasok`) ON DELETE SET NULL
        ) ENGINE=InnoDB;
    ");
    echo "Tabel 'barang_masuk' berhasil dibuat atau sudah ada.
";

    // Tabel Barang Keluar
    // Pastikan tabel 'barang' sudah ada dengan primary key 'id_barang'
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS `barang_keluar` (
            `id_keluar` INT AUTO_INCREMENT PRIMARY KEY,
            `id_barang` INT NOT NULL,
            `jumlah` INT NOT NULL,
            `tanggal_keluar` DATETIME NOT NULL,
            `keterangan` VARCHAR(255),
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (`id_barang`) REFERENCES `barang`(`id_barang`) ON DELETE CASCADE
        ) ENGINE=InnoDB;
    ");
    echo "Tabel 'barang_keluar' berhasil dibuat atau sudah ada.
";

    echo "
Semua tabel berhasil diproses.
";

} catch (PDOException $e) {
    die("Gagal membuat tabel: " . $e->getMessage());
}
