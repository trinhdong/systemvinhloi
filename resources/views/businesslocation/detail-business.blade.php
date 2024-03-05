@extends('layouts.app')
@section('title')
    {{-- write css this page--}}
    {{__('admin.business_location_detail')}}
@endsection
@section('css')
    {{-- write css this page--}}
@endsection
@section('breadcrumb')
    {{-- write breadcrumb this page--}}
    {{__('admin.business_location_detail')}}
@endsection
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="p-4 rounded">
                    <div class="row mb-3">
                        <label for="inputEnterYourName" class="col-sm-2 col-form-label">{{__('admin.business_location_name')}}</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="inputEnterYourName" value="{{ $business->name }}" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputPhoneNo2" class="col-sm-2 col-form-label">{{__('admin.business_location_code')}}</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="inputPhoneNo2" value="{{ $business->business_code }}" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputPhoneNo2" class="col-sm-2 col-form-label">{{__('admin.business_location_adress')}}</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="inputPhoneNo2" value="{{ $business->address }}" readonly>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="inputChoosePassword2" class="col-sm-2 col-form-label">{{__('admin.business_location_phone')}}</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="inputPhoneNo2"  value="{{ $business->phone_number }}" readonly>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    <div>
                        <a href="{{ route('list-business') }}" type="button" class="btn btn-primary px-5 mx-2">{{__('admin.btn_back')}}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')

@endsection



