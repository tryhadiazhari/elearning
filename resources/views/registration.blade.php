<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ELearning SMP Kreatif | {{ $title }}</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="/assets/plugins/fontawesome/css/all.css">
    <link rel="stylesheet" href="/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="/assets/plugins/toastr/toastr.min.css">
    <link rel="stylesheet" href="/assets/plugins/fontawesome/css/all.css">
    <link rel="stylesheet" href="/assets/plugins/sweetalert2/sweetalert2.min.css">
    <link rel="stylesheet" href="{{ asset('/assets/dist/css/adminlte.min.css') }}">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="card rounded">
            <div class="card-header">
                <label class="card-title col-12 text-center">Account Registration</label>
            </div>
            <form action="/cek/field" method="post" autocomplete="off">
                @csrf
                <div class="card-body login-card-body  rounded">
                    <div class="input-group mb-4">
                        <input type="text" class="form-control fielddata" name="fielddata" placeholder="Cari berdasarkan NUPTK / NISN Anda" autofocus>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-barcode"></span>
                            </div>
                        </div>
                        <div class="invalid-feedback invalid-fielddata"></div>
                    </div>
                    <div class="input-group mb-4">
                        <input type="password" class="form-control password" name="password" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        <div class="invalid-feedback invalid-password"></div>
                    </div>
                    <div class="input-group mb-4">
                        <input type="password" class="form-control password_confirmation" name="password_confirmation" placeholder="Ulangi Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        <div class="invalid-feedback invalid-password_confirmation"></div>
                    </div>
                    <p class="mb-0 pb-0">
                        <label class="mb-0">Sudah punya akun? Login</label> <a href="/auth">disini</a>
                    </p>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary btn-block">Daftar</button>
                </div>
            </form>
        </div>
    </div>

    <script src="/assets/plugins/jquery/jquery.min.js"></script>
    <script src="/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/plugins/toastr/toastr.min.js"></script>
    <script src="/assets/dist/js/adminlte.min.js"></script>
    <script src="/assets/plugins/inputmask/jquery.inputmask.min.js"></script>
    <script src="/assets/plugins/sweetalert2/sweetalert2.min.js"></script>
    <script>
        $('.fielddata').inputmask({
            placeholder: '',
            regex: '^[0-9]+$'
        });

        $('.password, .password_confirmation').inputmask({
            placeholder: '',
            regex: '^[a-zA-Z0-9\\s]+$'
        });

        $(document).ready(function() {
            $('form').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    url: $(this).attr('action'),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: $(this).attr('method'),
                    data: $(this).serialize(),
                    beforeSend: function() {
                        $('.form-control').removeClass('is-invalid');
                        $('.invalid-feedback').html('');
                    },
                    statusCode: {
                        404: function(error) {
                            $.each(error.responseJSON, function(a, b) {
                                $('.' + a).addClass('is-invalid');
                                $('.invalid-' + a).html(b);
                            })
                        },
                        400: function(error) {
                            toastr.error(error.responseJSON.error);
                            $('form').trigger('reset');
                        }
                    },
                    success: function(response) {
                        Swal.fire({
                            title: 'Konfirmasi Data!',
                            html: "<table class='table text-left text-md table-sm table-reponsive-md nowrap'>" +
                                "<tr>" +
                                "<td>Nama</td>" +
                                "<td width='1'>:</td>" +
                                "<td>" + response.data.nama + "</td>" +
                                "</tr>" +
                                "<tr>" +
                                "<td>Jenis Kelamin</td>" +
                                "<td width='1'>:</td>" +
                                "<td>" + response.data.jk + "</td>" +
                                "</tr>" +
                                "<tr>" +
                                "<td>Username</td>" +
                                "<td width='1'>:</td>" +
                                "<td>" + response.username + "</td>" +
                                "</tr>" +
                                "<tr>" +
                                "<td>Password</td>" +
                                "<td width='1'>:</td>" +
                                "<td>" + response.password + "</td>" +
                                "</tr>" +
                                "<tr>" +
                                "<td>Status</td>" +
                                "<td width='1'>:</td>" +
                                "<td>" + response.status + "</td>" +
                                "</tr>" +
                                "</table>" +
                                "<p class='text-md text-justify'>Data di atas adalah data login Anda. <br>Jika data sudah sesuai, silahkan klik tombol <strong>Ya</strong> untuk melanjutkan...</p>",
                            icon: 'success',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Ya',
                            cancelButtonText: 'Tidak'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    url: '/auth/registration/save',
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    method: 'POST',
                                    data: {
                                        id: response.id,
                                        username: response.username,
                                        password: response.password,
                                        status: response.status,
                                    },
                                    error: function(error) {
                                        toastr.error(error.responseJSON.error);
                                    },
                                    success: function(response) {
                                        toastr.success(response);

                                        setTimeout(function() {
                                            window.location = '/auth';
                                        }, 1500)
                                    }
                                })
                            }
                        })
                    }
                })
            })
        })
    </script>
</body>

</html>