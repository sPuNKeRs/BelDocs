<div class='panel panel-default'>
    <div class='panel-heading'>
        <i class='fa fa fa-comments-o fa-lg'></i>
        Комментарии
    </div>
    <div class='panel-body' id="comments-list">
        @if(isset($comments))

        @foreach($comments as $comment)
        <div class="media" id="comment_{{$comment->id}}">
            <a class="pull-left" href="#">
                <img class="media-object" width="64px" src="{!! $comment->user_profile->presenter()->avatar() !!}">
            </a>
            @if(App::make('authentication_helper')->hasPermission(array("_superadmin")) || App::make('authenticator')->getLoggedUser()->id == $comment->author_id)
                <i class="fa fa-minus-circle pull-right fa-lg delete-comment" style="margin-top: 10px;" aria-hidden="true" data-comment-id="{{$comment->id}}"></i>
            @endif
            <div class="media-body">
                <h4 class="media-heading">{{ $comment->user_profile->first_name.' '.$comment->user_profile->last_name }}
                    <small>{{ $comment->created_at->format('d.m.Y \в H:i:s') }}</small>
                </h4>
                {{ $comment->content }}
            </div>
            <br>
            <hr style="clear:both;">
        </div>

        @endforeach

        @endif


        {!! Form::open(['route' => 'comments.store', 'name' => 'formComment', 'id' => 'formComment'])!!}
        <div class="row">
            <div class="col-md-12">
                @include('widgets.form._formitem_textarea', ['name' => 'content', 'id' => 'commentContent', 'rows' => '6', 'placeholder' => 'Ваш комментарий'])
            </div>
        </div>
        <div class="form-actions">
            @include('widgets.form._formitem_btn_submit',['title' => 'Отправить', 'class' => 'btn btn-default', 'id' => 'post_comment'])
            {{--<a class="btn" href="{{ route('orders.inbox') }}">Отмена</a>--}}
        </div>
        {{ Form::hidden('entity_id', $entity->slug) }}
        {!! Form::token() !!}
        {!! Form::close()!!}


    </div>
</div>

@section('custom_js')
@parent
<script>
    $(document).ready(function(){
        // Удалить комментарий
        $('.delete-comment').click(function(){
            if(confirm('Вы действительно хотите удалить комментарий?')){
                var token, url, data, commentID, commentObj;

                commentID = $(this).data('comment-id');
                commentObj = $('#comment_'+commentID);
                token = $('input[name=_token]').val();

                url = '{{route('comments.delete')}}';
                data = {id: commentID};

                $.ajax({
                    url: url,
                    headers: {'X-CSRF-TOKEN': token},
                    data: data,
                    type: 'POST',
                    datatype: 'JSON',
                    success: function (response) {
                        var status  = response.status;

                        if(status == 'true')
                        {
                            commentObj.remove();
                        }
                    }
                });
            }
        });

        // Отправить комментарий
        $('#post_comment').click(function(e){

            var token, url, formData;

            token = $('input[name=_token]').val();
            url = '{{ route('comments.store') }}';
            formData = new FormData($('#formComment')[0]);

            $.ajax({
                url: url,
                headers: {'X-CSRF-TOKEN': token},
                processData: false,
                contentType: false,
                data: formData,
                type: 'POST',
                success: function (response) {
                    console.log('success');
                    console.log(response);

                    $('#commentContent').val('');
                    $('#comments-list').prepend(response);

                },
                error: function(errors){
                    console.log('errors');
                    var err = JSON.parse(errors.responseText);
                    var errMsg = '<p class="help-block">'+err.content+'</p>';
                    $('#commentContent').parent('div').addClass('has-error');
                    $('#commentContent').parent('div').append(errMsg);
                }
            });

            e.preventDefault();
        });

        // Убрать ошибку при заполенении
        $('#commentContent').bind('keypress change', function(e){
            var self = e.currentTarget;
            $(self).parent('div').removeClass('has-error');
            $(self).parent('div').find('.help-block').remove();
        });
    });
</script>
@endsection