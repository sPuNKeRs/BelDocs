<?php 
    if(! isset($value)) $value = null;
?>
<div class="{!! $errors->has($name) ? 'has-error' : null !!}">
    <label class="text-uppercase text-sm" for="{!! $name !!}">{!! $title !!}</label>
    {!! Form::password($name, array('placeholder' => $placeholder, 'class' => 'form-control mb')) !!}
    <p class="help-block">{!! $errors->first($name) !!}</p>
</div>