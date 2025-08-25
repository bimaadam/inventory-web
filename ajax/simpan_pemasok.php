<?php
require_once '../config/database.php';
require_once '../includes/functions.php';

cekLogin();

// Pastikan request adalah POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse('error', 'Metode request tidak valid');
}

// Ambil data dari form
$nama_pemasok = $_POST['nama_pemasok'] ?? '';
$alamat = $_POST['alamat'] ?? '';
$telepon = $_POST['telepon'] ?? '';

// Validasi input
if (empty($nama_pemasok)) {
    jsonResponse('error', 'Nama pemasok harus diisi');
}

try {
    // Simpan data pemasok baru
    $stmt = $pdo->prepare("INSERT INTO pemasok (nama_pemasok, alamat, telepon) VALUES (?, ?, ?)");
    $stmt->execute([$nama_pemasok, $alamat, $telepon]);
    
    jsonResponse('success', 'Data pemasok berhasil disimpan');
    
} catch (PDOException $e) {
    // Cek jika ada error duplikasi (jika ada unique constraint pada nama_pemasok)
    if ($e->errorInfo[1] == 1062) {
        jsonResponse('error', 'Nama pemasok sudah ada.');
    } else {
        logError('Error simpan pemasok: ' . $e->getMessage(), __FILE__);
        jsonResponse('error', 'Terjadi kesalahan sistem saat menyimpan data');
    }
}
?>