@extends('admin.layouts.main')
@section('content')
    <div class="content col-sm-9 col-sm-push-3">
        <h3 style="text-align:center;">welcome,administrator {{ Auth::guard('admin')->user()->name }}!</h3>

        <br/>
        <br/>
        <a class="btn btn-primary" href="{{ route('pdftest') }}" target="_blank">inner-pdf icon remove test</a>

        <hr/>

        <form action="{{ route('uploadtest') }}" method="post" class="form-horizontal" enctype="multipart/form-data">

            {{csrf_field()}}

            <div class="form-group">
                <label for="file" class="col-sm-2 control-label">file to upload</label>
                <div class="col-sm-10">
                    <input type="file" id="fileupload" name="testimage" class="form-control">
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-primary" id="submit">submit</button>
                </div>
            </div>

        </form>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="{{ asset('node_modules/blueimp-file-upload/js/jquery.iframe-transport.js') }}"></script>
    <script src="{{ asset('node_modules/blueimp-file-upload/js/jquery.fileupload.js') }}"></script>
    <script>
        /*$('#submit').click(function () {
            $('#fileupload').fileupload();
        })*/
    </script>
@stop