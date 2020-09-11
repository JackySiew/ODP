<div class="sidebar" data-color="red">
    <div class="logo text-center">
      <a href="{{url('admin')}}" class="simple-text logo-normal">
        Online Designer Platform
      </a>
    </div>
    <div class="sidebar-wrapper" id="sidebar-wrapper">
      <ul class="nav">
      <li class="{{ 'admin' == request()->path() ? 'active' : ''}}">
          <a href="{{url('admin')}}">
            <i class="now-ui-icons design_app"></i>
            <p>Dashboard</p>
          </a>
        </li>
        <li class="{{ 'users' == request()->path() ? 'active' : ''}}">
          <a href="{{url('users')}}">
            <i class="fa fa-users"></i>
            <p>All users</p>
          </a>
        </li>
        <li class="{{ 'aprofile' == request()->path() ? 'active' : ''}}">
          <a href="{{url('aprofile')}}">
            <i class="now-ui-icons users_single-02"></i>
            <p>My Profile</p>
          </a>
        </li>
        <li class="{{ 'prodlist' == request()->path() ? 'active' : ''}}">
          <a href="{{url('prodlist')}}">
            <i class="now-ui-icons design_bullet-list-67"></i>
            <p>Product List</p>
          </a>
        </li>
        <li class="{{ 'aorders' == request()->path() ? 'active' : ''}}">
          <a href="{{url('aorders')}}">
            <i class="now-ui-icons design_bullet-list-67"></i>
            <p>Order List</p>
          </a>
        </li>
        <li class="{{ 'chatting' == request()->path() ? 'active' : ''}}">
          <a href="chatting">
            <i class="fa fa-comment"></i>
            <p>Chatting Room</p>
          </a>
        </li>
      </ul>
    </div>
  </div>
