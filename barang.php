<?php
require_once 'config/database.php';
require_once 'includes/functions.php';

cekLogin();

// Ambil data barang dengan kategori
try {
    $stmt = $pdo->query("
        SELECT b.*, k.nama_kategori 
        FROM barang b 
        LEFT JOIN kategori_barang k ON b.id_kategori = k.id_kategori 
        ORDER BY b.tanggal_dibuat DESC
    ");
    $barang = $stmt->fetchAll();
    
    // Ambil data kategori untuk dropdown
    $stmt = $pdo->query("SELECT * FROM kategori_barang ORDER BY nama_kategori ASC");
    $kategori = $stmt->fetchAll();
} catch (PDOException $e) {
    $barang = [];
    $kategori = [];
}
?>
<?php 
$pageTitle = 'Data Barang';
require_once 'includes/header.php'; 
?>

        <!-- Content -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3">Data Barang</h6>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="px-3 mb-3">
                                <button class="btn bg-gradient-primary" onclick="tambahBarang()">
                                    <i class="fas fa-plus"></i>&nbsp;&nbsp;Tambah Barang
                                </button>
                            </div>
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No.</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama Barang</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Kategori</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Harga</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Stok</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        <?php foreach ($barang as $row): ?>
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm"><?php echo $i; ?></h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0"><?php echo htmlspecialchars($row['nama_barang']); ?></p>
                                                <p class="text-xs text-secondary mb-0"><?php echo htmlspecialchars($row['deskripsi_barang']); ?></p>
                                            </td>
                                            <td>
                                                <span class="badge badge-sm bg-gradient-success"><?php echo htmlspecialchars($row['nama_kategori'] ?: 'Tidak ada'); ?></span>
                                            </td>
                                            <td>
                                                <span class="text-secondary text-xs font-weight-bold"><?php echo formatRupiah($row['harga_barang']); ?></span>
                                            </td>
                                            <td>
                                                <span class="text-secondary text-xs font-weight-bold"><?php echo $row['stok_barang']; ?></span>
                                            </td>
                                            <td class="align-middle">
                                                <button class="btn btn-sm bg-gradient-info me-1" onclick="editBarang(<?php echo $row['id_barang']; ?>)">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </button>
                                                <button class="btn btn-sm bg-gradient-danger" onclick="hapusBarang(<?php echo $row['id_barang']; ?>)">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <?php $i++; ?>
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

    <!-- Modal Barang -->
    <div class="modal fade" id="modalBarang" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <form id="formBarang">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalBarangTitle">Tambah Barang</h5>
                        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="barang_id" name="id_barang">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group input-group-outline mb-3">
                                    <label class="form-label">Nama Barang</label>
                                    <input type="text" id="nama_barang" name="nama_barang" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group input-group-outline mb-3">
                                    <select id="id_kategori" name="id_kategori" class="form-control" required>
                                        <option value="">Pilih Kategori</option>
                                        <?php foreach ($kategori as $kat): ?>
                                        <option value="<?php echo $kat['id_kategori']; ?>"><?php echo htmlspecialchars($kat['nama_kategori']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group input-group-outline mb-3">
                                    <label class="form-label">Harga Barang</label>
                                    <input type="number" id="harga_barang" name="harga_barang" class="form-control" step="0.01" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group input-group-outline mb-3">
                                    <label class="form-label">Stok Barang</label>
                                    <input type="number" id="stok_barang" name="stok_barang" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="input-group input-group-outline mb-3">
                            <label class="form-label">Deskripsi Barang</label>
                            <textarea id="deskripsi_barang" name="deskripsi_barang" class="form-control" rows="3"></textarea>
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
    <script src="assets/js/barang.js"></script>
</body>
</html>