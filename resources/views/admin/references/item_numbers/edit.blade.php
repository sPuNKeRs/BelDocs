@extends('laravel-authentication-acl::admin.layouts.base-2cols')

@section('title')
    Панель управления: Редактирование справочника "Номенклатурный номер"
@stop

@section('content')

    <div class="row">
        <div class="col-md-12">
            {{-- model general errors from the form --}}
            @if($errors->has('model') )
                <div class="alert alert-danger">{{$errors->first('model')}}</div>
            @endif

            {{-- successful message --}}
            <?php $message = Session::get('message'); ?>
            @if( isset($message) )
                <div class="alert alert-success">{{$message}}</div>
            @endif
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title bariol-thin">{!! isset($item_number->id) ? '<i class="fa fa-pencil"></i> Редактирование' : '<i class="fa fa-envelope"></i> Добавить ' !!} "Номенклатурный номер"</h3>
                </div>
                <div class="panel-body">
                {!! Form::model($item_number, [ 'url' => [URL::route('references.itemnumber.edit'), $item_number->id], 'method' => 'post'] )  !!}
                <!-- description text field -->
                    <div class="form-group">
                        {!! Form::label('description','Описание: *') !!}
                        {!! Form::text('description', null, ['class' => 'form-control', 'placeholder' => 'Описание']) !!}
                    </div>
                    <span class="text-danger">{!! $errors->first('description') !!}</span>
                    <!-- item_number text field -->
                    <div class="form-group">
                        {!! Form::label('item_number','Номенклатурный номер: *') !!}
                        {!! Form::text('item_number', null, ['class' => 'form-control', 'placeholder' => 'Номенклатурный номер', 'id' => 'slug']) !!}
                    </div>
                    <span class="text-danger">{!! $errors->first('item_number') !!}</span>
                    {!! Form::hidden('id') !!}
                    <a href="{!! URL::route('references.itemnumber.delete',['id' => $item_number->id, '_token' => csrf_token()]) !!}" class="btn btn-danger pull-right margin-left-5 delete">Удалить</a>
                    {!! Form::submit('Сохранить', array("class"=>"btn btn-info pull-right ")) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop

@section('footer_scripts')
    {!! HTML::script('packages/jacopo/laravel-authentication-acl/js/vendor/slugit.js') !!}
    <script>
        $(".delete").click(function(){
            return confirm("Вы действительно хотите удалить этот пункт?");
        });
        $(function(){
            $('#slugme').slugIt();
        });
    </script>
@stop