@extends('layouts.app')
@section('title')
   Home Page
@endsection

@section('top')
    fixed-top
@endsection

@section('extra-css')
  <link href="{{ asset('homepage_assets/css/style.css') }}" rel="stylesheet">
@endsection

@section('content')
<div id="carouselExampleInterval" class="carousel slide carousel-fade" data-ride="carousel">
  <div class="carousel-inner">
    @php $i = 1; @endphp
    @foreach ($sliders as $slider)
    <div class="carousel-item {{$i == '1' ? 'active':''}}" data-interval="5000">
      @php $i++;  @endphp
      <img src="{{asset('storage/slide/'.$slider->image)}}" class="d-block" width="100%" height="600" alt="Slider Image">
      <div class="carousel-caption d-none d-md-block bg-dark mb-5">
        <h1>{{$slider->heading}}</h1>
        <p>{!!$slider->description!!}</p>
        <a href="{{$slider->link}}" >{{$slider->link_name}}</a>
      </div>
    </div>
    @endforeach
  </div>
  <a class="carousel-control-prev" href="#carouselExampleInterval" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleInterval" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
<br>


<!-- ======= About Us Section ======= -->
  <section id="about" class="about">
    <div class="container" data-aos="fade-up">
        <div class="section-title">
          <h2 class="text-center">About Online Designer Platform</h2>
              <p>Online Designer Platform is designed on a web-based system and provides customers and designers with a functioning
               website to find/upload their design product into well-organized system.</p>
          </div>

          <div class="row">
              <div class="col-lg-6" data-aos="fade-right">
                  <img src="{{ asset('img/design.jfif') }}" class="img-fluid"
                      alt="">
              </div>
              <div class="col-lg-6 pt-4 pt-lg-0 content" data-aos="fade-left">
                  <h3>System Objective</h3>
                      <i class="icofont-check-circled"></i> Provide a platform for freelance designers to facilitate promotio. <br>
                      <i class="icofont-check-circled"></i> Convenient for customers to find a suitable designers and communicate. <br>
                      <i class="icofont-check-circled"></i> Provide a working space for users/designers. <br>
              </div>
          </div>

      </div>
  </section><!-- End About Us Section -->

<br>
<br>
  <!-- ======= Services Section ======= -->
  <section id="services" class="services services">
      <div class="container" data-aos="fade-up">

          <div class="section-title">
              <h2>Services</h2>
              <p>The following services are tailor-made for designers and customers.
              </p>
          </div>

          <div class="row">
              <div class="col-lg-4 col-md-6 icon-box" data-aos="zoom-in" data-aos-delay="100">
                  <div class="icon"><i class="fa fa-area-chart"></i></div>
                  <h4 class="title"><a href="">Record Monthly Sales</a></h4>
                  <p class="description">Designer can view their monthly sales in this system.</p>
              </div>
              <div class="col-lg-4 col-md-6 icon-box" data-aos="zoom-in" data-aos-delay="200">
                  <div class="icon"><i class="fa fa-check-square"></i></div>
                  <h4 class="title"><a href="">View ordering status</a></h4>
                  <p class="description">Customers can view their ordering status in this system.</p>
              </div>
              <div class="col-lg-4 col-md-6 icon-box" data-aos="zoom-in" data-aos-delay="300">
                  <div class="icon"><i class="fa fa-tasks"></i></div>
                  <h4 class="title"><a href="">Customize Request</a></h4>
                  <p class="description">Customers can make a customize request task to make a special 
                      unique design product and send to designer to design it.</p>
              </div>
              <div class="col-lg-4 col-md-6 icon-box" data-aos="zoom-in" data-aos-delay="100">
                  <div class="icon"><i class="fa fa-weixin"></i></div>
                  <h4 class="title"><a href="">Chat Room</a></h4>
                  <p class="description">THe system designers and customers can chatting with each other
                      in this system.</p>
              </div>
              <div class="col-lg-4 col-md-6 icon-box" data-aos="zoom-in" data-aos-delay="200">
                  <div class="icon"><i class="fa fa-clipboard"></i></div>
                  <h4 class="title"><a href="">Provide bidding</a></h4>
                  <p class="description">This system provide customers to make a bidding events to designers in this system.
                  </p>
              </div>
          </div>

      </div>
  </section><!-- End Services Section -->
