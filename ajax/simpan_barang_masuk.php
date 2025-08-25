<?php
require_once '../config/database.php';
require_once '../includes/functions.php';

cekLogin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse('error', 'Metode request tidak valid');
}

// Ambil data dari form
$id_barang = $_POST['id_barang'] ?? '';
$id_pemasok = !empty($_POST['id_pemasok']) ? $_POST['id_pemasok'] : null;
$jumlah = $_POST['jumlah'] ?? '';
$tanggal_masuk = $_POST['tanggal_masuk'] ?? '';

// Validasi input
if (empty($id_barang) || empty($jumlah) || empty($tanggal_masuk)) {
    jsonResponse('error', 'Semua field yang wajib diisi harus diisi');
}

if (!is_numeric($jumlah) || $jumlah <= 0) {
    jsonResponse('error', 'Jumlah harus berupa angka positif');
}

try {
    // Mulai transaksi database
    $pdo->beginTransaction();

    // 1. Simpan data transaksi barang masuk
    $stmt = $pdo->prepare(
        "INSERT INTO barang_masuk (id_barang, id_pemasok, jumlah, tanggal_masuk) VALUES (?, ?, ?, ?)"
    );
    $stmt->execute([$id_barang, $id_pemasok, $jumlah, $tanggal_masuk]);

    // 2. Update stok di tabel barang
    $stmt_update_stok = $pdo->prepare(
        "UPDATE barang SET stok_barang = stok_barang + ? WHERE id_barang = ?"
    );
    $stmt_update_stok->execute([$jumlah, $id_barang]);

    // Commit transaksi
    $pdo->commit();
    
    jsonResponse('success', 'Transaksi barang masuk berhasil disimpan dan stok telah diperbarui.');

} catch (PDOException $e) {
    // Rollback transaksi jika terjadi error
    $pdo->rollBack();
    logError('Error simpan barang masuk: ' . $e->getMessage(), __FILE__);
    jsonResponse('error', 'Terjadi kesalahan sistem saat menyimpan transaksi.');
}
?>