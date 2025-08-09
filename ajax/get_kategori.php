<?php
require_once '../config/database.php';
require_once '../includes/functions.php';

cekLogin();

// Pastikan request adalah GET
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    jsonResponse('error', 'Metode request tidak valid');
}

// Ambil ID kategori
$id_kategori = $_GET['id'] ?? '';

// Validasi input
if (empty($id_kategori)) {
    jsonResponse('error', 'ID kategori harus diisi');
}

try {
    // Ambil data kategori berdasarkan ID
    $stmt = $pdo->prepare("SELECT * FROM kategori_barang WHERE id_kategori = ?");
    $stmt->execute([$id_kategori]);
    $kategori = $stmt->fetch();
    
    if ($kategori) {
        jsonResponse('success', 'Data kategori berhasil diambil', $kategori);
    } else {
        jsonResponse('error', 'Kategori tidak ditemukan');
    }
    
} catch (PDOException $e) {
    logError('Error get kategori: ' . $e->getMessage(), __FILE__);
    jsonResponse('error', 'Terjadi kesalahan sistem');
}
?>