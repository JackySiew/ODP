<nav class="navbar navbar-expand-md navbar-light @yield('top') bg-warning shadow-sm">
	<div class="container">
		<a class="navbar-brand" href="#">
			Online Designer Platform
		</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<!-- Left Side Of Navbar -->
			<ul class="navbar-nav mr-auto">
			  <li class="nav-item">
				<a class="nav-link" href="{{url('all-products')}}">
					Products
				</a>
			  </li> 
			  <li class="nav-item">
					<a class="nav-link" href="{{url('designers')}}">
						Designers
					</a>
			  </li>
			  <li class="nav-item">
				<a class="nav-link" href="{{url('chat')}}">
					Chat Room
				</a>
			  </li>
			</ul>

			<!-- Right Side Of Navbar -->
			<ul class="navbar-nav ml-auto">
				<!-- Authentication Links -->
				@guest
					<li class="nav-item">
						<a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
					</li>
					@if (Route::has('register'))
						<li class="nav-item">
							<a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
						</li>
					@endif
				@else
				<li class="nav-item">
				  <a class="nav-link" href="{{url('cart')}}">
					<i class="fa fa-shopping-cart fa-lg" aria-hidden="true"></i> 
					@if (Cart::session(auth()->id())->getContent()->count())
					<span class="badge badge-secondary">
					  {{Cart::session(auth()->id())->getContent()->count()}}
					</span>   
					@endif
				  </a>
				</li>      
				<li class="nav-item dropdown">
				  <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false" v-pre>
					<i class="fa fa-bell fa-lg"></i>
					@if (auth()->user()->unreadNotifications->count())
					<span class="badge badge-secondary">{{count(auth()->user()->unreadNotifications)}}</span>
					@endif
				  </a>
				  <ul class="dropdown-menu" role="menu">
					  <a href="{{url('allRead')}}" class="dropdown-item" style="color: green;">#Mark all as read</a>
					@foreach (auth()->user()->unreadNotifications as $notification)
					  <a href="#" class="dropdown-item text-danger">{{$notification->data['Action']}}</a>
					@endforeach                                              
					@foreach (auth()->user()->readNotifications()->take(4)->get() as $notification)
					<a href="#" class="dropdown-item">{{$notification->data['Action']}}</a>
					@endforeach                                              
				  </ul>
				</li>
					<li class="nav-item dropdown">
						<a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
							{{ Auth::user()->name }}
						</a>

						<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
							<a class="dropdown-item" href="{{url('my-profile')}}">
								My profile
							   </a>  
							   <a class="dropdown-item" href="{{url('my-orders')}}">
								Orders & Customize request
							   </a>  
									<a class="dropdown-item" href="{{ route('logout') }}"
							   onclick="event.preventDefault();
											 document.getElementById('logout-form').submit();">
								{{ __('Logout') }}
							</a>

							<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
								@csrf
							</form>
						</div>
					</li>
				@endguest
			</ul>
		</div>
	</div>
</nav>
