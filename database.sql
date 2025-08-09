-- Database untuk sistem persediaan barang Zoya Cookies
CREATE DATABASE IF NOT EXISTS zoya_cookies_db;
USE zoya_cookies_db;

-- Tabel Admin
CREATE TABLE admin (
    id_admin INT PRIMARY KEY AUTO_INCREMENT,
    nama_admin VARCHAR(100) NOT NULL,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100),
    tanggal_dibuat DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Tabel Kategori Barang
CREATE TABLE kategori_barang (
    id_kategori INT PRIMARY KEY AUTO_INCREMENT,
    nama_kategori VARCHAR(100) NOT NULL,
    deskripsi_kategori TEXT,
    tanggal_dibuat DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Tabel Barang
CREATE TABLE barang (
    id_barang INT PRIMARY KEY AUTO_INCREMENT,
    nama_barang VARCHAR(100) NOT NULL,
    id_kategori INT,
    harga_barang DECIMAL(10,2) NOT NULL,
    stok_barang INT NOT NULL DEFAULT 0,
    deskripsi_barang TEXT,
    tanggal_dibuat DATETIME DEFAULT CURRENT_TIMESTAMP,
    tanggal_diperbarui DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_kategori) REFERENCES kategori_barang(id_kategori) ON DELETE SET NULL
);

-- Insert data admin default
INSERT INTO admin (nama_admin, username, password, email) VALUES 
('Administrator', 'admin', MD5('admin123'), 'admin@zoyacookies.com');

-- Insert data kategori default
INSERT INTO kategori_barang (nama_kategori, deskripsi_kategori) VALUES 
('Kue Kering', 'Berbagai jenis kue kering dan cookies'),
('Kue Basah', 'Kue dengan tekstur basah dan lembut'),
('Roti', 'Berbagai jenis roti dan pastry');

-- Insert data barang contoh
INSERT INTO barang (nama_barang, id_kategori, harga_barang, stok_barang, deskripsi_barang) VALUES 
('Cookies Coklat', 1, 25000.00, 50, 'Cookies dengan rasa coklat yang lezat'),
('Nastar', 1, 30000.00, 30, 'Kue nastar dengan selai nanas'),
('Brownies', 2, 35000.00, 20, 'Brownies coklat yang lembut'),
('Roti Tawar', 3, 15000.00, 25, 'Roti tawar untuk sarapan');