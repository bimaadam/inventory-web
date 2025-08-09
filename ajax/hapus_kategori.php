<?php
require_once '../config/database.php';
require_once '../includes/functions.php';

cekLogin();

// Pastikan request adalah POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse('error', 'Metode request tidak valid');
}

// Ambil ID kategori
$id_kategori = $_POST['id'] ?? '';

// Validasi input
if (empty($id_kategori)) {
    jsonResponse('error', 'ID kategori harus diisi');
}

try {
    // Cek apakah kategori sedang digunakan oleh barang
    $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM barang WHERE id_kategori = ?");
    $stmt->execute([$id_kategori]);
    $result = $stmt->fetch();
    
    if ($result['total'] > 0) {
        jsonResponse('error', 'Kategori tidak dapat dihapus karena masih digunakan oleh ' . $result['total'] . ' barang');
    }
    
    // Hapus kategori
    $stmt = $pdo->prepare("DELETE FROM kategori_barang WHERE id_kategori = ?");
    
    if ($stmt->execute([$id_kategori])) {
        if ($stmt->rowCount() > 0) {
            jsonResponse('success', 'Kategori berhasil dihapus');
        } else {
            jsonResponse('error', 'Kategori tidak ditemukan');
        }
    } else {
        jsonResponse('error', 'Gagal menghapus kategori');
    }
    
} catch (PDOException $e) {
    logError('Error hapus kategori: ' . $e->getMessage(), __FILE__);
    jsonResponse('error', 'Terjadi kesalahan sistem');
}
?>