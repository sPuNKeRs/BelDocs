<li class="list-group-item">
    <div class="row">
        <div class="col-md-4">
            <i class="fa fa-user fa-2x" aria-hidden="true"></i>    {{ Form::select('sel',
                                                                                    \App\User::getArrayOptions(),
                                                                                    null,
                                                                                    ['class' => 'selectpicker']) }}
        </div>
        <div class="col-md-3">
            @include('widgets.form._formitem_text', ['name' => 'executed_at',
                                                        'class' => 'execute_at form-control',
                                                        'value' => date('d.m.Y', strtotime($entity->create_date)),
                                                        'placeholder' => '01.01.2016',
                                                        'describedby' => 'basic-addon1'])

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
                    <span class="pull-right" style="margin: 6px -2px 0px 0; width: 57px;">
                        <div style="width: 55px;">
                            <a href="#" class="add-responsible-btn"><i class="fa fa-check-circle fa-2x" aria-hidden="true"></i></a>
                            <a href="#" class="del-responsible-btn"><i class="fa fa-minus-circle fa-2x text-danger" aria-hidden="true"></i></a>
                        </div>

        </span>
        </div>
    </div>
</li>