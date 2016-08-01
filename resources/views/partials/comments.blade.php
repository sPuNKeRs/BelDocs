<div class='panel panel-default'>
    <div class='panel-heading'>
        <i class='fa fa fa-comments-o fa-lg'></i>
        Комментарии
    </div>
    <div class='panel-body'>

        @foreach($comments as $comment)
        <div class="media" id="comment_{{$comment->id}}">
            <a class="pull-left" href="#">
                <img class="media-object" width="64px" src="{!! $comment->user_profile->presenter()->avatar() !!}">
                {{--<img class="media-object" src="http://placehold.it/64x64" alt="">--}}
            </a>
            <i class="fa fa-minus-circle pull-right fa-lg delete-comment" style="margin-top: 10px;" aria-hidden="true" data-comment-id="{{$comment->id}}"></i>
            <div class="media-body">
                <h4 class="media-heading">{{ $comment->user_profile->first_name.' '.$comment->user_profile->last_name }}
                    {{--<small>August 25, 2014 at 9:30 PM</small>--}}
                    {{--<small>{{ date('M d, Y h:m A',strtotime($comment->created_at)) }}</small>--}}
                    <small>{{ $comment->created_at->format('d.m.Y \в H:m') }}</small>
                    {{--<small>{{ LocalizedCarbon::createFromFormat('Y',strtotime($comment->created_at))->diffForHumans() }}</small>--}}
                </h4>
                {{ $comment->content }}
            </div>
            <br>
            <hr style="clear:both;">
        </div>

        @endforeach


        {!! Form::open(['route' => 'comments.store'])!!}
        <div class="row">
            <div class="col-md-12">
                @include('widgets.form._formitem_textarea', ['name' => 'content', 'rows' => '6', 'placeholder' => 'Ваш комментарий'])
            </div>
        </div>
        <div class="form-actions">
            @include('widgets.form._formitem_btn_submit',['title' => 'Отправить', 'class' => 'btn btn-default'])
            {{--<a class="btn" href="{{ route('orders.inbox') }}">Отмена</a>--}}
        </div>
        {{ Form::hidden('entity_id', $entity_id) }}
        {!! Form::token() !!}
        {!! Form::close()!!}


    </div>
</div>

@section('custom_js')
@parent
<script>
    $(document).ready(function(){
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
                            //console.log(commentObj);
                            commentObj.remove();
                        }
                    }
                });
            }
        });
    });
</script>
@endsection