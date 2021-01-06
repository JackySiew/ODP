<!-- NAVBAR -->
@if (auth()->user()->usertype == 'admin')
<nav class="navbar navbar-default navbar-fixed-top" style="background-color: cyan;">

@else
<nav class="navbar navbar-default navbar-fixed-top" style="background-color: yellow;">

@endif
	<div class="brand">
	<a href="{{url('designer')}}"><img src="{{asset('assets/img/odp.png')}}" alt="ODP Logo" class="img-responsive logo"></a>
	</div>
	<div class="container-fluid">
		<div class="navbar-btn">
			<button type="button" class="btn-toggle-fullwidth"><i class="lnr lnr-arrow-left-circle"></i></button>
		</div>
		<form class="navbar-form navbar-left">
			<div class="input-group">
				<input type="text" value="" class="form-control" placeholder="Search dashboard...">
				<span class="input-group-btn"><button type="button" class="btn btn-primary">Go</button></span>
			</div>
		</form>
		<div class="navbar-btn navbar-btn-right">
			<a class="btn btn-success update-pro" href="https://www.themeineed.com/downloads/klorofil-pro-bootstrap-admin-dashboard-template/?utm_source=klorofil&utm_medium=template&utm_campaign=KlorofilPro" title="Upgrade to Pro" target="_blank"><i class="fa fa-rocket"></i> <span>UPGRADE TO PRO</span></a>
		</div>
		<div id="navbar-menu">
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
					<a href="#" class="dropdown-toggle icon-menu" data-toggle="dropdown">
						<i class="lnr lnr-alarm"></i>
						@if(auth()->user()->unreadNotifications->count())
						<span class="badge bg-danger">{{count(auth()->user()->unreadNotifications)}}</span>
						@endif
					</a>
					<ul class="dropdown-menu notifications">
						<li class="notification-item">
                            <a href="{{url('allRead')}}" style="color: green;">#Mark all as read</a>
                        </li>                
						@foreach (auth()->user()->unreadNotifications()->get() as $notification)
						<li class="notification-item">
						  <a href="#" style="color:red;">{{$notification->data['Action']}}</a>
						</li>
						@endforeach       
						
						@foreach (auth()->user()->readNotifications()->take(4)->get() as $notification)
						<li class="notification-item">
						  <a href="#">{{$notification->data['Action']}}</a>
						</li>
						@endforeach                                              
					</ul>
				</li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="lnr lnr-question-circle"></i> <span>Help</span> <i class="icon-submenu lnr lnr-chevron-down"></i></a>
					<ul class="dropdown-menu">
						<li><a href="#">Basic Use</a></li>
						<li><a href="#">Working With Data</a></li>
						<li><a href="#">Security</a></li>
						<li><a href="#">Troubleshooting</a></li>
					</ul>
				</li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src="{{url('storage/image/'.Auth::user()->profile)}}" class="img-circle" alt="Avatar"> <span>{{ Auth::user()->name }}</span> <i class="icon-submenu lnr lnr-chevron-down"></i></a>
					<ul class="dropdown-menu">
						<li>
							@if (auth()->user()->usertype == 'designer')
								<a href="{{url('profile')}}"><i class="lnr lnr-user"></i> <span>My Profile</span></a>	
							@else
								<a href="{{url('aprofile')}}"><i class="lnr lnr-user"></i> <span>My Profile</span></a>		
							@endif
						</li>
						<li><a href="#"><i class="lnr lnr-envelope"></i> <span>Message</span></a></li>
						<li><a href="#"><i class="lnr lnr-cog"></i> <span>Settings</span></a></li>
						<li>
							<a class="dropdown-item text-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
								<i class="lnr lnr-exit"></i> <span>Logout</span>
							</a>
							<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
								{{ csrf_field() }}
							</form>
						</li>
					</ul>
				</li>
				<!-- <li>
					<a class="update-pro" href="https://www.themeineed.com/downloads/klorofil-pro-bootstrap-admin-dashboard-template/?utm_source=klorofil&utm_medium=template&utm_campaign=KlorofilPro" title="Upgrade to Pro" target="_blank"><i class="fa fa-rocket"></i> <span>UPGRADE TO PRO</span></a>
				</li> -->
			</ul>
		</div>
	</div>
</nav>
<!-- END NAVBAR -->