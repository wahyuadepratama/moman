<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta name="author" content="Sumon Rahman">
    <meta name="description" content="">
    <meta name="keywords" content="HTML,CSS,XML,JavaScript">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Title -->
    <title>Moman</title>
    <!-- Place favicon.ico in the root directory -->
    <link rel="apple-touch-icon" href="<?php $this->url('images/favicon.png') ?>">
    <link rel="shortcut icon" href="<?php $this->url('images/favicon.png') ?>" />
    <!-- Plugin-CSS -->
    <link rel="stylesheet" href="<?php $this->url('script/landing/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?php $this->url('script/landing/css/owl.carousel.min.css') ?>">
    <link rel="stylesheet" href="<?php $this->url('script/landing/css/linearicons.css') ?>">
    <link rel="stylesheet" href="<?php $this->url('script/landing/css/magnific-popup.css') ?>">
    <link rel="stylesheet" href="<?php $this->url('script/landing/css/animate.css') ?>">
    <!-- Main-Stylesheets -->
    <link rel="stylesheet" href="<?php $this->url('script/landing/css/normalize.css') ?>">
    <link rel="stylesheet" href="<?php $this->url('script/landing/style.css') ?>">
    <link rel="stylesheet" href="<?php $this->url('script/landing/css/responsive.css') ?>">
    <script src="<?php $this->url('script/landing/js/vendor/modernizr-2.8.3.min.js') ?>"></script>
    <link rel="stylesheet" href="https://unpkg.com/nprogress@0.2.0/nprogress.css">
    <script src="https://unpkg.com/nprogress@0.2.0/nprogress.js" charset="utf-8"></script>
    <link rel="stylesheet" href="https://unpkg.com/nprogress@0.2.0/nprogress.css">
    <!--[if lt IE 9]>
        <script src="//oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body data-spy="scroll" data-target=".mainmenu-area" onload="loading()">
    <!-- Preloader-content -->
    <div class="preloader">
        <span><i class="lnr lnr-sun"></i></span>
    </div>
    <!-- MainMenu-Area -->
    <nav class="mainmenu-area" data-spy="affix" data-offset-top="200">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#primary_menu">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#"><img src="<?php $this->url('images/logo/logo.png') ?>" style="height: 50px"></a>
            </div>
            <div class="collapse navbar-collapse" id="primary_menu">
                <ul class="nav navbar-nav mainmenu" style="text-align: right">
                    <li class="active"><a href="<?php $this->url('') ?>">Home</a></li>
                    <li><a href="<?php $this->url('maps') ?>">Maps</a></li>
                    <li><a href="<?php $this->url('donation') ?>">Donation</a></li>
                    <li><a href="<?php $this->url('qurban') ?>">Qurban</a></li>
                    <?php if (isset($_SESSION['jamaah'])): ?>
                      <?php if ($_SESSION['jamaah'] === true): ?>
                        <li><a href="<?php $this->url('jamaah/dashboard') ?>">Dashboard</a></li>
                      <?php endif; ?>
                    <?php else: ?>
                      <li><a href="<?php $this->url('login') ?>">Login</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
    <!-- MainMenu-Area-End -->
    <!-- Home-Area -->
    <header class="home-area overlay angle" id="home_page">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 hidden-sm col-md-5">
                    <figure class="mobile-image wow fadeInUp" data-wow-delay="0.2s">
                        <img src="<?php $this->url('script/landing/images/header-mobile.png') ?>" alt="">
                    </figure>
                </div>
                <div class="col-xs-12 col-md-7">
                    <div class="space-80 hidden-xs"></div>
                    <h1 class="wow fadeInUp" data-wow-delay="0.4s">Access the Mosque from Anywhere</h1>
                    <div class="space-20"></div>
                    <div class="desc wow fadeInUp" data-wow-delay="0.6s">
                        <p>Moman is application that makes it easy for Muslims to make donations, qurban and find detailed mosque information including locations quickly and accurately.</p>
                    </div>
                    <div class="space-20"></div>
                    <a href="#" style="color:black" class="bttn-white wow fadeInUp" data-wow-delay="0.8s"><i class="lnr lnr-download"></i>Download App</a>
                </div>
            </div>
        </div>
    </header>
    <!-- Home-Area-End -->

    <!-- How-To-Use -->
    <section class="section-padding">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-6">
                    <div class="page-title">
                        <h5 class="title wow fadeInUp" data-wow-delay="0.2s">Our services</h5>
                        <div class="space-10"></div>
                        <h3 class="dark-color wow fadeInUp" data-wow-delay="0.4s">Worship in a Modern Way</h3>
                    </div>
                    <div class="space-20"></div>
                    <div class="desc wow fadeInUp" data-wow-delay="0.6s">
                        <p>We help Muslims to be able to worship more easily. And we help mosque administrators to manage their mosques in a modern way.</p>
                    </div>
                    <div class="space-50"></div>
                    <a href="#" class="bttn-default wow fadeInUp" data-wow-delay="0.8s">Learn More</a>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-5 col-md-offset-1">
                    <div class="space-60 hidden visible-xs"></div>
                    <div class="service-box wow fadeInUp" data-wow-delay="0.2s">
                        <div class="box-icon">
                            <i class="lnr lnr-map-marker"></i>
                        </div>
                        <h4>Responsive Maps</h4>
                        <p>You can find locations, view routes and display all the information you need responsively.</p>

                    </div>
                    <div class="space-50"></div>
                    <div class="service-box wow fadeInUp" data-wow-delay="0.2s">
                        <div class="box-icon">
                            <i class="lnr lnr-users"></i>
                        </div>
                        <h4>Trusted Donation</h4>
                        <p>You can make donations to any mosque. You can even check the location and all the progress of donations in the mosque.</p>
                    </div>
                    <div class="space-50"></div>
                    <div class="service-box wow fadeInUp" data-wow-delay="0.2s">
                        <div class="box-icon">
                            <i class="lnr lnr-select"></i>
                        </div>
                        <h4>Management of The Mosque</h4>
                        <p>Manage mosque activities, transactions and financial transparency very easily.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- How-To-Use-End -->

    <!-- Footer-Area -->
    <footer class="footer-area" id="contact_page">
        <!-- Footer-Bootom -->
        <div class="footer-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-md-12">
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
            <span>Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | Created by Wahyu Ade Pratama with <i class="lnr lnr-heart" aria-hidden="true"></i></span>
            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                        <div class="space-30 hidden visible-xs"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer-Bootom-End -->
    </footer>
    <!-- Footer-Area-End -->
    <!--Vendor-JS-->
    <script src="<?php $this->url('script/landing/js/vendor/jquery-1.12.4.min.js') ?>"></script>
    <script src="<?php $this->url('script/landing/js/vendor/jquery-ui.js') ?>"></script>
    <script src="<?php $this->url('script/landing/js/vendor/bootstrap.min.js') ?>"></script>
    <!--Plugin-JS-->
    <script src="<?php $this->url('script/landing/js/owl.carousel.min.js') ?>"></script>
    <script src="<?php $this->url('script/landing/js/contact-form.js') ?>"></script>
    <script src="<?php $this->url('script/landing/js/ajaxchimp.js') ?>"></script>
    <script src="<?php $this->url('script/landing/js/scrollUp.min.js') ?>"></script>
    <script src="<?php $this->url('script/landing/js/magnific-popup.min.js') ?>"></script>
    <script src="<?php $this->url('script/landing/js/wow.min.js') ?>"></script>
    <!--Main-active-JS-->
    <script src="<?php $this->url('script/landing/js/main.js') ?>"></script>
    <script type="text/javascript">
      function loading() {
        NProgress.configure({ easing: 'ease', speed: 3000 });
        NProgress.configure({ showSpinner: false });
        NProgress.configure({ minimum: 0.9 });
        NProgress.start();
        $(window).on('load', function () {
          NProgress.done();
        });
        // setTimeout(function(){ NProgress.done(); }, 1000);
      }
    </script>
    <style media="screen">
      #nprogress .bar {
        background: #6cbd78cc;
      }
    </style>
</body>

</html>
