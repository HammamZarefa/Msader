@extends('admin.layouts.app')
@section('title',__('Invoices'))
@section('content')



    <div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">

        <div class="card-body">

            <a href="{{route('admin.invoice_add')}}"
            class="btn btn-success"><span>@lang('Add invoices')</span></a>
            <br>  <br>          
            <div class="table-responsive">
                    <table class=" table table-hover table-striped table-bordered">
                        <thead class="thead-primary">
                        <tr>
                            <th scope="col">id</th>
                            <th scope="col">Name</th>
                            <th scope="col">Date</th>
                            <th scope="col">Status</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Method</th>
                            <th scope="col">Description</th>
                            <th scope="col">created_at</th>

                        </tr>
                        </thead>
                        <tbody>

                        @foreach($invoices as $invoice)
                            <tr>
                                <td>{{$invoice->id}}</td>
                                <td>{{$invoice->Name}}</td>
                                <td>{{$invoice->Date}}</td>
                                <td>{{$invoice->Status}}</td>
                                <td>{{$invoice->Amount}}</td>
                                <td>{{$invoice->Method}}</td>
                                <td>{{$invoice->Description}}</td>
                                <td>{{$invoice->created_at}}</td>
                                <td>

                                    <div class="form-row">
                                        <div>
                                    <form action="{{ route('admin.invoice_edit',$invoice->id) }}" method="Get">
                                        @csrf
                                        <button type="submit" class="btn btn-secondary">Edit</button>
                                    </form>
                                        </div>

                                        <div style=" margin-left: 10px">
                                    <form action="{{ route('admin.invoice_destroy',$invoice->id) }}" method="Post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                        </div>
                                </div>
                                </td>
                                
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
            </div>
        </div>
    </div>


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
           let data = {"_token": "{{ csrf_token() }}",action: 'smscode', id: $id, api_key: '{{auth()->user()->api_token}}' };
           // url = url.replace(':id', $id);
            {{--document.location.href=url;--}}
            $.ajax({
                type: 'post',
                url:  url,
                // url : url.replace(':id', $id),
                data: data,
                success: function (data) {
                    if(data.status=='success')
                    {
                        $('#'+$id).text(data.smsCode)
                    }
                    else {alert('تأكد من طلب الرمز ثم اعد المحاولة')}
                }
            });
        }
    </script>
@endpush
