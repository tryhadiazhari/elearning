@extends('template')
@section('css')
<link rel="stylesheet" href="/assets/plugins/datatables/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="/assets/plugins/toastr/toastr.min.css">
<link rel="stylesheet" href="/assets/plugins/sweetalert2/sweetalert2.min.css">
@stop

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <button class="btn btn-primary btn-add">
                    <span class="d-none d-lg-block">Tambah Siswa</span>
                    <span class="d-block d-lg-none"><i class="fas fa-plus mr-1"></i> Siswa</span>
                </button>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="my-0">{{ $title }}</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-hover table-bordered table-md {{ (count($data) == 0) ? 'table-responsive-sm' : 'table-responsive' }} nowrap" style="width: 100%">
                            <thead class="thead-dark">
                                <tr>
                                    <th class="text-center short">#</th>
                                    <th class="text-center">Nama Siswa</th>
                                    <th class="text-center noshort" width="1">NISN</th>
                                    <th class="text-center noshort" width="1">NIS</th>
                                    <th class="text-center noshort" width="1">Jenis Kelamin</th>
                                    <th class="text-center noshort">Alamat</th>
                                    <th class="text-center noshort" width="1">Telp</th>
                                    <th class="text-center noshort">Email</th>
                                    <th class="text-center noshort" width="1">Kelas</th>
                                    @if(count($data) > 0)
                                    <th class="text-center noshort" width="1">Aksi</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $no => $siswa)
                                <tr>
                                    <td class="text-center">{{ $no+1 }}</td>
                                    <td>{{ $siswa['nama'] }}</td>
                                    <td>{{ $siswa['nisn'] }}</td>
                                    <td>{{ $siswa['nis'] }}</td>
                                    <td>{{ $siswa['jk'] }}</td>
                                    <td>{{ $siswa['alamat'] }}</td>
                                    <td>{{ $siswa['telp'] }}</td>
                                    <td>{{ $siswa['email'] }}</td>
                                    <td>{{ ucwords(strtolower($siswa['nama_kelas'])) }}</td>
                                    <td class="text-center">
                                        <button class="btn btn-secondary btn-sm btn-edit" data-value="{{ $siswa['siswa_id'] }}">Edit</button>
                                        <button class="btn btn-danger btn-sm btn-delete" data-id="{{ $siswa['siswa_id'] }}" data-href="{{ $_SERVER['REQUEST_URI'] }}/{{ $siswa['siswa_id'] }}" onclick="javascript:void(0);">Hapus</button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalform" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalformLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalformLabel">Tambah {{ $title }}</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="#" class="modalform" autocomplete="off">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" class="form-control nama" id="nama" name="nama" autofocus>
                            <div class="invalid-feedback invalid-nama"></div>
                        </div>
                        <div class="form-group">
                            <label>NISN</label>
                            <input type="text" class="form-control nisn" id="nisn" name="nisn" maxlength="10">
                            <div class="invalid-feedback invalid-nisn"></div>
                        </div>
                        <div class="form-group">
                            <label>NIS</label>
                            <input type="text" class="form-control nis" id="nis" name="nis">
                            <div class="invalid-feedback invalid-nis"></div>
                        </div>
                        <div class="form-group">
                            <label>Jenis Kelamin</label>
                            <select class="form-control jk" id="jk" name="jk">
                                <option selected disabled>Choose</option>
                                <option value="Laki-Laki">Laki-Laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                            <div class="invalid-feedback invalid-jk"></div>
                        </div>
                        <div class="form-group">
                            <label>Alamat</label>
                            <input type="text" class="form-control alamat" id="alamat" name="alamat">
                            <div class="invalid-feedback invalid-alamat"></div>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" class="form-control email" id="email" name="email">
                            <div class="invalid-feedback invalid-email"></div>
                        </div>
                        <div class="form-group">
                            <label>Telepon</label>
                            <input type="text" class="form-control telp" id="telp" name="telp" maxlength="13">
                            <div class="invalid-feedback invalid-telp"></div>
                        </div>
                        <div class="form-group">
                            <label>Kelas</label>
                            <select class="form-control kelas" name="kelas">
                                <option disabled selected>Choose</option>
                                @foreach($datakelas as $kelas)
                                <option value="{{ $kelas['kelas_id'] }}">{{ $kelas['nama_kelas'] }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback invalid-kelas"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
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
    $('.nama').inputmask({
        placeholder: '',
        regex: '^[a-zA-Z\\s]+$'
    });

    $('.nis, .nisn').inputmask({
        placeholder: '',
        regex: '^[0-9\\-]+$'
    });

    $('.alamat').inputmask({
        placeholder: '',
        regex: '^[a-zA-Z0-9\\s\\.\\/\\-]+$'
    });

    $('.telp').inputmask({
        placeholder: '',
        regex: '\\d*'
    });

    $('.username').inputmask({
        placeholder: '',
        regex: '^[a-zA-Z0-9]+$'
    });

    $('.password').inputmask({
        placeholder: '',
        regex: '^[a-zA-Z0-9\\!,./@#$%&*+/?]+$'
    });

    $(".email").inputmask({
        placeholder: '',
        mask: "*{1,20}[.*{1,20}][.*{1,20}][.*{1,20}][@]*{1,20}[.*{2,6}][.*{1,2}]",
        greedy: false,
        onBeforePaste: function(pastedValue, opts) {
            pastedValue = pastedValue.toLowerCase();
            return pastedValue.replace("mailto:", "");
        },
        definitions: {
            '*': {
                validator: "[0-9A-Za-z]",
                casing: "lower"
            }
        }
    });

    $(document).ready(function() {
        $('.table').DataTable({
            "aoColumnDefs": [{
                "bSortable": false,
                "aTargets": ["noshort"]
            }],
        });

        $('.btn-add').on('click', function() {
            $('.modal').modal('show').find('.modal-title').text('Tambah {{ $title }}');
            $('.modal').find('.modalform').attr('method', 'post');
            $('.modal').find('.modalform').attr('action', '/siswa')
        });

        $('.btn-edit').on('click', function() {
            $('.modal').modal('show').find('.modal-title').text('Edit {{ $title }}');
            $('.modal').find('.modalform').attr('action', '/siswa/' + $(this).data('value'))
            $('.modal').find('.modalform').attr('method', 'put')

            $.ajax({
                url: '/siswa/' + $(this).data('value') + '/edit',
                success: function(response) {
                    $.each(response, function(fi, va) {
                        $("." + fi).val(va);
                    });
                }
            })
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
                        toastr.error(error.responseJSON.error);
                    }
                },
                success: function(response) {
                    $("#modalform").modal('hide').on('hidden.bs.modal', function() {
                        $(this).find('form').trigger('reset');
                    });

                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: response.success,
                        showConfirmButton: false,
                        timer: 1500
                    });

                    setTimeout(function() {
                        location.reload()
                    }, 1500);
                }
            });
        });

        $('.btn-delete').on('click', function() {
            Swal.fire({
                title: 'Apa Anda yakin?',
                text: "Anda tidak dapat mengembalikan data ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: $(this).data('href'),
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'DELETE',
                        dataType: "JSON",
                        error: function(xhr) {
                            toastr.error(xhr.responseJSON);
                        },
                        success: function(response) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: response.success,
                                showConfirmButton: false,
                                timer: 1500
                            })

                            setTimeout(function() {
                                location.reload()
                            }, 1500)
                        },
                    })
                }
            })
        });

        $('.close').click(function() {
            $('#modalform').on('hidden.bs.modal', function() {
                $(this).find('form').trigger('reset');
            })
        })
    });
</script>
@stop