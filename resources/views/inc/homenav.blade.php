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
				<a class="nav-link active" href="{{url('new-arrrival')}}">
					New Arrival
				</a>
			  </li> 
			  <li class="nav-item">
					<a class="nav-link" href="{{url('about')}}">
						About Us
					</a>
			  </li>
			  <li class="nav-item">
				<a class="nav-link" href="{{url('contact')}}">
					Contact us
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
				@endguest
			</ul>
		</div>
	</div>
</nav>
