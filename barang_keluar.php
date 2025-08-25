<?php
require_once 'config/database.php';
require_once 'includes/functions.php';

cekLogin();

// Ambil data transaksi barang keluar
try {
    $stmt = $pdo->query("
        SELECT bk.id_keluar, bk.tanggal_keluar, bk.jumlah, bk.keterangan,
               b.nama_barang, b.id_barang
        FROM barang_keluar bk
        JOIN barang b ON bk.id_barang = b.id_barang
        ORDER BY bk.tanggal_keluar DESC
    ");
    $barang_keluar = $stmt->fetchAll();

    // Ambil data barang untuk dropdown
    $stmt_barang = $pdo->query("SELECT id_barang, nama_barang, stok_barang FROM barang ORDER BY nama_barang");
    $barang_list = $stmt_barang->fetchAll();

} catch (PDOException $e) {
    $barang_keluar = [];
    $barang_list = [];
}
?>
<?php 
$pageTitle = 'Transaksi Barang Keluar';
require_once 'includes/header.php'; 
?>

        <!-- Content -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3">Transaksi Barang Keluar</h6>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="px-3 mb-3">
                                <button class="btn bg-gradient-primary" onclick="tambahBarangKeluar()">
                                    <i class="fas fa-plus"></i>&nbsp;&nbsp;Catat Barang Keluar
                                </button>
                            </div>
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No.</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tanggal</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama Barang</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Jumlah</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Keterangan</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        <?php foreach ($barang_keluar as $row): ?>
                                        <tr>
                                            <td><p class="text-xs font-weight-bold mb-0 px-3"><?php echo $i; ?></p></td>
                                            <td><p class="text-xs font-weight-bold mb-0"><?php echo date('d/m/Y H:i', strtotime($row['tanggal_keluar'])); ?></p></td>
                                            <td><p class="text-xs font-weight-bold mb-0"><?php echo htmlspecialchars($row['nama_barang']); ?></p></td>
                                            <td><p class="text-xs font-weight-bold mb-0"><?php echo htmlspecialchars($row['jumlah']); ?></p></td>
                                            <td><p class="text-xs font-weight-bold mb-0"><?php echo htmlspecialchars($row['keterangan']); ?></p></td>
                                            <td class="align-middle">
                                                <button class="btn btn-sm bg-gradient-danger" onclick="hapusBarangKeluar(<?php echo $row['id_keluar']; ?>, <?php echo $row['id_barang']; ?>, <?php echo $row['jumlah']; ?>)">
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
    </main>

    <!-- Modal Barang Keluar -->
    <div class="modal fade" id="modalBarangKeluar" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form id="formBarangKeluar">
                    <div class="modal-header">
                        <h5 class="modal-title">Catat Barang Keluar</h5>
                        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="input-group input-group-outline my-3">
                             <select id="id_barang" name="id_barang" class="form-control" required>
                                <option value="">Pilih Barang</option>
                                <?php foreach ($barang_list as $barang): ?>
                                <option value="<?php echo $barang['id_barang']; ?>">(Stok: <?php echo $barang['stok_barang']; ?>) <?php echo htmlspecialchars($barang['nama_barang']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="input-group input-group-outline mb-3">
                            <label class="form-label">Jumlah</label>
                            <input type="number" id="jumlah" name="jumlah" class="form-control" required>
                        </div>
                        <div class="input-group input-group-outline mb-3">
                            <label class="form-label">Keterangan</label>
                            <input type="text" id="keterangan" name="keterangan" class="form-control" required>
                        </div>
                        <div class="input-group input-group-outline mb-3">
                            <input type="datetime-local" id="tanggal_keluar" name="tanggal_keluar" class="form-control" required>
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
    <script src="assets/js/barang_keluar.js"></script>
</body>
</html>
