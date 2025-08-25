<?php
require_once '../config/database.php';
require_once '../includes/functions.php';

cekLogin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse('error', 'Metode request tidak valid');
}

// Ambil data dari AJAX
$id_keluar = $_POST['id_keluar'] ?? '';
$id_barang = $_POST['id_barang'] ?? '';
$jumlah = $_POST['jumlah'] ?? '';

// Validasi input
if (empty($id_keluar) || empty($id_barang) || empty($jumlah)) {
    jsonResponse('error', 'Data tidak lengkap untuk menghapus transaksi.');
}

if (!is_numeric($jumlah) || $jumlah <= 0) {
    jsonResponse('error', 'Jumlah tidak valid.');
}

try {
    // Mulai transaksi database
    $pdo->beginTransaction();

    // 1. Hapus data transaksi barang keluar
    $stmt = $pdo->prepare("DELETE FROM barang_keluar WHERE id_keluar = ?");
    $stmt->execute([$id_keluar]);

    if ($stmt->rowCount() === 0) {
        throw new Exception("Transaksi tidak ditemukan atau sudah dihapus.");
    }

    // 2. Update (tambah/kembalikan) stok di tabel barang
    $stmt_update_stok = $pdo->prepare(
        "UPDATE barang SET stok_barang = stok_barang + ? WHERE id_barang = ?"
    );
    $stmt_update_stok->execute([$jumlah, $id_barang]);

    // Commit transaksi
    $pdo->commit();
    
    jsonResponse('success', 'Transaksi barang keluar berhasil dihapus dan stok telah dikembalikan.');

} catch (Exception $e) {
    // Rollback transaksi jika terjadi error
    $pdo->rollBack();
    logError('Error hapus barang keluar: ' . $e->getMessage(), __FILE__);
    jsonResponse('error', 'Terjadi kesalahan sistem saat menghapus transaksi: ' . $e->getMessage());
}
?>