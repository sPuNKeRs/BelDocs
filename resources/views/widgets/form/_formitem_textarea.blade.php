<?php
    if(! isset($name)) $name = 'textarea';
    if(! isset($title)) $title = null;
    if(! isset($rows)) $rows = 4; 
?>
<div class="form-group">
    <div class="{!! $errors->has($name) ? 'has-error' : null !!}">
        <label class="control-label">{!! $title !!}</label>
        <textarea class="form-control" rows="{!! $rows !!}" name="{!! $name !!}"></textarea>
        <p class="help-block">{!! $errors->first($name) !!}</p>
    </div>
</div>