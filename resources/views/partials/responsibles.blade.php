<div class="panel panel-default responsibles-table">
    <div class="panel-heading">
        <i class="fa fa-users" aria-hidden="true"></i> Исполнители


        @if(App::make('authentication_helper')->hasPermission(array("_superadmin")) || App::make('authenticator')->getLoggedUser()->id == $entity->author_id)
        <span class="pull-right" style="margin: -4px; width: 30px;">
            <a href="#" id="add_responsible"><i class="fa fa-plus-circle fa-2x" aria-hidden="true"></i></a>
        </span>
        @endif

    </div>
    <ul class="responsibles-table-list list-group">
        @if(isset($responsibles))
            @foreach($responsibles as $index => $responsible)
                @include('partials.responsibles_li', [$responsible, $index])
            @endforeach
        @endif
    </ul>
</div>

@section('custom_js')
    @parent
    <script type="text/javascript">
        $(document).ready(function () {
            // -- ИНИЦИАЛИЗАЦИЯ --

            var token = $('input[name=_token]').val();
            var entity_id = $('#entity_id').val();
            var entity_type = $('#entity_type').val();
            $('.executed_at').datepicker();

            //alert(entity_type);
            //$('.selectpicker').selectpicker();
            //$('.selectpicker').selectpicker('render');

            // -- СОБЫТИЯ --


            $('.responsibles-table-list').on('change', '.status_user', function(e){
                var self = $(e.currentTarget).parents('.list-group-item');
                storeResponsibleUser(self);
            });


            $('.responsibles-table-list').on('changed.bs.select', '.selectpicker', function(e){
                var self = $(e.currentTarget).parents('.list-group-item');

                storeResponsibleUser(self);
            });

            $('.responsibles-table-list').on('change', '.executed_at', function(e){
                var self = $(e.currentTarget).parents('.list-group-item');
                storeResponsibleUser(self);
            });

            // Наэимаем на плюсик для добавления ответсвтенного
            $('#add_responsible').click(function () {
                getResponsibleTpl();
            });

            $('.responsibles-table-list').on('click', '.del-responsible-btn', function (e) {
                if(confirm('Удалить ответственного?')){
                    var self = $(e.currentTarget).parents('.list-group-item');
                    destroyResponsibleUser(self);
                }
            });

            // -- ФУНКЦИИ --

            //Удалить ответственного
            function destroyResponsibleUser(self)
            {
                var rel_id = self.data('responsibleId');
                var url = '{{ route('responsible.destroy') }}';

                var data = {
                    'id': rel_id
                };

                $.ajax({
                    url: url,
                    headers: {'X-CSRF-TOKEN': token},
                    data: data,
                    type: 'POST',
                    success: function (response) {
                        console.log(response);
                        self.remove();
                    },
                    error: function (errors) {
                        console.log(errors);
                    }
                });
            }

            // Сохранение ответственного лица
            function storeResponsibleUser(self)
            {
                var user_id = self.find('select').val();
                var executed_at = self.find('.executed_at').val();
                var status = self.find('input.status_user').prop('checked');

                console.log('Entity ID: ' + entity_id);
                console.log('Entity Type: ' + entity_type);
                console.log('user_id: ' + user_id);
                console.log('executed_at: ' + executed_at);
                console.log('status: ' + status);

                var url = ' {{route('responsible.store') }}';
                var data = {
                    'rel_id': self.data('responsibleId'),
                    'entity_id': entity_id,
                    'entity_type': entity_type,
                    'user_id': user_id,
                    'executed_at': executed_at,
                    'status': status
                };

                $.ajax({
                    url: url,
                    headers: {'X-CSRF-TOKEN': token},
                    data: data,
                    type: 'POST',
                    success: function (response) {
                        console.log(response);
                        self.find('.del-responsible-btn').removeClass('hidden');
                        self.find('.row').animate({ backgroundColor: "#ffffff" }, 400).removeClass('has-error-row');
                        self.data('responsibleId', response.id);
                        console.log(self.data('responsibleId'));
                    },
                    error: function (errors) {
                        console.log(errors);
                    }
                });
            }

            // Запрашиваем шаблон для ответственного
            function getResponsibleTpl() {
                var url = ' {{route('responsible.getResponsibleTpl') }}';
                var countLi = $('.responsibles-table-list').children().length;
                var data = {'countLi': countLi, 'entity_id': entity_id, 'entity_type': entity_type};

                $.ajax({
                    url: url,
                    headers: {'X-CSRF-TOKEN': token},
                    data: data,
                    type: 'POST',
                    success: function (response) {
                        $('.responsibles-table-list').append(response);
                        $('.selectpicker').selectpicker('render');
                        $('.executed_at').datepicker();
                    },
                    error: function (errors) {
                        console.log(errors);
                    }
                });
            }

            $('.responsibles-table-list').on('change', '.selectpicker', function(e){
                var self = e.currentTarget;
                console.log(self);
                $(self).prop('disabled', true);
            });
        });
    </script>
@stop