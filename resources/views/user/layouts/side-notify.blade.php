{{--<div class="fixed-icon rfixedicon">--}}
{{--    <i class="fa fa-envelope-open"></i>--}}
{{--</div>--}}

{{--<div class="fixedsidebar rfixed">--}}
{{--    <div class="fs-header d-flex align-items-center justify-content-between">--}}
{{--        <h5 class="text-white">@lang("What's new on $basic->site_title")</h5>--}}
{{--        <div class="btn-close close-sidebar">&times;</div>--}}
{{--    </div>--}}
{{--    <div class="fs-wrapper">--}}
{{--        @foreach($notices as $notice)--}}
{{--        <div class="content">--}}
{{--            <div class="featureDate">--}}
{{--                <div class="category categoryNew new">--}}
{{--                    @lang($notice->highlight_text)--}}
{{--                </div>--}}
{{--                <span>{{dateTime($notice->created_at,'d M, Y')}}</span>--}}
{{--            </div>--}}

{{--            <h3 class="featureTitle">--}}
{{--                @lang($notice->title)--}}
{{--            </h3>--}}


{{--            <div class="featureContent">--}}
{{--                <p>--}}
{{--                    @lang($notice->details)--}}

{{--                </p>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        @endforeach--}}

{{--    </div>--}}
{{--</div>--}}
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
