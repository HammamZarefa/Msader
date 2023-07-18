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
                        @foreach($provider_api as $prov_api)
                            <option value="{{$prov_api->url}}"
                                    @if(@request()->url == $prov_api->url) selected @endif>@lang($prov_api->url)</option>
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

                        @foreach($logs_searchs as $logs_search)
                            <tr>
                                <td><label> {{$logs_search['id']}}</label></td>
                                <td>{{$logs_search['order_id']}}</td>
                                <td>
                                    <a  href="javascript:void(0)" data-container="body" data-toggle="popover"
                                        data-placement="top" data-content="{{$logs_search['url']}}">
                                        {{\Str::limit($logs_search['url'], 30)}}
                                    </a>
                                </td>
                                <td >{{$logs_search['method']}}</td>
                                <td  style="max-width: 200px;">
                                    <div style="height:80px;overflow:auto;">
                                        {{$logs_search['header']['Content-Type']}}<br>
                                        {{$logs_search['header']['Accept']}}
                                    </div>
                                </td>
                                
                                <td  style="max-width: 80;">
                                    {{-- @foreach($logs_search->body as $property) --}}
                                        <b>{{ json_encode($logs_search->body,true) }}</b>
                                    {{-- @endforeach --}}
                                </td>
                                
                                <td  style="max-width: 200px;">
                                    <div style="height:80px;overflow:auto;">
                                        @isset($logs_search->disclosure)
                                            <p>{{json_encode($logs_search->disclosure,true)}}</p>
                                        @endisset                          
                                     </div>
                                </td>
                                    <td>{{$logs_search['created_at']}}</td>
                               
                    
                                
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
