<?php
require_once 'config/database.php';
require_once 'includes/functions.php';

cekLogin();

// Hitung statistik dashboard
try {
    // Total Kategori
    $stmt_kategori = $pdo->query("SELECT COUNT(*) as total FROM kategori_barang");
    $total_kategori = $stmt_kategori->fetch()['total'];

    // Total Pemasok
    $stmt_pemasok = $pdo->query("SELECT COUNT(*) as total FROM pemasok");
    $total_pemasok = $stmt_pemasok->fetch()['total'];

    // Total Jenis Barang
    $stmt_barang = $pdo->query("SELECT COUNT(*) as total FROM barang");
    $total_barang = $stmt_barang->fetch()['total'];

    // Barang akan habis (stok < 10)
    $low_stock_threshold = 10;
    $stmt_low_stock_count = $pdo->prepare("SELECT COUNT(*) as total FROM barang WHERE stok_barang < ?");
    $stmt_low_stock_count->execute([$low_stock_threshold]);
    $total_low_stock = $stmt_low_stock_count->fetch()['total'];

    // Ambil 5 barang dengan stok terendah
    $stmt_low_stock_items = $pdo->prepare("SELECT nama_barang, stok_barang FROM barang WHERE stok_barang < ? ORDER BY stok_barang ASC LIMIT 5");
    $stmt_low_stock_items->execute([$low_stock_threshold]);
    $low_stock_items = $stmt_low_stock_items->fetchAll();

} catch (PDOException $e) {
    // Set default values on error
    $total_kategori = 0;
    $total_pemasok = 0;
    $total_barang = 0;
    $total_low_stock = 0;
    $low_stock_items = [];
    logError("Dashboard Query Error: " . $e->getMessage(), __FILE__);
}
?>
<?php 
$pageTitle = 'Dashboard';
require_once 'includes/header.php'; 
?>

        <!-- Content -->
        <div class="container-fluid py-4">
            <div class="row">
                <!-- Card Total Kategori -->
                <div class="col-xl-3 col-sm-6 mb-4">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                                <i class="fas fa-tags text-white"></i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 text-capitalize">Total Kategori</p>
                                <h4 class="mb-0"><?php echo $total_kategori; ?></h4>
                            </div>
                        </div>
                        <hr class="dark horizontal my-0">
                        <div class="card-footer p-3"></div>
                    </div>
                </div>

                <!-- Card Total Pemasok -->
                <div class="col-xl-3 col-sm-6 mb-4">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                                <i class="fas fa-truck text-white"></i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 text-capitalize">Total Pemasok</p>
                                <h4 class="mb-0"><?php echo $total_pemasok; ?></h4>
                            </div>
                        </div>
                        <hr class="dark horizontal my-0">
                        <div class="card-footer p-3"></div>
                    </div>
                </div>

                <!-- Card Total Jenis Barang -->
                <div class="col-xl-3 col-sm-6 mb-4">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
                                <i class="fas fa-box-open text-white"></i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 text-capitalize">Total Jenis Barang</p>
                                <h4 class="mb-0"><?php echo $total_barang; ?></h4>
                            </div>
                        </div>
                        <hr class="dark horizontal my-0">
                        <div class="card-footer p-3"></div>
                    </div>
                </div>

                <!-- Card Barang Akan Habis -->
                <div class="col-xl-3 col-sm-6 mb-4">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div class="icon icon-lg icon-shape bg-gradient-danger shadow-danger text-center border-radius-xl mt-n4 position-absolute">
                                <i class="fas fa-exclamation-triangle text-white"></i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 text-capitalize">Barang Akan Habis</p>
                                <h4 class="mb-0"><?php echo $total_low_stock; ?></h4>
                            </div>
                        </div>
                        <hr class="dark horizontal my-0">
                        <div class="card-footer p-3"></div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <!-- Tabel Stok Akan Habis -->
                <div class="col-lg-7 mb-lg-0 mb-4">
                    <div class="card">
                        <div class="card-header pb-0 p-3">
                            <div class="d-flex justify-content-between">
                                <h6 class="mb-2">Daftar Stok Barang Akan Habis (Stok < <?php echo $low_stock_threshold; ?>)</h6>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama Barang</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Sisa Stok</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($low_stock_items)): ?>
                                            <tr><td colspan="2" class="text-center py-3">Semua stok barang aman.</td></tr>
                                        <?php else: ?>
                                            <?php foreach ($low_stock_items as $item): ?>
                                            <tr>
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm"><?php echo htmlspecialchars($item['nama_barang']); ?></h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    <span class="text-danger font-weight-bold"><?php echo $item['stok_barang']; ?></span>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Selamat Datang -->
                <div class="col-lg-5">
                     <div class="card h-100">
                        <div class="card-header pb-0">
                            <h6>Selamat Datang & Akses Cepat</h6>
                        </div>
                        <div class="card-body d-flex flex-column justify-content-center">
                            <p class="text-sm">
                                Gunakan tombol di bawah untuk mengakses menu transaksi utama dengan cepat.
                            </p>
                            <a href="barang_masuk.php" class="btn bg-gradient-success mb-2">
                                <i class="fas fa-sign-in-alt"></i>&nbsp;&nbsp;Catat Barang Masuk
                            </a>
                            <a href="barang_keluar.php" class="btn bg-gradient-warning mb-2">
                                <i class="fas fa-sign-out-alt"></i>&nbsp;&nbsp;Catat Barang Keluar
                            </a>
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