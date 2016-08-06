<?php
    if(!isset($type)) $type = 'success';
    if(!isset($dismissible)) $dismissible = 'alert-dismissible';
    if(!isset($alert_text)) $alert_text = 'NO MESSAGE';
?>

'<div class="alert alert-{{ $type }} {{$dismissible}}" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Закрыть"><span aria-hidden="true">&times;</span></button>{{$alert_text}}</div>'