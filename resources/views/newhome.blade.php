@extends('layouts.home')

@section('content')
<!-- ======= Hero Section ======= -->
<section id="hero">
    <div id="heroCarousel" class="carousel slide carousel-fade" data-ride="carousel">

        <ol class="carousel-indicators" id="hero-carousel-indicators"></ol>

        <div class="carousel-inner" role="listbox">

            <!-- Slide 1 -->
            <div class="carousel-item active"
                style="background-image: url('{{ asset('medicio assets/img/slide/slide-1.jpg') }}');">
                <div class="container">
                    <h2>Welcome to use Patient Tracking System</h2>
                    <p>Welcome to the Patient Tracking System. Before using this system, please make sure that your
                        personal account has been registered by your doctor in charge. Thank you for your attention.</p>
                    <a href="#about" class="btn-get-started scrollto">Read More</a>
                </div>
            </div>

            <!-- Slide 2 -->
            <div class="carousel-item"
                style="background-image: url('{{ asset('medicio assets/img/slide/slide-2.jpg') }}');">
                <div class="container">
                    <h2>Record Daily Health Index</h2>
                    <p>Through this system, users can record their various health indexes on a daily basis and can use
                        this to judge their health status.</p>
                    <a href="#about" class="btn-get-started scrollto">Read More</a>
                </div>
            </div>

            <!-- Slide 3 -->
            <div class="carousel-item"
                style="background-image: url('{{ asset('medicio assets/img/slide/slide-3.jpg') }}');">
                <div class="container">
                    <h2>Monitor Patient Health Status</h2>
                    <p>Through the user's health index records, the doctors in charge can more easily communicate their
                        suggestions and the corresponding follow-up time and date through this system.</p>
                    <a href="#about" class="btn-get-started scrollto">Read More</a>
                </div>
            </div>

        </div>

        <a class="carousel-control-prev" href="#heroCarousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon icofont-simple-left" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>

        <a class="carousel-control-next" href="#heroCarousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon icofont-simple-right" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>

    </div>
</section><!-- End Hero -->


