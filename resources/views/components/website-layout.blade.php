<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>{{ $title ?? 'Website' }} | Wonder Learning Pvt. Ltd.</title>
<!-- Stylesheets -->
<link href="css/bootstrap.css" rel="stylesheet">
<link href="plugins/revolution/css/settings.css" rel="stylesheet" type="text/css"><!-- REVOLUTION SETTINGS STYLES -->
<link href="plugins/revolution/css/layers.css" rel="stylesheet" type="text/css"><!-- REVOLUTION LAYERS STYLES -->
<link href="plugins/revolution/css/navigation.css" rel="stylesheet" type="text/css"><!-- REVOLUTION NAVIGATION STYLES -->

<link href="css/style.css" rel="stylesheet">
<link href="css/responsive.css" rel="stylesheet">

<link rel="shortcut icon" href="images/logo.png" type="image/x-icon">
<link rel="icon" href="images/logo.png" type="image/x-icon">

<!-- Responsive -->
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<!--[if lt IE 9]><script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script><![endif]-->
<!--[if lt IE 9]><script src="js/respond.js"></script><![endif]-->

<style>
    .header-style-two .top-right .link-box::before {
        content: '';
    }
</style>
</head>

<body>

<div class="page-wrapper">
    <!-- Preloader -->
    <div class="preloader"></div>

    <header class="main-header {{ isset($index) ? 'header-style-two' : '' }}">
        <!-- Header Top -->
        @if(isset($index))
        <div class="header-top">
            <div class="auto-container">
                <div class="clearfix">
                    <div class="top-left">
                        <ul class="info-list clearfix">
                            <li><a href="tel:7264809024"><span class="fa fa-phone-square"></span> 726 480 9024</a></li>
                            <li><a href="mailto:help@wonderlearning.in"><span class="fa fa-envelope"></span>help@wonderlearning.in</a></li>
                        </ul>
                    </div>

                    <div class="top-right">
                        <!-- link Box -->
                        <div class="link-box"><a href="/login">Login</a></div>
                        {{-- <ul class="social-icon-colored row">
                            <li class='col'><a href="#"><span class="fab fa-facebook-f"></span></a></li>
                            <li class='col'><a href="#"><span class="fab fa-twitter"></span></a></li>
                            <li class='col'><a href="#"><span class="fab fa-youtube"></span></a></li>
                        </ul> --}}
                        {{-- <div class="search-box-btn">Search <span class="icon fa fa-search"></span></div> --}}
                    </div>
                </div>
            </div>
        </div>
        <div class="header-lower">
            <div class="auto-container clearfix">
                <!--Info-->
                <div class="logo-outer">
                    <div class="logo"><a href="/"><img style="max-height: 50px;" src="images/logo.png" alt="" title=""></a></div>
                </div>
                <!--Nav Box-->
                <div class="nav-outer clearfix">
                    <!-- Main Menu -->
                    <nav class="main-menu navbar-expand-md navbar-light">
                        <div class="navbar-header">
                            <!-- Toggle Button -->      
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="icon flaticon-menu-button"></span>
                            </button>
                        </div>              
                        <div class="collapse navbar-collapse clearfix" id="navbarSupportedContent">
                            <ul class="navigation clearfix">
                                <li class="{{ (Request::is('/') ? 'current' : '') }}">
                                    <a href="{{url('/')}}">Home</a>
                                    <ul>
                                        <li><a href="/#about-section">About Us</a></li>
                                        <li><a href="#vision-and-mission">Vision & Mission</a></li>
                                    </ul>
                                </li>
                                <li class="{{ (Request::is('programs') ? 'current' : '') }}"><a href="{{ url('/programs')}}">Programs</a></li>
                                <li class="{{ Request::is('services') ? 'current' : '' }}"><a href="services">Services</a>
                                <li class="{{ Request::is('testimonials') ? 'current' : '' }}"><a href='{{ url('testimonials') }}'>Testimonials</a></li>
                                <li class="{{ Request::is('awards') ? 'current' : '' }}"><a href='{{ url('awards') }}'>Awards </a></li>
                                <li class="{{ Request::is('gallery') ? 'current' : '' }}"><a href='{{ url('gallery') }}'>Gallery</a></li>
                                <li class="{{ Request::is('clients') ? 'current' : '' }}"><a href='{{ url('clients') }}'>Clients</a></li>
                                <li class="{{ Request::is('franchise') ? 'current' : '' }}"><a href='{{ url('franchise') }}'>Franchise</a></li>
                                <li class="{{ Request::is('contact-us') ? 'current' : '' }}"><a href='{{ url('contact-us') }}'>Contact us </a></li>
                            </ul>
                        </div>
                    </nav>
                    <!-- Main Menu End-->
                </div>
            </div>
        </div>
        @else
        <div class="header-upper">
            <div class="auto-container">
                <div class="nav-outer clearfix">
                    {{-- <ul class="info-box clearfix">
                        <li><a href="tel:6668880000">666 888 0000 <span class="fa fa-phone-square"></span></a></li>    <li><a href="mailto:info@bebio.com"><span class="fa fa-envelope"></span>info@bebio.com</a></li>
                    </ul> --}}

                    <div class="responsive-logo"><a href="index.html"><img style="max-height: 50px;" src="images/logo.png" alt="" title="Bebio - Kinder Garten HTML Template"></a></div>

                    <!-- Main Menu -->
                    <nav class="main-menu navbar-expand-md navbar-light">
                        <div class="navbar-header">
                            <!-- Togg le Button -->      
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="icon flaticon-menu-button"></span>
                            </button>
                        </div>

                        <div class="collapse navbar-collapse clearfix" id="navbarSupportedContent">
                            <ul class="navigation clearfix">
                                <li class="{{ (Request::is('/') ? 'current' : '') }}">
                                    <a href="{{url('/')}}">Home</a>
                                    <ul>
                                        <li><a href="/#about-section">About Us</a></li>
                                        <li><a href="#vision-and-mission">Vision & Mission</a></li>
                                    </ul>
                                </li>
                                <li class="{{ (Request::is('programs') ? 'current' : '') }}"><a href="{{ url('/programs')}}">Programs</a></li>
                                <li class="{{ Request::is('services') ? 'current' : '' }}"><a href="services">Services</a>
                                <li class="{{ Request::is('testimonials') ? 'current' : '' }}"><a href='{{ url('testimonials') }}'>Testimonials</a></li>
                                <li class="{{ Request::is('awards') ? 'current' : '' }}"><a href='{{ url('awards') }}'>Awards </a></li>
                                <li class="{{ Request::is('gallery') ? 'current' : '' }}"><a href='{{ url('gallery') }}'>Gallery</a></li>
                                <li class="{{ Request::is('clients') ? 'current' : '' }}"><a href='{{ url('clients') }}'>Clients</a></li>
                                <li class="{{ Request::is('franchise') ? 'current' : '' }}"><a href='{{ url('franchise') }}'>Franchise</a></li>
                                <li class="{{ Request::is('contact-us') ? 'current' : '' }}"><a href='{{ url('contact-us') }}'>Contact us</a></li>
                            </ul>
                        </div>
                    </nav>
                    <!-- Main Menu End-->
                </div>
            </div>
        </div>
        <div class="header-lower">
            <div class="auto-container">
                <div class="outer-box">
                    <!-- Option Box -->
                    <div class="option-box">
                        <ul class="clearfix">
                           {{-- <li class="search-box-btn"><span class="icon fa fa-search"></span></li>  --}}
                           <li><a href="mailto:help@wonderlearning.in"><span class="fa fa-envelope"></span></a></li>
                        </ul>
                    </div>

                    <!--Logo-->
                    <div class="logo-outer">
                        <div class="logo"><a href="/"><img style="max-height: 50px;" src="images/logo.png" alt="" title=""></a></div>
                    </div>

                    <ul class="social-icon-colored">
                        <li><a href="#"><span class="fab fa-facebook-f"></span></a></li>
                        {{-- <li><a href="#"><span class="fab fa-twitter"></span></a></li>
                        <li><a href="#"><span class="fab fa-youtube"></span></a></li> --}}
                    </ul>
                </div>
            </div>
        </div>
        @endif

        <!-- Sticky Header  -->
        <div class="sticky-header">
            <div class="auto-container clearfix">
                <!--Logo-->
                <div class="logo pull-left">
                    <a href="index.html" title=""><img src="images/logo.png" style="max-height: 50px;" alt="" title=""></a>
                </div>
                <!--Right Col-->
                <div class="pull-right">
                    <!-- Main Menu -->
                    <nav class="main-menu">
                        <div class="navbar-collapse show collapse clearfix">
                            <ul class="navigation clearfix">
                                <li class="{{ (Request::is('/') ? 'current' : '') }}">
                                    <a href="{{url('/')}}">Home</a>
                                    <ul>
                                        <li><a href="/#about-section">About Us</a></li>
                                        <li><a href="#vision-and-mission">Vision & Mission</a></li>
                                    </ul>
                                </li>
                                <li class="{{ (Request::is('programs') ? 'current' : '') }}"><a href="{{ url('/programs')}}">Programs</a></li>
                                <li class="{{ Request::is('services') ? 'current' : '' }}"><a href="services">Services</a>
                                <li class="{{ Request::is('testimonials') ? 'current' : '' }}"><a href='{{ url('testimonials') }}'>Testimonials</a></li>
                                <li class="{{ Request::is('awards') ? 'current' : '' }}"><a href='{{ url('awards') }}'>Awards </a></li>
                                <li class="{{ Request::is('gallery') ? 'current' : '' }}"><a href='{{ url('gallery') }}'>Gallery</a></li>
                                <li class="{{ Request::is('clients') ? 'current' : '' }}"><a href='{{ url('clients') }}'>Clients</a></li>
                                <li class="{{ Request::is('franchise') ? 'current' : '' }}"><a href='{{ url('franchise') }}'>Franchise</a></li>
                                <li class="{{ Request::is('contact-us') ? 'current' : '' }}"><a href='{{ url('contact-us') }}'>Contact us </a></li>
                            </ul>
                        </div>
                    </nav><!-- Main Menu End-->
                </div>
            </div>
        </div><!-- End Sticky Menu -->
    </header>
    <!-- End Main Header -->
    {{ $slot }}
    <!--Main Footer-->
    <footer class="main-footer">
        <div class="anim-icons">
            <span class="icon icon-sparrow wow zoomIn" data-wow-delay="400ms"></span>
            <span class="icon icon-rainbow-2 wow zoomIn" data-wow-delay="800ms"></span>
            <span class="icon icon-star-3"></span>
            <span class="icon icon-star-3 two"></span>
            <span class="icon icon-sun"></span>
            <span class="icon icon-plane wow zoomIn" data-wow-delay="1200ms"></span>
        </div>

        <!--Scroll to top-->
        <div class="scroll-to-top scroll-to-target" data-target="html"><span class="icon icon-arrow-up"></span></div>

        <!--footer upper-->
        <div class="footer-upper">
            <div class="auto-container">
                <div class="row clearfix">
                    <!--Big Column-->
                    <div class="big-column col-xl-7 col-lg-12 col-md-12 col-sm-12">
                        <div class="row clearfix">
                        
                            <!--Footer Column-->
                            <div class="footer-column col-lg-6 col-md-6 col-sm-12">
                                <div class="footer-widget logo-widget">
                                    <div class="logo">
                                        <a href="/"><img src="images/logo.png" alt="" /></a>
                                    </div>
                                    <div class="text"></div>

                                </div>
                            </div>
                            
                            <!--Footer Column-->
                            <div class="footer-column col-lg-6 col-md-6 col-sm-12">
                                <div class="footer-widget contact-widget text-center text-lg-left">
                                    <h4 class="widget-title">Contact</h4>
                                    <div class="widget-content">
                                        <ul class="contact-info">    
                                            <li><a href="tel:7264809024"><span class="fa fa-phone-square"></span>726 480 9024</a></li>
                                            <li><a href="mailto:support@wonderlearning.in"><span class="fa fa-envelope"></span>support@wonderlearning.in</a></li>
                                            <li><span class="fa fa-map"></span> 
                                                A-13/ 303 Mangal Bhairav Apt.,<br>
                                                Nanded City, Sinhgad Road,<br>
                                                Pune, Maharashtra – 411 041
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!--Big Column-->
                    <div class="big-column col-xl-5 col-lg-12 col-md-12 col-sm-12">
                        <div class="row clearfix">
                            <!--Footer Column-->
                            <div class="footer-column col-xl-6 col-lg-6 col-md-6 col-sm-4">
                                <div class="footer-widget links-widget text-center text-lg-left">
                                    <h4 class="widget-title">Links</h4>
                                    <div class="widget-content">
                                        <ul class="list">
                                            <li><a href="/#about-section">About</a></li>
                                            <li><a href="/contact-us">Contact</a></li>
                                            <li><a href="/gallery">Our Gallery</a></li>
                                            <li><a href="/programs">Programs</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!--Footer Column-->
                            {{-- <div class="footer-column col-xl-4 col-lg-3 col-md-6 col-sm-12">
                                <div class="footer-widget activites-widget">
                                    <h4 class="widget-title">Activities</h4>
                                    <div class="widget-content">
                                        <ul class="list">
                                            <li><a href="#">Table/Floor Toys</a></li>
                                            <li><a href="#">Outdoor Games</a></li>
                                            <li><a href="#">Sand Play</a></li>
                                            <li><a href="#">Play Dough</a></li>
                                            <li><a href="#">Building Blocks</a></li>
                                            <li><a href="#">Water Play</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div> --}}

                            <!--Footer Column-->
                            <div class="footer-column col-xl-6 col-lg-6 col-md-12 col-sm-12">
                                <div class="footer-widget newsletter-widget text-center text-lg-left">
                                    <h4 class="widget-title">Newsletter</h4>
                                    <div class="newsletter-form">
                                        <form method="post" action="contact.html">
                                            <div class="form-group">
                                                <input type="email" name="email" value="" placeholder="Enter Your Email" required="">
                                                <button type="submit" class="theme-btn btn-style-one">Subscribe</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Footer Bottom-->
        <div class="footer-bottom">
            <div class="auto-container">
                <ul class="social-icon-colored">
                    <li><a href="#"><span class="fab fa-facebook-f"></span></a></li>
                    <li><a href="#"><span class="fab fa-twitter"></span></a></li>
                    <li><a href="#"><span class="fab fa-youtube"></span></a></li>
                </ul>
                <div class="copyright"> Copyrights &copy; {{ date('Y') }} Wonder Learning Pvt. Ltd. </div>
            </div>
        </div>
    </footer>
    <!--End Main Footer-->

