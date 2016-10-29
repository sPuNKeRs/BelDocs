<div class="panel panel-default grid">
  <div class="panel-heading">
    <i class='fa fa-table fa-lg'></i> Результат поиска
    <div class="panel-tools">
      <!--<a class="btn pull-right" data-toggle="toolbar-tooltip" href="#" title="" data-original-title="Печать"  onclick="print()">
                  <i class="fa fa-print fa-lg" aria-hidden="true"></i>
      </a>-->
      <div class="badge"><b>Кол-во:</b> {{count($search_results)}}</div>
    </div>
  </div>

  <!--Карточка вывода результата - начало-->
  @foreach($search_results as $item)
  <div class="search-item">
    <div class="row">
      <div class="col-md-2 text-center">
        <i class='fa fa-pencil-square-o fa-4x'></i><br>
        <b>Тип:</b> {{ReportsHelper::typeToName($item)}}<hr>
        <b>Дата создания</b> {{date('d.m.Y', strtotime($item->create_date))}}<br><br>
        <b>Выполнить до</b> {{date('d.m.Y', strtotime($item->execute_date))}}
      </div>

      <div class="col-md-10">
         <div class="row">
          <div class="col-md-3"><h5>№{{$item->entity_num}} {{ (isset($item->item_number)) ? '('.$item->item_number->item_number.')' : '' }}</h5></div>
          <div class="col-md-9 text-justify"><h4>{{$item->title}}</h4></div>
        </div>
        <hr>
        <div class="row">
          <div class="col-md-12 text-justify">
            {!!$item->description!!}
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-md-12 text-justify">
            <b>Резолюция</b><br>
            {!!$item->resolution!!}
          </div>
        </div>
      </div>
    </div>
  </div>
  @endforeach
  <!--Карточка вывода результата - конец-->


</div>