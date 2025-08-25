<?php
require_once '../config/database.php';
require_once '../includes/functions.php';

cekLogin();

// Pastikan request adalah POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse('error', 'Metode request tidak valid');
}

// Ambil ID dari form
$id_pemasok = $_POST['id_pemasok'] ?? '';

// Validasi input
if (empty($id_pemasok)) {
    jsonResponse('error', 'ID pemasok harus diisi');
}

try {
    // Hapus data pemasok
    $stmt = $pdo->prepare("DELETE FROM pemasok WHERE id_pemasok = ?");
    $stmt->execute([$id_pemasok]);
    
    // Cek apakah ada baris yang terhapus
    if ($stmt->rowCount() > 0) {
        jsonResponse('success', 'Data pemasok berhasil dihapus');
    } else {
        jsonResponse('error', 'Pemasok tidak ditemukan atau sudah dihapus');
    }
    
} catch (PDOException $e) {
    // Cek jika ada error foreign key constraint
    if ($e->errorInfo[1] == 1451) {
        jsonResponse('error', 'Gagal menghapus: Pemasok ini masih digunakan di data Barang Masuk.');
    } else {
        logError('Error hapus pemasok: ' . $e->getMessage(), __FILE__);
        jsonResponse('error', 'Terjadi kesalahan sistem saat menghapus data');
    }
}
?>