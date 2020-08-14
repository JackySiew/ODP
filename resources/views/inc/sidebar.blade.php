<div class="sidebar" data-color="yellow">
    <div class="logo">
      <a href="http://www.creative-tim.com" class="simple-text logo-mini">
        CT
      </a>
      <a href="http://www.creative-tim.com" class="simple-text logo-normal">
        Creative Tim
      </a>
    </div>
    <div class="sidebar-wrapper" id="sidebar-wrapper">
      <ul class="nav">
      <li class="{{ 'designer' == request()->path() ? 'active' : ''}}">
          <a href="/designer">
            <i class="now-ui-icons design_app"></i>
            <p>Dashboard</p>
          </a>
        </li>
        <li class="{{ 'profile' == request()->path() ? 'active' : ''}}">
          <a href="/profile">
            <i class="now-ui-icons users_single-02"></i>
            <p>User Profile</p>
          </a>
        </li>
        <li class="{{ 'users' == request()->path() ? 'active' : ''}}">
          <a href="/users">
            <i class="now-ui-icons users_single-02"></i>
            <p>Users</p>
          </a>
        </li>
        <li class="{{ 'products' == request()->path() ? 'active' : ''}}">
          <a href="/products">
            <i class="now-ui-icons design_bullet-list-67"></i>
            <p>Product List</p>
          </a>
        </li>
        <li>
          <a href="./notifications.html">
            <i class="now-ui-icons ui-1_bell-53"></i>
            <p>Notifications</p>
          </a>
        </li>
        <li>
          <a href="./typography.html">
            <i class="now-ui-icons text_caps-small"></i>
            <p>Typography</p>
          </a>
        </li>
        <li class="active-pro">
          <a href="./upgrade.html">
            <i class="now-ui-icons arrows-1_cloud-download-93"></i>
            <p>Upgrade to PRO</p>
          </a>
        </li>
      </ul>
    </div>
  </div>
