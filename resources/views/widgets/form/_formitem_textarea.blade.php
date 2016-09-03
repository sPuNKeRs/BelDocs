<?php
    if(! isset($id)) $id = null;
    if(! isset($name)) $name = 'textarea';
    if(! isset($title)) $title = null;
    if(! isset($value)) $value = null;
    if(! isset($placeholder)) $placeholder = null;
    if(! isset($rows)) $rows = 4;
    if(! isset($disabled)) $disabled = null;
?>
<div class="form-group">
    <div class="{!! $errors->has($name) ? 'has-error' : null !!}">
        <label class="control-label">{!! $title !!}</label>
        {!! Form::textarea($name, $value, array('placeholder' =>  $placeholder, 'id' => $id , 'class' => 'form-control mb', 'rows' => $rows, ($disabled)?'disabled':'')) !!}
        <p class="help-block">{!! $errors->first($name) !!}</p>
    </div>
</div>

