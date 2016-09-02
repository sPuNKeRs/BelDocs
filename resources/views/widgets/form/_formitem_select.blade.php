<?php
    if(!isset($name)) $name = null;
    if(!isset($title)) $title = null;
    if(!isset($class)) $class = null;
    if(!isset($options)) $options = ['']; // array('L' => 'Large', 'S' => 'Small')
    if(!isset($disabled)) $disabled = "false";
?>
<div class="form-group">
    <label class="control-label">{{$title}}</label>
    {{ Form::select($name, $options, null, ['class' => 'form-control '.$class, (isset($disabled) && $disabled == "true") ? 'disabled': '']) }}
</div>