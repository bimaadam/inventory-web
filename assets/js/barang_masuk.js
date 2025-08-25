// assets/js/barang_masuk.js

function tambahBarangMasuk() {
    $('#formBarangMasuk')[0].reset();
    
    // Set default value for datetime-local to now
    var now = new Date();
    now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
    $('#tanggal_masuk').val(now.toISOString().slice(0,16));

    $('#modalBarangMasuk').modal('show');
    $('.input-group').removeClass('is-filled');
}

function hapusBarangMasuk(id_masuk, id_barang, jumlah) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Menghapus transaksi ini akan mengurangi stok barang terkait. Aksi ini tidak dapat dibatalkan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: 'ajax/hapus_barang_masuk.php',
                type: 'POST',
                data: { 
                    id_masuk: id_masuk,
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
    $('#formBarangMasuk').on('submit', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: 'ajax/simpan_barang_masuk.php',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    $('#modalBarangMasuk').modal('hide');
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