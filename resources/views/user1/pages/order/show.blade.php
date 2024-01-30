@extends('user.layouts.app')
@section('title',__('Orders'))
@section('content')

    <!-- main-area -->
    <main>
        <!-- login -->

        <!-- login -->

        <section class="breadcrumb-area breadcrumb-bg" style="overflow: hidden;">
            <div class="container">
                <div class="swiper0">
                    <!-- Additional required wrapper -->
                    <div class="swiper-wrapper ">
                        <!-- Slides -->
                        <div class="swiper-slide d-flex">
                            <div class="col-md-6 text-center">
                                <img class="breadcrumb-img" src="assets/img/blog/news_thumb01.png" alt="">
                            </div>
                            <div class="col-md-6 text-end">
                                <div class="breadcrumb-content">
                                    <h3 class="title">منتجاتنا</h3>
                                    <p class="mt-1">منتجاتنا الافضل</p>
                                    <a class="breadcrumb-button" href="#" style="--color: #46c2c3;">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                        المزيد
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- Slides -->
                        <div class="swiper-slide d-flex">
                            <div class="col-md-6 text-center">
                                <img class="breadcrumb-img" src="assets/img/blog/news_thumb01.png" alt="">
                            </div>
                            <div class="col-md-6 text-end">
                                <div class="breadcrumb-content">
                                    <h3 class="title">منتجاتنا</h3>
                                    <p class="mt-1">منتجاتنا الافضل</p>
                                    <a class="breadcrumb-button" href="#" style="--color: #d300ff;">
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
                </div>
            </div>
        </section>

        <!-- ticker-wrap-->

        <!-- ticker-wrap-->
        <div class="area-bg">

            <!-- sell-nfts-area -->
            <div class="category-area">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-sm-4 ">
                            <div class="select">
                                <select>
                                    <option value="1">All</option>
                                    <option value="2">Awaiting</option>
                                    <option value="3">Pending</option>
                                    <option value="4">Processing</option>
                                    <option value="5">In progress</option>
                                    <option value="6">Completed</option>
                                    <option value="7">Partial</option>
                                    <option value="8">Canceled</option>
                                    <option value="9">Refunded</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-sm-3">
                            <div class="sidebar-search">
                                <form action="#">
                                    <input type="text" placeholder="Order Id">
                                    <button type="submit"><i class="fa fa-search"></i></button>
                                </form>
                            </div>
                        </div>
                        <div class="col-12 col-sm-3">
                            <div class="sidebar-search">
                                <form action="#">
                                    <input type="date" class="form-control" name="date_time" id="datepicker">
                                </form>
                            </div>
                        </div>
                        <div class="col-12 col-sm-2">
                            <button type="submit" class="btn"
                                    style="padding-left: 30px;padding-right: 30px;height: 100%;">بحث <i
                                    class="fa fa-search"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- sell-nfts-area-end -->
            <!-- Latest Transaction -->
            <div class="container mt-5">
                <div class="activity-table-wrap">
                    <div class="activity-table-nav">
                        <h4 class="">الطلبات</h4>
                        <ul class="nav nav-tabs" id="myTab" role="tablist" style="margin-inline-start: 50px;">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="nft-tab" data-bs-toggle="tab" data-bs-target="#nft"
                                        type="button"
                                        role="tab" aria-controls="nft" aria-selected="true">الكل
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="month-tab" data-bs-toggle="tab" data-bs-target="#month"
                                        type="button"
                                        role="tab" aria-controls="month" aria-selected="false">آخر شهر
                                </button>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="nft" role="tabpanel" aria-labelledby="nft-tab">
                            <div class="activity-table-responsive">
                                <table class="table activity-table">
                                    <thead>
                                    <tr>
                                        <th class="text-center" scope="col">رقم بالطلب</th>
                                        <th class="text-center" scope="col">تفاصيل الطلب</th>
                                        <th class="text-center" scope="col">سعر</th>
                                        <th class="text-center" scope="col" class="time">رابط</th>
                                        <th class="text-center" scope="col" class="time">كود</th>
                                        <th class="text-center" scope="col" class="time">تاريخ الطلب</th>
                                        <th class="text-center" scope="col" class="time">حالة الطلب</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td scope="row" class="">
                                            2507
                                        </td>
                                        <td>
                                            Ahlan Chat
                                            Link: 0
                                            Quantity: 2000
                                        </td>
                                        <td> 0.76 USD</td>
                                        <td> 0</td>
                                        <td></td>
                                        <td> 28/10/2023 - 01:33 PM</td>
                                        <td class="text-danger fw-bold">مرفوض</td>
                                    </tr>
                                    <tr>
                                        <td scope="row" class="">
                                            2507
                                        </td>
                                        <td>
                                            Ahlan Chat
                                            Link: 0
                                            Quantity: 2000
                                        </td>
                                        <td> 0.76 USD</td>
                                        <td> 0</td>
                                        <td></td>
                                        <td> 28/10/2023 - 01:33 PM</td>
                                        <td class="text-success fw-bold">مكتمل</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="month" role="tabpanel" aria-labelledby="month-tab">
                            <div class="activity-table-responsive">
                                <table class="table activity-table">
                                    <thead>
                                    <tr>
                                        <th class="text-center" scope="col">رقم المعاملة</th>
                                        <th class="text-center" scope="col">الكمية</th>
                                        <th class="text-center" scope="col">الملاحظات</th>
                                        <th class="text-center" scope="col" class="time">التاريخ</th>
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
                                        <td> 28 Oct 2023 01:34 PM</td>
                                    </tr>
                                    <tr>
                                        <td scope="row" class="">
                                            FTZW9MOBGRE1
                                        </td>
                                        <td class="text-danger fw-bold"> -0.76 USD</td>
                                        <td> استرجاع الرصيد بعد تحويل حالة الطلب الى مسترجع</td>
                                        <td> 28 Oct 2023 01:34 PM</td>
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
    <script>
        'use strict';
        $(document).on('click', '.infoBtn', function () {
            var modal = $('#infoModal');
            var id = $(this).data('service_id');
            var orderRoute = "{{route('user.order.create')}}" + '?serviceId=' + id;
            $('.order-now').attr('href', orderRoute);
            modal.find('.info-reason').html($(this).data('reason'));
        });

        $(document).on('click', '#details', function () {
            var title = $(this).data('servicetitle');
            var id = $(this).data('service_id');

            var orderRoute = "{{route('user.order.create')}}" + '?serviceId=' + id;
            $('.order-now').attr('href', orderRoute);

            var description = $(this).data('description');
            $('#title').text(title);
            $('#servicedescription').text(description);
        });
    </script>
    <script>
        function checksms($id) {
            var url = "{{ route('userApiKey') }}";
            let data = {
                "_token": "{{ csrf_token() }}",
                action: 'smscode',
                id: $id,
                api_key: '{{auth()->user()->api_token}}'
            };
            // url = url.replace(':id', $id);
            {{--document.location.href=url;--}}
            $.ajax({
                type: 'post',
                url: url,
                // url : url.replace(':id', $id),
                data: data,
                success: function (data) {
                    if (data.status == 'success') {
                        $('#' + $id).text(data.smsCode)
                    } else {
                        alert('تأكد من طلب الرمز ثم اعد المحاولة')
                    }
                }
            });
        }
    </script>
@endpush
