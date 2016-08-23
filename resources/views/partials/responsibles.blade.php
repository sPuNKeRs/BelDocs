<?php
    $users_opt = [];
?>

<div class="panel panel-default responsibles-table">
    <div class="panel-heading">
        <i class="fa fa-users" aria-hidden="true"></i> Исполнители
        <span class="pull-right" style="margin: -4px; width: 30px;">
            <a href="#" id="add_responsible"><i class="fa fa-plus-circle fa-2x" aria-hidden="true"></i></a>
        </span>
    </div>
    <ul class="responsibles-table-list list-group ">
        @include('partials.responsibles_li')
    </ul>
</div>


@section('custom_js')
    @parent

    <script type="text/javascript">
        $(document).ready(function(){




            $('.responsibles-table-list').on('click','.add-responsible-btn', function(){
                alert('Hello');
            });

            // entity_id
            // user_id
            // entity_type
            // status
            // executed_at




            $('.selectpicker').selectpicker({
                size: 4,
                liveSearch: true,
                width: '90%',
                title: 'Выберите из списка'
            });


            $('.execute_at').datepicker();
        });
    </script>
@stop