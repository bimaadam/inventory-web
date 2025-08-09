<?php
require_once '../config/database.php';
require_once '../includes/functions.php';

cekLogin();

// Pastikan request adalah POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse('error', 'Metode request tidak valid');
}

// Ambil data dari form
$nama_barang = bersihkanInput($_POST['nama_barang'] ?? '');
$id_kategori = $_POST['id_kategori'] ?? '';
$harga_barang = $_POST['harga_barang'] ?? '';
$stok_barang = $_POST['stok_barang'] ?? '';
$deskripsi_barang = bersihkanInput($_POST['deskripsi_barang'] ?? '');

// Validasi input
if (empty($nama_barang)) {
    jsonResponse('error', 'Nama barang harus diisi');
}

if (empty($id_kategori)) {
    jsonResponse('error', 'Kategori barang harus dipilih');
}

if (empty($harga_barang) || !is_numeric($harga_barang) || $harga_barang < 0) {
    jsonResponse('error', 'Harga barang harus diisi dengan angka positif');
}

if (empty($stok_barang) || !is_numeric($stok_barang) || $stok_barang < 0) {
    jsonResponse('error', 'Stok barang harus diisi dengan angka positif');
}

try {
    // Cek apakah barang dengan nama yang sama sudah ada
    $stmt = $pdo->prepare("SELECT id_barang FROM barang WHERE nama_barang = ?");
    $stmt->execute([$nama_barang]);
    
    if ($stmt->fetch()) {
        jsonResponse('error', 'Nama barang sudah digunakan');
    }
    
    // Simpan barang baru
    $stmt = $pdo->prepare("INSERT INTO barang (nama_barang, id_kategori, harga_barang, stok_barang, deskripsi_barang) VALUES (?, ?, ?, ?, ?)");
    
    if ($stmt->execute([$nama_barang, $id_kategori, $harga_barang, $stok_barang, $deskripsi_barang])) {
        jsonResponse('success', 'Barang berhasil ditambahkan');
    } else {
        jsonResponse('error', 'Gagal menambahkan barang');
    }
    
} catch (PDOException $e) {
    logError('Error simpan barang: ' . $e->getMessage(), __FILE__);
    jsonResponse('error', 'Terjadi kesalahan sistem');
}
?>