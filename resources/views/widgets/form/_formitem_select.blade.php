<?php
    if(!isset($name)) $name = null;
    if(!isset($title)) $title = null;
    if(!isset($class)) $class = null;
    if(!isset($options)) $options = ['']; // array('L' => 'Large', 'S' => 'Small')
?>
<div class="form-group">
    <label class="control-label">{{$title}}</label>
    {{ Form::select($name, $options, null, ['class' => 'form-control '.$class]) }}
</div>