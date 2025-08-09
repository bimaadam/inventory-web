<?php
require_once '../config/database.php';
require_once '../includes/functions.php';

cekLogin();

// Pastikan request adalah POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse('error', 'Metode request tidak valid');
}

// Ambil data dari form
$nama_kategori = bersihkanInput($_POST['nama_kategori'] ?? '');
$deskripsi_kategori = bersihkanInput($_POST['deskripsi_kategori'] ?? '');

// Validasi input
if (empty($nama_kategori)) {
    jsonResponse('error', 'Nama kategori harus diisi');
}

try {
    // Cek apakah kategori dengan nama yang sama sudah ada
    $stmt = $pdo->prepare("SELECT id_kategori FROM kategori_barang WHERE nama_kategori = ?");
    $stmt->execute([$nama_kategori]);
    
    if ($stmt->fetch()) {
        jsonResponse('error', 'Nama kategori sudah digunakan');
    }
    
    // Simpan kategori baru
    $stmt = $pdo->prepare("INSERT INTO kategori_barang (nama_kategori, deskripsi_kategori) VALUES (?, ?)");
    
    if ($stmt->execute([$nama_kategori, $deskripsi_kategori])) {
        jsonResponse('success', 'Kategori berhasil ditambahkan');
    } else {
        jsonResponse('error', 'Gagal menambahkan kategori');
    }
    
} catch (PDOException $e) {
    logError('Error simpan kategori: ' . $e->getMessage(), __FILE__);
    jsonResponse('error', 'Terjadi kesalahan sistem');
}
?>