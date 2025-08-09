<?php
require_once 'config/database.php';
require_once 'includes/functions.php';

cekLogin();

// Ambil data kategori
try {
    $stmt = $pdo->query("SELECT * FROM kategori_barang ORDER BY tanggal_dibuat DESC");
    $kategori = $stmt->fetchAll();
} catch (PDOException $e) {
    $kategori = [];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/png" href="material-dashboard-master/assets/img/favicon.png">
    <title>Kategori Barang - Zoya Cookies</title>
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
                    <a class="nav-link text-white" href="dashboard.php">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">dashboard</i>
                        </div>
                        <span class="nav-link-text ms-1">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white active bg-gradient-primary" href="kategori.php">
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
                        <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Kategori Barang</li>
                    </ol>
                    <h6 class="font-weight-bolder mb-0">Kategori Barang</h6>
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
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3">Kategori Barang</h6>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="px-3 mb-3">
                                <button class="btn bg-gradient-primary" onclick="tambahKategori()">
                                    <i class="material-icons text-sm">add</i>&nbsp;&nbsp;Tambah Kategori
                                </button>
                            </div>
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama Kategori</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Deskripsi</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tanggal Dibuat</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($kategori as $row): ?>
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm"><?php echo $row['id_kategori']; ?></h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0"><?php echo htmlspecialchars($row['nama_kategori']); ?></p>
                                            </td>
                                            <td>
                                                <p class="text-xs text-secondary mb-0"><?php echo htmlspecialchars($row['deskripsi_kategori']); ?></p>
                                            </td>
                                            <td>
                                                <span class="text-secondary text-xs font-weight-bold"><?php echo date('d/m/Y H:i', strtotime($row['tanggal_dibuat'])); ?></span>
                                            </td>
                                            <td class="align-middle">
                                                <button class="btn btn-sm bg-gradient-info me-1" onclick="editKategori(<?php echo $row['id_kategori']; ?>)">
                                                    <i class="material-icons text-sm">edit</i>
                                                </button>
                                                <button class="btn btn-sm bg-gradient-danger" onclick="hapusKategori(<?php echo $row['id_kategori']; ?>)">
                                                    <i class="material-icons text-sm">delete</i>
                                                </button>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
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

    <!-- Modal Kategori -->
    <div class="modal fade" id="modalKategori" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form id="formKategori">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalKategoriTitle">Tambah Kategori</h5>
                        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="kategori_id" name="id_kategori">
                        <div class="input-group input-group-outline mb-3">
                            <label class="form-label">Nama Kategori</label>
                            <input type="text" id="nama_kategori" name="nama_kategori" class="form-control" required>
                        </div>
                        <div class="input-group input-group-outline mb-3">
                            <label class="form-label">Deskripsi Kategori</label>
                            <textarea id="deskripsi_kategori" name="deskripsi_kategori" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn bg-gradient-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Core JS Files -->
    <script src="material-dashboard-master/assets/js/core/popper.min.js"></script>
    <script src="material-dashboard-master/assets/js/core/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="material-dashboard-master/assets/js/material-dashboard.min.js?v=3.0.0"></script>
    <script src="assets/js/kategori.js"></script>
</body>
</html>