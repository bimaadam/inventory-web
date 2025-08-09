<?php
require_once '../config/database.php';
require_once '../includes/functions.php';

cekLogin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $id_barang = (int)$_POST['id_barang'];
        $nama_barang = trim($_POST['nama_barang']);
        $id_kategori = $_POST['id_kategori'] ? (int)$_POST['id_kategori'] : null;
        $harga_barang = (float)$_POST['harga_barang'];
        $stok_barang = (int)$_POST['stok_barang'];
        $deskripsi_barang = trim($_POST['deskripsi_barang']);
        
        // Validasi input
        if (empty($nama_barang)) {
            throw new Exception('Nama barang tidak boleh kosong');
        }
        
        if ($harga_barang <= 0) {
            throw new Exception('Harga barang harus lebih dari 0');
        }
        
        if ($stok_barang < 0) {
            throw new Exception('Stok barang tidak boleh negatif');
        }
        
        // Update data
        $stmt = $pdo->prepare("
            UPDATE barang 
            SET nama_barang = ?, id_kategori = ?, harga_barang = ?, stok_barang = ?, deskripsi_barang = ?
            WHERE id_barang = ?
        ");
        
        $stmt->execute([$nama_barang, $id_kategori, $harga_barang, $stok_barang, $deskripsi_barang, $id_barang]);
        
        echo json_encode([
            'status' => 'success',
            'message' => 'Barang berhasil diperbarui'
        ]);
        
    } catch (Exception $e) {
        echo json_encode([
            'status' => 'error',
            'message' => $e->getMessage()
        ]);
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Method tidak diizinkan'
    ]);
}
?>