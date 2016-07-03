<?php
    if(! isset($value)) $value = null;
    if(! isset($help)) $help = null;
?>

<div class="form-group {!! $errors->has($name) ? 'has-error' : null !!}">
    <label class="control-label" for="{!! $name !!}">{{ $title }}</label>
    {!! Form::text($name, $value, array('placeholder' =>  $placeholder, 'class' => 'form-control mb' )) !!}
    <p class="help-block">{!! $help !!}</p>
    <p class="help-block">{!! $errors->first($name) !!}</p>
</div>
