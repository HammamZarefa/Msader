@extends('user.layouts.app')
@section('title')
    @lang('Service')
@endsection
@section('content')
    {{--    @include('partials.banner')--}}
    <div id="show-products" class="show">
        <section class="inner-explore-products content">
            <div class="container">
                <div class="row justify-content-center">
                    @foreach($categories as $category)
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                            <div class="card-game btn-order"  data-category-id="{{ $category->id }}">
                                <div class="wrapper">
                                    <img src="{{asset('assets/themes/user/img/bg/dark_rider-cover.jpg')}}" class="cover-image"/>
                                </div>
                                <!-- <img src="assets/img/bg/dark_rider-title.png" class="title" /> -->
                                <h4 class="text-center title">{{$category->category_title}}</h4>
                                <!-- <img src="assets/img/bg/dark_rider-character.webp" class="character" /> -->
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    </div>
    <div id="show-orders">
        <section class="inner-explore-products content">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-3 col-lg-4 col-sm-6 orders-item">
                        <div class="swiper1">
                            <!-- Additional required wrapper -->
                            <div class="swiper-wrapper">
                                <!-- Slides -->
                                <div class="swiper-slide">
                                    <div class="top-collection-item">
                                        <div class="collection-item-top">
                                            <ul>
                                                <li class="avatar">
                                                    <strong
                                                        style="font-size: 20px;margin-inline-start: 10px;"
                                                        class="text-white">اختر باقة</strong>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="collection-item-thumb">
                                            <img src="assets/img/others/top_collection06.jpg" alt="">
                                        </div>
                                        <div class="collection-item-content">
                                            <h5 class="title">
                                                <a> 1000 مشاهدة تلغرام ضمان 60 يوم </a>
                                                <span class="price" data-value="vlaue">$0.1</span>
                                            </h5>
                                            <hr>
                                            <h5 class="title">
                                                <a>Max : <span class="Max m-0">100000</span></a>
                                                <a>Min : <span class="Min m-0">1000</span></a>
                                            </h5>
                                        </div>
                                        <div class="collection-item-bottom">
                                            <ul>
                                                <li onclick="swiper1.slideNext()" class="bid m-auto btn">
                                                    أطلب الان
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide order-form">
                                    <div class="top-collection-item ">
                                        <div class="water"></div>
                                        <div class="collection-item-top">
                                            <ul>
                                                <li class="avatar">
                                                    <strong
                                                        style="font-size: 20px;margin-inline-start: 10px;"
                                                        class="text-white">عملية الطلب</strong>
                                                </li>
                                                <li class="Prev p-3" onclick="swiper1.slidePrev()">
                                                    <i style="color:#fff;" class="fas fa-arrow-right"></i>
                                                </li>
                                            </ul>
                                        </div>
                                        <div
                                            class="mt-5 collection-item-thumb d-flex align-items-center justify-content-between">
                                            <h5>السعر</h5>
                                            <h5 style="color: #fff">$<span class="main-price"
                                                                           data-price="0.1">0.1</span></h5>
                                        </div>
                                        <form action="" class="create-item-form">
                                            <div class="form-grp">
                                                <input id="number" type="text" placeholder="رقم اللاعب">
                                            </div>
                                            <div class="form-grp">
                                                <input class="qty" type="number" onkeypress="return isNumberKey(event)"
                                                       placeholder="الكمية">
                                            </div>
                                            <div class="collection-item-bottom">
                                                <ul>
                                                    <li class="m-auto">
                                                        <button type="submit" class="btn-form-order">
                                                            <span>أطلب الآن</span>
                                                        </button>
                                                    </li>
                                                </ul>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>


    <div class="container-fluid px-3 user-service-list">

        <div class="row   justify-content-between mx-lg-5">

            <div class="col-md-12">
                <ol class="breadcrumb center-items">
                    <li><a href="{{route('user.home')}}">@lang('Home')</a></li>
                    <li class="active">@lang('Service')</li>
                </ol>

                <div class="card my-3">
                    <div class="card-body">
                        <form action="{{ route('user.service.search') }}" method="get">
                            <div class="row justify-content-between">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="text" name="service" value="{{@request()->service}}"
                                               class="form-control"
                                               placeholder="@lang('Search for Services')">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <select name="category" id="category" class="form-control statusfield">
                                            <option value="">@lang('All Category')</option>
                                            @foreach($categories as $category)
                                                <option
                                                    value="{{$category->id}}" {{($category->id == @request()->category) ? 'selected' : ''}}>@lang($category->category_title)</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <button type="submit" class="btn waves-effect waves-light w-100 btn-primary"><i
                                                class="fas fa-search"></i> @lang('Search')</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <div class="row my-3 justify-content-between mx-lg-5">
            <div class="col-md-12">

                <div id="accordion" class="accordion-service">
                    @foreach($categories as $category)
                        @if( 0 < count($category->service))
                            <div class="card mb-3">
                                <div class="card-header" id="faqhead{{$category->id}}">
                                    <a href="#" class="btn btn-header-link" data-toggle="collapse"
                                       data-target="#faq{{$category->id}}" aria-expanded="true"
                                       aria-controls="faq{{$category->id}}">
                                        {{$category->category_title }}
                                    </a>
                                </div>
                                <div id="faq{{$category->id}}" class="collapse @if($loop->first) show @endif"
                                     aria-labelledby="faqhead{{$category->id}}" data-parent="#accordion">
                                    <div class="card-body">
                                        <div class="table-responsive ">
                                            <table class="categories-show-table table  table-striped text-dark">
                                                <thead>
                                                <tr>
                                                    <th scope="col" class="text-center">@lang('ID')</th>
                                                    <th scope="col" class="text-left">@lang('Name')</th>
                                                    <th scope="col"
                                                        class="text-center">@lang('Rate Per 1k')</th>
                                                    <th scope="col" class="text-center">@lang('Min')</th>
                                                    <th scope="col" class="text-center">@lang('Max')</th>
                                                    <th scope="col" class="text-center">@lang('Description')</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($category->service as $service)
                                                    <tr>
                                                        <td data-label="@lang('ID')"
                                                            class="text-center">{{$service->id}}</td>
                                                        <td data-label="@lang('Name')" class="text-left">
                                                            @lang($service->service_title)
                                                        </td>
                                                        <td data-label="@lang('Rate Per 1k')" class="text-right">
                                                            @lang(config('basic.currency_symbol')){{$service->user_rate ?? $service->price}}
                                                        </td>
                                                        <td data-label="@lang('Min')" class="text-center">
                                                            @lang($service->min_amount)
                                                        </td>
                                                        <td data-label="@lang('Max')" class="text-center">
                                                            @lang($service->max_amount)
                                                        </td>

                                                        <td data-label="@lang('Description')" class="text-center">
                                                            <button type="button"
                                                                    class="btn btn-default btn-sm text-dark"
                                                                    data-toggle="modal"
                                                                    data-target="#description" id="details"
                                                                    data-id="{{$service->id}}"
                                                                    data-servicetitle="{{$service->service_title}}"
                                                                    data-description="{{$service->description}}">
                                                                <i class="fa fa-eye"></i> @lang('More')</button>
                                                        </td>

                                                    </tr>

                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        @endif
                    @endforeach
                </div>
            </div>
        </div>


    </div>

    <div class="modal fade" id="description">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-primary">
                    <h4 class="modal-title" id="title"></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body" id="servicedescription">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('Close')</button>
                    <a href="" type="submit" class="btn btn-primary order-now">@lang('Order Now')</a>
                </div>

            </div>
        </div>
    </div>

