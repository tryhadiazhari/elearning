<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ELearning SMP Kreatif | {{ $title }}</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="/assets/plugins/fontawesome/css/all.css">
    <link rel="stylesheet" href="/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="/assets/plugins/toastr/toastr.min.css">
    <link rel="stylesheet" href="/assets/plugins/fontawesome/css/all.css">
    <link rel="stylesheet" href="{{ asset('/assets/dist/css/adminlte.min.css') }}">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="card rounded">
            <div class="card-header">
                <label class="card-title col-12 text-center">Sign in to start your session</label>
            </div>
            <form action="/auth" method="post" autocomplete="off">
                <div class="card-body login-card-body  rounded">
                    @csrf
                    <div class="input-group mb-4">
                        <input type="text" class="form-control username" name="username" placeholder="Username" autofocus>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                        <div class="invalid-feedback invalid-username"></div>
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
                    <p class="mb-0 pb-0">
                        <label class="mb-0">Belum punya akun? Registrasi </label> <a href="/auth/registration">disini</a>
                    </p>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary btn-block">Login</button>
                </div>
            </form>
        </div>
    </div>

    <script src="/assets/plugins/jquery/jquery.min.js"></script>
    <script src="/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/plugins/toastr/toastr.min.js"></script>
    <script src="/assets/dist/js/adminlte.min.js"></script>
    <script>
        $(document).ready(function() {
            $('form').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    url: $(this).attr('action'),
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
                        }
                    },
                    success: function(response) {
                        toastr.success(response.success);

                        setTimeout(function() {
                            window.location = '/';
                        })
                    }
                })
            })
        })
    </script>
</body>

</html>