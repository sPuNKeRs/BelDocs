<!-- Sidebar -->
      <section id='sidebar'>
        
        <ul id='dock'>
          <li class='{{ Request::path() == '/' ? 'active' : ''}} launcher'>
            <i class='fa fa-dashboard'></i>
            <a href="/">Главная</a>
          </li>
          <li class='launcher dropdown hover {{ Request::is('orders/*') || Request::path() == 'orders' ? 'active' : ''}}'>
            <i class='fa fa-file-text-o'></i>
            <a href="/orders">Приказы</a>            
            <ul class='dropdown-menu'>              
              <li>
                <a href='#'>Входящие</a>
              </li>
              <li>
                <a href='#'>Исходящие</a>
              </li>              
            </ul>
          </li>
          <li class='launcher dropdown hover {{ Request::is('documents/*') || Request::path() == 'documents' ? 'active' : ''}}'>
            <i class='fa fa-table'></i>
            <a href="/documents">Документы</a>
            <ul class='dropdown-menu'>              
              <li>
                <a href='#'>Входящие</a>
              </li>
              <li>
                <a href='#'>Исходящие</a>
              </li>              
            </ul>
          </li>
          <li class='launcher {{ Request::is('dsp/*') || Request::path() == 'dsp' ? 'active' : ''}}'>
            <i class='fa fa-user-secret'></i>
            <a href='dsp'>ДСП</a>
          </li> 

          <li class='launcher dropdown hover {{ Request::is('reports/*') || Request::path() == 'reports' ? 'active' : ''}}'>
            <i class='fa fa-flag'></i>
            <a href='/reports'>Отчеты</a>
            <ul class='dropdown-menu'>              
              <li>
                <a href='#'>Отчет 1</a>
              </li>
              <li>
                <a href='#'>Отчет 2</a>
              </li>
              <li>
                <a href='#'>Отчет 3</a>
              </li>
            </ul>
          </li> 
          <li class='launcher {{ Request::is('search/*') || Request::path() == 'search' ? 'active' : ''}}'>
            <i class='fa fa-search'></i>
            <a href='search'>Поиск</a>
          </li>         
        </ul>
        <div data-toggle='tooltip' id='beaker' title='Made by Amicron'></div>
      </section>