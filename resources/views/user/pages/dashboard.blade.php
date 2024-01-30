@extends('user.layouts.app')
@section('title')
    @lang('Dashboard')
@endsection
@section('content')
    <!-- main-area -->
    <main>
        <div class="banner-bg">
            <!-- banner-area -->
            <div class="banner-area">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-6 text-center">
                            <div class="banner-content">
                                <h2 class="title">
                                    طابت بروض الحياة كل <br> <span>مصادر</span></h2>
                                <p>كل ما تحتاجه من مصادر</p>
                                <!-- <a href="login-register.html" class="banner-btn">Let’s get started <i class="fi-sr-arrow-right"></i></a> -->
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!-- banner-area-end -->

            <!-- top-seller-area -->
            <div class="top-seller-area">
                <div class="container">
                    <div class="top-seller-wrap">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="section-title mb-40">
                                    <h2 class="title">Top Seller <img src="{{asset('assets/themes/user/img/icons/title_icon01.png')}}" alt=""></h2>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-xl-3 col-lg-4 col-sm-6">
                                <div class="top-seller-item">
                                    <div class="top-seller-img">
                                        <img src="{{asset('assets/themes/user/img/others/top-seller-img.jpg')}}" alt="">
                                    </div>
                                    <div class="top-seller-content">
                                        <h5 class="title"><a href="author-profile.html">Alan walker</a></h5>
                                        <p>885.5 <span>Eth</span></p>
                                        <ul class="icon">
                                            <li><a href="collections.html"><i class="fi-sr-pharmacy"></i></a></li>
                                            <li><a href="login-register.html"><i class="fi-sr-share"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-4 col-sm-6">
                                <div class="top-seller-item">
                                    <div class="top-seller-img">
                                        <img src="{{asset('assets/themes/user/img/others/top-seller-img02.jpg')}}" alt="">
                                    </div>
                                    <div class="top-seller-content">
                                        <h5 class="title"><a href="author-profile.html">Mazanov Sky</a></h5>
                                        <p>885.5 <span>Eth</span></p>
                                        <ul class="icon">
                                            <li><a href="collections.html"><i class="fi-sr-pharmacy"></i></a></li>
                                            <li><a href="login-register.html"><i class="fi-sr-share"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-4 col-sm-6">
                                <div class="top-seller-item">
                                    <div class="top-seller-img">
                                        <img src="{{asset('assets/themes/user/img/others/top-seller-img03.jpg')}}" alt="">
                                    </div>
                                    <div class="top-seller-content">
                                        <h5 class="title"><a href="author-profile.html">Alvin Nov</a></h5>
                                        <p>885.5 <span>Eth</span></p>
                                        <ul class="icon">
                                            <li><a href="collections.html"><i class="fi-sr-pharmacy"></i></a></li>
                                            <li><a href="login-register.html"><i class="fi-sr-share"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-4 col-sm-6">
                                <div class="top-seller-item">
                                    <div class="top-seller-img">
                                        <img src="{{asset('assets/themes/user/img/others/top-seller-img04.jpg')}}" alt="">
                                    </div>
                                    <div class="top-seller-content">
                                        <h5 class="title"><a href="author-profile.html">Jimmy Dom</a></h5>
                                        <p>885.5 <span>Eth</span></p>
                                        <ul class="icon">
                                            <li><a href="collections.html"><i class="fi-sr-pharmacy"></i></a></li>
                                            <li><a href="login-register.html"><i class="fi-sr-share"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- top-seller-area-end -->
        </div>
        <div class="area-bg">
            <!-- sell-nfts-area -->
            <section class="sell-nfts-area">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="section-title mb-45">
                                <h2 class="title">
                                    <img width="100" src="{{asset('assets/themes/user/img/icons/trophy.png')}}" alt="">
                                    الاحصائيات
                                </h2>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-xl-3 col-lg-4 col-md-6">
                            <div class="sell-nfts-item">
                                <img src="{{asset('assets/themes/user/img/icons/nfts_03.png')}}" alt="" class="icon">
                                <span class="step-count"></span>
                                <h5 class="title">@lang('Your Balance')</h5>
                                <h3><sup class="set-doller">{{config('basic.currency_symbol')}}</sup>{{getAmount($walletBalance)}}</h3>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-md-6">
                            <div class="sell-nfts-item">
                                <img src="{{asset('assets/themes/user/img/icons/nfts_02.png')}}" alt="" class="icon">
                                <span class="step-count"></span>
                                <h5 class="title">@lang('Total Transaction') </h5>
                                <h3>{{number_format($totalTrx)}}</h3>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-md-6">
                            <div class="sell-nfts-item">
                                <img src="{{asset('assets/themes/user/img/icons/nfts_03.png')}}" alt="" class="icon">
                                <span class="step-count"></span>
                                <h5 class="title">@lang('Total Deposit')</h5>
                                <h3><sup class="set-doller">{{config('basic.currency_symbol')}}</sup>{{getAmount($totalDeposit)}}</h3>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-md-6">
                            <div class="sell-nfts-item">
                                <img width="75" src="{{asset('assets/themes/user/img/icons/nfts_08.png')}}" alt="" class="icon">
                                <span class="step-count"></span>
                                <h5 class="title">@lang('Total Tickets')</h5>
                                <h3>{{getAmount($ticket)}}</h3>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-md-6">
                            <div class="sell-nfts-item">
                                <img src="{{asset('assets/themes/user/img/icons/nfts_01.png')}}" alt="" class="icon">
                                <span class="step-count"></span>
                                <h5 class="title">@lang('Total Orders') </h5>
                                <h3>{{getAmount($order['total'])}}</h3>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-md-6">
                            <div class="sell-nfts-item">
                                <img width="75" src="{{asset('assets/themes/user/img/icons/nfts_06.png')}}" alt="" class="icon">
                                <span class="step-count"></span>
                                <h5 class="title">@lang('Processing Orders')</h5>
                                <h3>{{getAmount($order['processing'])}}</h3>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-md-6">
                            <div class="sell-nfts-item">
                                <img width="75" src="{{asset('assets/themes/user/img/icons/nfts_07.png')}}" alt="" class="icon">
                                <span class="step-count"></span>
                                <h5 class="title">@lang('Pending Orders')</h5>
                                <h3>{{getAmount($order['pending'])}}</h3>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-md-6">
                            <div class="sell-nfts-item">
                                <img src="{{asset('assets/themes/user/img/icons/nfts_04.png')}}" alt="" class="icon">
                                <span class="step-count"></span>
                                <h5 class="title">@lang('Completed Orders')</h5>
                                <h3>{{getAmount($order['completed'])}}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- sell-nfts-area-end -->
            <!-- Latest Transaction -->
            <div class="container mt-5">
                <div class="activity-table-wrap">
                    <div class="activity-table-nav">
                        <h4 class="">@lang('Latest Transaction')</h4>
                        <ul class="nav nav-tabs" id="myTab" role="tablist" style="margin-inline-start: 50px;">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="nft-tab" data-bs-toggle="tab" data-bs-target="#nft" type="button"
                                        role="tab" aria-controls="nft" aria-selected="true">الكل</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="month-tab" data-bs-toggle="tab" data-bs-target="#month" type="button"
                                        role="tab" aria-controls="month" aria-selected="false">آخر شهر</button>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="nft" role="tabpanel" aria-labelledby="nft-tab">
                            <div class="activity-table-responsive">
                                <table class="table activity-table">
                                    <thead>
                                    <tr>
                                        <th class="text-center" scope="col">@lang('Transaction ID')</th>
                                        <th class="text-center" scope="col">@lang('Amount')</th>
                                        <th class="text-center" scope="col">@lang('Remarks')</th>
                                        <th class="text-center" scope="col" class="time">@lang('Time')</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($transactions as $transaction)
                                    <tr>
                                        <td scope="row" class="">
                                            @lang($transaction->trx_id)
                                        </td>
                                        <td class="text-{{($transaction->trx_type == "+") ? 'success': 'danger'}} fw-bold" id="increase">
                                            {{($transaction->trx_type == "+") ? '+': '-'}}{{getAmount($transaction->amount, config('basic.fraction_number')). ' ' . trans(config('basic.currency'))}}
                                            <img width="10" src="assets/img/icons/title_icon01.png" alt="">
                                        </td>
                                        <td> @lang($transaction->remarks)</td>
                                        <td> {{ dateTime($transaction->created_at, 'd M Y h:i A') }} </td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="month" role="tabpanel" aria-labelledby="month-tab">
                            <div class="activity-table-responsive">
                                <table class="table activity-table">
                                    <thead>
                                    <tr>
                                        <th class="text-center" scope="col">@lang('Transaction ID')</th>
                                        <th class="text-center" scope="col">@lang('Amount')</th>
                                        <th class="text-center" scope="col">@lang('Remarks')</th>
                                        <th class="text-center" scope="col" class="time">@lang('Time')</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td scope="row" class="">
                                            FTZW9MOBGRE1
                                        </td>
                                        <td class="text-success fw-bold" id="increase">
                                            +0.76 USD
                                            <img width="10" src="assets/img/icons/title_icon01.png" alt="">
                                        </td>
                                        <td> استرجاع الرصيد بعد تحويل حالة الطلب الى مسترجع</td>
                                        <td> 28 Oct 2023 01:34 PM </td>
                                    </tr>
                                    <tr>
                                        <td scope="row" class="">
                                            FTZW9MOBGRE1
                                        </td>
                                        <td class="text-danger fw-bold"> -0.76 USD </td>
                                        <td> استرجاع الرصيد بعد تحويل حالة الطلب الى مسترجع</td>
                                        <td> 28 Oct 2023 01:34 PM </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Latest Transaction -->
        </div>
    </main>
    <!-- main-area-end -->

@endsection

@push('js')

@endpush
