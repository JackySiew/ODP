<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Online Designer Platform | @yield('title') </title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">    
    @yield('extra-css')
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light @yield('top') bg-warning shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
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

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        <li class="nav-item">
                            <a class="nav-link" href="{{url('cart')}}"><i class="fa fa-shopping-cart fa-lg" aria-hidden="true"></i> Shopping Cart <span class="badge badge-secondary">{{Session::has('cart') ? Session::get('cart')->totalQty : ''}}</span></a>
                        </li>          
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
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                  <a class="dropdown-item" href="{{url('my-orders')}}">
                                  My Order
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

        <main class="py-4 mb-5">
            <div class="@yield('class')">
                @yield('content')
            </div>
        </main>
    </div>
<!-- Load Facebook SDK for JavaScript -->
<div id="fb-root"></div>
<script>
  window.fbAsyncInit = function() {
    FB.init({
      xfbml            : true,
      version          : 'v8.0'
    });
  };

  (function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<!-- Your Chat Plugin code -->
<div class="fb-customerchat"
  attribution=setup_tool
  page_id="107178994448866"
logged_in_greeting="Hello! How can we help you?"
logged_out_greeting="Hello! How can we help you?">
</div>
          <!-- Footer -->
          <footer class="page-footer font-small bg-dark text-white pt-4 mt-5">

            <!-- Footer Links -->
            <div class="container-fluid text-center text-md-left">
          
              <!-- Grid row -->
              <div class="row">
          
                <!-- Grid column -->
                <div class="col-md-6 mt-md-0 mt-3">
          
                  <!-- Content -->
                  <h5 class="text-uppercase">More About</h5>
                  <p>Try to know more about Onliine Designer Platform</p>
          
                </div>
                <!-- Grid column -->
          
                <hr class="clearfix w-100 d-md-none pb-3">
          
                <!-- Grid column -->
                <div class="col-md-3 mb-md-0 mb-3">
          
                  <!-- Links -->
                  <h5 class="text-uppercase">About</h5>
          
                  <ul class="list-unstyled">
                    <li>
                      <a href="#!">Online Designer Platform</a>
                    </li>
                    <li>
                      <a href="#!">Products</a>
                    </li>
                    <li>
                      <a href="#!">Contact</a>
                    </li>
                    <li>
                      <a href="#!"></a>
                    </li>
                  </ul>
          
                </div>
                <!-- Grid column -->
          
                <!-- Grid column -->
                <div class="col-md-3 mb-md-0 mb-3">
          
                  <!-- Links -->
                  <h5 class="text-uppercase">Follow Us</h5>
          
                  <ul class="list-unstyled">
                    <li>
                      <a href="#!">Facebook</a>
                    </li>
                    <li>
                      <a href="#!">Instagram</a>
                    </li>
                    <li>
                      <a href="#!">Twitter</a>
                    </li>
                    <li>
                      <a href="#!">WhatsApp</a>
                    </li>
                  </ul>
          
                </div>
                <!-- Grid column -->
          
              </div>
              <!-- Grid row -->
          
            </div>
            <!-- Footer Links -->
          
            <!-- Copyright -->
            <div class="footer-copyright text-center py-3">© 2020 Copyright:
            <a href="{{url('/')}}">odp.test</a>
              {{-- <a href="https://mdbootstrap.com/"> MDBootstrap.com</a> --}}
            </div>
            <!-- Copyright -->
          
        </footer>
        <!-- Footer -->
        

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>    
    @yield('scripts')
</body>
</html>
