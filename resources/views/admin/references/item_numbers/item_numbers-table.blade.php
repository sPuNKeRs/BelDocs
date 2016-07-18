<div class="row">
    <div class="col-md-12 margin-bottom-12">
        <a href="{!! URL::route('references.itemnumber.edit') !!}" class="btn btn-info pull-right"><i class="fa fa-plus"></i>Добавить</a>
    </div>
</div>
@if( $item_numbers == ' ' )
    <table class="table table-hover">
        <thead>
        <tr>
            <th>Permission description</th>
            <th>Permission name</th>
            <th>Operations</th>
        </tr>
        </thead>
        <tbody>
        @foreach($item_numbers as $item_number)
            <tr>
                <td style="width:45%">{!! $item_number->description !!}</td>
                <td style="width:45%">{!! $item_number->permission !!}</td>
                <td style="witdh:10%">
                    @if(! $item_number->protected)
                        <a href="{!! URL::route('permission.edit', ['id' => $item_number->id]) !!}"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                        <a href="{!! URL::route('permission.delete',['id' => $item_number->id, '_token' => csrf_token()]) !!}" class="margin-left-5"><i class="fa fa-trash-o delete fa-2x"></i></a>
                    @else
                        <i class="fa fa-times fa-2x light-blue"></i>
                        <i class="fa fa-times fa-2x margin-left-12 light-blue"></i>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@else
    <span class="text-warning"><h5>Справочник пустой.</h5></span>
@endif