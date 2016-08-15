{{ Form::file('upload_files[]', ['id'=>'upload_files', 'multiple'=>'true', 'files' => 'true' ]) }}

@section('custom_js')
    @parent
    <script>
        $(document).ready(function () {
            var token = $('input[name=_token]').val();

            $("#upload_files").fileinput({
                'showUpload': true,
                'uploadUrl': '{{ route('attachments.store') }}',
                'uploadAsync': false,
                'previewFileType': 'any',
                'language': 'ru',
                'dropZoneEnabled': false,
                'overwriteInitial': false,
                'initialPreviewAsData': true,
                'showCaption': false,
                'showPreview': true,
                'showRemove': false,
                'showUpload': false,
                'showCancel': false,
                'showClose': false,
                'showUploadedThumbs': true,
                @if(!App::make('authentication_helper')->hasPermission(array("_superadmin")) || !App::make('authenticator')->getLoggedUser()->id == $entity->author_id)
                    'showBrowse': false,
                @endif
                'browseOnZoneClick': false,
                'autoReplace': false,
                'purifyHtml': true,
                'fileActionSettings': {
                    'showRemove': false
                },
                'previewSettings': {
                    image: {width: "100px", height: "100px"},
                    html: {width: "100px", height: "100px"},
                    text: {width: "100px", height: "100px"},
                    video: {width: "100px", height: "100px"},
                    audio: {width: "100px", height: "100px"},
                    flash: {width: "100px", height: "100px"},
                    object: {width: "100px", height: "100px"},
                    other: {width: "100px", height: "100px"}
                },
                'previewFileIconSettings': {
                    'doc': '<i class="fa fa-file-word-o text-primary"></i>',
                    'docx': '<i class="fa fa-file-word-o text-primary"></i>',
                    'xls': '<i class="fa fa-file-excel-o text-success"></i>',
                    'xlsx': '<i class="fa fa-file-excel-o text-success"></i>',
                    'ppt': '<i class="fa fa-file-powerpoint-o text-danger"></i>',
                    'pptx': '<i class="fa fa-file-powerpoint-o text-danger"></i>',
                    'jpg': '<i class="fa fa-file-photo-o text-warning"></i>',
                    'pdf': '<i class="fa fa-file-pdf-o text-danger"></i>',
                    'zip': '<i class="fa fa-file-archive-o text-muted"></i>',
                    'ZIP': '<i class="fa fa-file-archive-o text-muted"></i>',
                },

                'ajaxSettings': {
                    headers: {'X-CSRF-TOKEN': token}
                },
                'ajaxDeleteSettings': {
                    headers: {'X-CSRF-TOKEN': token}
                },
                'uploadExtraData': function (previewId, index) {
                    return {
                        'id': '{{$entity->id}}',
                        'slug': '{{$entity->slug}}',
                        'entity_type': '{{$entity_type}}'
                    };
                },
                @if(isset($initialPreview))
                'initialPreview': [
                    @foreach($initialPreview as $file)
                            '{{$file}}',
                    @endforeach
                ],
                @endif

                        @if(isset($initialPreviewConfig))
                'initialPreviewConfig': {!! $initialPreviewConfig !!},
                @endif
                otherActionButtons: '<a class="kv-file-download btn btn-xs btn-default" title="Скачать" {dataKey}><i class="fa fa-download" aria-hidden="true"></i></a>'

            });

            $('.file-preview').on('click', '.kv-file-download', function (e) {
                var id = $(this).data('key');
                console.log(id);
                var url = ' {{route('attachments.geturl') }}';

                var data = {'id': id};

                // get download url
                $.ajax({
                    url: url,
                    headers: {'X-CSRF-TOKEN': token},
                    data: data,
                    type: 'POST',
                    success: function (response) {
                        window.location = response;
                    },
                    error: function (errors) {
                        console.log(errors);
                    }
                });
            });

            $('#upload_files').on('filebatchselected', function (event, files) {
                $('#upload_files').fileinput('upload');
            });
        });
    </script>
@endsection