</div>
<!--End pagewrapper-->


<!--Search Popup-->
{{-- <div id="search-popup" class="search-popup">
    <div class="close-search theme-btn"><span class="fa fa-times"></span></div>
    <div class="popup-inner">
        <div class="overlay-layer"></div>
        <div class="search-form">
            <form method="post" action="index.html">
                <div class="form-group">
                    <fieldset>
                        <input type="search" class="form-control" name="search-input" value="" placeholder="Search Here" required >
                        <input type="submit" value="Search Now!" class="theme-btn">
                    </fieldset>
                </div>
            </form>
            
            <br>
            <h3>Recent Search Keywords</h3>
            <ul class="recent-searches">
                <li><a href="#">Business</a></li>
                <li><a href="#">Web Development</a></li>
                <li><a href="#">SEO</a></li>
                <li><a href="#">Logistics</a></li>
                <li><a href="#">Freedom</a></li>
            </ul>
        
        </div>
        
    </div>
</div> --}}


<script src="js/jquery.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<!--Revolution Slider-->
<script src="plugins/revolution/js/jquery.themepunch.revolution.min.js"></script>
<script src="plugins/revolution/js/jquery.themepunch.tools.min.js"></script>
<script src="plugins/revolution/js/extensions/revolution.extension.actions.min.js"></script>
<script src="plugins/revolution/js/extensions/revolution.extension.carousel.min.js"></script>
<script src="plugins/revolution/js/extensions/revolution.extension.kenburn.min.js"></script>
<script src="plugins/revolution/js/extensions/revolution.extension.layeranimation.min.js"></script>
<script src="plugins/revolution/js/extensions/revolution.extension.migration.min.js"></script>
<script src="plugins/revolution/js/extensions/revolution.extension.navigation.min.js"></script>
<script src="plugins/revolution/js/extensions/revolution.extension.parallax.min.js"></script>
<script src="plugins/revolution/js/extensions/revolution.extension.slideanims.min.js"></script>
<script src="plugins/revolution/js/extensions/revolution.extension.video.min.js"></script>
<script src="js/main-slider-script.js"></script>
<!--Revolution Slider-->
<script src="js/jquery-ui.js"></script>
<script src="js/jquery.fancybox.js"></script>
<script src="js/owl.js"></script>
<script src="js/jquery.countdown.js"></script>
<script src="js/wow.js"></script>
<script src="js/appear.js"></script>
<script src="js/validate.js"></script>
<script src="js/parallax.min.js"></script>
<script src="js/script.js"></script>
<!--Google Map APi Key-->
{{-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDcaOOcFcQ0hoTqANKZYz-0ii-J0aUoHjk"></script>
<script src="js/map-script.js"></script> --}}
<!--End Google Map APi-->
</body>
</html>