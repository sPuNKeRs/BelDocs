@extends('laravel-authentication-acl::client.layouts.base')
@section('title', 'Вход в систему')
@section('pageClass', 'login')

@section('content')
<div class='wrapper'>
      <div class='row'>
        <div class='col-lg-12'>
          <div class='brand text-center'>
            <h1>
              <div class='logo-icon'>                
              </div>
              {!! Config::get('acl_base.app_name') !!}
            </h1>
          </div>
        </div>
      </div>
      <div class='row'>
        <div class='col-lg-12'>
          {!! Form::open(array('url' => URL::route("user.login"), 'method' => 'post') ) !!}
            <?php $message = Session::get('message'); ?>
            @if( isset($message) )                
                <div class="alert alert-success">{!! $message !!}</div>
            @endif
            @if($errors && ! $errors->isEmpty() )
                @foreach($errors->all() as $error)
                    <div class="alert alert-danger">{!! $error !!}</div>
                @endforeach
            @endif
            <fieldset class='text-center'>
              <legend>Вход в систему</legend>
              <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                        {!! Form::email('email', '', ['id' => 'email', 'class' => 'form-control', 'placeholder' => 'Электронная почта (Логин)', 'required', 'autocomplete' => 'off']) !!}
                    </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                    {!! Form::password('password', ['id' => 'password', 'class' => 'form-control', 'placeholder' => 'Пароль', 'required', 'autocomplete' => 'off']) !!}
                </div>
              </div>
              <div class='text-center'>
                <div>
                    {!! Form::checkbox('remember')!!}
                    {!! Form::label('remember','Запомнить меня') !!}
                
                </div>
                <input type="submit" value="Войти" class="btn btn-info btn-block">
                <br>
                {!! link_to_route('user.recovery-password','Забыли пароль?') !!}
              </div>
            </fieldset>
          {!! Form::close() !!}
        </div>
      </div>
    </div>
@stop