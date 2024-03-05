@extends('layouts.app')
@section('title')
    {{-- write css this page--}}
    {{__('admin.original_product_add')}}
@endsection
@section('css')
    {{-- write css this page--}}
@endsection
@section('breadcrumb')
    {{-- write breadcrumb this page--}}
    {{__('admin.original_product_add')}}
@endsection
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('create-oproduct') }}" method="post">
                @csrf
                <div class="p-4 rounded">
                    <div class="row mb-2" style="padding: 11px">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul style="margin: 0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                    <div class="row mb-2">
                        <label for="inputEnterYourName" class="col-sm-2 col-form-label">{{__('admin.original_product_category')}}</label>
                        <div class="col-sm-10">
                            <input type="text" name="category" class="form-control" id="inputEnterYourName" placeholder="{{__('admin.original_product_category')}}" value="{{ old('category') }}">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <label for="inputPhoneNo2" class="col-sm-2 col-form-label">{{__('admin.original_product_name')}}</label>
                        <div class="col-sm-10">
                            <input type="text" name="name" class="form-control" id="inputPhoneNo2" placeholder="{{__('admin.original_product_name')}}" value="{{ old('name') }}">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <label for="inputEmailAddress2" class="col-sm-2 col-form-label">{{__('admin.original_product_price')}}</label>
                        <div class="col-sm-10">
                            <input type="text" name="unit_price" class="form-control" id="inputEmailAddress2" placeholder="{{__('admin.original_product_price')}}" value="{{ old('unit_price') }}">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <label for="inputEmailAddress2" class="col-sm-2 col-form-label">{{__('admin.original_product_order_period')}}</label>
                        <div class="col-sm-10">
                            <input type="number" name="order_period" class="form-control" id="inputEmailAddress2" placeholder="{{__('admin.original_product_order_period')}}" value="{{ old('order_period') }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-end">
            <div>
                <a href="{{route('list-oproduct')}}" type="button" class="btn btn-primary px-5 mx-2">{{__('admin.btn_back')}}</a>
            </div>
            <div>
                <button type="submit" class="btn btn-primary px-5 mx-2">{{__('admin.btn_create')}}</button>
            </div>
        </div>
        </form>
    </div>
</div>
@endsection
@section('script')

@endsection
