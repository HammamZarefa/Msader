@extends('admin.layouts.app')
@section('title')
    {{ trans($page_title) }}
@endsection
@section('content')
    <div class="container-fluid">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ trans($error) }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="row">
            <div class="col-12">
                <div class="card card-primary shadow">
                    <div class="card-body">
                        <form method="post" action="{{route('admin.payment-history.store')}}"
                              class="needs-validation base-form" novalidate="" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label>{{trans('Name')}}</label>
                                    <input type="text" class="form-control" name="name"
                                           value="{{ old('name') }}" required>
                                    @if ($errors->has('name'))
                                        <span class="invalid-text">
                                                {{ trans($errors->first('name')) }}
                                            </span>
                                    @endif
                                </div>

                                <div class="form-group col-md-4">
                                    <label>{{trans('Date')}}</label>
                                    <input type="date" class="form-control "
                                           name="date"
                                           value="{{ old('date') }}" required="required">

                                    @if ($errors->has('date'))
                                        <span class="invalid-text">
                                                {{ trans($errors->first('date')) }}
                                            </span>
                                    @endif
                                </div>
                                <div class="form-group col-md-4">
                                    <label>{{trans('Status')}}</label>
                                    <select id="inputState" class="form-control" name="status">
                                        <option value="completed" selected>@lang('Completed')</option>
                                        <option value="pending"> @lang('Pending')</option>
                                        <option value="failed"> @lang('Failed')</option>
                                    </select>
                                    @if ($errors->has('status'))
                                        <span class="invalid-text">
                                                {{ trans($errors->first('status')) }}
                                            </span>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4 col-4">
                                    <label>{{trans('Amount')}}</label>
                                    <div class="input-group ">
                                        <input type="number" class="form-control "
                                               name="amount"
                                               value="{{ old('amount') }}"
                                               required=""
                                               step=".001">
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                {{ $basic->currency ?? trans('USD') }}
                                            </div>
                                        </div>
                                    </div>

                                    @if ($errors->has('amount'))
                                        <span class="invalid-text">
                                                {{ trans($errors->first('amount')) }}
                                            </span>
                                    @endif
                                </div>

                                <div class="form-group col-md-4 col-4">
                                    <label>{{trans('Method')}}</label>
                                    <div class="input-group ">
                                        <input type="text" class="form-control "
                                               name="method"
                                               value="{{ old('method') }}"
                                               required="">
                                        <div class="input-group-append">
                                        </div>
                                    </div>

                                    @if ($errors->has('method'))
                                        <span class="invalid-text">
                                                {{ trans($errors->first('method')) }}
                                            </span>
                                    @endif
                                </div>
                                <div class="form-group col-md-4 col-4">
                                    <label class="d-block">@lang('Is Pay?')</label>
                                    <div class="custom-switch-btn w-md-25">
                                        <input type='hidden' value='1' name='is_pay'>
                                        <input type="checkbox" name="is_pay" class="custom-switch-checkbox" id="is_pay"
                                               value="0">
                                        <label class="custom-switch-checkbox-label" for="is_pay">
                                            <span class="custom-switch-checkbox-inner"></span>
                                            <span class="custom-switch-checkbox-switch"></span>
                                        </label>
                                    </div>
                                    @error('is_pay')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row justify-content-between">
                                <div class="col-sm-12 col-md-12">
                                    <div class="form-group ">
                                        <label>@lang('Description')</label>
                                        <textarea class="form-control summernote" name="description" id="summernote"
                                                  rows="5">{{old('description')}}</textarea>
                                        @error('description')
                                        <span class="text-danger">{{ trans($message) }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <button type="submit"
                                    class="btn btn-rounded btn-primary btn-block mt-3">@lang('Save Changes')</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style-lib')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/summernote.min.css')}}">
@endpush
@push('js-lib')
    <script src="{{ asset('assets/global/js/summernote.min.js')}}"></script>
@endpush

@push('js')
    <script>
        "use strict";
        $(document).ready(function (e) {
            $('.summernote').summernote({
                height: 250,
                callbacks: {
                    onBlurCodeview: function () {
                        let codeviewHtml = $(this).siblings('div.note-editor').find('.note-codable').val();
                        $(this).val(codeviewHtml);
                    }
                }
            });
        });

    </script>
@endpush
