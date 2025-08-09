// Variabel global
let isEdit = false;

$(document).ready(function() {
    // Handler untuk form submit
    $('#formKategori').on('submit', function(e) {
        e.preventDefault();
        simpanKategori();
    });
});

// Fungsi untuk tambah kategori
function tambahKategori() {
    isEdit = false;
    $('#modalKategoriTitle').text('Tambah Kategori');
    $('#kategori_id').val('');
    $('#nama_kategori').val('');
    $('#deskripsi_kategori').val('');
    
    // Reset form labels
    resetFormLabels();
    
    $('#modalKategori').modal('show');
}

// Fungsi untuk edit kategori
function editKategori(id) {
    isEdit = true;
    $('#modalKategoriTitle').text('Edit Kategori');
    
    $.ajax({
        url: 'ajax/get_kategori.php',
        type: 'GET',
        data: { id: id },
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                $('#kategori_id').val(response.data.id_kategori);
                $('#nama_kategori').val(response.data.nama_kategori);
                $('#deskripsi_kategori').val(response.data.deskripsi_kategori);
                
                // Set form labels as active
                setFormLabelsActive();
                
                $('#modalKategori').modal('show');
            } else {
                showAlert('danger', response.message);
            }
        },
        error: function() {
            showAlert('danger', 'Terjadi kesalahan sistem');
        }
    });
}

// Fungsi untuk simpan kategori
function simpanKategori() {
    const formData = $('#formKategori').serialize();
    const url = isEdit ? 'ajax/update_kategori.php' : 'ajax/simpan_kategori.php';
    
    $.ajax({
        url: url,
        type: 'POST',
        data: formData,
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                $('#modalKategori').modal('hide');
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

// Fungsi untuk hapus kategori
function hapusKategori(id) {
    if (confirm('Apakah Anda yakin ingin menghapus kategori ini?')) {
        $.ajax({
            url: 'ajax/hapus_kategori.php',
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
    $('#formKategori .input-group').removeClass('is-focused is-filled');
}

// Fungsi untuk set form labels active
function setFormLabelsActive() {
    $('#formKategori .input-group').addClass('is-focused is-filled');
}