@extends($theme.'layouts.app')
@section('title','Home')

@section('content')
    <main style="margin-top: 150px;">
        <!-- Start Ticker -->
        @include($theme.'sections.ticker')
        <!-- End Ticker -->
        <!-- Start Slider -->
        @include($theme.'sections.slider')
        <!-- End Slider -->
        <!-- Start Testimonial -->
        @include($theme.'sections.testimonial')
        <!-- End Testimonial -->
        <!-- Start Services -->
        @include($theme.'sections.service')
        <!-- End Services -->
        <!-- Start Video -->
        @include($theme.'sections.video')
        <!-- End Video -->
        <!-- Start News -->
        @include($theme.'sections.blog')
        <!-- End News -->

    </main>

@endsection
