<div id="sidebar-nav" class="sidebar">
  <div class="sidebar-scroll">
    <nav>
      <ul class="nav">
        <li>
          <a href="{{url('designer')}}"  class="{{ 'designer' == request()->path() ? 'active' : ''}}">
            <i class="lnr lnr-home"></i> <span>Dashboard</span>
          </a>
        </li>
        <li>
          <a href="{{url('chatd')}}"  class="{{ 'chatd' == request()->path() ? 'active' : ''}}">
            <i class="fa fa-comments"></i> <span>Chat Room</span>
            @if ('chatd' != request()->path() && count(App\Message::where(['is_read'=>0 , 'to' =>auth()->user()->id])->get()) != 0)
              <span class="badge badge-danger">{{count(App\Message::where(['is_read'=>0 , 'to' =>auth()->user()->id])->get())}}</span>
            @endif
          </a>
        </li>
        <li>
          @if ('orders' == request()->path() ||'tasks' == request()->path())
          <a href="#subPages" data-toggle="collapse" class="active"><i class="lnr lnr-chart-bars"></i> <span>Orders & Customizes</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
          <div id="subPages" class="collapse in">
          @else
          <a href="#subPages" data-toggle="collapse" class="collapsed"><i class="lnr lnr-chart-bars"></i> <span>Orders & Customizes</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
          <div id="subPages" class="collapse ">
          @endif
            <ul class="nav">
               <li><a href="{{url('orders')}}" class="{{ 'orders' == request()->path() ? 'active' : ''}}">Manage Orders</a></li>
               <li><a href="{{url('tasks')}}" class="{{ 'tasks' == request()->path() ? 'active' : ''}}">Manage Customize Tasks</a></li>
            </ul>
          </div>
        </li>
        <li>
          @if ('products' == request()->path() ||'products/create' == request()->path())
          <a href="#subPages2" data-toggle="collapse" class="active"><i class="lnr lnr-chart-bars"></i> <span>My Products</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
          <div id="subPages2" class="collapse in">
          @else
          <a href="#subPages2" data-toggle="collapse" class="collapsed"><i class="lnr lnr-chart-bars"></i> <span>My Products</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
          <div id="subPages2" class="collapse ">
          @endif
            <ul class="nav">
               <li><a href="{{url('products')}}" class="{{ 'products' == request()->path() ? 'active' : ''}}">Manage Product</a></li>
               <li><a href="{{url('products/create')}}" class="{{ 'products/create' == request()->path() ? 'active' : ''}}">Create Product</a></li>
            </ul>
          </div>
        </li>
        {{-- <li>
          <a href="{{url('notification')}}"  class="{{ 'notification' == request()->path() ? 'active' : ''}}">
            <i class="lnr lnr-alarm"></i> <span>Notifications</span>
          </a>
        </li>
        <li>
          <a href="typography.html" class="">
            <i class="lnr lnr-text-format"></i> <span>Typography</span>
          </a>
        </li>
        <li>
          <a href="icons.html" class="">
            <i class="lnr lnr-linearicons"></i> <span>Icons</span>
          </a>
        </li> --}}
      </ul>
    </nav>
  </div>
</div>