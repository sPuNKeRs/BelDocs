<div class="panel panel-default grid">
  <div class="panel-heading">
    <i class='fa fa-table fa-lg'></i> Результат
    <div class="panel-tools">
      <a class="btn pull-right" data-toggle="toolbar-tooltip" href="#" title="" data-original-title="Печать отчета">
                  <i class="fa fa-print fa-lg" aria-hidden="true"></i>
      </a>
      <div class="badge"><b>Кол-во:</b> {{count($entitys)}}</div>
      <div class="badge"><b>За период:</b> с <b>{{$from_date}}</b> по <b>{{$by_date}}</b></div>
      <div class="badge"><b>Тип:</b> {{$entity_type}}</div>


    </div>
  </div>
  <table class="table table-condensed">
    <thead>
      <tr>
        <th width="5%">№</th>
        <th width="10%">Н. н.</th>
        <th width="20%">Тема</th>
        <th width="45%">Резолюция</th>
        <th width="10%">Исполнить до</th>
        <th width="10%">Статус</th>
      </tr>
    </thead>
    <tbody>
    @foreach($entitys as $entity)
      <tr>
        <td>{{$entity->entity_num}}</td>
        <td>{{$entity->entity_num}}</td>
        <td>{{$entity->title}}</td>
        <td>{{$entity->resolution}}</td>
        <td>{{$entity->execute_date}}</td>
        <td>{{(($entity->status == 1)) ? 'Выполнено' : 'Не выполено' }}</td>
      </tr>
    @endforeach
    </tbody>
  </table>
</div>