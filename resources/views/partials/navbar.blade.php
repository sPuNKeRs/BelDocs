<!-- Navbar -->
<div class='navbar navbar-default' id='navbar'>
  <a class='navbar-brand' href='/'>
    <i class='fa fa-beer'></i>
    {!!Config::get('acl_base.app_name')!!}
  </a>
  <ul class='nav navbar-nav pull-right'>    
    <li class='dropdown user'>
      <a class='dropdown-toggle' data-toggle='dropdown' href='#'>
        <i class='fa fa-user'></i>
        <strong>{!! $logged_user->user_profile()->first()->last_name.' '.$logged_user->user_profile()->first()->first_name !!}</strong>
        @include('partials.avatar')
        <b class='caret'></b>
      </a>
      <ul class='dropdown-menu'>
        <li>
          <a href='/admin/users/profile/self'>Мой профиль</a>
        </li>
        <li class='divider'></li>
        <li>
          <a href='admin/users/dashboard'>
            <i class='fa fa-cog'></i>
            Настройки
          </a>
        </li>
        <li class='divider'></li>
        <li>
          <a href="/user/logout">Выход</a>
        </li>
      </ul>
    </li>
  </ul>
</div>