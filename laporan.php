<?php
require_once 'config/database.php';
require_once 'includes/functions.php';

cekLogin();

$jenis_laporan = $_POST['jenis_laporan'] ?? '';
$tanggal_mulai = $_POST['tanggal_mulai'] ?? '';
$tanggal_selesai = $_POST['tanggal_selesai'] ?? '';

$results = [];
$report_title = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if ($jenis_laporan == 'stok_barang') {
            $report_title = 'Laporan Stok Barang';
            $stmt = $pdo->query("SELECT b.id_barang, b.nama_barang, k.nama_kategori, b.stok_barang, b.harga_barang FROM barang b LEFT JOIN kategori_barang k ON b.id_kategori = k.id_kategori ORDER BY b.nama_barang");
            $results = $stmt->fetchAll();
        } elseif (!empty($tanggal_mulai) && !empty($tanggal_selesai)) {
            $start_date = $tanggal_mulai . ' 00:00:00';
            $end_date = $tanggal_selesai . ' 23:59:59';

            if ($jenis_laporan == 'barang_masuk') {
                $report_title = "Laporan Barang Masuk ($tanggal_mulai s/d $tanggal_selesai)";
                $stmt = $pdo->prepare("
                    SELECT bm.tanggal_masuk, b.nama_barang, p.nama_pemasok, bm.jumlah
                    FROM barang_masuk bm
                    JOIN barang b ON bm.id_barang = b.id_barang
                    LEFT JOIN pemasok p ON bm.id_pemasok = p.id_pemasok
                    WHERE bm.tanggal_masuk BETWEEN ? AND ?
                    ORDER BY bm.tanggal_masuk ASC
                ");
                $stmt->execute([$start_date, $end_date]);
                $results = $stmt->fetchAll();
            } elseif ($jenis_laporan == 'barang_keluar') {
                $report_title = "Laporan Barang Keluar ($tanggal_mulai s/d $tanggal_selesai)";
                $stmt = $pdo->prepare("
                    SELECT bk.tanggal_keluar, b.nama_barang, bk.jumlah, bk.keterangan
                    FROM barang_keluar bk
                    JOIN barang b ON bk.id_barang = b.id_barang
                    WHERE bk.tanggal_keluar BETWEEN ? AND ?
                    ORDER BY bk.tanggal_keluar ASC
                ");
                $stmt->execute([$start_date, $end_date]);
                $results = $stmt->fetchAll();
            }
        }
    } catch (PDOException $e) {
        // Handle error
    }
}
?>
<?php 
$pageTitle = 'Laporan';
require_once 'includes/header.php'; 
?>

        <!-- Content -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4 no-print">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3">Filter Laporan</h6>
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="laporan.php">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="input-group input-group-outline my-3">
                                            <select name="jenis_laporan" class="form-control" required>
                                                <option value="">Pilih Jenis Laporan</option>
                                                <option value="stok_barang" <?php echo ($jenis_laporan == 'stok_barang') ? 'selected' : ''; ?>>Laporan Stok Barang</option>
                                                <option value="barang_masuk" <?php echo ($jenis_laporan == 'barang_masuk') ? 'selected' : ''; ?>>Laporan Barang Masuk</option>
                                                <option value="barang_keluar" <?php echo ($jenis_laporan == 'barang_keluar') ? 'selected' : ''; ?>>Laporan Barang Keluar</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="input-group input-group-outline my-3">
                                            <input type="date" name="tanggal_mulai" class="form-control" value="<?php echo $tanggal_mulai; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="input-group input-group-outline my-3">
                                            <input type="date" name="tanggal_selesai" class="form-control" value="<?php echo $tanggal_selesai; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-primary">Tampilkan</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <?php if (!empty($results)): ?>
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-success shadow-success border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3"><?php echo $report_title; ?></h6>
                                <button class="btn btn-light position-absolute top-0 end-0 mt-2 me-2 no-print" onclick="window.print()">Cetak</button>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <!-- Tampilkan tabel sesuai jenis laporan -->
                                    <?php if ($jenis_laporan == 'stok_barang'): ?>
                                    <thead><tr><th>No.</th><th>Nama Barang</th><th>Kategori</th><th>Stok</th><th>Harga</th></tr></thead>
                                    <tbody><?php $i = 1; foreach($results as $row): ?><tr>
                                        <td><p class="text-xs font-weight-bold mb-0 px-3"><?php echo $i; ?></p></td>
                                        <td><p class="text-xs font-weight-bold mb-0"><?php echo $row['nama_barang']; ?></p></td>
                                        <td><p class="text-xs font-weight-bold mb-0"><?php echo $row['nama_kategori']; ?></p></td>
                                        <td><p class="text-xs font-weight-bold mb-0"><?php echo $row['stok_barang']; ?></p></td>
                                        <td><p class="text-xs font-weight-bold mb-0"><?php echo formatRupiah($row['harga_barang']); ?></p></td>
                                    </tr><?php $i++; endforeach; ?></tbody>
                                    <?php elseif ($jenis_laporan == 'barang_masuk'): ?>
                                    <thead><tr><th>No.</th><th>Tanggal Masuk</th><th>Nama Barang</th><th>Pemasok</th><th>Jumlah</th></tr></thead>
                                    <tbody><?php $i = 1; foreach($results as $row): ?><tr>
                                        <td><p class="text-xs font-weight-bold mb-0 px-3"><?php echo $i; ?></p></td>
                                        <td><p class="text-xs font-weight-bold mb-0"><?php echo date('d/m/Y H:i', strtotime($row['tanggal_masuk'])); ?></p></td>
                                        <td><p class="text-xs font-weight-bold mb-0"><?php echo $row['nama_barang']; ?></p></td>
                                        <td><p class="text-xs font-weight-bold mb-0"><?php echo $row['nama_pemasok'] ?? '-'; ?></p></td>
                                        <td><p class="text-xs font-weight-bold mb-0"><?php echo $row['jumlah']; ?></p></td>
                                    </tr><?php $i++; endforeach; ?></tbody>
                                    <?php elseif ($jenis_laporan == 'barang_keluar'): ?>
                                    <thead><tr><th>No.</th><th>Tanggal Keluar</th><th>Nama Barang</th><th>Jumlah</th><th>Keterangan</th></tr></thead>
                                    <tbody><?php $i = 1; foreach($results as $row): ?><tr>
                                        <td><p class="text-xs font-weight-bold mb-0 px-3"><?php echo $i; ?></p></td>
                                        <td><p class="text-xs font-weight-bold mb-0"><?php echo date('d/m/Y H:i', strtotime($row['tanggal_keluar'])); ?></p></td>
                                        <td><p class="text-xs font-weight-bold mb-0"><?php echo $row['nama_barang']; ?></p></td>
                                        <td><p class="text-xs font-weight-bold mb-0"><?php echo $row['jumlah']; ?></p></td>
                                        <td><p class="text-xs font-weight-bold mb-0"><?php echo $row['keterangan']; ?></p></td>
                                    </tr><?php $i++; endforeach; ?></tbody>
                                    <?php endif; ?>
                                </table>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>

    <!-- Core JS Files -->
    <script src="material-dashboard-master/assets/js/core/popper.min.js"></script>
    <script src="material-dashboard-master/assets/js/core/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="material-dashboard-master/assets/js/material-dashboard.min.js?v=3.0.0"></script>
</body>
</html>
