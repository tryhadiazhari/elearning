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
            <div class="col-auto mb-3">
                <button class="btn btn-primary btn-md create-discuss" onclick="window.location='/forum-diskusi'"><i class="fa fa-arrow-left"></i> Kembali</button>
            </div>
            <div class="col-md-12 py-0 my-0">
                <div class="card direct-chat direct-chat-primary">
                    <div class="card-header">
                        <h3 class="card-title">{{ $dataforum->forum_judul . ' (' . $dataforum->nama_kelas . ')' }}</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body border">
                        <!-- Conversations are loaded here -->
                        <div class="direct-chat-messages" style="height: 350px;">
                            @foreach($forumreply as $reply)
                            <div class="direct-chat-msg {{ ($reply->from == $user->nama) ? 'right' : '' }}">
                                <div class="direct-chat-infos clearfix">
                                    <span class="direct-chat-name float-{{ ($reply->from == $user->nama) ? 'right' : '' }}">{{ ($reply->from == $user->nama) ? 'Anda' : $reply->from }}</span>
                                </div>
                                <div class="direct-chat-text {{ ($reply->from == $user->nama) ? 'mr-1 ml-4' : 'ml-1 mr-4' }}">
                                    <?= $reply->discussing ?>
                                </div>
                                <span class="text-sm direct-chat-timestamp float-{{ ($reply->from == $user->nama) ? 'right mr-1' : 'left ml-1' }}">{{ date('Y-m-d H:i:s', strtotime($reply->created_at)) }}</span>
                            </div>
                            <!-- <div class="card<?= ($reply->from == $user->nama) ? '' : ' ml-4' ?>">
                                <div class="card-header">
                                    <label><?= $reply->from ?></label>
                                </div>
                                <div class="card-body">
                                    <?= $reply->discussing ?>
                                </div>
                            </div> -->
                            @endforeach
                        </div>
                    </div>
                    <div class="card-footer">
                        <form action="/forum-diskusi/<?= $dataforum->id ?>/reply" method="POST" class="form-reply">
                            <div class="input-group">
                                <!-- <textarea name="reply" id="reply" class="form-control reply" style="resize: none;" rows="1"></textarea> -->
                                <input type="text" name="reply" id="reply" class="form-control reply" style="resize: none;">
                                <div class="invalid-feedback invalid-reply"></div>
                                <span class="input-group-append">
                                    <button type="submit" class="btn btn-primary">Send</button>
                                </span>
                            </div>
                        </form>
                    </div>
                </div>
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
    // $(function() {
    //     $('.date').datetimepicker({
    //         format: 'YYYY-MM-DD',
    //         locale: 'id'
    //     });

    //     $('.isidiskusi').summernote({
    //         toolbar: [
    //             ['style', ['style']],
    //             ['font', ['bold', 'underline', 'italic']],
    //             ['para', ['ul', 'ol']],
    //         ],
    //         height: 150, //set editable area's height
    //         disableResize: true, // Does not work
    //         disableResizeEditor: true // Does not work either
    //     });
    // });

    $(document).ready(function() {
        $('.form-reply').on('submit', function(e) {
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