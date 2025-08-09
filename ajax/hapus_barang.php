<?php
require_once '../config/database.php';
require_once '../includes/functions.php';

cekLogin();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    try {
        $id = (int)$_POST['id'];
        
        // Cek apakah barang ada
        $stmt = $pdo->prepare("SELECT nama_barang FROM barang WHERE id_barang = ?");
        $stmt->execute([$id]);
        $barang = $stmt->fetch();
        
        if (!$barang) {
            throw new Exception('Barang tidak ditemukan');
        }
        
        // Hapus barang
        $stmt = $pdo->prepare("DELETE FROM barang WHERE id_barang = ?");
        $stmt->execute([$id]);
        
        echo json_encode([
            'status' => 'success',
            'message' => 'Barang berhasil dihapus'
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
        'message' => 'Parameter tidak valid'
    ]);
}
?>