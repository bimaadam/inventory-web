<?php
require_once '../config/database.php';
require_once '../includes/functions.php';

// Pastikan request adalah POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse('error', 'Metode request tidak valid');
}

// Ambil data dari form
$username = bersihkanInput($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

// Validasi input
if (empty($username) || empty($password)) {
    jsonResponse('error', 'Username dan password harus diisi');
}

try {
    // Cari admin berdasarkan username
    $stmt = $pdo->prepare("SELECT id_admin, nama_admin, username, password FROM admin WHERE username = ?");
    $stmt->execute([$username]);
    $admin = $stmt->fetch();
    
    if ($admin && md5($password) === $admin['password']) {
        // Login berhasil
        $_SESSION['admin_id'] = $admin['id_admin'];
        $_SESSION['admin_nama'] = $admin['nama_admin'];
        $_SESSION['admin_username'] = $admin['username'];
        
        jsonResponse('success', 'Login berhasil! Mengalihkan ke dashboard...');
    } else {
        jsonResponse('error', 'Username atau password salah');
    }
    
} catch (PDOException $e) {
    logError('Error login: ' . $e->getMessage(), __FILE__);
    jsonResponse('error', 'Terjadi kesalahan sistem');
}
?>