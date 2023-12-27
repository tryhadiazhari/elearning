@extends('template')
@section('css')
<link rel="stylesheet" href="/assets/plugins/datatables/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="/assets/plugins/toastr/toastr.min.css">
<link rel="stylesheet" href="/assets/plugins/sweetalert2/sweetalert2.min.css">
<link rel="stylesheet" href="/assets/plugins/filepond/filepond.css">
<link rel="stylesheet" href="/assets/plugins/summernote/summernote-bs4.min.css">
@stop

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <button class="btn btn-primary btn-add">
                    <span class="d-none d-lg-block">Tambah Bahan Ajar</span>
                    <!-- <span class="d-none d-lg-block" data-bs-toggle="modal" data-bs-target="#modalform">Tambah Bahan Ajar</span> -->
                    <span class="d-block d-lg-none"><i class="fas fa-plus mr-1"></i> Bahan Ajar</span>
                </button>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="my-0">{{ $title }}</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-hover table-bordered table-md table-responsive-{{ (count($data) == 0) ? 'sm' : 'lg' }} nowrap" style="width: 100%">
                            <thead class="thead-dark">
                                <tr>
                                    <th class="text-center short" width="1">#</th>
                                    <th class="text-center">Judul / Deskripsi Materi</th>
                                    <th class="text-center noshort" width="1">Mapel</th>
                                    <th class="text-center noshort" width="1">Kelas</th>
                                    <th class="text-center noshort" width="1">File</th>
                                    <th class="text-center noshort" width="1">Tanggal Post</th>
                                    @if(count($data) > 0)
                                    <th class="text-center noshort" width="1">Aksi</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $no => $materi)
                                <tr>
                                    <td class="text-center">{{ $no+1 }}</td>
                                    <td>
                                        <p>
                                            <strong>{{ $materi['nama_materi'] }}</strong>
                                            <br />
                                            <small>{{ Illuminate\Support\Str::limit(strip_tags($materi['deskripsi']), 50, '...') }}</small>
                                        </p>
                                    </td>
                                    <td>{{ $materi['mapel'] }}</td>
                                    <td>{{ $materi['kelas'] }}</td>
                                    <td>{{ $materi['nama_file'] }}</td>
                                    <td>{{ $materi['created_date'] }}</td>
                                    <td class="text-center">
                                        <button class="btn btn-secondary btn-sm btn-edit" data-value="{{ $materi['materi_id'] }}">Edit</button>
                                        <button class="btn btn-danger btn-sm btn-delete" data-id="{{ $materi['materi_id'] }}" data-href="{{ $_SERVER['REQUEST_URI'] }}/{{ $materi['materi_id'] }}" onclick="javascript:void(0);">Hapus</button>
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
                <form action="#" class="modalform" autocomplete="off" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Mata Pelajaran</label>
                            <select class="form-control mapel" name="mapel">
                                <option disabled selected>Choose</option>
                                @foreach($datamapel as $mapel)
                                <option value="{{ $mapel['kd_mapel'].' - '. $mapel['kd_kelas'] }}">{{ $mapel['nama_mapel'] .' ('. ucwords(strtolower($mapel['nama_kelas'])) .')' }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback invalid-mapel"></div>
                        </div>
                        <div class="form-group">
                            <label>Judul Materi</label>
                            <input type="text" class="form-control judulmateri" name="judulmateri">
                            <div class="invalid-feedback invalid-judulmateri"></div>
                        </div>
                        <div class="form-group">
                            <label>Deskripsi</label>
                            <textarea class="form-control deskripsi" name="deskripsi" style="resize: none"></textarea>
                            <div class="invalid-feedback invalid-deskripsi"></div>
                        </div>
                        <div class="form-group fileupload">
                            <label>Upload File</label>
                            <input type="file" name="file" class="file">
                            <div class="invalid-feedback invalid-file"></div>
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
<script src="/assets/plugins/filepond/filepond.min.js"></script>
<script src="/assets/plugins/filepond/filepond-plugin-file-validate-type.js"></script>
<script src="/assets/plugins/summernote/summernote-bs4.min.js"></script>
@stop
@section('scriptjs')
<script>
    const inputElement = document.querySelector('input[type="file"]');
    FilePond.registerPlugin(FilePondPluginFileValidateType);

    // Create a FilePond instance
    const pond = FilePond.create(inputElement, {
        allowFileTypeValidation: true,
        acceptedFileTypes: ['application/pdf', 'video/mp4'],
    });

    FilePond.setOptions({
        server: {
            process: {
                url: '/upload',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            },
            revert: {
                url: '/delete',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            }
        },
    });

    $(document).ready(function() {
        $('.judulmateri').inputmask({
            placeholder: '',
            regex: '^[a-zA-Z0-9\\s]+$'
        });

        $('.table').DataTable({
            "aoColumnDefs": [{
                "bSortable": false,
                "aTargets": ["noshort"]
            }],
        });

        $('.deskripsi').summernote({
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'italic']],
                ['para', ['ul', 'ol']],
            ],
            height: 150, //set editable area's height
            disableResize: true, // Does not work
            disableResizeEditor: true // Does not work either
        });

        $('.btn-add').on('click', function() {
            $('#modalform').modal('show').find('.modal-title').text('Tambah {{ $title }}');
            $('.modal').find('.modalform').attr('method', 'post');
            $('.modal').find('.modalform').attr('action', '{{ $_SERVER["REQUEST_URI"] }}')
        });

        $('.btn-edit').on('click', function() {
            $('#modalform').modal('show').find('.modal-title').text('Edit {{ $title }}');
            $('.modal').find('.modalform').attr('action', '{{ $_SERVER["REQUEST_URI"] }}/' + $(this).data('value'))
            $('.modal').find('.modalform').attr('method', 'post')


            $.ajax({
                url: '{{ $_SERVER["REQUEST_URI"] }}/' + $(this).data('value') + '/edit',
                success: function(response) {
                    $.each(response, function(fi, va) {
                        $("." + fi).val(va);
                    });

                    $('.deskripsi').summernote('code', response.deskripsi);

                    $('<div class="form-group oldfile"><label>Old file</label><label class="col-12 row fst-italic text-decoration-underline text-info">' + response.filename + '</label></div>').insertBefore('.fileupload')
                }
            })
        });

        $('form').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: $(this).attr('action'),
                method: $(this).attr('method'),
                data: new FormData(this),
                processData: false,
                contentType: false,
                dataType: 'JSON',
                beforeSend: function() {
                    $('.form-control').removeClass('is-invalid');
                    $('.file').removeClass('is-invalid');
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
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        dataType: "JSON",
                        data: {
                            id: $(this).data("id")
                        },
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
                $('.oldfile').remove()
            })
        })
    });
</script>
@stop