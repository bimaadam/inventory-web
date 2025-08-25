<?php
require_once 'config/database.php';
require_once 'includes/functions.php';

cekLogin();

// Ambil data pemasok
try {
    $stmt = $pdo->query("SELECT * FROM pemasok ORDER BY created_at DESC");
    $pemasok = $stmt->fetchAll();
} catch (PDOException $e) {
    $pemasok = [];
}
?>
<?php 
$pageTitle = 'Data Pemasok';
require_once 'includes/header.php'; 
?>

        <!-- Content -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3">Data Pemasok</h6>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="px-3 mb-3">
                                <button class="btn bg-gradient-primary" onclick="tambahPemasok()">
                                    <i class="fas fa-plus"></i>&nbsp;&nbsp;Tambah Pemasok
                                </button>
                            </div>
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No.</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama Pemasok</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Alamat</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Telepon</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        <?php foreach ($pemasok as $row): ?>
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm"><?php echo $i; ?></h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0"><?php echo htmlspecialchars($row['nama_pemasok']); ?></p>
                                            </td>
                                            <td>
                                                <p class="text-xs text-secondary mb-0"><?php echo htmlspecialchars($row['alamat']); ?></p>
                                            </td>
                                            <td>
                                                <span class="text-secondary text-xs font-weight-bold"><?php echo htmlspecialchars($row['telepon']); ?></span>
                                            </td>
                                            <td class="align-middle">
                                                <button class="btn btn-sm bg-gradient-info me-1" onclick="editPemasok(<?php echo $row['id_pemasok']; ?>)">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </button>
                                                <button class="btn btn-sm bg-gradient-danger" onclick="hapusPemasok(<?php echo $row['id_pemasok']; ?>)">
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

    <!-- Modal Pemasok -->
    <div class="modal fade" id="modalPemasok" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form id="formPemasok">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalPemasokTitle">Tambah Pemasok</h5>
                        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="pemasok_id" name="id_pemasok">
                        <div class="input-group input-group-outline mb-3">
                            <label class="form-label">Nama Pemasok</label>
                            <input type="text" id="nama_pemasok" name="nama_pemasok" class="form-control" required>
                        </div>
                        <div class="input-group input-group-outline mb-3">
                            <label class="form-label">Alamat</label>
                            <textarea id="alamat" name="alamat" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="input-group input-group-outline mb-3">
                            <label class="form-label">Telepon</label>
                            <input type="text" id="telepon" name="telepon" class="form-control">
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="material-dashboard-master/assets/js/material-dashboard.min.js?v=3.0.0"></script>
    <script src="assets/js/pemasok.js"></script>
</body>
</html>
