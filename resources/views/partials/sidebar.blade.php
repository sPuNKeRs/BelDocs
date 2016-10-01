<!-- Sidebar -->
      <section id='sidebar'>
        
        <ul id='dock'>
          <li class='{{ Request::path() == '/' ? 'active' : ''}} launcher'>
            <i class='fa fa-dashboard'></i>
            <a href="/">Главная</a>
          </li>
          <li class='launcher dropdown hover {{ Request::is('orders/*') || Request::path() == 'orders' ? 'active' : ''}}'>
            <i class='fa fa-file-text-o'></i>
            <a href="{{ route('orders.index') }}">Приказы</a>            
            <ul class='dropdown-menu'>              
              <li>
                <a href='{{ route('orders.inbox', Request::session()->get('inboxOrderParamSort') ) }}'>Входящие</a>
              </li>
              <li>
                <a href='{{ route('orders.outbox', Request::session()->get('outboxOrderParamSort')) }}'>Исходящие</a>
              </li>              
            </ul>
          </li>
          <li class='launcher dropdown hover {{ Request::is('documents/*') || Request::path() == 'documents' ? 'active' : ''}}'>
            <i class='fa fa-table'></i>
            <a href="{{ route('documents.index') }}">Документы</a>
            <ul class='dropdown-menu'>              
              <li>
                <a href='{{ route('documents.inbox') }}'>Входящие</a>
              </li>
              <li>
                <a href='{{ route('documents.outbox') }}'>Исходящие</a>
              </li>              
            </ul>
          </li>

          @if(App::make('authentication_helper')->hasPermission(array("_superadmin", "_dsp-index")))
          <li class='launcher dropdown hover {{ Request::is('dsp/*') || Request::path() == 'dsp' ? 'active' : ''}}'>
            <i class='fa fa-user-secret'></i>
            <a href="{{ route('dsp.index') }}">ДСП</a>
            <ul class='dropdown-menu'>              
              <li>
                <a href='{{ route('dsp.inbox') }}'>Входящие</a>
              </li>
              <li>
                <a href='{{ route('dsp.outbox') }}'>Исходящие</a>
              </li>              
            </ul>
          </li>   
          @endif

          <li class='launcher {{ Request::is('reports/*') || Request::path() == 'reports' ? 'active' : ''}}'>
            <i class='fa fa-flag'></i>
            <a href='{{ route('reports.index') }}'>Отчеты</a>            
          </li> 
          <li class='launcher {{ Request::is('search/*') || Request::path() == 'search' ? 'active' : ''}}'>
            <i class='fa fa-search'></i>
            <a href='{{ route('search.index') }}'>Поиск</a>
          </li>         
        </ul>
        <div data-toggle='tooltip' id='beaker' title='Made by Amicron'></div>
      </section>