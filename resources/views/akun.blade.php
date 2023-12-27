@extends('template')
@section('css')
<link rel="stylesheet" href="/assets/plugins/datatables/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="/assets/plugins/toastr/toastr.min.css">
<link rel="stylesheet" href="/assets/plugins/sweetalert2/sweetalert2.min.css">
@stop

@section('content')
<section class="content">
    <div class="container-fluid pt-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="my-0">{{ $title }}</h4>
                    </div>
                    <form action="/akun/{{ $user['uname'] }}" method="PUT">
                        @csrf
                        <div class="card-body pb-2">
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" class="form-control username" name="username" value="{{ $user['uname'] }}" readonly>
                            </div>
                            <div class="form-group" id="oldpassword">
                                <label>Password Lama</label>
                                <div class="input-group">
                                    <input type="password" class="form-control old_password" name="old_password" id="old_password">
                                    <span class="input-group-text" id="showpassword"><i class="fa fa-eye fa-fw"></i></span>
                                    <div class="invalid-feedback invalid-old_password"></div>
                                </div>
                            </div>
                            <div class="form-group" id="newpassword">
                                <label>Password Baru</label>
                                <div class="input-group">
                                    <input type="password" class="form-control new_password" name="new_password" id="new_password">
                                    <span class="input-group-text" id="showpassword"><i class="fa fa-eye"></i></span>
                                    <div class="invalid-feedback invalid-new_password"></div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Ganti Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@stop

@section('js')
<script src="/assets/plugins/datatables/js/jquery.dataTables.min.js"></script>
<script src="/assets/plugins/datatables/js/dataTables.bootstrap4.min.js"></script>
<script src="/assets/plugins/inputmask/jquery.inputmask.min.js"></script>
<script src="/assets/plugins/toastr/toastr.min.js"></script>
<script src="/assets/plugins/sweetalert2/sweetalert2.min.js"></script>
@stop
@section('scriptjs')
<script>
    $('.old_password, .new_password').inputmask({
        placeholder: '',
        regex: '^[a-zA-Z0-9]+$'
    });

    $(document).ready(function() {
        $('.table').DataTable({
            "aoColumnDefs": [{
                "bSortable": false,
                "aTargets": ["noshort"]
            }],
        });

        $('#oldpassword').find('#showpassword').click(function() {
            if ($(this).find('i').hasClass('fa-eye')) {
                $(this).find('i').removeClass('fa-eye').addClass('fa-eye-slash');
                $('.old_password').attr('type', 'text');
            } else {
                $(this).find('i').removeClass('fa-eye-slash').addClass('fa-eye')
                $('.old_password').attr('type', 'password');
            }
        });

        $('#newpassword').find('#showpassword').click(function() {
            if ($(this).find('i').hasClass('fa-eye')) {
                $(this).find('i').removeClass('fa-eye').addClass('fa-eye-slash');
                $('.new_password').attr('type', 'text');
            } else {
                $(this).find('i').removeClass('fa-eye-slash').addClass('fa-eye')
                $('.new_password').attr('type', 'password');
            }
        });

        $('form').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                url: $(this).attr('action'),
                method: $(this).attr('method'),
                data: $(this).serialize(),
                beforeSend: function() {
                    $('.form-control').removeClass('is-invalid');
                },
                statusCode: {
                    404: function(error) {
                        $.each(error.responseJSON, function(a, b) {
                            $('.' + a).addClass('is-invalid');
                            $('.invalid-' + a).html('<strong>' + b + '</strong>');
                        })
                    },
                    400: function(error) {
                        toastr.error(error.responseJSON);
                    }
                },
                success: function(response) {
                    $("#modalform").modal('hide').on('hidden.bs.modal', function() {
                        $(this).find('form').trigger('reset');
                    });

                    toastr.success(response);

                    setTimeout(function() {
                        location.reload()
                    }, 1500);
                }
            });
        });

        $('.close').click(function() {
            $('#modalform').on('hidden.bs.modal', function() {
                $(this).find('form').trigger('reset');
            })
        })
    });
</script>
@stop