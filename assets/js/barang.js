// Variabel global
let isEdit = false;

$(document).ready(function() {
    // Handler untuk form submit
    $('#formBarang').on('submit', function(e) {
        e.preventDefault();
        simpanBarang();
    });
});

// Fungsi untuk tambah barang
function tambahBarang() {
    isEdit = false;
    $('#modalBarangTitle').text('Tambah Barang');
    $('#barang_id').val('');
    $('#nama_barang').val('');
    $('#id_kategori').val('');
    $('#harga_barang').val('');
    $('#stok_barang').val('');
    $('#deskripsi_barang').val('');
    
    // Reset form labels
    resetFormLabels();
    
    $('#modalBarang').modal('show');
}

// Fungsi untuk edit barang
function editBarang(id) {
    isEdit = true;
    $('#modalBarangTitle').text('Edit Barang');
    
    $.ajax({
        url: 'ajax/get_barang.php',
        type: 'GET',
        data: { id: id },
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                $('#barang_id').val(response.data.id_barang);
                $('#nama_barang').val(response.data.nama_barang);
                $('#id_kategori').val(response.data.id_kategori);
                $('#harga_barang').val(response.data.harga_barang);
                $('#stok_barang').val(response.data.stok_barang);
                $('#deskripsi_barang').val(response.data.deskripsi_barang);
                
                // Set form labels as active
                setFormLabelsActive();
                
                $('#modalBarang').modal('show');
            } else {
                showAlert('danger', response.message);
            }
        },
        error: function() {
            showAlert('danger', 'Terjadi kesalahan sistem');
        }
    });
}

// Fungsi untuk simpan barang
function simpanBarang() {
    const formData = $('#formBarang').serialize();
    const url = isEdit ? 'ajax/update_barang.php' : 'ajax/simpan_barang.php';
    
    $.ajax({
        url: url,
        type: 'POST',
        data: formData,
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                $('#modalBarang').modal('hide');
                showAlert('success', response.message);
                
                // Reload halaman setelah 1 detik
                setTimeout(function() {
                    location.reload();
                }, 1000);
            } else {
                showAlert('danger', response.message);
            }
        },
        error: function() {
            showAlert('danger', 'Terjadi kesalahan sistem');
        }
    });
}

// Fungsi untuk hapus barang
function hapusBarang(id) {
    if (confirm('Apakah Anda yakin ingin menghapus barang ini?')) {
        $.ajax({
            url: 'ajax/hapus_barang.php',
            type: 'POST',
            data: { id: id },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    showAlert('success', response.message);
                    
                    // Reload halaman setelah 1 detik
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                } else {
                    showAlert('danger', response.message);
                }
            },
            error: function() {
                showAlert('danger', 'Terjadi kesalahan sistem');
            }
        });
    }
}

// Fungsi helper untuk show alert
function showAlert(type, message) {
    const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
    const alertHtml = `<div class="alert ${alertClass} alert-dismissible fade show" role="alert">
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>`;
    
    // Hapus alert sebelumnya
    $('.alert').remove();
    
    // Tambahkan alert baru
    $('.container-fluid').prepend(alertHtml);
    
    // Auto hide setelah 3 detik
    setTimeout(function() {
        $('.alert').fadeOut();
    }, 3000);
}

// Fungsi untuk reset form labels
function resetFormLabels() {
    $('#formBarang .input-group').removeClass('is-focused is-filled');
}

// Fungsi untuk set form labels active
function setFormLabelsActive() {
    $('#formBarang .input-group').addClass('is-filled');
}