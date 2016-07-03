@if ($breadcrumbs)
    <ul class="breadcrumb" id='breadcrumb'>
        @foreach ($breadcrumbs as $breadcrumb)
            @if (!$breadcrumb->last)
                <li><a href="{{ $breadcrumb->url }}">{{ $breadcrumb->title }}</a></li>
            @else
                <li class="title active">{{ $breadcrumb->title }}</li>
            @endif
        @endforeach
    </ul>
@endif