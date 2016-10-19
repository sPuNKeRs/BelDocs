<?php
if (isset($responsibles)) $countLi = $index;
if (!isset($responsible)) $responsible = null;

$access = false;
if (App::make('authentication_helper')->hasPermission(array("_superadmin")) || App::make('authenticator')->getLoggedUser()->id == $entity->author_id) {
    $access = true;
}

$access_status = false;
if (App::make('authentication_helper')->hasPermission(array("_superadmin")) || App::make('authenticator')->getLoggedUser()->id == $responsible->user_id) {
    $access_status = true;
}

// Если это просто просмотр, то запретить вносить изменения
if(isset($is_view) && $is_view == 'true')
{
   $is_view = true;
}
else
{
  $is_view = false;
}
?>

<li class="list-group-item" data-count-num="{{$countLi}}"
    data-responsible-id="{{(isset($responsible->id)? $responsible->id: '')}}">
    <div class="row {{!isset($responsible) ? 'has-error-row' : ''}}">
        <div class="col-md-4">
            <i class="fa fa-user fa-2x" aria-hidden="true"></i> {{ Form::select('responsible_user'.$countLi,

                                                                                    (isset($responsible))? \App\User::getArrayUser($responsible->user_id) : \App\User::getArrayOptions($entity_id, $entity_type),
                                                                                    //dd(\App\User::getArrayOptions($entity_id, $entity_type)),
                                                                                    (isset($responsible->user_id)) ? $responsible->user_id : null,
                                                                                    ['class' => 'selectpicker responsible_user',
                                                                                    'data-live-search' => true,
                                                                                    'data-size'=> 4,
                                                                                    'data-width'=>'90%',
                                                                                    'data-title'=>'Выберите из списка',
                                                                                    'data-count-li'=>$countLi,
                                                                                    (!isset($responsible)) ? '' : 'disabled',
                                                                                    ($access)?'':'disabled']) }}
        </div>
        <div class="col-md-3">
            @include('widgets.form._formitem_text', ['name' => 'executed_at'.$countLi,                                                        
                                                        'class' => ($is_view) ? ' form-control executed_at_value' : 'executed_at_value executed_at executed_at'.$countLi.' form-control',
                                                        'value' => (isset($responsible->executed_at))? date('d.m.Y', strtotime($responsible->executed_at)) : date('d.m.Y'),
                                                        'data-count-li' => $countLi,
                                                        'placeholder' => '01.01.2016',
                                                        'describedby' => 'basic-addon1',
                                                        ($access)?'':'readonly' => 'true'                                                        
                                                        ])

        </div>
        <div class="col-md-3 text-right">
            @include('widgets.form._formitem_checkbox', ['name'=>'status_user'.$countLi,
                                                            'title'=> 'Статус',
                                                            'value'=> '1',
                                                            'id' => 'status_user'.$countLi,
                                                            'data-count-li' => $countLi,
                                                            'class' => 'custom checkbox status_user',
                                                            'left' => null,
                                                            'checked' => (isset($responsible->status) and $responsible->status == 1) ? true : false,
                                                            ($access_status)?'':'disabled'=>'true'])
        </div>
        <div class="col-md-2">
            @if(App::make('authentication_helper')->hasPermission(array("_superadmin")) || App::make('authenticator')->getLoggedUser()->id == $entity->author_id)
                <span class="pull-right" style="margin: 6px -30px 0px 0; width: 57px;">
                        <div style="width: 55px;">
                            {{--<a href="#" class="add-responsible-btn"><i class="fa fa-check-circle fa-2x" aria-hidden="true"></i></a>--}}

                            <a href="#" class="del-responsible-btn {{(isset($responsible)? '': 'hidden')}}"><i
                                        class="fa fa-minus-circle fa-2x text-danger" aria-hidden="true"></i></a>
                        </div>
                    </span>
            @endif
        </div>
    </div>
</li>