<div class='panel panel-default'>
    <div class='panel-heading'>
        <i class='fa fa fa-comments-o fa-lg'></i>
        Комментарии
    </div>
    <div class='panel-body'>

        @foreach($comments as $comment)
        <div class="media">
            <a class="pull-left" href="#">
                <img class="media-object" width="64px" src="{!! $comment->user_profile->presenter()->avatar() !!}">
                {{--<img class="media-object" src="http://placehold.it/64x64" alt="">--}}
            </a>
            <div class="media-body">
                <h4 class="media-heading">{{ $comment->user_profile->first_name.' '.$comment->user_profile->last_name }}
                    {{--<small>August 25, 2014 at 9:30 PM</small>--}}
                    <small>{{ date('M d, Y h:m A',strtotime($comment->created_at)) }}</small>
                </h4>
                {{ $comment->content }}
            </div>
        </div>
        <hr>
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