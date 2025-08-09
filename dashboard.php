<?php
require_once 'config/database.php';
require_once 'includes/functions.php';

cekLogin();

// Hitung total barang
try {
    $stmt = $pdo->query("SELECT COUNT(*) as total_barang FROM barang");
    $total_barang = $stmt->fetch()['total_barang'];
    
    $stmt = $pdo->query("SELECT COUNT(*) as total_kategori FROM kategori_barang");
    $total_kategori = $stmt->fetch()['total_kategori'];
} catch (PDOException $e) {
    $total_barang = 0;
    $total_kategori = 0;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/png" href="material-dashboard-master/assets/img/favicon.png">
    <title>Dashboard - Zoya Cookies</title>
    <!-- Fonts -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <!-- CSS Files -->
    <link href="material-dashboard-master/assets/css/material-dashboard.css?v=3.0.0" rel="stylesheet" />
</head>

<body class="g-sidenav-show bg-gray-200">
    <!-- Sidebar -->
    <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 bg-gradient-dark" id="sidenav-main">
        <div class="sidenav-header">
            <a class="navbar-brand m-0" href="dashboard.php">
                <img src="material-dashboard-master/assets/img/logo-ct.png" class="navbar-brand-img h-100" alt="main_logo">
                <span class="ms-1 font-weight-bold text-white">Zoya Cookies</span>
            </a>
        </div>
        <hr class="horizontal light mt-0 mb-2">
        <div class="collapse navbar-collapse w-auto max-height-vh-100" id="sidenav-collapse-main">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link text-white active bg-gradient-primary" href="dashboard.php">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">dashboard</i>
                        </div>
                        <span class="nav-link-text ms-1">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="kategori.php">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">category</i>
                        </div>
                        <span class="nav-link-text ms-1">Kategori Barang</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="barang.php">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">inventory</i>
                        </div>
                        <span class="nav-link-text ms-1">Data Barang</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="sidenav-footer position-absolute w-100 bottom-0">
            <div class="mx-3">
                <a class="btn btn-outline-primary mt-4 w-100" href="logout.php">
                    <i class="material-icons opacity-10">logout</i> Keluar
                </a>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <!-- Navbar -->
        <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur">
            <div class="container-fluid py-1 px-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Halaman</a></li>
                        <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Dashboard</li>
                    </ol>
                    <h6 class="font-weight-bolder mb-0">Dashboard</h6>
                </nav>
                <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
                    <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                        <span class="text-sm">Selamat datang, <?php echo $_SESSION['admin_nama']; ?>!</span>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Content -->
        <div class="container-fluid py-4">
            <div class="row">
                <!-- Card Total Barang -->
                <div class="col-xl-6 col-sm-6 mb-4">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-icons opacity-10">inventory</i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 text-capitalize">Total Barang</p>
                                <h4 class="mb-0"><?php echo $total_barang; ?></h4>
                            </div>
                        </div>
                        <hr class="dark horizontal my-0">
                        <div class="card-footer p-3">
                            <p class="mb-0"><span class="text-success text-sm font-weight-bolder">Data</span> total barang yang tersedia</p>
                        </div>
                    </div>
                </div>

                <!-- Card Total Kategori -->
                <div class="col-xl-6 col-sm-6 mb-4">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-icons opacity-10">category</i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 text-capitalize">Total Kategori</p>
                                <h4 class="mb-0"><?php echo $total_kategori; ?></h4>
                            </div>
                        </div>
                        <hr class="dark horizontal my-0">
                        <div class="card-footer p-3">
                            <p class="mb-0"><span class="text-success text-sm font-weight-bolder">Data</span> total kategori barang</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Selamat Datang -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header pb-0">
                            <h6>Selamat Datang di Sistem Persediaan Zoya Cookies</h6>
                        </div>
                        <div class="card-body">
                            <p class="text-sm">
                                Sistem ini digunakan untuk mengelola persediaan barang toko kue Zoya Cookies. 
                                Anda dapat mengelola kategori barang dan data barang melalui menu di sebelah kiri.
                            </p>
                            <div class="row">
                                <div class="col-lg-6">
                                    <a href="kategori.php" class="btn bg-gradient-primary mb-2">
                                        <i class="material-icons text-sm">category</i>&nbsp;&nbsp;Kelola Kategori
                                    </a>
                                </div>
                                <div class="col-lg-6">
                                    <a href="barang.php" class="btn bg-gradient-info mb-2">
                                        <i class="material-icons text-sm">inventory</i>&nbsp;&nbsp;Kelola Barang
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="footer py-4">
            <div class="container-fluid">
                <div class="row align-items-center justify-content-lg-between">
                    <div class="col-lg-6 mb-lg-0 mb-4">
                        <div class="copyright text-center text-sm text-muted text-lg-start">
                            © <?php echo date('Y'); ?> Sistem Persediaan Zoya Cookies
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </main>

    <!-- Core JS Files -->
    <script src="material-dashboard-master/assets/js/core/popper.min.js"></script>
    <script src="material-dashboard-master/assets/js/core/bootstrap.min.js"></script>
    <script src="material-dashboard-master/assets/js/material-dashboard.min.js?v=3.0.0"></script>
</body>
</html>