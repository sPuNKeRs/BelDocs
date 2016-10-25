<?php
  if(!isset($count)) $count = 0;
  if(!isset($report_param)) $report_param = array('entite_type'=>'Приказы');
?>
<div class="panel panel-default grid">
  <div class="panel-heading">
    <i class='fa fa-table fa-lg'></i> Результат
    <div class="panel-tools">
      <a class="btn pull-right" data-toggle="toolbar-tooltip" href="#" title="" data-original-title="Печать отчета">
                  <i class="fa fa-print fa-lg" aria-hidden="true"></i>
      </a>
      <div class="badge"><b>Кол-во:</b> {{$count}}</div>
      <div class="badge"><b>За период:</b> с <b>10.10.2016</b> по <b>20.10.2016</b></div>
      <div class="badge"><b>Тип:</b> {{$report_param['entite_type']}}</div>


    </div>
  </div>
  <table class="table table-condensed">
    <thead>
      <tr>
        <th>#</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Username</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>1</td>
        <td>Mark</td>
        <td>Otto</td>
        <td>@mdo</td>
      </tr>
      <tr>
        <td>2</td>
        <td>Jacob</td>
        <td>Thornton</td>
        <td>@fat</td>
      </tr>
      <tr>
        <td>3</td>
        <td>Larry</td>
        <td>the Bird</td>
        <td>@twitter</td>
      </tr>
    </tbody>
  </table>
</div>