<div class="panel panel-info">
    <div class="panel-heading">
        <h3 class="panel-title bariol-thin"><i class="fa fa-search"></i> Поиск групп</h3>
    </div>
    <div class="panel-body">
        {!! Form::open(['route' => 'groups.list','method' => 'get']) !!}
        <!-- name text field -->
        <div class="form-group">
            {!! Form::label('name','Имя:') !!}
            {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'имя группы']) !!}
        </div>
        <span class="text-danger">{!! $errors->first('name') !!}</span>
        {!! Form::submit('Найти', ["class" => "btn btn-info pull-right"]) !!}
        {!! Form::close() !!}
    </div>
</div>