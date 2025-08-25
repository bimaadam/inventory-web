<?php
// includes/sidebar.php

// Dapatkan nama file halaman saat ini
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 bg-gradient-dark" id="sidenav-main">
    <div class="sidenav-header">
        <a class="navbar-brand m-0" href="dashboard.php">
            <img src="assets/img/logo.png" class="navbar-brand-img h-100" alt="main_logo">
            <span class="ms-4 font-weight-bold text-white">Zoya Admin</span>
        </a>
    </div>
    <hr class="horizontal light mt-0 mb-2">
    <div class="collapse navbar-collapse w-auto max-height-vh-100" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link text-white <?php echo ($currentPage == 'dashboard.php') ? 'active bg-gradient-primary' : ''; ?>" href="dashboard.php">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-tachometer-alt text-white"></i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>

            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Master Data</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white <?php echo ($currentPage == 'kategori.php') ? 'active bg-gradient-primary' : ''; ?>" href="kategori.php">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-tags text-white"></i>
                    </div>
                    <span class="nav-link-text ms-1">Kategori</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white <?php echo ($currentPage == 'barang.php') ? 'active bg-gradient-primary' : ''; ?>" href="barang.php">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-box-open text-white"></i>
                    </div>
                    <span class="nav-link-text ms-1">Barang</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white <?php echo ($currentPage == 'pemasok.php') ? 'active bg-gradient-primary' : ''; ?>" href="pemasok.php">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-truck text-white"></i>
                    </div>
                    <span class="nav-link-text ms-1">Pemasok</span>
                </a>
            </li>

            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Transaksi</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white <?php echo ($currentPage == 'barang_masuk.php') ? 'active bg-gradient-primary' : ''; ?>" href="barang_masuk.php">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-sign-in-alt text-white"></i>
                    </div>
                    <span class="nav-link-text ms-1">Barang Masuk</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white <?php echo ($currentPage == 'barang_keluar.php') ? 'active bg-gradient-primary' : ''; ?>" href="barang_keluar.php">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-sign-out-alt text-white"></i>
                    </div>
                    <span class="nav-link-text ms-1">Barang Keluar</span>
                </a>
            </li>

            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Lainnya</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white <?php echo ($currentPage == 'laporan.php') ? 'active bg-gradient-primary' : ''; ?>" href="laporan.php">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-chart-pie text-white"></i>
                    </div>
                    <span class="nav-link-text ms-1">Laporan</span>
                </a>
            </li>
            <!-- <li class="nav-item">
                <a class="nav-link text-white <?php echo ($currentPage == 'admin.php') ? 'active bg-gradient-primary' : ''; ?>" href="admin.php">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-users-cog text-white"></i>
                    </div>
                    <span class="nav-link-text ms-1">Manajemen Admin</span>
                </a>
            </li> -->
        </ul>
    </div>
    <div class="sidenav-footer position-absolute w-100 bottom-0">
        <div class="mx-3">
            <a class="btn btn-outline-primary mt-4 w-100" href="logout.php">
                <i class="fas fa-sign-out-alt text-white"></i> Keluar
            </a>
        </div>
    </div>
</aside>