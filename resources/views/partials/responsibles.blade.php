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
    <ul class="responsibles-table-list list-group">
        {{--@include('partials.responsibles_li')--}}
    </ul>
</div>


@section('custom_js')
    @parent

    <script type="text/javascript">
        $(document).ready(function () {
            $('.selectpicker').selectpicker({
                size: 4,
                liveSearch: true,
                width: '90%',
                title: 'Выберите из списка'
            });

            $('.execute_at').datepicker();


            // Наэимаем на плюсик для добавления ответсвтенного
            $('#add_responsible').click(function () {

            });


            // Запрашиваем шаблон для ответственного
            function getResponsibleRow() {

                var id = $(this).data('key');
                var url = ' {{route('attachments.geturl') }}';
                var data = {'id': id};

                $.ajax({
                    url: url,
                    headers: {'X-CSRF-TOKEN': token},
                    data: data,
                    type: 'POST',
                    success: function (response) {
                        console.log(response);
                    },
                    error: function (errors) {
                        console.log(errors);
                    }
                });
            }

            $('.responsibles-table-list').on('click', '.add-responsible-btn', function (e) {
                var self = $(e.currentTarget).parents('.list-group-item');
                var entity_id = $('#entity_id').val();
                var entity_type = $('#entity_type').val();
                var user_id = self.find('select').val();
                var status = self.find('input.status_user').val();


                console.log(status);
            });

            $('.responsibles-table-list').on('click', '.del-responsible-btn', function (e) {
                alert('Del');
            });


            // status
            // executed_at


        });
    </script>
@stop