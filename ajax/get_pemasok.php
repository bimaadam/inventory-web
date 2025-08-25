<?php
require_once '../config/database.php';
require_once '../includes/functions.php';

cekLogin();

// Pastikan request adalah GET
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    jsonResponse('error', 'Metode request tidak valid');
}

// Ambil ID pemasok
$id_pemasok = $_GET['id'] ?? '';

// Validasi input
if (empty($id_pemasok)) {
    jsonResponse('error', 'ID pemasok harus diisi');
}

try {
    // Ambil data pemasok berdasarkan ID
    $stmt = $pdo->prepare("SELECT * FROM pemasok WHERE id_pemasok = ?");
    $stmt->execute([$id_pemasok]);
    $pemasok = $stmt->fetch();
    
    if ($pemasok) {
        jsonResponse('success', 'Data pemasok berhasil diambil', $pemasok);
    } else {
        jsonResponse('error', 'Pemasok tidak ditemukan');
    }
    
} catch (PDOException $e) {
    logError('Error get pemasok: ' . $e->getMessage(), __FILE__);
    jsonResponse('error', 'Terjadi kesalahan sistem');
}
?>