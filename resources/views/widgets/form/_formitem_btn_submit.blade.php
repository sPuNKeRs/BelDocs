<?php
    if(! isset($title)) $title = 'Submit';
    if(! isset($id)) $id = null;
    if(! isset($class)) $class = 'btn btn-primary btn-block';
?>
{!! Form::submit($title, array('id' => $id, 'class' => $class)) !!}