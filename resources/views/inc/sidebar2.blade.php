<div id="sidebar-nav" class="sidebar">
  <div class="sidebar-scroll">
    <nav>
      <ul class="nav">
        <li>
          <a href="{{url('admin')}}"  class="{{ 'admin' == request()->path() ? 'active' : ''}}">
            <i class="lnr lnr-home"></i> <span>Dashboard</span>
          </a>
        </li>
        <li>
          @if ('aorders' == request()->path() || 'atasks' == request()->path() || 'report' == request()->path() )
          <a href="#subPages" data-toggle="collapse" class="active"><i class="lnr lnr-chart-bars"></i> <span>Sales Report</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
          <div id="subPages" class="collapse in">
          @else
          <a href="#subPages" data-toggle="collapse" class="collapsed"><i class="lnr lnr-chart-bars"></i> <span>Sales Report</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
          <div id="subPages" class="collapse">
          @endif
            <ul class="nav">
              <li>
                <a href="{{url('report')}}" class="{{ 'report' == request()->path() ? 'active' : ''}}"><span>Search Report</span></a>
              </li>      
               <li><a href="{{url('aorders')}}" class="{{ 'aorders' == request()->path() ? 'active' : ''}}">Manage Orders</a></li>
               <li><a href="{{url('atasks')}}" class="{{ 'atasks' == request()->path() ? 'active' : ''}}">Manage Customize Tasks</a></li>
            </ul>
          </div>
        </li>
        <li>
          <a href="{{url('chata')}}" class="{{ 'chata' == request()->path() ? 'active' : ''}}">
            <i class="fa fa-comments"></i> <span>Chat Room</span>
            @if ('chatd' != request()->path() && count(App\Message::where(['is_read'=>0 , 'to' =>auth()->user()->id])->get()) != 0)
            <span class="badge badge-danger">{{count(App\Message::where(['is_read'=>0 , 'to' =>auth()->user()->id])->get())}}</span>
          @endif

          </a>
        </li>
        <li>
          <a href="{{url('prodlist')}}" class="{{ 'prodlist' == request()->path() ? 'active' : ''}}"><i class="fa fa-list"></i> <span>Product Lists</span></a>
        </li>
        <li>
          @if ('categories' == request()->path() || 'categories/create' == request()->path())
          <a href="#subPages2" data-toggle="collapse" class="active"><i class="lnr lnr-chart-bars"></i> <span>Category List</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
          <div id="subPages2" class="collapse in">
          @else
          <a href="#subPages2" data-toggle="collapse" class="collapsed"><i class="lnr lnr-chart-bars"></i> <span>Category List</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
          <div id="subPages2" class="collapse">
          @endif
          <ul class="nav">
            <li>
              <a href="{{url('categories')}}" class="{{ 'categories' == request()->path() ? 'active' : ''}}"><span>Manage Categories</span></a>
            </li>      
             <li><a href="{{route('categories.create')}}" class="{{ 'categories/create' == request()->path() ? 'active' : ''}}">Create Category</a></li>
          </ul>
          </div>
        </li>
        <li>
          <a href="{{url('slider')}}" class="{{ 'slider' == request()->path() ? 'active' : ''}}"><i class="fa fa-clone"></i> <span>Sliders</span></a>
        </li>
        <li>
          <a href="{{url('users')}}" class="{{ 'users' == request()->path() ? 'active' : ''}}"><i class="fa fa-users"></i> <span>User Lists</span></a>
        </li>
      </ul>
    </nav>
  </div>
</div>