@extends('laravel-authentication-acl::admin.layouts.base-2cols')

@section('title')
    Панель управления: Редактирование справочника "Отправители"
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
                    <h3 class="panel-title bariol-thin">{!! isset($sender->id) ? '<i class="fa fa-pencil"></i> Редактирование' : '<i class="fa fa-envelope"></i> Добавить ' !!} "Отправителя"</h3>
                </div>
                <div class="panel-body">
                {!! Form::model($sender, [ 'url' => [URL::route('references.sender.edit'), $sender->id], 'method' => 'post'] )  !!}
                <!-- description text field -->
                    <div class="form-group">
                        {!! Form::label('description','Описание: *') !!}
                        {!! Form::text('description', null, ['class' => 'form-control', 'placeholder' => 'Описание']) !!}
                    </div>
                    <span class="text-danger">{!! $errors->first('description') !!}</span>
                    <!-- sender text field -->
                    <div class="form-group">
                        {!! Form::label('sender','Отправитель: *') !!}
                        {!! Form::text('sender', null, ['class' => 'form-control', 'placeholder' => 'Отправитель', 'id' => 'slug']) !!}
                    </div>
                    <span class="text-danger">{!! $errors->first('sender') !!}</span>
                    {!! Form::hidden('id') !!}
                    <a href="{!! URL::route('references.sender.delete',['id' => $sender->id, '_token' => csrf_token()]) !!}" class="btn btn-danger pull-right margin-left-5 delete">Удалить</a>
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