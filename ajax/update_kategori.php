<?php
require_once '../config/database.php';
require_once '../includes/functions.php';

cekLogin();

// Pastikan request adalah POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse('error', 'Metode request tidak valid');
}

// Ambil data dari form
$id_kategori = $_POST['id_kategori'] ?? '';
$nama_kategori = bersihkanInput($_POST['nama_kategori'] ?? '');
$deskripsi_kategori = bersihkanInput($_POST['deskripsi_kategori'] ?? '');

// Validasi input
if (empty($id_kategori) || empty($nama_kategori)) {
    jsonResponse('error', 'ID kategori dan nama kategori harus diisi');
}

try {
    // Cek apakah kategori dengan nama yang sama sudah ada (selain yang sedang diedit)
    $stmt = $pdo->prepare("SELECT id_kategori FROM kategori_barang WHERE nama_kategori = ? AND id_kategori != ?");
    $stmt->execute([$nama_kategori, $id_kategori]);
    
    if ($stmt->fetch()) {
        jsonResponse('error', 'Nama kategori sudah digunakan');
    }
    
    // Update kategori
    $stmt = $pdo->prepare("UPDATE kategori_barang SET nama_kategori = ?, deskripsi_kategori = ? WHERE id_kategori = ?");
    
    if ($stmt->execute([$nama_kategori, $deskripsi_kategori, $id_kategori])) {
        jsonResponse('success', 'Kategori berhasil diperbarui');
    } else {
        jsonResponse('error', 'Gagal memperbarui kategori');
    }
    
} catch (PDOException $e) {
    logError('Error update kategori: ' . $e->getMessage(), __FILE__);
    jsonResponse('error', 'Terjadi kesalahan sistem');
}
?>