<?php
require_once '../config/database.php';
require_once '../includes/functions.php';

cekLogin();

// Pastikan request adalah POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse('error', 'Metode request tidak valid');
}

// Ambil data dari form
$id_pemasok = $_POST['id_pemasok'] ?? '';
$nama_pemasok = $_POST['nama_pemasok'] ?? '';
$alamat = $_POST['alamat'] ?? '';
$telepon = $_POST['telepon'] ?? '';

// Validasi input
if (empty($id_pemasok) || empty($nama_pemasok)) {
    jsonResponse('error', 'ID dan Nama pemasok harus diisi');
}

try {
    // Update data pemasok
    $stmt = $pdo->prepare("UPDATE pemasok SET nama_pemasok = ?, alamat = ?, telepon = ? WHERE id_pemasok = ?");
    $stmt->execute([$nama_pemasok, $alamat, $telepon, $id_pemasok]);
    
    jsonResponse('success', 'Data pemasok berhasil diperbarui');
    
} catch (PDOException $e) {
    // Cek jika ada error duplikasi (jika ada unique constraint pada nama_pemasok)
    if ($e->errorInfo[1] == 1062) {
        jsonResponse('error', 'Nama pemasok sudah ada.');
    } else {
        logError('Error update pemasok: ' . $e->getMessage(), __FILE__);
        jsonResponse('error', 'Terjadi kesalahan sistem saat memperbarui data');
    }
}
?>