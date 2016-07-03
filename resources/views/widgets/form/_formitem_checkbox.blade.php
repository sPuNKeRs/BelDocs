<?php

if(! isset($value)) $value = null;
if(! isset($checked)) $checked = null;
if(! isset($title)) $title = null;

?>

<div class="{!! $errors->has($name) ? 'has-error' : null !!}">
    <div class="checkbox checkbox-circle checkbox-info">
        {!! Form::checkbox($name, $value, $checked) !!}
        <label for="{!! $name !!}">{{ $title }}</label>                
    </div>                
</div>