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
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-4 my-2">
                                <label>Mata Pelajaran</label>
                                <select class="form-control" name="mapel">
                                    <option selected disabled>Choose</option>
                                    @foreach($datamapel as $mapel)
                                    <option value="{{ $mapel['kd_mapel'].' - '. $mapel['kd_kelas'] }}">{{ $mapel['nama_mapel'] .' ('.$mapel['kd_kelas'].')' }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-md-4 my-2">
                                <label>Tanggal</label>
                                <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                    <input type="text" class="form-control datetimepicker-input" name="tanggal" data-target="#reservationdate" autocomplete="off" />
                                    <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-4 my-2">
                                <label class="d-none d-sm-block">&nbsp;</label>
                                <button type="button" class="btn btn-info btn-block caridata">Cari</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="viewdata"></div>
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
    });

    $(document).ready(function() {
        $('.caridata').on('click', function(e) {
            if ($('select[name="mapel"] option:selected').val() == 'Choose' || $('input[name="tanggal"]').val() == "") {
                toastr.error('Isi data dengan benar!!!');
                $('.viewdata').html('');
            } else {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/bahanajar/cari/' + $('select[name="mapel"] option:selected').val() + '/' + $('input[name="tanggal"]').val(),
                    method: $(this).attr('method'),
                    data: {
                        id: $('select[name="mapel"] option:selected').val(),
                        tgl: $('input[name="tanggal"]').val()
                    },
                    beforeSend: function() {
                        $('.viewdata').html('Loading data...')
                    },
                    error: function(error) {
                        toastr.error(error.responseJSON);
                        $('.viewdata').html('')
                    },
                    success: function(response) {
                        $('select[name="mapel"]').prop('disabled', false)
                        $('input[name="tanggal"]').prop('disabled', false)

                        $('.viewdata').html(response)

                        $('.btn-read').on('click', function() {
                            showdata($(this).data('id'))
                        })
                    }
                })
            }
        })

        function showdata(data) {
            $.ajax({
                url: 'bahanajar/' + data,
                method: 'GET',
                beforeSend: function() {
                    $('.viewdata').html('Loading data...')
                },
                error: function(error) {
                    toastr.error(error.responseJSON);
                },
                success: function(response) {
                    $('.viewdata').html(response)
                    $('.btn-refresh').click(function() {
                        $('.caridata').trigger('click')
                    });

                    $('select[name="mapel"]').prop('disabled', true)
                    $('input[name="tanggal"]').prop('disabled', true)
                }
            })
        }
    })
</script>
@stop