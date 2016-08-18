<?php
    $users_opt = [];
?>

<div class="panel panel-default responsibles-table">
    <div class="panel-heading">


        <i class="fa fa-users" aria-hidden="true"></i> Исполнители

        <span class="pull-right" style="margin: -4px; width: 30px;">
            <a href="#"><i class="fa fa-plus-circle fa-2x" aria-hidden="true"></i></a>
        </span>


    </div>


    <ul class="list-group">

        <li class="list-group-item">

            <div class="row">
                <div class="col-md-4">
                    <i class="fa fa-user fa-2x" aria-hidden="true"></i>    {{ Form::select('sel', $users_opt, null, ['class' => 'selectpicker', 'style'=>'width: 100%;']) }}
                </div>
                <div class="col-md-3">
                    @include('widgets.form._formitem_text', ['name' => 'executed_at', 'class' => 'execute_at form-control' , 'value' => date('d.m.Y', strtotime($entity->create_date)), 'placeholder' => '01.01.2016', 'describedby' => 'basic-addon1'])

                </div>
                <div class="col-md-3 text-right">
                    @include('widgets.form._formitem_checkbox', ['name'=>'status_user',
                                                                    'title'=> 'Статус',
                                                                    'value'=> '1',
                                                                    'id' => 'status_user',
                                                                    'class' => 'custom checkbox',
                                                                    'left' => null])
                </div>
                <div class="col-md-2">
                    <span class="pull-right" style="margin: 6px -2px 0px 0; width: 30px;">
            <a href="#"><i class="fa fa-minus-circle fa-2x text-danger" aria-hidden="true"></i></a>
        </span>
                </div>
            </div>


        </li>
    </ul>
</div>


@section('custom_js')
    @parent

    <script type="text/javascript">
        $(document).ready(function(){

            $('.selectpicker').selectpicker({
                size: 4,
                liveSearch: true,
                width: '90%'
            });


            $('.execute_at').datepicker();
        });
    </script>
@stop