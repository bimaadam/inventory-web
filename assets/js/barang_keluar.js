// assets/js/barang_keluar.js

function tambahBarangKeluar() {
    $('#formBarangKeluar')[0].reset();
    
    // Set default value for datetime-local to now
    var now = new Date();
    now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
    $('#tanggal_keluar').val(now.toISOString().slice(0,16));

    $('#modalBarangKeluar').modal('show');
    $('.input-group').removeClass('is-filled');
}

function hapusBarangKeluar(id_keluar, id_barang, jumlah) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Menghapus transaksi ini akan mengembalikan stok barang terkait. Aksi ini tidak dapat dibatalkan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: 'ajax/hapus_barang_keluar.php',
                type: 'POST',
                data: { 
                    id_keluar: id_keluar,
                    id_barang: id_barang,
                    jumlah: jumlah
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire(
                            'Dihapus!',
                            response.message,
                            'success'
                        ).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: response.message,
                        });
                    }
                }
            });
        }
    });
}


$(document).ready(function() {
    $('#formBarangKeluar').on('submit', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: 'ajax/simpan_barang_keluar.php',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    $('#modalBarangKeluar').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: response.message,
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: response.message,
                    });
                }
            }
        });
    });
});