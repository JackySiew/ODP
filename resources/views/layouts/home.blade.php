<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Online Designer Platform </title>

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('medicio assets/vendor/bootstrap/css/bootstrap.min.css') }}"
        rel="stylesheet">
    <link href="{{ asset('medicio assets/vendor/icofont/icofont.min.css') }}"
        rel="stylesheet">
    <link href="{{ asset('medicio assets/vendor/boxicons/css/boxicons.min.css') }}"
        rel="stylesheet">
    <link href="{{ asset('medicio assets/vendor/animate.css/animate.min.css') }}"
        rel="stylesheet">
    <link
        href="{{ asset('medicio assets/vendor/owl.carousel/assets/owl.carousel.min.css') }}"
        rel="stylesheet">
    <link href="{{ asset('medicio assets/vendor/venobox/venobox.css') }}" rel="stylesheet">
    <link href="{{ asset('medicio assets/vendor/aos/aos.css') }}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ asset('medicio assets/css/style.css') }}" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        ::selection {
            color: #fff;
            background: #007bff;
        }

        ::-webkit-scrollbar {
            width: 3px;
            border-radius: 25px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #ddd;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #ccc;
        }

        .wrapper {
            width: 370px;
            background: #fff;
            border-radius: 5px;
            border: 1px solid lightgrey;
            border-top: 0px;
        }

        .wrapper .title {
            background: #007bff;
            color: #fff;
            font-size: 20px;
            font-weight: 500;
            line-height: 60px;
            text-align: center;
            border-bottom: 1px solid #006fe6;
            border-radius: 5px 5px 0 0;
        }

        .wrapper .form {
            padding: 20px 15px;
            min-height: 400px;
            max-height: 400px;
            overflow-y: auto;
        }

        .wrapper .form .inbox {
            width: 100%;
            display: flex;
            align-items: baseline;
        }

        .wrapper .form .user-inbox {
            justify-content: flex-end;
            margin: 13px 0;
        }

        .wrapper .form .inbox .icon {
            height: 40px;
            width: 40px;
            color: #fff;
            text-align: center;
            line-height: 40px;
            border-radius: 50%;
            font-size: 18px;
            background: #007bff;
        }

        .wrapper .form .inbox .msg-header {
            max-width: 53%;
            margin-left: 10px;
        }

        .form .inbox .msg-header p {
            color: #fff;
            background: #007bff;
            border-radius: 10px;
            padding: 8px 10px;
            font-size: 14px;
            word-break: break-all;
        }

        .form .user-inbox .msg-header p {
            color: #333;
            background: #efefef;
        }

        .wrapper .typing-field {
            display: flex;
            height: 60px;
            width: 100%;
            align-items: center;
            justify-content: space-evenly;
            background: #efefef;
            border-top: 1px solid #d9d9d9;
            border-radius: 0 0 5px 5px;
        }

        .wrapper .typing-field .input-data {
            height: 40px;
            width: 335px;
            position: relative;
        }

        .wrapper .typing-field .input-data input {
            height: 100%;
            width: 100%;
            outline: none;
            border: 1px solid transparent;
            padding: 0 80px 0 15px;
            border-radius: 3px;
            font-size: 15px;
            background: #fff;
            transition: all 0.3s ease;
        }

        .typing-field .input-data input:focus {
            border-color: rgba(0, 123, 255, 0.8);
        }

        .input-data input::placeholder {
            color: #999999;
            transition: all 0.3s ease;
        }

        .input-data input:focus::placeholder {
            color: #bfbfbf;
        }

        .wrapper .typing-field .input-data button {
            position: absolute;
            right: 5px;
            top: 50%;
            height: 30px;
            width: 65px;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            outline: none;
            opacity: 0;
            pointer-events: none;
            border-radius: 3px;
            background: #007bff;
            border: 1px solid #007bff;
            transform: translateY(-50%);
            transition: all 0.3s ease;
        }

        .wrapper .typing-field .input-data input:valid~button {
            opacity: 1;
            pointer-events: auto;
        }

        .typing-field .input-data button:hover {
            background: #006fef;
        }

    </style>
</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="fixed-top">
        <div class="container d-flex align-items-center">
            <h1 class="logo mr-auto"><a href="/">PTS</a></h1>

            <nav class="nav-menu d-none d-lg-block">
                <ul>
                    <li class="active"><a href="/">Home</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="#services">Services</a></li>
                    <li><a href="#roles">Roles</a></li>
                    <li><a href="#request">Request</a></li>
                    <li><a href="#supplier">Supplier</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul>
            </nav><!-- .nav-menu -->

            <a href="{{ route('login') }}" class="appointment-btn scrollto">Login</a>

        </div>
    </header><!-- End Header -->






    <main id="main">

        @yield('content')

    </main>




    <div id="preloader"></div>
    <a href="#" class="back-to-top" style="right: 100px;"><i class="icofont-simple-up"></i></a>


    <script src="{{ asset('medicio assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('medicio assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}">
    </script>
    <script src="{{ asset('medicio assets/vendor/jquery.easing/jquery.easing.min.js') }}">
    </script>
    <script src="{{ asset('medicio assets/vendor/waypoints/jquery.waypoints.min.js') }}">
    </script>
    <script src="{{ asset('medicio assets/vendor/counterup/counterup.min.js') }}"></script>
    <script src="{{ asset('medicio assets/vendor/owl.carousel/owl.carousel.min.js') }}">
    </script>
    <script src="{{ asset('medicio assets/vendor/venobox/venobox.min.js') }}"></script>
    <script src="{{ asset('medicio assets/vendor/aos/aos.js') }}"></script>

    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAphLmTkJdgAd_CuSE18mJFDTMNuFLs9jU&libraries=places&callback=initialize"
        async defer></script>


    <!-- Template Main JS File -->
    <script src="{{ asset('medicio assets/js/main.js') }}"></script>
    
</body>

</html>
