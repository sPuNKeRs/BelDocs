<div class="media" id="comment_{{$comment->id}}">
    <a class="pull-left" href="#">
        <img class="media-object" width="64px" src="{!! $comment->user_profile->presenter()->avatar() !!}">
    </a>
    <i class="fa fa-minus-circle pull-right fa-lg delete-comment" style="margin-top: 10px;" aria-hidden="true" data-comment-id="{{$comment->id}}"></i>
    <div class="media-body">
        <h4 class="media-heading">{{ $comment->user_profile->first_name.' '.$comment->user_profile->last_name }}
            <small>{{ $comment->created_at->format('d.m.Y \в H:i:s') }}</small>
        </h4>
        {{ $comment->content }}
    </div>
    <br>
    <hr style="clear:both;">
</div>