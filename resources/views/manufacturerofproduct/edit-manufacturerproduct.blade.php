@extends('layouts.app')
@section('title')
    {{-- write css this page--}}
    {{__('admin.manufacture_product_edit')}}
@endsection
@section('css')
    {{-- write css this page--}}
@endsection
@section('breadcrumb')
    {{-- write breadcrumb this page--}}
    {{__('admin.manufacture_product_edit')}}
@endsection
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <form action="
                {{-- {{ route('edited-business',$getBusiness->id) }} --}}
                " method="post">
                @csrf
                <div class="p-4 rounded">
                    <input type="hidden" name="id_business" value="{{$getMOP->id}}">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul style="margin: 0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="row mb-3">
                        <label for="inputEnterYourName" class="col-sm-2 col-form-label">{{__('admin.manufacture_product_category')}}</label>
                        <div class="col-sm-8">
                            <input type="text" name="category" class="form-control" id="inputEnterYourName" placeholder="{{__('admin.manufacture_product_category')}}" value="{{ $getMOP->category }}">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputEnterYourName" class="col-sm-2 col-form-label">{{__('admin.manufacture_product_name')}}</label>
                        <div class="col-sm-8">
                            <input type="text" name="name" class="form-control" id="inputEnterYourName" placeholder="{{__('admin.manufacture_product_name')}}" value="{{ $getMOP->name }}">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputPhoneNo2" class="col-sm-2 col-form-label">{{__('admin.manufacture_product_price')}}</label>
                        <div class="col-sm-8">
                            <input type="text" name="unit_price" class="form-control" id="inputPhoneNo2" placeholder="{{__('admin.manufacture_product_price')}}" value="{{ $getMOP->unit_price }}">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputEmailAddress2" class="col-sm-2 col-form-label">{{__('admin.manufacture_product_order_period')}}</label>
                        <div class="col-sm-8">
                            <input type="number" name="order_period" class="form-control" id="inputEmailAddress2" placeholder="{{__('admin.manufacture_product_order_period')}}" value="{{ $getMOP->order_period }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-end">
            <div>
                <a href="{{route('list-moproduct')}}" type="button" class="btn btn-primary px-5 mx-2">{{__('admin.btn_back')}}</a>
            </div>
            <div>
                <button type="submit" class="btn btn-primary px-5 mx-2">{{__('admin.btn_save')}}</button>
            </div>
        </div>
        </form>
    </div>
</div>
@endsection
@section('script')

@endsection



