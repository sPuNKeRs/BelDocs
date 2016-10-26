<div class="panel panel-default grid">
  <div class="panel-heading">
    <i class='fa fa-table fa-lg'></i> Результат
    <div class="panel-tools">
      <a class="btn pull-right" data-toggle="toolbar-tooltip" href="#" title="" data-original-title="Печать отчета">
                  <i class="fa fa-print fa-lg" aria-hidden="true"></i>
      </a>
      <div class="badge"><b>Кол-во:</b> {{count($entitys)}}</div>
      <div class="badge"><b>За период:</b> с <b>{{date('d.m.Y', strtotime($from_date))}}</b> по <b>{{date('d.m.Y', strtotime($by_date))}}</b></div>
      <div class="badge"><b>Тип:</b> {{$entity_type}}</div>


    </div>
  </div>
  <table class="table table-condensed">
    <thead>
      <tr>
        <th width="5%">Тип</th>
        <th width="5%">№</th>
        <th width="5%">Н.Н.</th>
        <th width="10%">Дата создания</th>
        <th width="10%">Отправитель / Получатель</th>
        <th width="10%">Тема</th>
        <th width="35%">Резолюция</th>
        <th width="10%">Исполнить до</th>
        <th width="10%">Статус</th>
      </tr>
    </thead>
    <tbody>
    @foreach($entitys as $entity)
      <tr>
        <td>{{ReportsHelper::typeToName($entity)}}</td>
        <td>{{$entity->entity_num}}</td>
        <td>{{ (isset($entity->item_number)) ? $entity->item_number->item_number : '---' }}</td>
        <td>{{date('d.m.Y', strtotime($entity->create_date))}}</td>
        <td>{{ (isset($entity->sender)) ? $entity->sender->sender : '---' }}</td>
        <td>{{$entity->title}}</td>
        <td>{{$entity->resolution}}</td>
        <td>{{date('d.m.Y', strtotime($entity->execute_date))}}</td>
        <td>{{(($entity->status == 1)) ? 'Выполнено' : 'Не выполено' }}</td>
      </tr>
    @endforeach
    </tbody>
  </table>
</div>