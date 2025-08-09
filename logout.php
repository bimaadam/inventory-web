<?php
require_once 'includes/functions.php';

// Mulai session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Hapus semua data session
session_unset();
session_destroy();

// Redirect ke halaman login
header('Location: login.php');
exit();
?>