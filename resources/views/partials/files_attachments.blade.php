{{ Form::file('upload_files', ['id'=>'upload_files', 'multiple'=>'true' ]) }}

{{--<input id="upload_files" type="file" name="upload_files" multiple>--}}
@section('custom_js')
    @parent
    <script>
        $(document).ready(function(){
            // with plugin options
            $("#upload_files").fileinput({'showUpload':false, 'previewFileType':'any', 'language': 'ru'});
        });
    </script>
@endsection