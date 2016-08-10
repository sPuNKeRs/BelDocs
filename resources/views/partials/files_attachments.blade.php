{{ Form::file('upload_files', ['id'=>'upload_files', 'multiple'=>'true' ]) }}

@section('custom_js')
    @parent
    <script>
        $(document).ready(function(){
            // with plugin options
            $("#upload_files").fileinput({'showUpload':false,
                                          'previewFileType':'any',
                                          'language': 'ru',
                                          'overwriteInitial': false});
        });
    </script>
@endsection