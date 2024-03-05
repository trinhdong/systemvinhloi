@extends('layouts.app')
@section('title')
    {{-- write css this page--}}
    {{__('admin.manufacture_product_detail')}}
@endsection
@section('css')
    {{-- write css this page--}}
@endsection
@section('breadcrumb')
    {{-- write breadcrumb this page--}}
    {{__('admin.manufacture_product_detail')}}
@endsection
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="p-4 rounded">
                    <div class="row mb-3">
                        <label for="inputEnterYourName" class="col-sm-2 col-form-label">{{__('admin.manufacture_product_category')}}</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="inputEnterYourName" value="{{ $getMOP->category }}" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputEnterYourName" class="col-sm-2 col-form-label">{{__('admin.manufacture_product_name')}}</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="inputEnterYourName" value="{{ $getMOP->name }}" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputPhoneNo2" class="col-sm-2 col-form-label">{{__('admin.manufacture_product_price')}}</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="inputPhoneNo2" value="{{ $getMOP->unit_price }}" readonly>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="inputChoosePassword2" class="col-sm-2 col-form-label">{{__('admin.manufacture_product_order_period')}}</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="inputPhoneNo2"  value="{{ $getMOP->order_period }}" readonly>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    <div>
                        <a href="{{ route('list-moproduct') }}" type="button" class="btn btn-primary px-5 mx-2">{{__('admin.btn_back')}}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')

@endsection



