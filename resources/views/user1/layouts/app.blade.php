<!DOCTYPE html>
<html lang="en" @if(session()->get('rtl') == 1) dir="rtl" @endif >
<head>
    @include('user.layouts.head')
</head>
<body class="rtl">
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
<!-- <canvas id="canv"></canvas> -->
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
<!-- preloader-end -->

<div class="overlay"></div>
@include('user.layouts.sidebar')
<!-- Offcanvas-area -->
<div class="offcanvas-wrapper">
    <div class="menu-trigger"><i class="fi-sr-angle-small-left"></i></div>
    <div class="menu-close"><i class="fi-sr-angle-small-right"></i></div>
    <div class="offcanvas-inner scroll">
        <div class="author-profile text-center mb-30">
            <div class="author-img">
                <img src="assets/img/others/author_img.png" alt="">
            </div>
            <div class="author-content">
                <h4 class="title">Author Profile</h4>
                <p>Super Author</p>
                <a href="login-register.html" class="btn">Checkout</a>
            </div>
        </div>
        <div class="sidebar-slider text-center mb-25">
            <div class="sidebar-active">
                <div class="sidebar-img">
                    <a href="market-single.html"><img src="assets/img/others/sidebar_img01.png" alt=""></a>
                </div>
                <div class="sidebar-img">
                    <a href="market-single.html"><img src="assets/img/others/sidebar_img02.png" alt=""></a>
                </div>
                <div class="sidebar-img">
                    <a href="market-single.html"><img src="assets/img/others/sidebar_img03.png" alt=""></a>
                </div>
            </div>
        </div>
        <div class="overview">
            <div class="overview-title">
                <h4 class="title">Overview</h4>
            </div>
            <div class="overview-item-wrap">
                <div class="overview-item">
                    <div class="overview-icon">
                        <i class="fi-sr-box-alt"></i>
                    </div>
                    <div class="overview-content">
                        <h4 class="title">Open project</h4>
                        <span>820</span>
                    </div>
                    <a href="nft-marketplace.html"><i class=" fi-sr-angle-small-right"></i></a>
                </div>
                <div class="overview-item">
                    <div class="overview-icon">
                        <i class="fi-sr-mountains"></i>
                    </div>
                    <div class="overview-content">
                        <h4 class="title">Successful Completed</h4>
                        <span>546</span>
                    </div>
                    <a href="nft-marketplace.html"><i class=" fi-sr-angle-small-right"></i></a>
                </div>
                <div class="overview-item">
                    <div class="overview-icon">
                        <i class=" fi-sr-hourglass-end"></i>
                    </div>
                    <div class="overview-content">
                        <h4 class="title">trending</h4>
                        <span>32</span>
                    </div>
                    <a href="nft-marketplace.html"><i class=" fi-sr-angle-small-right"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="offcanvas-overly"></div>
<!-- Offcanvas-area-end -->
<div class="main-content">
    @include('user.layouts.header')

    @include('user.layouts.side-notify')

    <div class="page-wrapper d-block">
        @yield('content')
    </div>
    @include('user.layouts.footer')
</div>


<script src="{{asset('assets/global/js/jquery.min.js') }}"></script>
<script src="{{asset('assets/global/js/popper.min.js') }}"></script>
<script src="{{ asset('assets/global/js/bootstrap.min.js') }}"></script>
@stack('js-lib')
<script src="{{ asset('assets/admin/js/app-style-switcher.js') }}"></script>
<script src="{{ asset('assets/admin/js/feather.min.js') }}"></script>
<script src="{{ asset('assets/global/js/notiflix-aio-2.7.0.min.js')}}"></script>
<script src="{{ asset('assets/admin/js/perfect-scrollbar.jquery.min.js')}}"></script>
<script src="{{ asset('assets/admin/js/sidebarmenu.js')}}"></script>
<script src="{{ asset('assets/global/js/select2.min.js')}}"></script>
<script src="{{ asset('assets/admin/js/admin-mart.js')}}"></script>
<script src="{{ asset('assets/admin/js/custom.js')}}"></script>


<script src="{{ asset('assets/global/js/axios.min.js') }}"></script>
<script src="{{ asset('assets/global/js/vue.min.js') }}"></script>
<script src="{{ asset('assets/global/js/pusher.min.js') }}"></script>

@include('user.layouts.notification')
@stack('js')


<script>
    "use strict";
    if (!localStorage.sidenote || localStorage.sidenote == 'true') {
        $('.fixed-icon').removeClass('rfixedicon');
        $('.fixedsidebar').removeClass('rfixed');
    }

    $(document).on('click', '.close-sidebar', function () {
        $('.fixed-icon').addClass('rfixedicon');
        $('.fixedsidebar').addClass('rfixed');
        localStorage.setItem("sidenote", false);
    });

    $(document).on('click', '.fixed-icon', function () {

        $('.fixed-icon').toggleClass('rfixedicon');
        $('.fixedsidebar').toggleClass('rfixed');

        if (typeof (Storage) !== "undefined") {
            if (localStorage.sidenote == 'true') {
                localStorage.setItem("sidenote", false);
            } else {
                localStorage.setItem("sidenote", true);
            }
        }
    });


    const darkMode = () => {
        var $theme = document.body.classList.toggle("dark-mode");

        $.ajax({
            url: "{{ route('themeMode') }}/" + $theme,
            type: 'get',
            success: function (response) {
            }
        });
    };
</script>


<script>
    'use strict';
    let pushNotificationArea = new Vue({
        el: "#pushNotificationArea",
        data: {
            items: [],
        },
        mounted() {
            this.getNotifications();
            this.pushNewItem();
        },
        methods: {
            getNotifications() {
                let app = this;
                axios.get("{{ route('user.push.notification.show') }}")
                    .then(function (res) {
                        app.items = res.data;
                    })
            },
            readAt(id, link) {
                let app = this;
                let url = "{{ route('user.push.notification.readAt', 0) }}";
                url = url.replace(/.$/, id);
                axios.get(url)
                    .then(function (res) {
                        if (res.status) {
                            app.getNotifications();
                            if (link != '#') {
                                window.location.href = link
                            }
                        }
                    })
            },
            readAll() {
                let app = this;
                let url = "{{ route('user.push.notification.readAll') }}";
                axios.get(url)
                    .then(function (res) {
                        if (res.status) {
                            app.items = [];
                        }
                    })
            },
            pushNewItem() {
                let app = this;
                // Pusher.logToConsole = true;
                let pusher = new Pusher("{{ env('PUSHER_APP_KEY') }}", {
                    encrypted: true,
                    cluster: "{{ env('PUSHER_APP_CLUSTER') }}"
                });
                let channel = pusher.subscribe('user-notification.' + "{{ Auth::id() }}");
                channel.bind('App\\Events\\UserNotification', function (data) {
                    app.items.unshift(data.message);
                });
                channel.bind('App\\Events\\UpdateUserNotification', function (data) {
                    app.getNotifications();
                });
            }
        }
    });
</script>

</
>
</html>
