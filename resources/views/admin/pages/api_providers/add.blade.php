@extends('admin.layouts.app')
@section('title')
    @lang('API Controls')
@endsection
@section('content')
    <div class="center">
        <select id="api">
            <option selected> @lang('Select Provider')</option>
            @foreach($providerData as $key => $provider)
                <option data-slug="{{$key}}" data-url="{{$provider['url']}}" data-name="{{$provider['api_name']}}">
                    {{$provider['api_name']}}</option>
            @endforeach
        </select>
    </div>
    <div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
        <div class="card-body">
            <form method="post" action=" {{route('admin.provider.api-provider.store')}} " enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group ">
                            <label>@lang('Api Name')</label>
                            <input type="text" id="api_name" name="api_name" value="{{ old('api_name') }}" required
                                   class="form-control form-control-sm">
                            <div class="invalid-feedback">@lang('Please fill in the api name')</div>
                            @error('api_name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group ">
                            <label>@lang('API Key')</label>
                            <input type="text" name="api_key" value="{{ old('api_key') }}" required="required"
                                   class="form-control form-control-sm">
                            <div class="invalid-feedback">@lang('Please fill in the api key')</div>
                            @error('api_key')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group ">
                            <label>@lang('URL')</label>
                            <input type="text" id="url" name="url" value="{{ old('url') }}" required="required"
                                   class="form-control form-control-sm">
                            <div class="invalid-feedback">@lang('Please fill in the url')</div>

                            @error('url')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group ">
                            <label>@lang('Slug')</label>
                            <input type="text" id="slug" name="slug" value="{{ old('slug') }}"
                                   class="form-control form-control-sm">
                            <div class="invalid-feedback">@lang('Please fill in the slug')</div>

                            @error('url')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group ">
                            <label class="d-block">@lang('Status')</label>
                            <div class="custom-switch-btn w-md-50">
                                <input type='hidden' value='1' name='status'>
                                <input type="checkbox" name="status" class="custom-switch-checkbox" id="status"
                                       value="0">
                                <label class="custom-switch-checkbox-label" for="status">
                                    <span class="custom-switch-checkbox-inner"></span>
                                    <span class="custom-switch-checkbox-switch"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="category_description">@lang('Description')</label>
                    <textarea class="form-control" id="description" rows="3"
                              name="description">{{ old('description') }}</textarea>
                    <div class="invalid-feedback">@lang('Please fill in the description')</div>

                    @error('description')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="submit-btn-wrapper mt-md-5 text-center text-md-left">
                    <button type="submit" class=" btn  btn-primary btn-block mt-3">
                        <span>@lang('Add API Provider')</span></button>
                </div>
            </form>
        </div>
    </div>

@endsection
@push('js')
    <script>
        "use strict";
        $(document).ready(function (e) {
            $('#api').change(function () {
                var option = this.selectedOptions[0];
                const url = $(option).data('url');
                const name = $(option).data('name');
                const slug = $(option).data('slug');
                $('#slug').val(slug);
                $('#api_name').val(name);
                $('#url').val(url);
                console.log(url);
            })
        });
    </script>
@endpush
