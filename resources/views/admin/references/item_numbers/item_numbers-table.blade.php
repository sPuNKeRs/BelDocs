@if( session('status') )
    <p class="alert alert-success">{{ session('status') }}</p>
@endif
<div class="row">
    <div class="col-md-12 margin-bottom-12">
        <a href="{!! URL::route('references.itemnumber.edit') !!}" class="btn btn-info pull-right"><i class="fa fa-plus"></i>Добавить</a>
    </div>
</div>

@if( count($item_numbers) > 0 )
    <table class="table table-hover">
        <thead>
        <tr>
            <th>Номенклатурный номер</th>
            <th>Описание</th>
            <th>Операции</th>
        </tr>
        </thead>
        <tbody>
        @foreach($item_numbers as $item_number)
            <tr>
                <td style="width:45%">{!! $item_number->item_number !!}</td>
                <td style="width:45%">{!! $item_number->description !!}</td>

                <td style="witdh:10%">
                    @if(! $item_number->protected)
                        <a href="{!! URL::route('references.itemnumber.edit', ['id' => $item_number->id]) !!}"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                        <a href="{!! URL::route('references.itemnumber.delete',['id' => $item_number->id, '_token' => csrf_token()]) !!}" class="margin-left-5"><i class="fa fa-trash-o delete fa-2x"></i></a>
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