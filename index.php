<?php
require_once 'includes/functions.php';

// Mulai session jika belum
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Jika sudah login, redirect ke dashboard
if (isset($_SESSION['admin_id'])) {
    header('Location: dashboard.php');
    exit();
} else {
    // Jika belum login, redirect ke login
    header('Location: login.php');
    exit();
}
?>