<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/png" href="material-dashboard-master/assets/img/favicon.png">
    <title>Login - Zoya Cookies</title>
    <!-- Fonts -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <!-- CSS Files -->
    <link href="material-dashboard-master/assets/css/material-dashboard.css?v=3.0.0" rel="stylesheet" />
</head>

<body class="bg-gray-200">
    <main class="main-content mt-0">
        <div class="page-header align-items-start min-vh-100" style="background-image: url('https://images.unsplash.com/photo-1497294815431-9365093b7331?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1950&q=80');">
            <span class="mask bg-gradient-dark opacity-6"></span>
            <div class="container my-auto">
                <div class="row">
                    <div class="col-lg-4 col-md-8 col-12 mx-auto">
                        <div class="card z-index-0 fadeIn3 fadeInBottom">
                            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                                <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
                                    <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">Login</h4>
                                    <div class="row mt-3">
                                        <div class="col-12 text-center">
                                            <h6 class="text-white mb-0">Sistem Persediaan Zoya Cookies</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <form id="loginForm" method="POST">
                                    <div class="input-group input-group-outline mb-3">
                                        <label class="form-label">Username</label>
                                        <input type="text" name="username" class="form-control" required>
                                    </div>
                                    <div class="input-group input-group-outline mb-3">
                                        <label class="form-label">Password</label>
                                        <input type="password" name="password" class="form-control" required>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn bg-gradient-primary w-100 my-4 mb-2">Masuk</button>
                                    </div>
                                </form>
                                <div id="loginMessage" class="mt-2"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Core JS Files -->
    <script src="material-dashboard-master/assets/js/core/popper.min.js"></script>
    <script src="material-dashboard-master/assets/js/core/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script>
    $(document).ready(function() {
        $('#loginForm').on('submit', function(e) {
            e.preventDefault();
            
            $.ajax({
                url: 'ajax/login_process.php',
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        $('#loginMessage').html('<div class="alert alert-success">' + response.message + '</div>');
                        setTimeout(function() {
                            window.location.href = 'dashboard.php';
                        }, 1000);
                    } else {
                        $('#loginMessage').html('<div class="alert alert-danger">' + response.message + '</div>');
                    }
                },
                error: function() {
                    $('#loginMessage').html('<div class="alert alert-danger">Terjadi kesalahan sistem.</div>');
                }
            });
        });
    });
    </script>
    <script>
    // Script to handle floating labels for Material Dashboard
    $(document).ready(function() {
        function checkAndFill() {
            $('.input-group.input-group-outline input').each(function() {
                if ($(this).val().trim() !== '') {
                    $(this).parent().addClass('is-filled');
                } else {
                    $(this).parent().removeClass('is-filled');
                }
            });
        }

        // Check on page load (with a slight delay for autofill)
        setTimeout(checkAndFill, 100); // Give browser time to autofill

        // Check on focus, keyup, and blur
        $('.input-group.input-group-outline input').on('focus keyup blur', function() {
            checkAndFill();
        });

        // Also check when the form is submitted (in case of validation errors)
        $('#loginForm').on('submit', function() {
            checkAndFill();
        });
    });
    </script>
</body>
</html>