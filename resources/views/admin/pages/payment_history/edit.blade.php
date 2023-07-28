@extends('admin.layouts.app')
@section('title')
    @lang('Edit payment')
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
                        <form method="post" action="{{route('admin.payment-history.update',$payment)}}"
                              class="needs-validation base-form" novalidate="" enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label>{{trans('Name')}}</label>
                                    <input type="text" class="form-control" name="name"
                                           value="{{$payment->name }}" required>
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
                                           value="{{ $payment->date }}" required="required">

                                    @if ($errors->has('date'))
                                        <span class="invalid-text">
                                                {{ trans($errors->first('date')) }}
                                            </span>
                                    @endif
                                </div>
                                <div class="form-group col-md-4">
                                    <label>{{trans('Status')}}</label>
                                    <select id="inputState" class="form-control" name="status">
                                        <option value="completed" @if($payment->status == 'completed')  selected @endif>
                                            @lang('Completed')</option>
                                        <option value="pending" @if($payment->status == 'pending')  selected @endif>
                                            @lang('Pending')</option>
                                        <option value="failed" @if($payment->status == 'failed')  selected @endif>
                                            @lang('Failed')</option>
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
                                        <input type="number" class="form-control" name="amount"
                                               value="{{ $payment->amount }}" required="" step=".001">
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
                                               value="{{$payment->method }}"
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
                                        <input type='hidden' value='1' name='is_pay' {{ $payment->is_pay ? 'checked' : '' }}>
                                        <input type="checkbox" name="is_pay" class="custom-switch-checkbox" id="is_pay"
                                               value="0" {{ $payment->is_pay ? '' : 'checked' }}>
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
                                                  rows="5">{{$payment->description}}</textarea>
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

        $(document).ready(function () {
            setCurrency();
            $(document).on('change', 'input[name="currency"]', function () {
                setCurrency();
            });

            function setCurrency() {
                let currency = $('input[name="currency"]').val();
                $('.set-currency').text(currency);
            }

            $(document).on('click', '.copy-btn', function () {
                var _this = $(this)[0];
                var copyText = $(this).parents('.input-group-append').siblings('input');
                $(copyText).prop('disabled', false);
                copyText.select();
                document.execCommand("copy");
                $(copyText).prop('disabled', true);
                $(this).text('Coppied');
                setTimeout(function () {
                    $(_this).text('');
                    $(_this).html('<i class="fas fa-copy"></i>');
                }, 500)
            });
        })


        $(document).ready(function (e) {

            $("#generate").on('click', function () {
                var form = `<div class="col-md-12">
                                <div class="form-group">
                                    <div class="input-group">
                                        <input name="field_name[]" class="form-control " type="text" value="" required placeholder="{{trans('Field Name')}}">

                                        <select name="type[]"  class="form-control  ">
                                            <option value="text">{{trans('Input Text')}}</option>
                                            <option value="textarea">{{trans('Textarea')}}</option>
                                            <option value="file">{{trans('File upload')}}</option>
                                        </select>

                                        <select name="validation[]"  class="form-control  ">
                                            <option value="required">{{trans('Required')}}</option>
                                            <option value="nullable">{{trans('Optional')}}</option>
                                        </select>

                                        <span class="input-group-btn">
                                            <button class="btn btn-danger delete_desc" type="button">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div> `;

                $('.addedField').append(form)
            });


            $(document).on('click', '.delete_desc', function () {
                $(this).closest('.input-group').parent().remove();
            });


            $('#image').change(function () {
                let reader = new FileReader();
                reader.onload = (e) => {
                    $('#image_preview_container').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            });

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
    <script>
        $(document).ready(function (e) {
            "use strict";

            $('#image').change(function () {
                let reader = new FileReader();
                reader.onload = (e) => {
                    $('#image_preview_container').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            });


            $('select').select2({
                selectOnClose: true
            });

        });
    </script>
@endpush
