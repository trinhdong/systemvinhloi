@extends('layouts.app')
@section('title')
    {{-- write css this page--}}
    {{__('admin.business_location_add')}}
@endsection
@section('css')
    {{-- write css this page--}}
@endsection
@section('breadcrumb')
    {{-- write breadcrumb this page--}}
    {{__('admin.business_location_add')}}
@endsection
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <form action="" method="post">
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
                        <label for="inputEnterYourName" class="col-sm-2 col-form-label">{{__('admin.business_location_name')}}</label>
                        <div class="col-sm-10">
                            <input type="text" name="name" class="form-control" id="inputEnterYourName" placeholder="名前" value="{{ old('name') }}">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <label for="inputEnterYourName" class="col-sm-2 col-form-label">{{__('admin.business_location_code')}}</label>
                        <div class="col-sm-10">
                            <input type="text" name="business_code" class="form-control" id="inputEnterYourName" placeholder="コード" value="{{ old('business_code') }}">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <label for="inputPhoneNo2" class="col-sm-2 col-form-label">{{__('admin.business_location_adress')}}</label>
                        <div class="col-sm-10">
                            <input type="text" name="address" class="form-control" id="inputPhoneNo2" placeholder="住所" value="{{ old('address') }}">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <label for="inputEmailAddress2" class="col-sm-2 col-form-label">{{__('admin.business_location_phone')}}</label>
                        <div class="col-sm-10">
                            <input type="text" name="phone_number" class="form-control" id="inputEmailAddress2" placeholder="電話番号" value="{{ old('phone_number') }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-end">
            <div>
                <a href="{{ route('list-business') }}" type="button" class="btn btn-primary px-5 mx-2">{{__('admin.btn_back')}}</a>
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



