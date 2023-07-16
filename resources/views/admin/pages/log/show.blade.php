@extends('admin.layouts.app')
@section('title')
    Log Info
@endsection

@section('content')


<div class="col-xl-10">
    <form action="{{ route('admin.log_search') }}" method="get">
        <div class="row">
           

            <div class="col-md-4 col-xl-3">
                <div class="form-group">
                    <select name="order" id="order" class="form-control statusfield">
                        <option value="-1"
                                @if(@request()->order == '-1') selected @endif>@lang('All order')</option>
                        @foreach($logs as $log)
                            <option value="{{$log->order_id}}"
                                    @if(@request()->order == $log->order_id) selected @endif>@lang($log->order_id)</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-4 col-xl-3">
                <div class="form-group">
                    <select name="url" id="url" class="form-control statusfield">
                        <option value="-1"
                                @if(@request()->url == '-1') selected @endif>@lang('All url')</option>
                        @foreach($logs as $log)
                            <option value="{{$log->url}}"
                                    @if(@request()->url == $log->url) selected @endif>@lang($log->url)</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-4 col-xl-3">
                <div class="form-group">
                    <select name="method" id="method" class="form-control statusfield">
                        <option value="-1"
                                @if(@request()->method == '-1') selected @endif>@lang('All method')</option>
                        @foreach($logs as $log)
                            <option value="{{$log->method}}"
                                    @if(@request()->method == $log->method) selected @endif>@lang($log->method)</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-4 col-xl-3">
                <div class="form-group">
                    <select name="header" id="header" class="form-control statusfield">
                        <option value="-1"
                                @if(@request()->header == '-1') selected @endif>@lang('All header')</option>
                        @foreach($logs as $log)
                            <option value="{{$log->header}}"
                                    @if(@request()->header == $log->header) selected @endif>@lang($log->header)</option>
                        @endforeach
                    </select>
                </div>
            </div>


           


            <div class="col-md-4 col-xl-3">
                <div class="form-group">
                    <select name="body" id="body" class="form-control statusfield">
                        <option value="-1"
                                @if(@request()->body == '-1') selected @endif>@lang('All body')</option>
                        @foreach($logs as $log)
                            <option value="{{$log->body}}"
                                    @if(@request()->body == $log->body) selected @endif>@lang($log->body)</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-4 col-xl-3">
                <div class="form-group">
                    <select name="disclosure" id="disclosure" class="form-control statusfield">
                        <option value="-1"
                                @if(@request()->disclosure == '-1') selected @endif>@lang('All disclosure')</option>
                        @foreach($logs as $log)
                            <option value="{{$log->disclosure}}"
                                    @if(@request()->disclosure == $log->disclosure) selected @endif>@lang($log->disclosure)</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-4 col-xl-3">
                <div class="form-group">
                    <button type="submit" class="btn btn-primary w-100 w-sm-auto"><i
                            class="fas fa-search"></i> @lang('Search')</button>
                </div>
            </div>
        </div>
    </form>
</div>


    <div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">

        <div class="card-body">

           
            <div class="table-responsive">
                    <table class=" table table-hover table-striped table-bordered">
                        <thead class="thead-primary">
                        <tr>
                            <th scope="col">order_id</th>
                            <th scope="col">url</th>
                            <th scope="col">method</th>
                            <th scope="col">header</th>
                            <th scope="col">body</th>
                            <th scope="col">disclosure</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($logs_searchs as $logs_search)
                            <tr>
                                <td>{{$logs_search->order_id}}</td>
                                <td>{{$logs_search->url}}</td>
                                <td>{{$logs_search->method}}</td>
                                <td>{{$logs_search->header}}</td>
                                <td>{{$logs_search->body}}</td>
                                <td>{{$logs_search->disclosure}}</td>
                               
                                {{-- <td data-label="@lang('Title')">@lang($notice->title) </td>
                                <td data-label="@lang('Highlight text')"><span class="badge badge-info">@lang($notice->highlight_text)</span> </td>

                                <td data-label="@lang('Status')">
                                    <span class="badge badge-pill {{ $notice->status == 0 ? 'badge-danger' : 'badge-success' }}">{{ $notice->status == 0 ? 'Inactive' : 'Active' }}</span>
                                </td> --}}

                                
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
            </div>
        </div>
    </div>



   
@endsection


