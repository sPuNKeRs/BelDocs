<?php
    if(!isset($name)) $name = null;
    if(!isset($title)) $title = null;
    if(!isset($class)) $class = null;
    if(!isset($options)) $options = ['']; // array('L' => 'Large', 'S' => 'Small')
    if(!isset($disabled)) $disabled = "false";
    if(!isset($live_search)) $live_search = true;
    if(!isset($data_size)) $data_size = false;
?>
<div class="form-group">
    <label class="control-label">{{$title}}</label>
    {{ Form::select($name, $options, null, ['data-size' => ($data_size) ? $data_size : '','data-live-search' => ($live_search) ? true : false ,'class' => 'form-control '.$class, (isset($disabled) && $disabled == "true") ? 'disabled': '']) }}
</div>