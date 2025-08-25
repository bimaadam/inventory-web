<?php
// includes/header.php
// Pastikan session sudah dimulai
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/png" href="material-dashboard-master/assets/img/favicon.png">
    <title><?php echo isset($pageTitle) ? $pageTitle . ' - Zoya' : 'Sistem Persediaan Zoya'; ?></title>
    <!-- Fonts -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- CSS Files -->
    <link href="material-dashboard-master/assets/css/material-dashboard.css?v=3.0.0" rel="stylesheet" />
    <style>
        @media print {
            body.g-sidenav-show {
                overflow: visible !important;
            }
            .g-sidenav-show .main-content {
                margin-left: 0 !important;
            }
            .no-print {
                display: none !important;
            }
            .card {
                box-shadow: none !important;
                border: 1px solid #dee2e6 !important;
            }
            .table {
                width: 100%;
            }
        }
    </style>
</head>

<body class="g-sidenav-show bg-gray-200">
    <?php require_once 'includes/sidebar.php'; ?>

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <!-- Navbar -->
        <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl no-print" id="navbarBlur">
            <div class="container-fluid py-1 px-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Halaman</a></li>
                        <li class="breadcrumb-item text-sm text-dark active" aria-current="page"><?php echo isset($pageTitle) ? $pageTitle : 'Dashboard'; ?></li>
                    </ol>
                    <h6 class="font-weight-bolder mb-0"><?php echo isset($pageTitle) ? $pageTitle : 'Dashboard'; ?></h6>
                </nav>
                <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
                    <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                        <span class="text-sm">Selamat datang, <?php echo $_SESSION['admin_nama']; ?>!</span>
                    </div>
                </div>
            </div>
        </nav>