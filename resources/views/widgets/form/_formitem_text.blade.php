<?php
    if(! isset($value)) $value = null;
    if(! isset($describedby)) $describedby = null;
    if(! isset($fa_icon)) $fa_icon = 'fa-calendar';
    if(! isset($readonly)) $readonly = null;

?>
{{--<div class="{!! $errors->has($name) ? 'has-error' : null !!}">--}}
    {{--<label class="text-uppercase text-sm" for="{!! $name !!}">{{ $title }}</label>--}}
    {{--{!! Form::text($name, $value, array('placeholder' =>  $placeholder, 'class' => 'form-control', 'id' => $name )) !!}--}}
    {{--<p class="help-block">{!! $errors->first($name) !!}</p>--}}
{{--</div>--}}







<div class=" {{ isset($describedby) ? 'input-group' : ''}} {!! $errors->has($name) ? 'has-error' : null !!} ">
    {!! Form::text($name, $value, array('placeholder' =>  $placeholder,
                                        'class' => 'form-control',
                                        'id' => $name,
                                        'aria-describedby' => $describedby,
                                        'readonly' => $readonly)) !!}
    @if($describedby)
        <label for="{{$name}}" class="input-group-addon" id="basic-addon1"><i class="fa {{$fa_icon}} fa-lg"></i></label>
    @endif

</div>
<p class="help-block {!! $errors->has($name) ? 'has-error' : null !!}">{!! $errors->first($name) !!}</p>



