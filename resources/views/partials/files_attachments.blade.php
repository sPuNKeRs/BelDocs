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
                                          'initialPreviewAsData': true,
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
                                            'purifyHtml': true,
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

                                          'ajaxSettings':{
                                              headers: {'X-CSRF-TOKEN': token}
                                          },
                                          'uploadExtraData': function(){
                                              return {
                                                        'id':'{{$order->id}}',
                                                        'slug': '{{$order->slug}}',
                                                        'entity_type': '{{$entity_type}}'
                                              };
                                          },
                                            @if(isset($initialPreview))
                                           'initialPreview':[
                                                @foreach($initialPreview as $file)
                                                    '{{$file}}',
                                                @endforeach
                                            ],
                                            @endif

                                            @if(isset($initialPreviewConfig))
                                            'initialPreviewConfig': {!! $initialPreviewConfig !!},
                                            @endif
                                        
//                                        'initialPreview': [
//                                            'http://kartik-v.github.io/bootstrap-fileinput-samples/samples/pdf-sample.pdf',
//                                        ],

//
//                                        'initialPreviewConfig': [
//                                            {type: "pdf", size: 8000, caption: "PDF-Sample.pdf", url: "/file-upload-batch/2", key: 10},
//                                        ]
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