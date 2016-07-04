<?php
    if(! isset($multiple)) $multiple = null;
?>
<div class="form-group {!! $errors->has($name) ? 'has-error' : null !!}">
    <label class="control-label">{{ $title }}</label>
    {!! Form::file($name, array('multiple'=> $multiple) ) !!}
</div>