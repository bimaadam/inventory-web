// assets/js/pemasok.js

function tambahPemasok() {
    $('#formPemasok')[0].reset();
    $('#pemasok_id').val('');
    $('#modalPemasokTitle').text('Tambah Pemasok');
    $('#modalPemasok').modal('show');
    $('.input-group').removeClass('is-filled');
}

function editPemasok(id) {
    $.ajax({
        url: 'ajax/get_pemasok.php?id=' + id,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                var data = response.data;
                $('#pemasok_id').val(data.id_pemasok);
                $('#nama_pemasok').val(data.nama_pemasok);
                $('#alamat').val(data.alamat);
                $('#telepon').val(data.telepon);
                
                $('#modalPemasokTitle').text('Edit Pemasok');
                $('.input-group').addClass('is-filled'); // For Material Dashboard
                $('#modalPemasok').modal('show');
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

function hapusPemasok(id) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Data yang dihapus tidak dapat dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: 'ajax/hapus_pemasok.php',
                type: 'POST',
                data: { id_pemasok: id },
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
    $('#formPemasok').on('submit', function(e) {
        e.preventDefault();
        var id = $('#pemasok_id').val();
        var url = id ? 'ajax/update_pemasok.php' : 'ajax/simpan_pemasok.php';
        
        $.ajax({
            url: url,
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    $('#modalPemasok').modal('hide');
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
