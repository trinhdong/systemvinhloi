@extends('layouts.app')
@section('title')
    {{-- write css this page--}}
    {{__('admin.user_detail')}}
@endsection
@section('css')
    {{-- write css this page--}}
@endsection
@section('breadcrumb')
    {{-- write breadcrumb this page--}}
    {{__('admin.user_detail')}}
@endsection
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="p-4 rounded">
                    <div class="row mb-3">
                        <label for="inputEnterYourName" class="col-sm-2 col-form-label">{{__('admin.user_name')}}</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="inputEnterYourName" value="{{ $get_user->name }}" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputEnterYourName" class="col-sm-2 col-form-label">{{__('admin.user_code')}}</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="inputEnterYourName" value="{{ $get_user->user_code }}" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputPhoneNo2" class="col-sm-2 col-form-label">{{__('admin.user_mail')}}</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="inputPhoneNo2" value="{{ $get_user->email }}" readonly>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="inputChoosePassword2" class="col-sm-2 col-form-label">{{__('admin.user_role')}}</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="inputPhoneNo2"  value="{{ $get_user->rolename }}" readonly>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    <div>
                        <a href="{{ route('list-user') }}" type="button" class="btn btn-primary px-5 mx-2">{{__('admin.btn_back')}}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')

@endsection