<main id="main">

    <!-- ======= About Us Section ======= -->
    <section id="about" class="about">
        <div class="container" data-aos="fade-up">

            <div class="section-title">
                <h2>About Patient Tracking System</h2>
                <p>Patient tracking system is designed on a web-based system and provides doctors with a functioning
                    website to manage all their chronic patients into a well-organized system. This system focuses on
                    small and medium clinics.</p>
            </div>

            <div class="row">
                <div class="col-lg-6" data-aos="fade-right">
                    <img src="{{ asset('medicio assets/img/about.jpg') }}" class="img-fluid"
                        alt="">
                </div>
                <div class="col-lg-6 pt-4 pt-lg-0 content" data-aos="fade-left">
                    <h3>System Objective</h3>
                    <ul>
                        <li><i class="icofont-check-circled"></i> Chronic patients can more easily record their daily
                            blood pressure index, etc. without handwriting.</li>
                        <li><i class="icofont-check-circled"></i> Convenient for doctors to arrange more appropriate
                            follow-up consultation time to the chronic patients.</li>
                        <li><i class="icofont-check-circled"></i> Increase doctors' control over the situation of
                            chronic patients through the daily health index that provided by the chronic patient.</li>
                        <li><i class="icofont-check-circled"></i> Convenient for chronic patients to find a suitable
                            medical equipment supplier by using this system platform.</li>

                    </ul>
                </div>
            </div>

        </div>
    </section><!-- End About Us Section -->


    <!-- ======= Services Section ======= -->
    <section id="services" class="services services">
        <div class="container" data-aos="fade-up">

            <div class="section-title">
                <h2>Services</h2>
                <p>The following services are tailor-made for patients with chronic diseases and their doctor in charge.
                </p>
            </div>

            <div class="row">
                <div class="col-lg-4 col-md-6 icon-box" data-aos="zoom-in" data-aos-delay="100">
                    <div class="icon"><i class="icofont-heart-beat"></i></div>
                    <h4 class="title"><a href="">Record Daily Health Index</a></h4>
                    <p class="description">Patient can record their daily health index in this system.</p>
                </div>
                <div class="col-lg-4 col-md-6 icon-box" data-aos="zoom-in" data-aos-delay="200">
                    <div class="icon"><i class="icofont-drug"></i></div>
                    <h4 class="title"><a href="">View advice</a></h4>
                    <p class="description">Patient can view the advice that provided by their doctor in charge in this
                        system.</p>
                </div>
                <div class="col-lg-4 col-md-6 icon-box" data-aos="zoom-in" data-aos-delay="300">
                    <div class="icon"><i class="icofont-heartbeat"></i></div>
                    <h4 class="title"><a href="">View date of follow-up visit</a></h4>
                    <p class="description">Patient can view the date of follow-up visit that provided by their doctor in
                        charge in this system.</p>
                </div>
                <div class="col-lg-4 col-md-6 icon-box" data-aos="zoom-in" data-aos-delay="100">
                    <div class="icon"><i class="icofont-heart-beat"></i></div>
                    <h4 class="title"><a href="">View medical equipment supplier</a></h4>
                    <p class="description">Patient can view the medical equipment supplier information in this system.
                    </p>
                </div>
                <div class="col-lg-4 col-md-6 icon-box" data-aos="zoom-in" data-aos-delay="200">
                    <div class="icon"><i class="icofont-drug"></i></div>
                    <h4 class="title"><a href="">Provide advice</a></h4>
                    <p class="description">Doctor can provide their advice to their patient in charge in this system.
                    </p>
                </div>
                <div class="col-lg-4 col-md-6 icon-box" data-aos="zoom-in" data-aos-delay="300">
                    <div class="icon"><i class="icofont-heartbeat"></i></div>
                    <h4 class="title"><a href="">Provide the date of follow-up visit</a></h4>
                    <p class="description">Doctor can provide the date of follow-up visit to their patient in charge in
                        this system.</p>
                </div>
            </div>

        </div>
    </section><!-- End Services Section -->

    <!-- ======= Featured Services Section ======= -->
    <section id="roles" class="featured-services">
        <div class="container aos-init aos-animate" data-aos="fade-up">
            <div class="section-title">
                <h2>Roles</h2>
                <p>The following are the main roles listed in this system and what they can do.</p>
            </div>

            <div class="row">
                <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0">
                    <div class="icon-box" data-aos="fade-up" data-aos-delay="100">
                        <div class="icon"><i class="icofont-heart-beat"></i></div>
                        <h4 class="title"><a href="/#featured-services">Chronic Patient</a></h4>
                        <p class="description">
                            <i class="icofont-check-circled"></i>Record Daily Health Index
                            <i class="icofont-check-circled"></i>View the advice
                            <i class="icofont-check-circled"></i>View date of follow-up visit
                            <i class="icofont-check-circled"></i>View supplier information
                        </p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0">
                    <div class="icon-box" data-aos="fade-up" data-aos-delay="200">
                        <div class="icon"><i class="icofont-drug"></i></div>
                        <h4 class="title"><a href="">Doctor</a></h4>
                        <p class="description">
                            <i class="icofont-check-circled"></i>View patient health index
                            <i class="icofont-check-circled"></i>Provide advice
                            <i class="icofont-check-circled"></i>Provide date of follow-up visit
                        </p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0">
                    <div class="icon-box" data-aos="fade-up" data-aos-delay="300">
                        <div class="icon"><i class="icofont-thermometer-alt"></i></div>
                        <h4 class="title"><a href="">Supplier</a></h4>
                        <p class="description">
                            <i class="icofont-check-circled"></i>Provide personal supplier information request
                            <i class="icofont-check-circled"></i>View personal supplier request status
                        </p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0">
                    <div class="icon-box" data-aos="fade-up" data-aos-delay="400">
                        <div class="icon"><i class="icofont-heartbeat"></i></div>
                        <h4 class="title"><a href="">Administrator</a></h4>
                        <p class="description">
                            <i class="icofont-check-circled"></i>Manage user account
                            <i class="icofont-check-circled"></i>Manage doctor personal information
                            <i class="icofont-check-circled"></i>Manage patient personal information
                            <i class="icofont-check-circled"></i>Manage supplier request status
                        </p>
                    </div>
                </div>

            </div>

        </div>
    </section><!-- End Featured Services Section -->

    <!-- ======= Appointment Section ======= -->
    <section id="request" class="appointment section-bg">
        <div class="container" data-aos="fade-up">

            <div class="section-title">
                <h2>Make an Supplier Request</h2>
                <p>Did you want your supplier information shown in our system? Please provide your details information
                    to us for verify your location.</p>
            </div>
            @if(session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <form action="/supplier-create" method="POST" role="form" class="php-email-form" data-aos="fade-up"
                data-aos-delay="100" enctype="multipart/form-data">
                {{ csrf_field() }}

                <div class="form-row">
                    <div class="col-md-3 form-group">
                        @error('supplier_name')
                            <label class="form-group" style="color: #e83f3f;">{{ $message }}</label>
                        @enderror
                        <input type="text" name="supplier_name" class="form-control" placeholder="Supplier Name"
                            value="{{ old('supplier_name') }}">
                    </div>

                    <div class="col-md-3 form-group">
                        @error('supplier_phone')
                            <label class="form-group" style="color: #e83f3f;">{{ $message }}</label>
                        @enderror
                        <input type="text" name="supplier_phone" class="form-control" placeholder="Supplier Phone"
                            value="{{ old('supplier_phone') }}">
                    </div>

                    <div class="col-md-3 form-group">
                        @error('supplier_email')
                            <label class="form-group" style="color: #e83f3f;">{{ $message }}</label>
                        @enderror
                        <input type="email" name="supplier_email" class="form-control" placeholder="Supplier Email"
                            value="{{ old('supplier_email') }}">
                    </div>
                    <div class="col-md-3 form-group">
                        @error('photo')
                            <label class="form-group" style="color: #e83f3f;">{{ $message }}</label>
                        @enderror
                        <input type="file" name="photo" class="form-control @error('photo') is-invalid @enderror" placeholder="Supplier Photo" value="{{ old('photo') }}">
                    </div>
                </div>


                <div class="form-group">
                    @error('supplier_address')
                        <label class="form-group" style="color: #e83f3f;">{{ $message }}</label>
                    @enderror
                    <input id="searchInput" class="form-control" type="text" placeholder="Please insert your location">
                </div>


                <div class="form-group">
                    <div class="map" id="map" style="width: 100%; height: 600px;"></div>
                </div>


                <div class="form-group">
                    @error('supplier_description')
                        <label class="form-group" style="color: #e83f3f;">{{ $message }}</label>
                    @enderror
                    <textarea rows="4" cols="80" class="form-control" placeholder="Please insert your description"
                        name="supplier_description">{{ old('supplier_description') }}</textarea>
                </div>


                <input type="hidden" name="supplier_address" id="location">
                <input type="hidden" name="address_latitude" id="lat">
                <input type="hidden" name="address_longitude" id="lng">
                <input type="hidden" name="status" class="form-control" placeholder="Supplier Status" value="Pending">

                <div class="text-center"><button type="submit">Make a Supplier Request</button></div>
            </form>

        </div>
    </section><!-- End Appointment Section -->

    <!-- ======= Testimonials Section ======= -->
    <section id="supplier" class="testimonials">
        <div class="container" data-aos="fade-up">

            <div class="section-title">
                <h2>Supplier</h2>
                <p>The following medical equipment supplier information is the supplier that has been certified and
                    accepted by the administrator. After 5 working days if your information has not been registered on
                    this system, please make sure that your personal supplier information is correct and resubmit your
                    request again in this system.
                </p>
            </div>

            <div class="owl-carousel testimonials-carousel" data-aos="fade-up" data-aos-delay="100">
                {{-- @foreach($suppliers as $supplier)
                    <div class="testimonial-item" style="font-style: normal;">
                        <p>
                            Address: {{ $supplier->supplier_address }} <br /><br />
                            Description: {{ $supplier->supplier_description }}
                        </p>
                        <img src="/storage/supplier_images/{{ $supplier->supplier_photo }}"
                            class="testimonial-img" alt="">
                        <h3>{{ $supplier->supplier_name }}</h3>
                        <h4>{{ $supplier->supplier_phone }} </h4>
                        <h4>{{ $supplier->supplier_email }} </h4>
                    </div>
                @endforeach --}}
            </div>

        </div>
    </section><!-- End Testimonials Section -->

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
                                <h3>Our Address</h3>
                                <p>No.47 Jalan Kemuliaan 37, Taman Universiti, 81300 Skudai, Johor</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box mt-4">
                                <i class="bx bx-envelope"></i>
                                <h3>Email Us</h3>
                                <p>eoss01@outlook.com</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box mt-4">
                                <i class="bx bx-phone-call"></i>
                                <h3>Call Us</h3>
                                <p>+60 13 701 9419</p>
                            </div>
                        </div>
                    </div>

                </div>


            </div>

        </div>
    </section><!-- End Contact Section -->

</main><!-- End #main -->

@endsection