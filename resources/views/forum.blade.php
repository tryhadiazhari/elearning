@extends('template')
@section('css')
<link rel="stylesheet" href="/assets/plugins/toastr/toastr.min.css">
<link rel="stylesheet" href="/assets/plugins/daterangepicker/daterangepicker.css">
<link rel="stylesheet" href="/assets/plugins/summernote/summernote-bs4.min.css">
@stop

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header py-0">
                        <div class="row py-0">
                            <div class="col py-0 mt-1">
                                <h4 class="mt-2">{{ $title }}</h4>
                            </div>
                            <div class="col-auto my-2">
                                <button class="btn btn-primary btn-md create-discuss">Buat Diskusi</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if(count($dataforum) == 0)
                        Tidak ada data tersedia...
                        @else
                        <div class="col">
                            <div class="timeline mb-0">
                                @foreach($dataforum as $forum)
                                <div class="time-label">
                                    <span class="bg-red">{{ date('Y-m-d', strtotime($forum['created_at'])) }}</span>
                                </div>
                                <div class="col-12">
                                    <i class="fas fa-info bg-blue"></i>
                                    <div class="timeline-item mr-0">
                                        <div class="timeline-header">
                                            <a href="<?= $_SERVER['REQUEST_URI'] . '/' . $forum['id'] ?>">
                                                {{ (session('lvl') == 'Guru') ? $forum->nama . ' - ' . $forum->forum_judul . ' (' . $forum->forum_kd_mapel .' / '. $forum->nama_kelas .')' : $forum->forum_judul . ' - ' . $forum->forum_kd_mapel }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="creatediscuss" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="creatediscussLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="creatediscussLabel">Buat Diskusi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?= $_SERVER['REQUEST_URI'] ?>/simpan" class="creatediscuss" method="POST" autocomplete="off">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Judul <span class="text-red">*</span></label>
                            <input type="text" name="judul" class="judul form-control">
                            <div class="invalid-feedback invalid-judul"></div>
                        </div>
                        <div class="form-group">
                            <label>Kelas <span class="text-red">*</span></label>
                            <select name="kelas" class="form-control kelas">
                                <option disabled selected>Choose</option>
                                @foreach($datamapel as $mapel)
                                <option value="{{ $mapel['kd_mapel'] .' - '. $mapel['kelas_id'] }}">{{ $mapel['nama_mapel'] .' ('. ucwords(strtolower($mapel['nama_kelas'])) .')' }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback invalid-kelas"></div>
                        </div>
                        <div class="form-group">
                            <label>Isi Diskusi <span class="text-red">*</span></label>
                            <textarea name="isidiskusi" class="form-control isidiskusi" style="resize: none;"></textarea>
                            <div class="invalid-feedback invalid-isidiskusi"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Buat</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@stop

@section('js')
<script src="/assets/plugins/toastr/toastr.min.js"></script>
<script src="/assets/plugins/daterangepicker/daterangepicker.js"></script>
<script src="/assets/plugins/summernote/summernote-bs4.min.js"></script>
@stop
@section('scriptjs')
<script>
    $(function() {
        $('.date').datetimepicker({
            format: 'YYYY-MM-DD',
            locale: 'id'
        });

        $('.isidiskusi').summernote({
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'italic']],
                ['para', ['ul', 'ol']],
            ],
            height: 150, //set editable area's height
            disableResize: true, // Does not work
            disableResizeEditor: true // Does not work either
        });
    });

    $(document).ready(function() {
        $('.create-discuss').click(function() {
            $('#creatediscuss').modal('show')
        });

        $('.creatediscuss').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
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

                    toastr.success(response.success);

                    setTimeout(function() {
                        location.reload()
                    }, 1500);
                }
            })
        })
    })
</script>
@stop