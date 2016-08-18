<?php

if (!isset($id)) $id = null;
if (!isset($class)) $class = null;
if (!isset($title)) $title = null;
if (!isset($value)) $value = null;
if (!isset($checked)) $checked = null;
if (!isset($left)) $left = null;


?>

@if($errors->has($name))
<div class="{!! $errors->has($name) ? 'has-error' : null !!}">
@endif
    @if($left)
        <div class="checkbox checkbox-circle checkbox-info">
            <label for="{!! $name !!}">{{ $title }}</label>
            {!! Form::checkbox($name, $value, $checked, ['id' => $id, 'class' => $class]) !!}
        </div>
    @else
        <div class="checkbox checkbox-circle checkbox-info">
            {!! Form::checkbox($name, $value, $checked, ['id' => $id, 'class' => $class]) !!}
            <label for="{!! $name !!}">{{ $title }}</label>
        </div>
    @endif
@if($errors->has($name))
</div>
@endif