<?php
require_once '../config/database.php';
require_once '../includes/functions.php';

cekLogin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse('error', 'Metode request tidak valid');
}

// Ambil data dari form
$id_barang = $_POST['id_barang'] ?? '';
$jumlah = $_POST['jumlah'] ?? '';
$keterangan = $_POST['keterangan'] ?? '';
$tanggal_keluar = $_POST['tanggal_keluar'] ?? '';

// Validasi input
if (empty($id_barang) || empty($jumlah) || empty($tanggal_keluar) || empty($keterangan)) {
    jsonResponse('error', 'Semua field harus diisi');
}

if (!is_numeric($jumlah) || $jumlah <= 0) {
    jsonResponse('error', 'Jumlah harus berupa angka positif');
}

try {
    // Mulai transaksi database
    $pdo->beginTransaction();

    // 1. Cek stok yang tersedia
    $stmt_cek_stok = $pdo->prepare("SELECT stok_barang FROM barang WHERE id_barang = ? FOR UPDATE");
    $stmt_cek_stok->execute([$id_barang]);
    $stok_saat_ini = $stmt_cek_stok->fetchColumn();

    if ($stok_saat_ini === false) {
        throw new Exception("Barang tidak ditemukan.");
    }

    if ($stok_saat_ini < $jumlah) {
        throw new Exception("Stok tidak mencukupi. Stok saat ini: " . $stok_saat_ini);
    }

    // 2. Update (kurangi) stok di tabel barang
    $stmt_update_stok = $pdo->prepare(
        "UPDATE barang SET stok_barang = stok_barang - ? WHERE id_barang = ?"
    );
    $stmt_update_stok->execute([$jumlah, $id_barang]);

    // 3. Simpan data transaksi barang keluar
    $stmt = $pdo->prepare(
        "INSERT INTO barang_keluar (id_barang, jumlah, keterangan, tanggal_keluar) VALUES (?, ?, ?, ?)"
    );
    $stmt->execute([$id_barang, $jumlah, $keterangan, $tanggal_keluar]);

    // Commit transaksi
    $pdo->commit();
    
    jsonResponse('success', 'Transaksi barang keluar berhasil disimpan dan stok telah diperbarui.');

} catch (Exception $e) {
    // Rollback transaksi jika terjadi error
    $pdo->rollBack();
    logError('Error simpan barang keluar: ' . $e->getMessage(), __FILE__);
    jsonResponse('error', 'Gagal menyimpan transaksi: ' . $e->getMessage());
}
?>