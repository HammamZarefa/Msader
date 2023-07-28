@extends('admin.layouts.app')
@section('title')
    {{ trans($page_title) }}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-primary shadow">
                    <div class="card-body">
                        <a href="{{route('admin.payment-history.create')}}" class="btn btn-success btn-sm float-right mb-3"><i class="fa fa-plus-circle"></i> {{trans('Add New')}}</a>


                        <table class="table ">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col">@lang('Name')</th>
                                <th scope="col">@lang('Type')</th>
                                <th scope="col">@lang('Date')</th>
                                <th scope="col">@lang('Status')</th>
                                <th scope="col">@lang('Amount')</th>
                                <th scope="col">@lang('Method')</th>
                                <th scope="col">@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody id="sortable">
                            @if(count($payments) > 0)
                                @foreach($payments as $payment)
                                    <tr data-code="{{ $payment->id }}">
                                        <td data-label="@lang('Name')">{{ $payment->name }} </td>
                                        <td data-label="@lang('Type')">
                                            {!!  $payment->is_pay == 1 ? '<span class="badge badge-success badge-pill">'.trans('Payment').'</span>' : '<span class="badge badge-danger badge-sm">'.trans('Charge').'</span>' !!}
                                        </td>
                                        <td data-label="@lang('Date')">{{ $payment->date }} </td>
                                        <td data-label="@lang('Status')">{{ $payment->status }} </td>
                                        <td data-label="@lang('Amount')">{{ $payment->amount }} </td>
                                        <td data-label="@lang('Method')">{{ $payment->method }} </td>
                                        <td data-label="@lang('Action')">
                                            <a href="{{ route('admin.payment-history.edit', $payment) }}"
                                               class="btn btn-primary btn-circle"
                                               data-toggle="tooltip"
                                               data-placement="top"
                                               data-original-title="@lang('Edit this Payment info')">
                                                <i class="fa fa-edit"></i></a>
                                            <a href="javascript:void(0)"
                                               class="btn btn-danger btn-circle status-change"
                                               data-toggle="modal" data-target="#statusModal"
                                               data-route="{{ route('admin.payment-history.destroy',$payment ) }} ">
                                                <i class="fa fa-trash }} "
                                                   aria-hidden="true"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td class="text-center text-danger" colspan="8">
                                        @lang('No Data Found')
                                    </td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>



    <div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">@lang('Confirm Status Change')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" method="post" id="statusForm">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        <p>@lang('Are you want to delete?')</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal"><span><i
                                    class="fas fa-power-off"></i> @lang('Cancel')</span></button>
                        <button type="submit" class="btn btn-primary"><span><i
                                    class="fas fa-save"></i> @lang('Change Status')</span></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection


@push('js')
    <script>
        "use strict";
        $(document).on('click', '.status-change', function () {
            let route = $(this).data('route');
            $('#statusForm').attr('action', route);
        });
    </script>
@endpush