<br>
<br>
  <!-- ======= Featured Services Section ======= -->
  <section id="roles" class="featured-services">
      <div class="container aos-init aos-animate" data-aos="fade-up">
          <div class="section-title">
              <h2>Roles</h2>
              <p>The following are the main roles listed in this system and what they can do.</p>
          </div>

          <div class="row">
              <div class="col-md-6 col-lg-4 d-flex align-items-stretch mb-5 mb-lg-0">
                  <div class="icon-box" data-aos="fade-up" data-aos-delay="100">
                      <div class="icon"><i class="fa fa-users"></i></div>
                      <h4 class="title"><a href="/#featured-services">Customers</a></h4>
                      <p class="description">
                          <i class="icofont-check-circled"></i>Buy product 
                          <i class="icofont-check-circled"></i>View the ordering status
                          <i class="icofont-check-circled"></i>Make customize request tasks
                          <i class="icofont-check-circled"></i>View designer information
                          <i class="icofont-check-circled"></i>Chat with designer
                      </p>
                  </div>
              </div>

              <div class="col-md-6 col-lg-4 d-flex align-items-stretch mb-5 mb-lg-0">
                  <div class="icon-box" data-aos="fade-up" data-aos-delay="200">
                      <div class="icon"><i class="fa fa-user-circle"></i></div>
                      <h4 class="title"><a href="">Designer</a></h4>
                      <p class="description">
                          <i class="icofont-check-circled"></i>View monthly sales
                          <i class="icofont-check-circled"></i>Upload product
                          <i class="icofont-check-circled"></i>Update ordering status
                          <i class="icofont-check-circled"></i>Chat with customers
                      </p>
                  </div>
              </div>

              <div class="col-md-6 col-lg-4 d-flex align-items-stretch mb-5 mb-lg-0">
                  <div class="icon-box" data-aos="fade-up" data-aos-delay="300">
                      <div class="icon"><i class="fa fa-user-circle-o"></i></div>
                      <h4 class="title"><a href="">Administrator</a></h4>
                      <p class="description">
                          <i class="icofont-check-circled"></i>Manage user's account
                          <i class="icofont-check-circled"></i>Manage advertising system
                          <i class="icofont-check-circled"></i>Respond feedback
                      </p>
                  </div>
              </div>

          </div>

      </div>
  </section><!-- End Featured Services Section -->


  <!-- ======= Contact Section ======= -->
  <section id="contact" class="contact">
      <div class="container">

          <div class="section-title">
              <h2>Contact</h2>
              <p>We would be delighted to respond to your enquiries, please feel free to drop us a line using the
                  phone or email us.</p>
          </div>

      </div>
      <div class="container">

          <div class="row mt-5">

              <div class="col-lg-12">

                  <div class="row">
                      <div class="col-md-12">
                          <div class="info-box">
                              <i class="bx bx-map"></i>
                              <h3>Address</h3>
                              <p>No.108A, Jalan Kemudiaan, Taman Universiti, 81300 Skudai, Johor</p>
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="info-box mt-4">
                              <i class="bx bx-envelope"></i>
                              <h3>Email</h3>
                              <p>jackysiew99@gmail.com</p>
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="info-box mt-4">
                              <i class="bx bx-phone-call"></i>
                              <h3>Call Us</h3>
                              <p>+60 12 799 0762</p>
                          </div>
                      </div>
                  </div>

              </div>


          </div>

      </div>
  </section><!-- End Contact Section -->


</div>

@endsection

@section('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script src="{{ asset('homepage_assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('homepage_assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('homepage_assets/vendor/jquery.easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('homepage_assets/vendor/waypoints/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('homepage_assets/vendor/counterup/counterup.min.js') }}"></script>
    <script src="{{ asset('homepage_assets/vendor/owl.carousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('homepage_assets/vendor/venobox/venobox.min.js') }}"></script>
    <script src="{{ asset('homepage_assets/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('homepage_assets/js/main.js') }}"></script>
@endsection