@extends($theme.'layouts.app')
@section('title','About Us')

@section('content')

    <div class="slider">
        <div class="row">
            <div class="col-md-6">
                <div class="swiper">
                    <!-- Additional required wrapper -->
                    <div class="swiper-wrapper ">
                        <!-- Slides -->
                        <div class="swiper-slide">
                            <div class="image">
                                <img src="assets/img/bg/dark_rider-cover.jpg" alt="">
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="image">
                                <img src="assets/img/bg/force_mage-cover.jpg" alt="">
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="image">
                                <img src="assets/img/bg/card-cover3.jpg" alt="">
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-md-6 content-left ">
                <h2 class="title">
                    طابت بروض الحياة كل <br> <span>مصادر</span></h2>
                <h5>كل ما تحتاجه من مصادر</h5>
                <div class="btn-slider">
                    <a class="breadcrumb-button" href="#" style="--color: #19d8ad;">
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        المزيد
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
