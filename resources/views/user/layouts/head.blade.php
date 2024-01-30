<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
@include('partials.seo')

@stack('style-lib')
<link href="{{asset('assets/themes/user/css/style.css')}}" rel="stylesheet">
<link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png">
<!-- Place favicon.ico in the root directory -->

<!-- CSS here -->
<link rel="stylesheet" href="{{asset('assets/themes/user/css/bootstrap.min.css')}}">
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<link rel="stylesheet" href="{{asset('assets/themes/user/css/magnific-popup.css')}}">
<link rel="stylesheet" href="{{asset('assets/themes/user/css/fontawesome-all.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/themes/user/css/uicons-solid-rounded.css')}}">
<link rel="stylesheet" href="{{asset('assets/themes/user/css/jquery.mCustomScrollbar.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/themes/user/css/flaticon.css')}}">
<link rel="stylesheet" href="{{asset('assets/themes/user/css/slick.css')}}">
<link rel="stylesheet" href="{{asset('assets/themes/user/css/default.css')}}">
<link rel="stylesheet" href="{{asset('assets/themes/user/css/style.css')}}">
<link rel="stylesheet" href="{{asset('assets/themes/user/css/style-new.css')}}">
<link rel="stylesheet" href="{{asset('assets/themes/user/css/loading.css')}}">
<link rel="stylesheet" href="{{asset('assets/themes/user/css/responsive.css')}}">
<!-- Arabic Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link
    href="https://fonts.googleapis.com/css2?family=Bitter:ital@1&family=Cairo:wght@500&family=Ruwudu:wght@500&display=swap"
    rel="stylesheet">
<link rel="stylesheet" href="{{asset('assets/themes/user/package/swiper-bundle.min.css')}}">

@stack('style')

@stack('extra-style')
