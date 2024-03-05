@extends('layouts.app')
@section('title')
    {{-- write css this page--}}
    {{__('admin.business_location_edit')}}
@endsection
@section('css')
    {{-- write css this page--}}
@endsection
@section('breadcrumb')
    {{-- write breadcrumb this page--}}
    {{__('admin.business_location_edit')}}
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
                    <input type="hidden" name="id_business" value="{{$getBusiness->id}}">
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
                        <label for="inputEnterYourName" class="col-sm-2 col-form-label">{{__('admin.business_location_name')}}</label>
                        <div class="col-sm-8">
                            <input type="text" name="name" class="form-control" id="inputEnterYourName" placeholder="名前" value="{{ $getBusiness->name }}">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <label for="inputEnterYourName" class="col-sm-2 col-form-label">{{__('admin.business_location_code')}}</label>
                        <div class="col-sm-10">
                            <input type="text" name="business_code" class="form-control" id="inputEnterYourName" placeholder="コード" value="{{ $getBusiness->business_code }}">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputPhoneNo2" class="col-sm-2 col-form-label">{{__('admin.business_location_adress')}}</label>
                        <div class="col-sm-8">
                            <input type="text" name="address" class="form-control" id="inputPhoneNo2" placeholder="住所" value="{{ $getBusiness->address }}">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputEmailAddress2" class="col-sm-2 col-form-label">{{__('admin.business_location_phone')}}</label>
                        <div class="col-sm-8">
                            <input type="text" name="phone_number" class="form-control" id="inputEmailAddress2" placeholder="電話番号" value="{{ $getBusiness->phone_number }}">
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
                <button type="submit" class="btn btn-primary px-5 mx-2">{{__('admin.btn_save')}}</button>
            </div>
        </div>
        </form>
    </div>
</div>
@endsection
@section('script')

@endsection