@endsection
@push('js')
    <script>
        "use strict";
        $(document).on('click', '#details', function () {
            var title = $(this).data('servicetitle');
            var id = $(this).data('id');

            var orderRoute = "{{route('user.order.create')}}" + '?serviceId=' + id;
            $('.order-now').attr('href', orderRoute);

            var description = $(this).data('description');
            $('#title').text(title);
            $('#servicedescription').html(description);
        });

        function isNumberKey(evt) {
            var charCode = (evt.which) ? evt.which : evt.keyCode
            if (charCode > 31 && (charCode < 48 || charCode > 57))
                return false;
            return true;
        }

        const swiper0 = new Swiper('.swiper0', {
            loop: true,
            spaceBetween: 100,
            autoplay: {delay: 5000},

        });
        const swiper1 = new Swiper('.swiper1', {
            loop: false,
            speed: 1000,
            effect: "cube",
            simulateTouch: false

        });
        const swiper2 = new Swiper('.swiper2', {
            loop: false,
            speed: 1000,
            effect: "cube",
            simulateTouch: false

        });
        const swiper3 = new Swiper('.swiper3', {
            loop: false,
            speed: 1000,
            effect: "cube",
            simulateTouch: false
        });
        const swiper4 = new Swiper('.swiper4', {
            loop: false,
            speed: 1000,
            effect: "cube",
            simulateTouch: false
        });
    </script>
@endpush

