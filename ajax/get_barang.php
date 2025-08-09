<?php
require_once '../config/database.php';
require_once '../includes/functions.php';

cekLogin();

// Pastikan request adalah GET
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    jsonResponse('error', 'Metode request tidak valid');
}

// Ambil ID barang
$id_barang = $_GET['id'] ?? '';

// Validasi input
if (empty($id_barang)) {
    jsonResponse('error', 'ID barang harus diisi');
}

try {
    // Ambil data barang berdasarkan ID
    $stmt = $pdo->prepare("SELECT * FROM barang WHERE id_barang = ?");
    $stmt->execute([$id_barang]);
    $barang = $stmt->fetch();
    
    if ($barang) {
        jsonResponse('success', 'Data barang berhasil diambil', $barang);
    } else {
        jsonResponse('error', 'Barang tidak ditemukan');
    }
    
} catch (PDOException $e) {
    logError('Error get barang: ' . $e->getMessage(), __FILE__);
    jsonResponse('error', 'Terjadi kesalahan sistem');
}
?>