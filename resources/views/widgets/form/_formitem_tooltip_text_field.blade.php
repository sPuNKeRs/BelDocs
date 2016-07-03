<?php
    if(! isset($value)) $value = null;
    if(! isset($tooltip)) $tooltip = null;
?>

<div class="form-group {!! $errors->has($name) ? 'has-error' : null !!}">
    <label class="control-label" for="{!! $name !!}">{{ $title }}</label>
    {!! Form::text($name, $value, array('placeholder' =>  $placeholder, 'class' => 'form-control mb', 'data-toggle' => 'tooltip',  'data-original-title' => $tooltip)) !!}
    <p class="help-block">{!! $errors->first($name) !!}</p>
</div>