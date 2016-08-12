{{ Form::file('upload_files[]', ['id'=>'upload_files', 'multiple'=>'true', 'files' => 'true' ]) }}

@section('custom_js')
    @parent
    <script>
        $(document).ready(function(){
            var token = $('input[name=_token]').val();
            // with plugin options
            $("#upload_files").fileinput({'showUpload':true,
                                          'uploadUrl': '{{ route('attachments.store') }}',
                                          'uploadAsync': false,
                                          'previewFileType':'any',
                                          'language': 'ru',
                                          'dropZoneEnabled': false,
                                          'overwriteInitial': false,
                                          'showCaption': false,
                                          'showPreview': true,
                                          'showRemove': false,
                                          'showUpload': false,
                                          'showCancel': false,
                                          'showClose': false,
                                          'showUploadedThumbs': true,
                                          'showBrowse': true,
                                          'browseOnZoneClick': false,
                                          'autoReplace': false,
                                          //'captionClass': '',
                                          //'previewClass': '',
                                          //'mainClass': '',
                                         'previewSettings':{
                                             image: {width: "100px", height: "100px"},
                                             html: {width: "100px", height: "100px"},
                                             text: {width: "100px", height: "100px"},
                                             video: {width: "100px", height: "100px"},
                                             audio: {width: "100px", height: "100px"},
                                             flash: {width: "100px", height: "100px"},
                                             object: {width: "100px", height: "100px"},
                                             other: {width: "100px", height: "100px"}
                                         },

                                          'ajaxSettings':{
                                              headers: {'X-CSRF-TOKEN': token}
                                          },
                                          'uploadExtraData':{
                                              'id':'{{$id}}',
                                              'slug': '{{$slug}}',
                                              'entity_type': '{{$entity_type}}'
                                          },

                                        
                                        'initialPreview': [
                                            'http://kartik-v.github.io/bootstrap-fileinput-samples/samples/pdf-sample.pdf',
                                        ],
                                        'initialPreviewAsData': true,

                                        'initialPreviewConfig': [
                                            {type: "pdf", size: 8000, caption: "PDF-Sample.pdf", url: "/file-upload-batch/2", key: 10},
                                        ]
            });
        });



        $('#upload_files').on('fileselect', function(event, numFiles, label) {

            //$('#upload_files').fileinput('upload');

        });

        $('#upload_files').on('filebatchselected', function(event, files) {
            $('#upload_files').fileinput('upload');
        });
    </script>
@endsection