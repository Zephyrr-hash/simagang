<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <meta content="" name="descriptison">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{ asset('assets/img/sim-green-hat.png') }}" rel="icon">
    <link href="{{ asset('assets/img/sim-green-hat.png') }}" rel="sim-vertical-blue">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/icofont/icofont.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/venobox/venobox.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/owl.carousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

    <!-- Template Main CSS File -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

    <!-- =======================================================
    * Template Name: Lumia - v2.1.0
    * Template URL: https://bootstrapmade.com/lumia-bootstrap-business-template/
    * Author: BootstrapMade.com
    * License: https://bootstrapmade.com/license/
    ======================================================== -->
</head>

<body>

  <!-- ======= Header ======= -->
    <header id="header" class="fixed-top d-flex align-items-center">
        <div class="container d-flex align-items-center">

        <div class="logo mr-auto ">
            <!-- <h1><a href="index.html"> SIMagang</a></h1> -->
            <!-- Uncomment below if you prefer to use an image logo -->
            <a href="index.html"><img src="{{ asset('assets/img/sim-green.png') }}" alt="" class="img-fluid p-3"></a>
        </div>

        <nav class="nav-menu d-none d-lg-block">
            <ul>
            <li><a href="{{ route('profile.index') }}">Dashboard</a></li>
            <li><a href="contact">Contact Us</a></li>
            @guest
                @if (Route::has('login'))
                <li><a href="{{ route('login') }}" ><i class="icofont-logout"></i>Log In</a></li>
                @endif
            @endguest
            </ul>
        </nav><!-- .nav-menu -->

        </div>
    </header><!-- End Header -->
    @include('flash-message')
    @yield('konteng')
    <footer id="footer">
        <div class="footer-top">
            <div class="container">
                <div class="row">
                <div class="col-lg-3 col-md-6 footer-contact">
                    <h3>SIMagang</h3>
                    <p>
                    Jalan Sekip <br>
                    Yogyakarta<br>
                    Indonesia <br><br>
                    <strong>Phone:</strong> +62 821 37057694<br>
                    <strong>Email:</strong> simagang@gmail.com<br>
                    </p>
                </div>
                <div class="col-lg-2 col-md-6 footer-links">
                    <h4>Lowongan Favorit</h4>
                    <ul>
                    <li><i class="bx bx-chevron-right"></i> <a href="#">Web Developer</a></li>
                    <li><i class="bx bx-chevron-right"></i> <a href="#">Graphic Design</a></li>
                    <li><i class="bx bx-chevron-right"></i> <a href="#">Android Developer</a></li>
                    <li><i class="bx bx-chevron-right"></i> <a href="#">Data Analayst</a></li>
                    <li><i class="bx bx-chevron-right"></i> <a href="#">UI Designer</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6 footer-links">
                    <h4>Perusahaan Favorit</h4>
                    <ul>
                    <li><i class="bx bx-chevron-right"></i> <a href="#">Web Design</a></li>
                    <li><i class="bx bx-chevron-right"></i> <a href="#">Web Development</a></li>
                    <li><i class="bx bx-chevron-right"></i> <a href="#">Product Management</a></li>
                    <li><i class="bx bx-chevron-right"></i> <a href="#">Marketing</a></li>
                    <li><i class="bx bx-chevron-right"></i> <a href="#">Graphic Design</a></li>
                    </ul>
                </div>
                </div>
            </div>
        </div>
        <div class="container d-md-flex py-4">
            <div class="mr-md-auto text-center text-md-left">
                <div class="copyright">
                &copy; Copyright <strong><span>SIMagang</span></strong>. All Rights Reserved
                </div>
                <div class="credits">
                Designed by <a href="#">SIM</a>
                </div>
            </div>
            <div class="social-links text-center text-md-right pt-3 pt-md-0">
                <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
                <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
                <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
                <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
                <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
            </div>
        </div>
    </footer><!-- End Footer -->
    <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>
    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery.easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>
    <script src="{{ asset('assets/vendor/waypoints/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/counterup/counterup.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/venobox/venobox.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/owl.carousel/owl.carousel.min.js') }}"></script>
    <!-- Template Main JS File -->
    <script src="{{ asset('assets/js/main.js') }}"></script>
    </body>
    </html>

