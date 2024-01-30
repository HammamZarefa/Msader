<!DOCTYPE html >
<!--[if lt IE 7 ]>
<html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]>
<html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]>
<html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html class="no-js" lang="en" @if(session()->get('rtl') == 1) dir="rtl" @endif >
<!--<![endif]-->
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <!--[if IE]>
    <meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'/>
    <![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    @include('partials.seo')

    <link rel="stylesheet" type="text/css"
          href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700;800&family=Poppins:wght@500;600;700&display=swap">
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" type="text/css" href="{{asset($themeTrue.'css/jquery-ui.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset($themeTrue.'css/bootstrap.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset($themeTrue.'css/all.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset($themeTrue.'css/icofont.min.css')}}"/>
    @stack('extra-style')
    <link rel="stylesheet" type="text/css" href="{{asset($themeTrue.'css/animate.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset($themeTrue.'css/owl.carousel.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset($themeTrue.'css/owl.theme.default.min.css')}}"/>

    <link rel="stylesheet"
          href="{{asset($themeTrue.'css/color.php')}}?primaryColor={{config('color.primaryColor')}}&subheading={{config('color.subheading')}}&bggrdleft={{config('color.bggrdleft')}}&bggrdright={{config('color.bggrdright')}}&bggrdleft2={{config('color.bggrdleft2')}}&btngrdleft={{config('color.btngrdleft')}}&copyrights={{config('color.copyrights')}}">

    @stack('style')

    <script src="{{asset('assets/global/js/modernizr.custom.js')}}"></script>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
<!-- whatsapp -->
<a href="https://wa.me/" target="_blank" class="whatsapp">
    <div class="whatsapp-bg">
            <span>
                <i class="fab fa-whatsapp"></i>
            </span>
    </div>
    <div class="drops">
        <div class="drop1"></div>
        <div class="drop2"></div>
    </div>
</a>
<svg xmlns="http://www.w3.org/2000/svg" version="1.1" style="position: absolute;z-index: -1;">
    <defs>
        <filter id="liquid">
            <feGaussianBlur in="SourceGraphic" stdDeviation="10" result="blur"/>
            <feColorMatrix in="blur" mode="matrix" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 18 -7"
                           result="liquid"/>
        </filter>
    </defs>
</svg>
<!-- whatsapp-end -->
<!-- preloader -->
<div id="preloader">
    <ul>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
    </ul>
</div>
<div id="sidebar" class="sidebar">
    <div id="sidebar-btn" class="sidebar-logo m-auto">
        <a href="index.html"> <img class="w-50" style="cursor: pointer;" src="assets/img/logo/logo-icon.png" alt=""></a>
    </div>
    <div class="sidebar-icon">
        <ul>
            <li class="active">
                <a href="index.html" class="icon"><i class="fi-sr-home"></i></a>
                <a href="index.html" class="name-link">لوحة التحكم</a>
            </li>
            <li>
                <a href="services.html" class="icon"><i class="fi-sr-apps-delete"></i></a>
                <a href="services.html" class="name-link">الباقات</a>
            </li>
            <li>
                <a href="orders.html" class="icon"><i class="fi-sr-butterfly"></i></a>
                <a href="orders.html" class="name-link">طلباتي</a>
            </li>
            <li>
                <a href="blog.html" class="icon"><i class="fi-sr-camping"></i></a>
                <a href="blog.html" class="name-link">المقالات</a>
            </li>
            <li>
                <a href="Add_Fund.html" class="icon"><i class="fi-sr-crown"></i></a>
                <a href="Add_Fund.html" class="name-link">شحن رصيد</a>
            </li>
            <li>
                <a href="orders.html" class="icon"><i class="fi-sr-database"></i></a>
                <a href="orders.html" class="name-link">دفعاتي</a>
            </li>
            <li>
                <a href="orders.html" class="icon"><i class="fi-sr-book-alt"></i></a>
                <a href="orders.html" class="name-link">المعاملات</a>
            </li>
            <li>
                <a href="#" class="icon"><i class="fi-sr-credit-card"></i></a>
                <a href="#" class="name-link">بطاقة الدعم</a>
            </li>
            <li>
                <button style="--clr:#e039fd" class="btn-sideBar"><span>أنقر</span><i></i></button>
            </li>
            <!-- <li>
                <a href="#" class="icon"><i class="fi-sr-user"></i></a>
                <a href="#" class="name-link">alaamhna3354</a>
            </li> -->
        </ul>
    </div>
</div>
<!-- preloader-end -->
<div class="overlay"></div>
<!-- main-content -->
<div class="main-content p-0">
    <header>
        <div class="menu-area">
            <div class="container">
                <div class="mobile-nav-toggler"><i class="fas fa-bars"></i></div>
                <div class="menu-wrap">
                    <nav class="menu-nav">
                        <div class="logo d-flex d-md-none m-auto"><a href="index.html"><img src="assets/img/logo/logo.png" alt=""></a></div>
                        <div class="navbar-wrap main-menu d-flex d-md-none" style="flex-grow: 0;">
                            <ul class="navigation">
                                <li>
                                    <i class="fi-sr-bell-ring"></i>
                                    <strong>0.00</strong>
                                </li>
                            </ul>
                        </div>
                        <div class="navbar-wrap main-menu d-none d-lg-flex">
                            <ul class="navigation">
                                <li><a href="">الرئيسية</a></li>
                                <li><a href="">المقالات</a></li>
                                <li><a href="">من نحن</a></li>
                                <li><a href="">تواصل معنا </a></li>

                                <li class="active d-none d-lg-flex">
                                    <a href="index.html" class="logo m-0"><img src="assets/img/logo/logo.png" alt=""></a>
                                </li>
                                <li class=" menu-item-has-children">
                                    <a href="#" style="font-size: 20px;">
                                        <i class="fi-sr-user"></i>
                                    </a>
                                    <ul class="submenu">
                                        <li><a href="profile.html"><i class="fi-sr-settings m-1"></i> My Profile</a></li>
                                        <li><a href="#"><i class="fi-sr-database m-1"></i> My Referral</a></li>
                                        <li><a href="#"><i class="fi-sr-crown m-1"></i> Referral Bonus</a></li>
                                        <li><a href="#"><i class="fi-sr-credit-card m-1"></i> Open Ticket</a></li>
                                        <li><a href="#"><i class="fi-sr-credit-card m-1"></i> Show Ticket</a></li>
                                        <li><a href="#"><i class="fi-sr-key m-1"></i> 2FA Security</a></li>
                                        <li><a href="login-register.html"><i class="fi-sr-sign-in-alt m-1"></i> Login & Register</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <i class="fi-sr-bell-ring"></i>
                                    <strong>0.00</strong>
                                </li>
                                <li class="notflication">
                                    <i class="fi-sr-bell"></i>
                                    <span>0</span>
                                </li>
                                <!--
                                                                              <li class="search-input">
                                                                                  <div class="header-form">
                                                                                      <form action="#">
                                                                                          <button><i class="flaticon-search"></i></button>
                                                                                          <input type="text" placeholder="Search Artwork">
                                                                                      </form>
                                                                                  </div>
                                                                              </li> -->
                            </ul>
                        </div>
                        <div class="header-action d-none d-md-block">
                            <ul>
                                <li class="header-btn"><a href="connect-wallets.html" class="btn">Wallet Connect</a></li>
                            </ul>
                        </div>
                    </nav>
                </div>
                <!-- Mobile Menu  -->
                <div class="mobile-menu">
                    <nav class="menu-box">
                        <div class="close-btn"><i class="fas fa-times"></i></div>
                        <div class="nav-logo"><a href="index.html"><img src="assets/img/logo/logo.png" alt=""></a>
                        </div>
                        <div class="menu-outer">
                            <!--Here Menu Will Come Automatically Via Javascript / Same Menu as in Header-->
                        </div>
                        <div class="social-links">
                            <ul class="clearfix">
                                <li><a href="#"><span class="fab fa-twitter"></span></a></li>
                                <li><a href="#"><span class="fab fa-facebook-f"></span></a></li>
                                <li><a href="#"><span class="fab fa-pinterest-p"></span></a></li>
                                <li><a href="#"><span class="fab fa-instagram"></span></a></li>
                                <li><a href="#"><span class="fab fa-youtube"></span></a></li>
                            </ul>
                        </div>
                    </nav>
                </div>
                <div class="menu-backdrop"></div>
                <!-- End Mobile Menu -->
            </div>
        </div>
    </header>
    <!-- header-area-end -->

    @yield('content')


    @stack('extra-content')


    @include($theme.'partials.footer')
</div>
    @include('plugins')


    <script src="{{asset('assets/global/js/jquery.min.js') }}"></script>
    <script src="{{asset('assets/global/js/jquery-ui.min.js')}}"></script>
    <script src="{{asset('assets/global/js/popper-1.12.9.min.js')}}"></script>
    <script src="{{asset('assets/global/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/global/js/fontawesome.min.js')}}"></script>
    @stack('extra-js')
    <script src="{{asset('assets/global/js/wow.min.js')}}"></script>
    <script src="{{asset('assets/global/js/owl.carousel.min.js')}}"></script>
    <script src="{{asset('assets/global/js/notiflix-aio-2.7.0.min.js')}}"></script>
    <script src="{{asset('assets/global/js/multi-animated-counter.js')}}"></script>
    <script src="{{asset($themeTrue.'js/script.js')}}"></script>

    @stack('script')

    @if (session()->has('success'))
        <script>
            Notiflix.Notify.Success("@lang(session('success'))");
        </script>
    @endif

    @if (session()->has('error'))
        <script>
            Notiflix.Notify.Failure("@lang(session('error'))");
        </script>
    @endif

    @if (session()->has('warning'))
        <script>
            Notiflix.Notify.Warning("@lang(session('warning'))");
        </script>
@endif


</body>
</html>
