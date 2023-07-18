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
                        <select name="url" id="url" class="form-control statusfield">
                            <option value="-1"
                                    @if(@request()->url == '-1') selected @endif>@lang('All url')</option>
                            @foreach($providers as $provider)
                                <option value="{{$provider->url}}"
                                        @if(@request()->url == $provider->url) selected @endif>@lang($provider->url)</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4 col-xl-3">
                    <div class="form-group">
                        <input type="date" class="form-control" name="date" id="datepicker"/>
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
                <table class="categories-show-table table table-hover table-striped table-bordered">

                    <thead class="thead-primary">
                    <tr>
                        <th scope="col">id</th>
                        <th scope="col">order_id</th>
                        <th scope="col">url</th>
                        <th scope="col">method</th>
                        <th scope="col">header</th>
                        <th scope="col">body</th>
                        <th scope="col">disclosure</th>
                        <th scope="col">created_at</th>

                    </tr>
                    </thead>
                    <tbody>

                    @foreach($logs as $log)
                        <tr>
                            <td><label> {{$log['id']}}</label></td>
                            <td>{{$log['order_id']}}</td>
                            <td>
                                <a href="javascript:void(0)" data-container="body" data-toggle="popover"
                                   data-placement="top" data-content="{{$log['url']}}">
                                    {{\Str::limit($log['url'], 30)}}
                                </a>
                            </td>
                            <td>{{$log['method']}}</td>
                            <td style="max-width: 200px;">
                                <div style="height:80px;overflow:auto;">
                                    {{$log['header']['Content-Type']}}<br>
                                    {{$log['header']['Accept']}}
                                </div>
                            </td>

                            <td style="max-width: 80;">
                                {{-- @foreach($logs_search->body as $property) --}}
                                <b>{{ json_encode($log->body,true) }}</b>
                                {{-- @endforeach --}}
                            </td>

                            <td style="max-width: 200px;">
                                <div style="height:80px;overflow:auto;">
                                    @isset($log->disclosure)
                                        <p>{{json_encode($log->disclosure,true)}}</p>
                                    @endisset
                                </div>
                            </td>
                            <td>{{$log['created_at']}}</td>


                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

<script>
    function myFunction() {
        // Get the text field
        var copyText = document.getElementById("myInput");

        // Select the text field
        copyText.select();
        copyText.setSelectionRange(0, 99999); // For mobile devices

        // Copy the text inside the text field
        navigator.clipboard.writeText(copyText.value);

        // Alert the copied text
        alert("Copied the text: " + copyText.value);
    }
</script>
