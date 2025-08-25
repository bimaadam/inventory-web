<?php
require_once '../config/database.php';
require_once '../includes/functions.php';

cekLogin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse('error', 'Metode request tidak valid');
}

// Ambil data dari AJAX
$id_masuk = $_POST['id_masuk'] ?? '';
$id_barang = $_POST['id_barang'] ?? '';
$jumlah = $_POST['jumlah'] ?? '';

// Validasi input
if (empty($id_masuk) || empty($id_barang) || empty($jumlah)) {
    jsonResponse('error', 'Data tidak lengkap untuk menghapus transaksi.');
}

if (!is_numeric($jumlah) || $jumlah <= 0) {
    jsonResponse('error', 'Jumlah tidak valid.');
}

try {
    // Mulai transaksi database
    $pdo->beginTransaction();

    // 1. Hapus data transaksi barang masuk
    $stmt = $pdo->prepare("DELETE FROM barang_masuk WHERE id_masuk = ?");
    $stmt->execute([$id_masuk]);

    if ($stmt->rowCount() === 0) {
        throw new Exception("Transaksi tidak ditemukan atau sudah dihapus.");
    }

    // 2. Update (kurangi) stok di tabel barang
    $stmt_update_stok = $pdo->prepare(
        "UPDATE barang SET stok_barang = stok_barang - ? WHERE id_barang = ?"
    );
    $stmt_update_stok->execute([$jumlah, $id_barang]);

    // Commit transaksi
    $pdo->commit();
    
    jsonResponse('success', 'Transaksi barang masuk berhasil dihapus dan stok telah diperbarui.');

} catch (Exception $e) {
    // Rollback transaksi jika terjadi error
    $pdo->rollBack();
    logError('Error hapus barang masuk: ' . $e->getMessage(), __FILE__);
    jsonResponse('error', 'Terjadi kesalahan sistem saat menghapus transaksi: ' . $e->getMessage());
}
?>